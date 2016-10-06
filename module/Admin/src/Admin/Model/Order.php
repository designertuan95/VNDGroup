<?php
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use VND\Model\Model;
class Order extends Model{
	protected 	$tableGateway;
	public 		$sqlSelect;
	protected 	$adapter;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}
	public function insertItem($objData,$id = null)
	{
		$arrData = array(
			'order' => array(
					'firstname' => $objData->firstname, 
					'lastname' => $objData->lastname, 
					'email' => $objData->email, 
					'telephone' => $objData->telephone, 
					'payment_firstname' => $objData->payment_firstname, 
					'payment_lastname' => $objData->payment_lastname, 
					'payment_company' => $objData->payment_company, 
					'payment_address_1' => $objData->payment_address_1, 
					'payment_address_2' => $objData->payment_address_2, 
					'payment_city' => $objData->payment_city, 
					'payment_postcode' => $objData->payment_postcode, 
					'payment_country' => $objData->payment_country, 
					'payment_method' => $objData->payment_method, 
					'payment_code' => $objData->payment_code, 
					'shipping_firstname' => $objData->shipping_firstname, 
					'shipping_lastname' => $objData->shipping_lastname, 
					'shipping_company' => $objData->shipping_company, 
					'shipping_address_1' => $objData->shipping_address_1, 
					'shipping_address_2' => $objData->shipping_address_2, 
					'shipping_city' => $objData->shipping_city, 
					'shipping_postcode' => $objData->shipping_postcode, 
					'shipping_method' => $objData->shipping_method, 
					'shipping_code' => $objData->shipping_code, 
					'comment' => $objData->comment, 
					'total' => $objData->total, 
					'date_added' => $objData->date_added, 
					'date_modified' => $objData->date_modified, 
					'customer_id' => $objData->customer_customer_id, 
			),
		);
		#print_r($arrData['order']);
		$arrParams = array('id' => $id, 'column' => 'order_id');
		$idOrder = parent::saveItem($arrData['order'],$arrParams);
		echo  $idOrder;
		if($id != null){
			$idOrder = $id;
		}
	}
}