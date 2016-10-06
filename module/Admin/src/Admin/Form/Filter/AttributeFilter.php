<?php
namespace Admin\Form\Filter;
use Zend\InputFilter\InputFilter;
class AttributeFilter extends InputFilter
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
		    'filters'	=> array(
		    	array('name' => 'HtmlEntities')
	    	),
		));

		$this->add(array(
		    'name' => 'attribute_group_id',
		    'required' => false,
		    'filters'	=> array(
		    	array('name' => 'HtmlEntities')
	    	),
		));
	}
}
?>