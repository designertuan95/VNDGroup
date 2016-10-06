<?php
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use VND\Model\Model;
class GroupProduct extends Model{
	protected 	$tableGateway;
	public 		$sqlSelect;
	protected 	$adapter;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}
	public function InsertItem($data,$id = null){
		$result = array();
		$arrParams = array('id' => 0, 'column' => 'product_id');
		parent::delete($column = 'product_id','group_product',$id);
		if(is_array($data['group_display_id']) && count($data['group_display_id']) > 0){
			foreach($data['group_display_id'] as $display_id){
				$arrData = array(
					'product_id' => $data['product_id'],
					'group_display_id' => $display_id
				);
				$result[] = parent::saveItem($arrData,$arrParams);
			}
		}
		return $result;
	}
	public function UpdateGroupProduct()
	{

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

	public function deleteItem($id)
	{
		parent::delete($column = 'product_id',$table = 'group_product',$id);
	}
}