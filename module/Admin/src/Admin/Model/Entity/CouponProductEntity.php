<?php
namespace Admin\Model\Entity;
class CouponProductEntity {
	public $coupon_id;
	public $product_id;
	public function exchangeArray($data)
	{
		$this->coupon_id = (!empty($data['coupon_id'])) ? $data['coupon_id'] : null;
		$this->product_id = (!empty($data['product_id'])) ? $data['product_id'] : null;
		$this->product_name = (!empty($data['product_name'])) ? $data['product_name'] : null;
		$this->image = (!empty($data['image'])) ? $data['image'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>