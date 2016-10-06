<?php
namespace Admin\Model\Entity;
class GroupProductEntity {
	public $group_display_id;
	public $product_id;
	public function exchangeArray($data)
	{
			$this->group_display_id  = (!empty($data['group_display_id'])) ? $data['group_display_id'] : null;
			$this->product_id = (!empty($data['product_id'])) ? $data['product_id'] : null;
	}
	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>