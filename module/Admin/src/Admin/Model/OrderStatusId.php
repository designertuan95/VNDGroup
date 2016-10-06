<?php
namespace Admin\Model;
class OrderStatusId{
	protected 	$tableGateway;
	public 		$sqlSelect;
	protected 	$adapter;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}
}