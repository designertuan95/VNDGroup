<?php
namespace Admin\Model\Entity;
class CouponEntity {
	public $coupon_id;
	public $name;
	public $code;
	public $type;
	public $discount;
	public $logged;
	public $shipping;
	public $date_start;
	public $date_end;
	public $discount_usage_limit;
	public $status;
	public $date_added;
	public $category;
	public $category_id;
	public $product_id;
	public function exchangeArray($data)
	{
		$time = new \Zend\Stdlib\DateTime();
		$dateStart = $date = date_create($data['date_start']);
		$dateEnd = $date = date_create($data['date_end']);
		$this->coupon_id = (!empty($data['coupon_id'])) ? $data['coupon_id'] : null;
		$this->name = (!empty($data['name'])) ? $data['name'] : null;
		$this->code = (!empty($data['code'])) ? $data['code'] : null;
		$this->type = (!empty($data['type'])) ? $data['type'] : null;
		$this->discount = (!empty($data['discount'])) ? $data['discount'] : null;
		$this->logged = (!empty($data['logged'])) ? $data['logged'] : 0;
		$this->shipping = (!empty($data['shipping'])) ? $data['shipping'] : 0;
		$this->date_start = (!empty($data['date_start'])) ?  date_format($dateStart,'Y-m-d') : null;
		$this->date_end = (!empty($data['date_end'])) ? 	 date_format($dateEnd,'Y-m-d') : null;
		$this->discount_usage_limit = (!empty($data['discount_usage_limit'])) ? $data['discount_usage_limit'] : null;
		$this->status = (!empty($data['status'])) ? $data['status'] : 0;
		$this->date_added = (!empty($data['date_added'])) ? $data['date_added'] : date('Y-m-d H:i:s',$time->getTimestamp());
		// Coupon Category
		$this->category = (!empty($data['category'])) ? $data['category'] : null;
		$this->category_id = (!empty($data['category_id'])) ? $data['category_id'] : null;
		// Coupon Product
		$this->product_id = (!empty($data['product_id'])) ? $data['product_id'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>