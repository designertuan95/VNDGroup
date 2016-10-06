<?php
namespace Admin\Model;
use VND\Model\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
class CouponCategory  extends Model{
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
		$arrParams = array('id' => 0, 'column' => 'category_id');
		parent::delete($column = 'coupon_id','coupon_category',$id);
		if(is_array($data['category_id']) && count($data['category_id']) > 0){
			foreach($data['category_id'] as $category_id){
				$arrData = array(
						'category_id' => $category_id,
						'coupon_id' => $data['coupon_id']
				);
				$result[] = parent::saveItem($arrData,$arrParams);
			}
		}
		return $result;
	}
	public function getItemById($id)
	{
		$rowset = $this->tableGateway->select(array('coupon_id' => $id));
		return $rowset;
	}
	public function itemSelectBox($id)
	{
			$items = $this->getItemById($id);
			$result = array();
			foreach($items as $item)
			{
				$result['category'][] = $item->category_id;
			}
			$entity = new \Admin\Model\Entity\CouponCategoryEntity();
			$entity->exchangeArray($result);
			return $entity;
	}
}