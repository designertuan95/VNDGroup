<?php
namespace Admin\Form\Filter;
use Zend\InputFilter\InputFilter;
class OrderFilter extends InputFilter{
	public function __construct(){
		$this->add(array(
		    'name' => 'pay-later',
		    'required' => false,
		    'filters'	=> array(
		    	array('name' => 'HtmlEntities')
	    	),
		    'validators' => array(
		        array(
		            'name' => 'string_length',
		            'options' => array(
		                'min' => 5
		            ),
		        ),
		    ),
		));
		$this->add(array(
				'name' => 'email',
				'required' => false,
				'filters'	=> array(
						array('name' => 'HtmlEntities')
				),

		));
		$this->add(array(
			'name' => 'district',
			'required' => false,
		));
		$this->add(array(
			'name' => 'city',
			'required' => false,
		));
		$this->add(array(
				'name' => 'accepts_marketing',
				'required' => false,
				'filters'	=> array(
						array('name' => 'HtmlEntities')
				),
		
		));
		$this->add(array(
				'name' => 'payment_district',
				'required' => false,
				'filters'	=> array(
						array('name' => 'HtmlEntities')
				),
		
		));
		$this->add(array(
				'name' => 'payment_city',
				'required' => false,
				'filters'	=> array(
						array('name' => 'HtmlEntities')
				),
		
		));

	}
}
?>