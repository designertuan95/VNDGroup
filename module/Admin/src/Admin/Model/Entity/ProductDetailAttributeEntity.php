<?php
namespace Admin\Model\Entity;
class ProductDetailAttributeEntity {
	public $product_detail_id;
	public $product_attribute_id;
	public function exchangeArray($data)
	{
			$this->product_detail_id  = (!empty($data['product_detail_id'])) ? $data['product_detail_id'] : null;
			$this->product_attribute_id = (!empty($data['product_attribute_id'])) ? $data['product_attribute_id'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>