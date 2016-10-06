<?php
namespace Admin\Form\Filter;
use Zend\InputFilter\InputFilter;
class GroupProductFilter extends InputFilter
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
	}
}
?>