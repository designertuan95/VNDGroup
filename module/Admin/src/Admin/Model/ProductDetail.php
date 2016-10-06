<?php
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
class ProductDetail{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function InsertItem($data){
		$this->tableGateway->insert($data);
		return $this->tableGateway->getLastInsertValue();
	}

}
?>