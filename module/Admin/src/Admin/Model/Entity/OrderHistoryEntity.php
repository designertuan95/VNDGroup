<?php
namespace Admin\Model\Entity;
class OrderHistoryEntity {
	public $order_history_id;
	public $notify;
	public $comment;
	public $date_added;
	public $order_order_id;
	public function exchangeArray($data)
	{
			$this->order_history_id  = (!empty($data['order_history_id'])) ? $data['order_history_id'] : null;
			$this->notify = (!empty($data['notify'])) ? $data['notify'] : null;
			$this->comment = (!empty($data['comment'])) ? $data['comment'] : null;
			$this->date_added = (!empty($data['date_added'])) ? $data['date_added'] : null;
			$this->order_order_id = (!empty($data['order_order_id'])) ? $data['order_order_id'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>