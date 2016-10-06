<?php
namespace Admin\Model\Entity;
class OrderEntity {
	public $order_id;
	public $firstname;
	public $lastname;
	public $email;
	public $telephone;
	public $payment_firstname;
	public $payment_lastname;
	public $payment_company;
	public $payment_address_1;
	public $payment_address_2;
	public $payment_city;
	public $payment_postcode;
	public $payment_country;
	public $payment_method;
	public $payment_code;
	public $shipping_firstname;
	public $shipping_lastname;
	public $shipping_company;
	public $shipping_address_1;
	public $shipping_address_2;
	public $shipping_city;
	public $shipping_postcode;
	public $shipping_method;
	public $shipping_code;
	public $comment;
	public $total;
	public $ordercol;
	public $date_added;
	public $date_modified;
	public $customer_customer_id;
	public function exchangeArray($data)
	{
		$time = new \Zend\Stdlib\DateTime();
		
		$this->order_id  = (!empty($data['order_id'])) ? $data['order_id'] : null;
		$this->firstname  = (!empty($data['firstname'])) ? $data['firstname'] : null;
		$this->lastname  = (!empty($data['lastname'])) ? $data['lastname'] : null;
		$this->email  = (!empty($data['email'])) ? $data['email'] : null;
		$this->telephone  = (!empty($data['telephone'])) ? $data['telephone'] : null;
		$this->payment_firstname  = (!empty($data['payment_firstname'])) ? $data['payment_firstname'] : null;
		$this->payment_lastname  = (!empty($data['payment_lastname'])) ? $data['payment_lastname'] : null;
		$this->payment_company  = (!empty($data['payment_company'])) ? $data['payment_company'] : null;
		$this->payment_address_1  = (!empty($data['payment_address_1'])) ? $data['payment_address_1'] : null;
		$this->payment_address_2  = (!empty($data['payment_address_2'])) ? $data['payment_address_2'] : null;
		$this->payment_city  = (!empty($data['payment_city'])) ? $data['payment_city'] : null;
		$this->payment_postcode  = (!empty($data['payment_postcode'])) ? $data['payment_postcode'] : null;
		$this->payment_country  = (!empty($data['payment_country'])) ? $data['payment_country'] : null;
		$this->payment_method  = (!empty($data['payment_method'])) ? $data['payment_method'] : null;
		$this->payment_code  = (!empty($data['payment_code'])) ? $data['payment_code'] : null;
		$this->shipping_firstname  = (!empty($data['shipping_firstname'])) ? $data['shipping_firstname'] : null;
		$this->shipping_lastname  = (!empty($data['shipping_lastname'])) ? $data['shipping_lastname'] : null;
		$this->shipping_company = (!empty($data['shipping_company'])) ? $data['shipping_company'] : null;
		$this->shipping_address_1  = (!empty($data['shipping_address_1'])) ? $data['shipping_address_1'] : null;
		$this->shipping_address_2  = (!empty($data['shipping_address_2'])) ? $data['shipping_address_2'] : null;
		$this->shipping_city  = (!empty($data['shipping_city'])) ? $data['shipping_city'] : null;
		$this->shipping_postcode  = (!empty($data['shipping_postcode'])) ? $data['shipping_postcode'] : null;
		$this->shipping_method  = (!empty($data['shipping_method'])) ? $data['shipping_method'] : null;
		$this->shipping_code  = (!empty($data['shipping_code'])) ? $data['shipping_code'] : null;
		$this->comment  = (!empty($data['comment'])) ? $data['comment'] : null;
		$this->total = (!empty($data['total'])) ? $data['total'] : null;
		$this->date_added  = (!empty($data['date_added'])) ? $data['date_added'] : date('Y-m-d H:i:s',$time->getTimestamp());
		$this->date_modified  = (!empty($data['date_modified'])) ? $data['date_modified'] : date('Y-m-d H:i:s',$time->getTimestamp());
		$this->customer_customer_id  = (!empty($data['customer_customer_id'])) ? $data['customer_customer_id'] : null;
		#print_r($data);
		// Product
		$this->product_id = (!empty($data['product_id'])) ? $data['product_id'] : null;
		
	}
	 // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
?>