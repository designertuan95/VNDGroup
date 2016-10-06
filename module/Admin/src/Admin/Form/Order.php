<?php
namespace Admin\Form;
use Zend\Form\Form;
class Order extends Form{
	public function __construct(){
		parent::__construct('orders');
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
		// Ìn input
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
			'type' => 'checkbox',
			'attribute' => array(
				'class' => 'form-control',
			),
			'options' => array(
		        'use_hidden_element' => true,
		        'checked_value' => '1',
		        'unchecked_value' => '0'
		    )
		));
		// Shipping input
		$this->add(array(
			'name' => 'shipping_firstname',
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
			'name' => 'shipping_lastname',
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
	
		// Pay input
		$this->add(array(
			'name' => 'payment_firstname',
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
			'name' => 'payment_lastname',
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
			'name' => 'payment_telephone',
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
			'name' => 'payment_address',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Địa chỉ'
			)
		));
		$this->add(array(
			'name' => 'payment_district',
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
			'name' => 'payment_city',
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
			'name' => 'payment_address_zip',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Postal / Zip Code',
			)
		));
		$this->add(array(
			'name' => 'status-pay',
			'type' => 'button',
			'attributes' => array(
				'class' => 'btn btn-blue'
			),
			'options' => array(
				'label' => 'Đã thanh toán',
				'value' => '1'
			)
		));
		$this->add(array(
			'name' => 'pay-later',
			
			'type' => 'button',
			'attributes' => array(
				'class' => 'btn btn-blue'
			),
			'options' => array(
				'label' => 'Thanh toán sau',
				'value' => '0'
			)
		));
		$this->add(array(
			'name' => 'product_id',
			'type' => 'hidden',
				
		));
		
	}
}
?>
