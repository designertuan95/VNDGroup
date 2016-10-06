<?php
namespace Admin\Form;
use Zend\Form\Form;
class Test extends Form{
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
			'name' => 'name_prd',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'btn btn-blue'
			),
			
		));
		
		
	}
}
?>
