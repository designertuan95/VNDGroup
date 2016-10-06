<?php
namespace Admin\Form\Filter;
use Zend\InputFilter\InputFilter;
class FilterFilter extends InputFilter
{
	public function __construct()
	{
		$this->add(array(
		    'name' => 'name',
		    'required' => true,
		    'validator' => array(
		    	array(
		    		'name' => 'NotEmpty'
	    		)
	    	)
		    
		));
		$this->add(array(
		    'name' => 'sort_order',
		    'required' => false,
	    	'validators' => array(
    		)
		));

		$this->add(array(
		    'name' => 'parent_id',
		    'required' => false,
		    'filters'	=> array(
		    	array('name' => 'HtmlEntities')
	    	),
		));
	}
}
?>