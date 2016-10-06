<?php
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use VND\Model\Model;
class Warehouse extends Model{
	protected 	$tableGateway;
	public 		$sqlSelect;
	protected 	$adapter;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}

	public function InsertItem($data,$id = 0){
		$result = array();
		$arrParams = array('id' => $id, 'column' => 'product_product_id');
		parent::saveItem($data,$arrParams);
		return $result;
	}
	public function deleteItem($id)
	{
		parent::delete($column = 'product_product_id','warehouse',$id);
	}
}