<?php
namespace Admin\Model\Entity;
class GroupCustomerEntity {
	public $group_customer_id;
	public $group_customer_name;
	public $sort_order;
	public function exchangeArray($data)
	{
			$this->status = (!empty($data['sort_order'])) ? $data['sort_order'] : 0;
			$this->group_customer_name = (!empty($data['group_customer_name'])) ? $data['group_customer_name'] : null;
			$this->group_customer_id = (!empty($data['group_customer_id'])) ? $data['group_customer_id'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>