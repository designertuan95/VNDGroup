<?php
namespace Admin\Model;
use VND\Model\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
class Coupon extends Model{
	protected 	$tableGateway;
	public 		$sqlSelect;
	protected 	$adapter;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}
	public function listItem($option = null,$arrParams = null)
	{
		$resultSet = $this->tableGateway->select(function(Select $select) use($arrParams){
		
		});
		return $resultSet;
		
	}
	public function insertItem($objData = null,$id = null)
	{
		$arrData = array(
			'couponTable' => array(
				'name' 						=> $objData->name,
				'type' 						=> $objData->type,
				'code' 						=> $objData->code,
				'discount'   				=> $objData->discount,
				'logged' 					=> $objData->logged,
				'shipping' 					=> $objData->shipping,
				'date_start' 				=> $objData->date_start,
				'date_end'		 			=> $objData->date_end,
				'discount_usage_limit' 		=> $objData->discount_usage_limit,
				'status' 					=> $objData->status,
				'date_added' 				=> $objData->date_added,
			),
			'coupon_product' => array(
				'product_id' => $objData->product_id,
			),
			'coupon_category' => array(
				'category_id' => $objData->category,
			)
				
		);
		$arrParams = array('id' => $id, 'column' => 'coupon_id');
		$coupon_id = parent::saveItem($arrData['couponTable'],$arrParams);
		if($id != null){
			$coupon_id = $id;
		}
		// Coupon categories
		$CouponCategoryTable = $this->getServiceLocator()->get('Admin\Model\CouponCategoryTable');
		$arrData['coupon_category']['coupon_id'] = $coupon_id;
		$CouponCategoryTable->InsertItem($arrData['coupon_category'],$coupon_id);
		// Coupon Products
		$CouponProduct = $this->getServiceLocator()->get('Admin\Model\CouponProductTable');
		$arrData['coupon_product']['coupon_id'] = $coupon_id;
		$CouponProduct->InsertItem($arrData['coupon_product'],$coupon_id);
		
		return $coupon_id;
		
	}
	
	public function getItemById($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(function(Select $select)  use($id){
			$select->where(array('coupon.coupon_id' => $id));
		});
		return $rowset->current();
	}
	
	public function changeStatus($id)
	{
		$item = $this->getItemById($id);
		$value = ($item->status == 0) ? 1 : 0 ;
		$arrParams = array('id' => $item->coupon_id ,'column' => 'coupon_id');
		$this->updateColumn($arrData = array('status' => $value),$arrParams);
	}
	public function deleteItem($id)
	{
		parent::delete($column = 'coupon_id',$table = 'coupon',$id);
		# 02. Delete Group Product
		$CouponCategoryTable = $this->getServiceLocator()->get('Admin\Model\CouponCategoryTable');
		$CouponCategoryTable->delete($column = 'coupon_id','coupon_category',$id);
		# 03. Delete Product_category
		$CouponProduct = $this->getServiceLocator()->get('Admin\Model\CouponProductTable');
		$CouponProduct->delete($column = 'coupon_id','coupon_product',$id);
				
	}
}