<?php
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use VND\Model\Model;
class Producer extends Model{
	protected $tableGateway;
	public $error = array();
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	public function countItem($option = null){
		return $this->tableGateway->select()->count();
	}
	public function listItem($option = null,$arrData = null)
	{
		if($option['task'] == 'page'){
			$resultSet = $this->tableGateway->select(function (Select $select) use($option,$arrData){
					if(isset($arrData['Query']) && !empty($arrData['Query'])){
						$select->where(
							new \Zend\Db\Sql\Predicate\Like('name','%'.$arrData['Query'].'%')
						);
					}
					$select->limit($arrData['ItemCountPerPage']); // Số bài muốn lấy
					// Vị trí bắt đầu lấy
					$select->offset( ($arrData['CurrentPageNumber']-1) * $arrData['ItemCountPerPage']);
					$select->order('producer_id DESC');
				#echo $this->tableGateway->getSql()->getSqlstringForSqlObject($select);
			});
		}
		return $resultSet;
	}

	public function getItemById($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('producer_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveItem($objData = null,$id = null)
	{	
		$arrData = array(
			'name' => $objData->name,
			'describe' => $objData->describe
		);
		$id = (int) $id;
		if($id == 0){
			// Insert Action
			$this->tableGateway->insert($arrData);
			return $this->tableGateway->getLastInsertValue();
		}else{
			// Update Action
			if ($this->getItemById($id)) {
	            $this->tableGateway->update($arrData, array('producer_id' => $id));
	        } else {
	            throw new \Exception('Album id does not exist');
			}
		}
	}
	public function deleteItem($id = 0,$option = array('task' => 'item'))
	{
		if(!is_array($id)){
			$this->tableGateway->delete(array('producer_id' => (int) $id));
		}elseif(is_array($id) && count($id) > 0){
			$deleteObj = new \Zend\Db\Sql\Delete('producer');
			$deleteObj->where(
				new \Zend\Db\Sql\Predicate\In('producer_id',$id)
			);
			$this->tableGateway->deleteWith($deleteObj); 
		}elseif($option['task'] == 'deleteAll'){
			$this->tableGateway->delete();
		}
	}

	public function itemSelectBox()
	{
		$items = $this->tableGateway->select(function(Select $select){
			$select->columns(array('producer_id','name'));
		});
		$result = array();
		foreach($items as $item)
		{
			$result[$item->producer_id] = $item->name;
		}
		return $result;
	}	

}
?>