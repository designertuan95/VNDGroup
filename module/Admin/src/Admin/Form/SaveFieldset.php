<?php
namespace Admin\Form;
use Zend\Form\Fieldset;
// Set filter fieldset 
use Zend\InputFilter\InputFilterProviderInterface;
class SaveFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct(){
		// set name Fieldset
		parent::__construct('SaveFieldset');
		// Input info General
		$this->add(array(
			'name' => 'save',
			'type' => 'Button',
			'attributes' => array(
				'class' => 'btn btn-blue',
				'type'  => 'submit',
				'value' => 1,
			),
			'options' => array(
				'label' => 'Hoàn thành & Lưu'
			)
		));
	}

	public function getInputFilterSpecification(){
		return array(
			// The input filter and validator settings
			'save'	=> array(
				'required' => false,
			),
		);
	} 
}