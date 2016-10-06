<?php
namespace Admin\Form;
use Zend\Form\Fieldset;
// Set filter fieldset 
use Zend\InputFilter\InputFilterProviderInterface;
class SearchFieldset extends Fieldset implements InputFilterProviderInterface
{
	public function __construct(){
		parent::__construct('SearchFieldset');
		$this->add(array(
			'name' => 'Query',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
				'placeholder' => 'Nhập từ khóa tìm kiếm ...'
			)
		));

		$this->add(array(
			'name' => 'type',
			'type' => 'Button',
			'attributes' => array(
				'class' => 'btn btn-default',
				'value' => '1',
				'type' => 'submit'
			),
			'options' => array(
				'label' => 'Tìm kiếm'
			)
		));
	}

	public function getInputFilterSpecification(){
		$arrFilter = array(
			// The input filter and validator settings
			'name'	=> array(
				'required' => false,
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
			),
		);
		return $arrFilter;
	} 

}
?>