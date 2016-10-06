<?php
namespace Admin\Model\Entity;
class CustomerEntity {
	public $customer_id;
	public $firstname;
	public $lastname;
	public $email;
	public $telephone;
	public $password;
	public $status;
	public $code;
	public $date_added;
	public $group_customer_id;
	public $address;
	public $city;
	public $address_zip;
	public $district;
	public $note;
	public $accepts_marketing;
	public $fullname;

	public function exchangeArray($data)
	{
			$this->customer_id  = (!empty($data['customer_id'])) ? $data['customer_id'] : null;
			$this->firstname = (!empty($data['firstname'])) ? $data['firstname'] : null;
			$this->lastname = (!empty($data['lastname'])) ? $data['lastname'] : null;
			$this->email = (!empty($data['email'])) ? $data['email'] : null;
			$this->telephone = (!empty($data['telephone'])) ? $data['telephone'] : null;
			$this->password = (!empty($data['password'])) ? $data['password'] : null;
			$this->status = (!empty($data['status'])) ? $data['status'] : 0;
			$this->code = (!empty($data['code'])) ? $data['code'] : null;
			$this->date_added = (!empty($data['date_added'])) ? $data['date_added'] : null;
			$this->group_customer_id = (!empty($data['group_customer_id'])) ? $data['group_customer_id'] : null;
			$this->accepts_marketing = (!empty($data['accepts_marketing'])) ? $data['accepts_marketing'] : 0;
			$this->fullname = $this->lastname.' '.$this->firstname;


			$this->address  = (!empty($data['address'])) ?  $data['address'] : null;
			$this->city = (!empty($data['city'])) ? $data['city'] : 0;
			$this->address_zip = (!empty($data['address_zip'])) ? $data['address_zip'] : null;
			$this->district = (!empty($data['district'])) ? $data['district'] : 0;
			$this->note = (!empty($data['note'])) ? $data['note'] : null;
	}

	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

  

}
?>