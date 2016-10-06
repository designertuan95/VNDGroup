<?php
namespace Admin\Model\Entity;
class OrderProductEntity {
	public $name;
	public $quantity;
	public $price;
	public $total;
	public $product_product_id;
	public $order_order_id;
	public function exchangeArray($data)
	{
			$this->name  = (!empty($data['name'])) ? $data['name'] : null;
			$this->quantity = (!empty($data['quantity'])) ? $data['quantity'] : null;
			$this->price = (!empty($data['price'])) ? $data['price'] : null;
			$this->total = (!empty($data['total'])) ? $data['total'] : null;
			$this->product_product_id = (!empty($data['product_product_id'])) ? $data['product_product_id'] : null;
			$this->order_order_id = (!empty($data['order_order_id'])) ? $data['order_order_id'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>