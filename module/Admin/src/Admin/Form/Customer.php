<?php
namespace Admin\Form;
use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
class Customer extends Form{
	public function __construct(){
		parent::__construct('customer');

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
                    '1' => 'Hiển thị',
                    '0' => 'Ẩn',
                ),
            ),
        ));
        // Input note
        $this->add(array(
            'name'  => 'note',
            'type'  => 'Textarea',
            'attributes'    => array(
                'rows'  => '4',
                'class' => 'form-control summernote',
                
            ),
            'options'       => array(
                'label'     => 'Ghi chú'
            )
        ));
       
        $this->add(array(
            'name' => 'save',
            'type' => 'button',
            'attributes' => array(
                'class' => 'btn btn-primary',
                'value' => 'true',
                'type'  => 'submit'
            ),
            'options' => array(
                'label' => 'Lưu',
            )
        ));

	}
}

?>