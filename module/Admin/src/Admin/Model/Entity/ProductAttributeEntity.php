<?php
namespace Admin\Model\Entity;
class ProductAttributeEntity {
	public $product_attribute_id;
	public $attribute_id;
	public $value;
	public function exchangeArray($data)
	{
			$this->product_attribute_id  = (!empty($data['product_attribute_id'])) ? $data['product_attribute_id'] : null;
			$this->attribute_id = (!empty($data['attribute_id'])) ? $data['attribute_id'] : null;
			$this->value = (!empty($data['value'])) ? $data['value'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>