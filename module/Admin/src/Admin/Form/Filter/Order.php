<?php
namespace Admin\Form;
use Zend\Form\Form;
class Order extends Form{
	public function __construct(){
		parent::__construct('orders');
		$this->add(new \Admin\Form\GeneralFieldset());
		// Ìn input
		$this->add(new \Admin\Form\InformationFieldset());
		// Shipping input
		$this->add(new \Admin\Form\ShippingFieldset());
		// Pay input
		$this->add(new \Admin\Form\PaymentFieldset());
		$this->add(array(
			'name' => 'status-pay',
			'type' => 'button',
			'attributes' => array(
				'class' => 'btn btn-blue'
			),
			'options' => array(
				'label' => 'Đã thanh toán',
				'value' => '1'
			)
		));
		
		$this->add(array(
			'name' => 'pay-later',
			
			'type' => 'button',
			'attributes' => array(
				'class' => 'btn btn-blue'
			),
			'options' => array(
				'label' => 'Thanh toán sau',
				'value' => '0'
			)
		));
		$this->add(array(
			'name' => 'product_id',
			'type' => 'hidden',
				
		));
		
	}
}
?>
