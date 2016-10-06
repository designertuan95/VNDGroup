<?php
namespace Admin\Model\Entity;
class WarehouseEntity {
	public $warehouse_id;
	public $quantity;
	public $inventory_policy;
	public $product_detail_id;
	public function exchangeArray($data)
	{
			$this->tags_id  = (!empty($data['warehouse_id'])) ? $data['warehouse_id'] : null;
			$this->tag_name = (!empty($data['quantity'])) ? $data['quantity'] : null;
			$this->tag_name = (!empty($data['inventory_policy'])) ? $data['inventory_policy'] : null;
			$this->tag_name = (!empty($data['product_detail_id'])) ? $data['product_detail_id'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>