<?php
namespace Admin\Form\Filter;
use Zend\InputFilter\InputFilter;
class ProductFilter extends InputFilter{
	public function __construct(){
		$this->add(array(
		    'name' => 'name',
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
		    'name' => 'price',
		    'required' => false,
		));
		$this->add(array(
				'name' => 'filter_id',
				'required' => false,
		));
		$this->add(array(
		    'name' => 'group_product',
		    'required' => false,
		));
		$this->add(array(
		    'name' => 'listed_price',
		    'required' => false,
		));
		$this->add(array(
		    'name' => 'quantity',
		    'required' => false,
		    'filters'	=> array(
		    	array('name' => 'HtmlEntities')
	    	),
		));
		$this->add(array(
		    'name' => 'category',
		    'required' => false,
		    'filters'	=> array(
		    	array('name' => 'HtmlEntities')
	    	),
		));

		$this->add(array(
		        'name' => 'albumImages',
		        'required' => false,
		        // 'validators' => array(
		        //     array(
		        //         'name' => 'Zend\Validator\File\Size',
		        //         'options' => array(
		        //             'min' => 120,
		        //             'max' => 6000000,
		        //         ),
		        //     ),
		        //     array(
		        //         'name' => 'Zend\Validator\File\Extension',
		        //         'options' => array(
		        //             'extension' => 'png,jpeg,jpg,gif',
		        //         ),
		        //     ),
		        //     array(
		        //     	'name' => 'Zend\Validator\File\ImageSize',
		        //     	'options' => array(
		        //     		'minWidth' => 50,
		        //     		'minHeight' => 50,
	         //    		)
	         //    	),
	         //    	array(
	         //    		'name' => 'Zend\Validator\File\IsImage'
          //   		)
		        // ),
	    ));

	    $this->add(array(
		        'name' => 'image',
		        'required' => false,
	    ));

	}
}
?>