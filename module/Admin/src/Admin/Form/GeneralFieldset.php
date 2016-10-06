<?php
namespace Admin\Form;
use Zend\Form\Fieldset;
// Set filter fieldset 
use Zend\InputFilter\InputFilterProviderInterface;
 use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class GeneralFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct(){
		// set name Fieldset
		parent::__construct('General');

		// Input info General
		$this->add(array(
			'name' => 'describe',
			'type' => 'Textarea',
			'attributes' => array(
				'class' => 'form-control',
				'rows'  => '4'
			),
			'options' => array(
				'label' => 'Mô tả'
			)
		));

		$this->add(array(
			'name' => 'detail',
			'type' => 'Textarea',
			'attributes' => array(
				'class' => 'form-control',
				'rows'  => '4'
			),
			'options' => array(
				'label' => 'Chi tiết'
			)
		));
		$this->add(array(
			'name' => 'name',
			'type' => 'Text',
			'attribute' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Tiêu đề'
			)
		));
		// Seo input
		$this->add(array(
			'name'	=> 'meta_title',
			'type'	=> 'text',
			'attributes'	=> array(
				'class'			=> 'form-control'
			),
			'options'		=> array(
				'label'		=> 'Tiêu đề trang'
			)
		));
		$this->add(array(
			'name'	=> 'meta_description',
			'type'	=> 'Textarea',
			'attributes'	=> array(
				'rows'	=> '4',
				'class'	=> 'form-control',
				
			),

			'options'		=> array(
				'label'		=> 'Mô tả trang'
			)
		));
		$this->add(array(
			'name'	=> 'alias',
			'type'	=> 'text',
			'attributes'	=> array(
				'class'			=> 'form-control'
			),
			'options'		=> array(
				'label'		=> 'Đường dẫn'
			)
		));
		// Input Status
		$this->add(array(
	        'type' => 'Zend\Form\Element\Radio',
	        'name' => 'status',
	        'options' => array(
	            'label' => 'What is your gender ?',
	            'label_attributes' => array(
                    'class' => 'radio',
                ),
	            'value_options' => array(
	                '0' => 'Hiển thị',
	                '1' => 'Ẩn',
	            ),
	        ),
	    ));
		// Input search
		$this->add(array(
			'name'	=> 'key_search',
			'type'	=> 'Text',
			'attributes'	=> array(
				'class'			=> 'form-control form-large search-input',
				'placeholder'	=> 'Nhập từ khóa cần tìm kiếm ...'
			),
			'options'		=> array(
				'label'		=> 'Đường dẫn'
			)
		));
		// Input date created
		$this->add(array(
			'name' => 'date_created',
			'type' => 'text',
			'attributes' => array(
				'class' => 'form-control date-picker',
				'data-date-format' => 'dd-mm-yyyy',
				'placeholder' => '15-9-2016'
			),
			'options' => array(
				'label' => 'Ngày tạo'
			)
		));
		// Input note
		$this->add(array(
			'name' => 'note',
			'type' => 'Textarea',
			'attributes' => array(
				'class' => 'form-control',
				'rows'  => '4',
			),
			'options' => array(
				'label' => 'Ghi chú'
			)
		));

		$this->add(array(
			'name' => 'save_and_new',
			'type' => 'button',
			'attributes' => array(
				'class' => 'btn btn-default',
				'value' => 'true',
				'type'	=> 'submit'
			),
			'options' => array(
				'label' => 'Lưu và thêm mới',
			)
		));

		$this->add(array(
			'name' => 'save',
			'type' => 'button',
			'attributes' => array(
				'class' => 'btn btn-primary',
				'value' => 'true',
				'type'	=> 'submit'
			),
			'options' => array(
				'label' => 'Lưu',
			)
		));
	}

	public function getInputFilterSpecification(){
		return array(
			// The input filter and validator settings
			'meta_title'	=> array(
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
			'status'	=> array(
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
	} 
}