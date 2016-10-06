<?php
namespace Admin\Model\Entity;
class UserGroupEntity {
	public $user_group_id;
	public $user_group_name;
	public $permission;
	public function exchangeArray($data)
	{
			$this->user_group_name  = (!empty($data['user_group_name'])) ? $data['user_group_name'] : null;
			$this->permission  = (!empty($data['permission'])) ? $data['permission'] : null;
			$this->user_group_id = (!empty($data['user_group_id'])) ? $data['user_group_id'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>