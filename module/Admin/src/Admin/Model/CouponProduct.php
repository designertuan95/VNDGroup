<?php
namespace Admin\Model;
use VND\Model\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
class CouponProduct  extends Model{
	protected 	$tableGateway;
	public 		$sqlSelect;
	protected 	$adapter;
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
		$this->adapter = $this->tableGateway->getAdapter();
	}
	public function InsertItem($data,$id = null,$task = 'insert'){
		$result = array();
		$arrParams = array('id' => 0, 'column' => 'product_id');
		parent::delete($column = 'coupon_id','coupon_product',$id);
		if(is_array($data['product_id']) && count($data['product_id']) > 0){
			foreach($data['product_id'] as $product_id){
				$arrData = array(
						'product_id' => $product_id,
						'coupon_id' => $data['coupon_id']
				);
				$result[] = parent::saveItem($arrData,$arrParams);
			}
		}
		
		return $result;
	}
	
	public function getItemById($id)
	{
		$rowset = $this->tableGateway->select(function(Select $select) use($id){
			$select->where(array('coupon_id' => $id));
			$select->join(
				array('prd' => 'product'),
				'coupon_product.product_id = prd.product_id',
				array('image','product_name')
				
			);
		});
		return $rowset;
	}
}