<?php
namespace Admin\Model;
use VND\Model\Model as AbstractModel;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
class Category{
	protected 	$tableGateway;
	public 		$sqlSelect;
	protected 	$adapter;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}


	public function itemSelectBox()
	{
		$items = $this->tableGateway->select(function(Select $select){
			$select->columns(array('category_id','name'));
		});
		$result = array();
		foreach($items as $item)
		{
			$result[$item->category_id] = $item->name;
		}
		return $result;
	}
}