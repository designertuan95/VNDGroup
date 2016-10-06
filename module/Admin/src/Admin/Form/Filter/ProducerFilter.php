<?php
namespace Admin\Form\Filter;
use Zend\InputFilter\InputFilter;
class ProducerFilter extends InputFilter{
	public function __construct(){
		$this->add(array(
		    'name' => 'name',
		    'required' => true,
		    'filters'	=> array(
		    	array('name' => 'HtmlEntities')
	    	),
		    'validators' => array(
		        array(
		            'name' => 'string_length',
		            'options' => array(
		                'min' => 1
		            ),
		        ),
		    ),
		));

	}
}
?>