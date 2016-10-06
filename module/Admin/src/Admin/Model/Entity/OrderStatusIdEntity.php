<?php
namespace Admin\Model\Entity;
class OrderStatusIdEntity {
	public $order_status_id;
	public $text;
	public function exchangeArray($data)
	{
		$this->order_status_id  = (!empty($data['order_status_id'])) ? $data['order_status_id'] : null;
		$this->text = (!empty($data['text'])) ? $data['text'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>