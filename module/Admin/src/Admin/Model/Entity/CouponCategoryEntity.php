<?php
namespace Admin\Model\Entity;
class CouponCategoryEntity {
	public $category_id;
	public $coupon_id;
	public $category;
	public function exchangeArray($data)
	{
		$this->category_id = (!empty($data['category_id'])) ? $data['category_id'] : null;
		$this->coupon_id = (!empty($data['coupon_id'])) ? $data['coupon_id'] : null;
		$this->category = (!empty($data['category'])) ? $data['category'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>