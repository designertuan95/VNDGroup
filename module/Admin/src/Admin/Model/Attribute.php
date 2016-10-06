<?php
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Admin\Model\AttributeGroupTable;
class Attribute{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	public function countItem($option = null){
		return $this->tableGateway->select()->count();
	}
	public function listItem($option = null,$arrData = null)
	{
		if($option == null){
			$resultSet	= $this->tableGateway->select(function(Select $select){
				$select->join(
					'attribute_group', 
					'attribute_group.attribute_group_id = attribute.attribute_group_id', 
					array('group_name' => 'name'), 
					$select::JOIN_LEFT
				);
				$select->order('attribute_id DESC');
				// echo $this->tableGateway->getSql()->getSqlstringForSqlObject($select);
			});
		}elseif($option['type'] == 'search'){
			$resultSet	= $this->tableGateway->select(function(Select $select) use($arrData){
				$select->join(
					'attribute_group', 
					'attribute_group.attribute_group_id = attribute.attribute_group_id', 
					array('group_name' => 'name'), 
					$select::JOIN_LEFT
				);
				$select->where(
						new \Zend\Db\Sql\Predicate\Like('attribute.name','%'.$arrData['Query'].'%')
				);
				$select->order('attribute_id DESC');
				#echo $this->tableGateway->getSql()->getSqlstringForSqlObject($select);
			});
		}elseif($option['type'] == 'page'){
			$resultSet	= $this->tableGateway->select(function(Select $select) use($arrData){
				$select->join(
					'attribute_group', 
					'attribute_group.attribute_group_id = attribute.attribute_group_id', 
					array('group_name' => 'name'), 
					$select::JOIN_LEFT
				);
				$select->order('attribute_id DESC');
				$select->limit($arrData['ItemCountPerPage']); // Số bài muốn lấy
				// Vị trí bắt đầu lấy
				$select->offset( ($arrData['CurrentPageNumber']-1) * $arrData['ItemCountPerPage']);
				#echo $this->tableGateway->getSql()->getSqlstringForSqlObject($select);
			});
		}
		
		return $resultSet;
	}

	public function getItemById($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('attribute_id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	public function saveItem($objData = null)
	{
		$data = array(
			'name' => $objData->name,
			'sort_order' => $objData->sort_order,
			'attribute_group_id' => $objData->attribute_group_id
		);
		$id = (int) $objData->attribute_id;
		if($id === 0){
			$this->tableGateway->insert($data);
			return $this->tableGateway->getLastInsertValue();
		}else{
			if($this->getItemById($id)){
				$this->tableGateway->update($data, array('attribute_id' => $id));
			}else{
				return false;
			}
		}
	}

	public function deleteItem($id = 0,$option = array('task' => 'item'))
	{
		if(!is_array($id)){
			$this->tableGateway->delete(array('attribute_id' => (int) $id));
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

}
?>