<?php
namespace Admin\Form;
use Zend\Form\Fieldset;
// Set filter fieldset 
use Zend\InputFilter\InputFilterProviderInterface;
class InformationFieldset extends Fieldset implements InputFilterProviderInterface{
	public function __construct(){
		parent::__construct('InfomationFieldset');
		// Info Customer
		$this->add(array(
			'name' => 'firstname',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
				'placeholder' => 'Tuấn'
			),
			'options' => array(
				'label' => 'Tên'
			)
		));
		$this->add(array(
			'name' => 'lastname',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
				'placeholder' => 'Nguyễn Văn'
			),
			'options' => array(
				'label' => 'Họ đệm'
			)
		));
		$this->add(array(
			'name' => 'email',
			'type' => 'email',
			'attributes' => array(
				'class' => 'form-control',
				'placeholder' => 'vndgroupvn@gmail.com'
			),
			'options' => array(
				'label' => 'Email'
			)
		));

		$this->add(array(
			'name' => 'telephone',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
				'placeholder' => 'VD : 01672050838'
			),
			'options' => array(
				'label' => 'Số điện thoại'
			)
		));

		$this->add(array(
			'name' => 'address',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Địa chỉ'
			)
		));
		$this->add(array(
			'name' => 'district',
			'type' => 'Select',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Quận/Huyện',
				'value_options' => array(
					'1' => 'Mê Linh',
					'2' => 'Đông Anh',
					'1' => 'Sóc sơn',
				)
			)
		));
		$this->add(array(
			'name' => 'city',
			'type' => 'Select',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Tỉnh/Thành Phố',
				'value_options' => array(
					'1' => 'Hà Nội',
					'2' => 'Hồ Chí Minh',
					'1' => 'Vĩnh Phúc',
				)
			)
		));
		$this->add(array(
			'name' => 'address_zip',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Postal / Zip Code',
			)
		));
		// Input remarketing
		$this->add(array(
			'name' => 'accepts_marketing',
			'type' => 'radio',
			'attribute' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label_attributes' => array(
					'class' => 'radio'
				),
				'value_options' => array(
					'Khách hàng muốn được tiếp thị'
				)
			)
		));

		
		
	}

	public function getInputFilterSpecification(){
		return array(
			// The input filter and validator settings
			'email'	=> array(
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
			'district'	=> array(
				'required' => false,
			    'filters'	=> array(
			    	array('name' => 'HtmlEntities')
		    	),
			    'validators' => array(
			
			    ),
			),
			'city'	=> array(
				'required' => false,
			    'filters'	=> array(
			    	array('name' => 'HtmlEntities')
		    	),
			    'validators' => array(
			    
			    ),
			),
			'accepts_marketing'	=> array(
					'required' => false,
					'filters'	=> array(
							array('name' => 'HtmlEntities')
					),
					'validators' => array(
						
					),
			),
		);
	} 
}