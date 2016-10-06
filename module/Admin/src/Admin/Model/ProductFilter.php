<?php
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use VND\Model\Model;
class ProductFilter extends Model{
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
		$this->deleteItem($id);
		if(is_array($data['filter_id']) && count($data['filter_id']) > 0){
			foreach($data['filter_id'] as $filter_id){
				$arrData = array(
					'product_id' => $data['product_id'],
					'filter_id' => $filter_id
				);
				$result[] = parent::saveItem($arrData,$arrParams);
			}
		}
		return $result;
	}
	public function deleteItem($id)
	{
		parent::delete($column = 'product_id','product_filter',$id);
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
}