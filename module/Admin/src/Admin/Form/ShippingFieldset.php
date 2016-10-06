<?php
namespace Admin\Form;
use Zend\Form\Fieldset;
// Set filter fieldset 
use Zend\InputFilter\InputFilterProviderInterface;
class ShippingFieldset  extends Fieldset implements InputFilterProviderInterface{
	public function __construct(){
		parent::__construct('ShippingFieldset');
		// Info Shipping Customer
		$this->add(array(
			'name' => 'shipping_first_name',
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
			'name' => 'shipping_last_name',
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
			'name' => 'shipping_telephone',
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
			'name' => 'shipping_address',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Địa chỉ'
			)
		));
		$this->add(array(
			'name' => 'shipping_district',
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
			'name' => 'shipping_city',
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
			'name' => 'shipping_address_zip',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Postal / Zip Code',
			)
		));
	}

	public function getInputFilterSpecification(){
		return array(
			// The input filter and validator settings
			'shipping_address_zip'	=> array(
				'required' => false,
			    'filters'	=> array(
			    	array('name' => 'HtmlEntities')
		    	),
			    'validators' => array(
			
			    ),
			),
				
			'shipping_district'	=> array(
					'required' => false,
					'filters'	=> array(
							array('name' => 'HtmlEntities')
					),
					'validators' => array(
								
						
					),
			),
			'shipping_city'	=> array(
					'required' => false,
					'filters'	=> array(
							array('name' => 'HtmlEntities')
					),
				
			),
		);
	} 
}
?>