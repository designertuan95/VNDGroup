<?php
namespace Admin\Model\Entity;
class GroupDisplayHomeEntity {
	public $group_display_id;
	public $name;
	public $describe;
	public $sort_order;
	public $status;
	public function exchangeArray($data)
	{
			$this->group_display_id = (!empty($data['group_display_id'])) ? $data['group_display_id'] : null;
			$this->name = (!empty($data['name'])) ? $data['name'] : null;
			$this->describe = (!empty($data['describe'])) ? $data['describe'] : null;
			$this->sort_order = (!empty($data['sort_order'])) ? $data['sort_order'] : 0;
			$this->status = (!empty($data['status'])) ? $data['status'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>