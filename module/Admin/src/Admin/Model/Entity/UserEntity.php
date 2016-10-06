<?php
namespace Admin\Model\Entity;
class UserEntity {
	public $user_id;
	public $username;
	public $password;
	public $firstname;
	public $lastname;
	public $email;
	public $image;
	public $code;
	public $ip;
	public $status;
	public $date_added;
	public $user_group_id;
	public function exchangeArray($data)
	{
			$this->user_id  = (!empty($data['user_id'])) ? $data['user_id'] : null;
			$this->username  = (!empty($data['username'])) ? $data['username'] : null;
			$this->password  = (!empty($data['password'])) ? $data['password'] : null;
			$this->firstname  = (!empty($data['firstname'])) ? $data['firstname'] : null;
			$this->lastname  = (!empty($data['lastname'])) ? $data['lastname'] : null;
			$this->email  = (!empty($data['email'])) ? $data['email'] : null;
			$this->image  = (!empty($data['image'])) ? $data['image'] : null;
			$this->code  = (!empty($data['code'])) ? $data['code'] : null;
			$this->ip  = (!empty($data['ip'])) ? $data['ip'] : null;
			$this->status  = (!empty($data['status'])) ? $data['status'] : 0;
			$this->date_added  = (!empty($data['date_added'])) ? $data['date_added'] : null;
			$this->user_group_id = (!empty($data['user_group_id'])) ? $data['user_group_id'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>