<?php
namespace Admin\Model;
use VND\Model\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
class Customer extends Model{
	protected 	$tableGateway;
	public 		$sqlSelect;
	protected 	$adapter;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}
	public function countItem()
	{
		return $this->tableGateway->select()->count();
	}
	public function listItem($option = null,$arrParams = null)
	{
		$resultSet = $this->tableGateway->select(function(Select $select) use($arrParams){
			// $select->columns(
			// 	array('fullname' => new \Zend\Db\Sql\Expression('GROUP_CONCAT(firstname,lastname)'))
			// );
			$filterData = $arrParams['filterData'];
			if(!empty($filterData['Query'])){
				$select->where(new \Zend\Db\Sql\Predicate\Like('firstname','%'.$filterData['Query'].'%'));
			}
		});
		return $resultSet;
		
	}
	public function insertItem(\Admin\Model\Entity\CustomerEntity $entity,$id = null)
	{
		$arrData = $entity->getArrayCopy();
		unset($arrData['fullname']);
		if($id != null){
			$arrData['customer_id'] = $id;
		}
		$arrParams = array('id' => $id, 'column' => 'customer_id');
		$customer_id = parent::saveItem($arrData,$arrParams);
		return $customer_id;
		
	}
}