<?php
namespace Admin\Form;
use Zend\InputFilter\InputFilter;
class AttributeFilter extends InputFilter
{
	public function __construct($data = null)
	{
		

		$this->add(array(
		    'name' => 'name',
		    'required' => true,
		    'filters'	=> array(
		    	array('name' => 'HtmlEntities')
	    	),
		    'validators' => array(
		        array(
		            'name' => 'not_empty',
		        ),
		        array(
		            'name' => 'string_length',
		            'options' => array(
		                'min' => 5
		            ),
		        ),
		    ),
		));

		$this->add(array(
		    'name' => 'describe',
		    'required' => true,
		    'filters'	=> array(
		    	array('name' => 'HtmlEntities')
	    	),
		    'validators' => array(
		        array(
		            'name' => 'not_empty',
		        ),
		        array(
		            'name' => 'string_length',
		            'options' => array(
		                'min' => 5
		            ),
		        ),
		    ),
		));
		#$this->setData($data);
		return $this;
	}
}
?>