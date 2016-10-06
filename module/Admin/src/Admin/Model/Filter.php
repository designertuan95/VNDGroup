<?php
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use VND\Model\Model;
class Filter extends Model{
	protected $tableGateway;
	public $error = array();
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	public function countItem($option = null){
		if($option['task'] == 'parent_0'){
			return $this->tableGateway->select(array('parent_id' => 0))->count();
		}else{
			return $this->tableGateway->select()->count();
		}
	}
	public function listItem($option = null,$arrData = null)
	{
		if($option['task'] == 'page'){
			$resultSet = $this->tableGateway->select(function (Select $select) use($option,$arrData){
				$select->where->equalTo('parent_id',0);
					if(isset($arrData['Query']) && !empty($arrData['Query'])){
						$select->where(
							new \Zend\Db\Sql\Predicate\Like('name','%'.$arrData['Query'].'%')
						);
					}
					$select->limit($arrData['ItemCountPerPage']); // Số bài muốn lấy
					// Vị trí bắt đầu lấy
					$select->offset( ($arrData['CurrentPageNumber']-1) * $arrData['ItemCountPerPage']);
					$select->order('sort_order ASC , filter_id DESC');
				#echo $this->tableGateway->getSql()->getSqlstringForSqlObject($select);
			});
		}elseif ($option['task'] == 'list-parent' && !empty($arrData['parent_id'])) {
			$resultSet = $this->tableGateway->select(array('parent_id' => $arrData['parent_id']));
		}
		return $resultSet;
	}

	public function getItemById($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('filter_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveItem($objData = null,$id = null)
	{
		unset($objData['filter_group']['SaveFieldset']);
		// Update Filter Group
		unset($objData['filter_group']['filter_id']);
		if(isset($id)){
			// Update Action
			try{
				$this->tableGateway->update($objData['filter_group'], array('filter_id' => $id));
			}catch(\Exception $ex){
				$this->error['update_group'] = $ex; 
			}
			// Delete Filter Child
			$this->tableGateway->delete(array('parent_id' => $id));
			if(!empty($objData['filter'])){
				// Insert Filter Child
				$this->insertFilters($objData['filter'],$type = 'filters',$id);
			}
		}else{
			// Insert Action
			$parent_id = $this->insertFilters($objData['filter_group'],'filter_group',$id = null);
			if(!empty($objData['filter'])){
				// Insert Filter Child
				$this->insertFilters($objData['filter'],$type = 'filters',$parent_id);
			}
			return $parent_id;
		}
		return array(
			'error' => $this->error,
		);
		
	}
	public function insertFilters($arrData,$type = 'filters',$id = null)
	{
		if($type == 'filters'){
			foreach($arrData as $filter){
				$filter['parent_id'] = $id;
				unset($filter['SaveFieldset']);
				try{
					$this->tableGateway->insert($filter);
				}catch(\Exception $ex){
					$this->error['filter'] = $ex; 
				}
			}
		}elseif($type == 'filter_group'){
			$arrData['parent_id'] = 0;
			$this->tableGateway->insert($arrData);
			return $this->tableGateway->getLastInsertValue();
		}
		
	}
	public function deleteItem($id = 0,$option = array('task' => 'item'))
	{
		if(!is_array($id)){
			$this->tableGateway->delete(array('parent_id' => (int) $id));
			$this->tableGateway->delete(array('filter_id' => (int) $id));
		}elseif(is_array($id) && count($id) > 0){
			$deleteObj = new \Zend\Db\Sql\Delete('attribute');
			$deleteObj->where(
				new \Zend\Db\Sql\Predicate\In('attribute_id',$id)
			);
			$this->tableGateway->deleteWith($deleteObj); 
		}elseif($option['task'] == 'deleteAll'){
			$this->tableGateway->delete();
		}
	}

	public function getFilters()
	{
		$resultSet = $this->tableGateway->select(function(Select $select){

		});
		$resultSet = $resultSet->toArray();
		$result = array();
		foreach($resultSet as $filter){
			if($filter['parent_id'] == 0){
				// Get Filter
				$id = $filter['filter_id'];
				$result[$id] = $filter;
				foreach($resultSet as $childFilter){
					// Get Filter Parent
					if($childFilter['parent_id'] == $id){
						$result[$id]['child'][] = $childFilter;
					}
				}
			}
		}
		return $result;
	}

	public function itemSelectBox()
	{
		$data = $this->getFilters();
		$result = array();
		foreach($data as $filter){
			if(!empty($filter['child'])){
				foreach($filter['child'] as $chidFilter){
					$result[$chidFilter['filter_id']] = $filter['name']. ' > '.$chidFilter['name'];
				}
			}else{
				$result[$filter['filter_id']] = $filter['name'];
			}
			
		}
		return $result;
	}

}
?>