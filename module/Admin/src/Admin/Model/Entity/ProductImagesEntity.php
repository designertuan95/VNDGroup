<?php
namespace Admin\Model\Entity;
class ProductImagesEntity {
	public $product_image_id;
	public $image;
	public $sort_order;
	public $product_id;
	public function exchangeArray($data)
	{
			$this->product_image_id  = (!empty($data['product_image_id'])) ? $data['product_image_id'] : null;
			$this->product_id = (!empty($data['product_id'])) ? $data['product_id'] : null;
			$this->image = (!empty($data['image'])) ? $data['image'] : null;
			$this->sort_order = (!empty($data['sort_order'])) ? $data['sort_order'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>