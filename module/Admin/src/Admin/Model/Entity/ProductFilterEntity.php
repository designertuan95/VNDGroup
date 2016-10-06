<?php
namespace Admin\Model\Entity;
class ProductFilterEntity {
	public $filter_filter_id;
	public $product_id;
	public function exchangeArray($data)
	{
			$this->filter_filter_id  = (!empty($data['filter_filter_id'])) ? $data['filter_filter_id'] : null;
			$this->product_id = (!empty($data['product_id'])) ? $data['product_id'] : null;
	}
	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>