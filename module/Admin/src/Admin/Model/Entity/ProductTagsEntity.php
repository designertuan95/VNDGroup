<?php
namespace Admin\Model\Entity;
class ProductTagsEntity {
	public $tags_tags_id;
	public $product_product_id;
	public function exchangeArray($data)
	{
			$this->tags_tags_id  = (!empty($data['tags_tags_id'])) ? $data['tags_tags_id'] : null;
			$this->product_product_id = (!empty($data['product_product_id'])) ? $data['product_product_id'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>