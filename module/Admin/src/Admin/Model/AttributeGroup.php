<?php
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
class AttributeGroup{
	protected 	$tableGateway;
	public 		$sqlSelect;
	protected 	$adapter;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}
	public function listItem($option = null,$data = null)
	{
		if($option == null){
			$resultSet = $this->tableGateway->select(function(Select $select){
				$select->order('sort_order DESC, attribute_group_id DESC');
			});
		}
		if($option['type'] == 'search'){
			$resultSet	= $this->tableGateway->select(function(Select $select) use($data){
				$select->order('sort_order DESC, attribute_group_id DESC');
				$select->where(
						new \Zend\Db\Sql\Predicate\Like('name','%'.$data['Query'].'%')
				);
				$select->order('sort_order DESC, attribute_group_id DESC');
				#echo $this->tableGateway->getSql()->getSqlstringForSqlObject($select);
			});
		}
		return $resultSet;
	}
	public function getItemById($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('attribute_group_id' => $id));
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
			'sort_order' => $objData->sort_order
		);
		$id = (int) $objData->attribute_group_id;
		if($id === 0){
			$this->tableGateway->insert($data);
			return $this->tableGateway->getLastInsertValue();
		}else{
			if($this->getItemById($id)){
				print_r($data);
				echo $id;
				$this->tableGateway->update($data, array('attribute_group_id' => $id));
			}else{
				return false;
			}
		}
	}
	public function itemSelectBox()
	{
		$items = $this->tableGateway->select(function(Select $select){
			$select->columns(array('attribute_group_id','name'));
		});
		$result = array();
		foreach($items as $item)
		{
			$result[$item->attribute_group_id] = $item->name;
		}
		return $result;
	}

	public function deleteItem($id = 0,$option = array('task' => 'item'))
	{
		if(!is_array($id)){
			$this->tableGateway->delete(array('attribute_group_id' => (int) $id));
		}elseif(is_array($id) && count($id) > 0){
			$deleteObj = new \Zend\Db\Sql\Delete('attribute_group');
			$deleteObj->where(
				new \Zend\Db\Sql\Predicate\In('attribute_group_id',$id)
			);
			$this->tableGateway->deleteWith($deleteObj); 
		}elseif($option['task'] == 'deleteAll'){
			$this->tableGateway->delete();
		}
		
	}
}