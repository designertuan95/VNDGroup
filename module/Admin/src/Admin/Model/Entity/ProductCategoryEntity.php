<?php
namespace Admin\Model\Entity;
class ProductCategoryEntity {
	public $category_id;
	public $product_id;
	public function exchangeArray($data)
	{
			$this->category_id  = (!empty($data['category_id'])) ? $data['category_id'] : null;
			$this->product_id = (!empty($data['product_id'])) ? $data['product_id'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>