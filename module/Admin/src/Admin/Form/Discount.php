<?php
namespace Admin\Form;
use Zend\Form\Form;
class Discount extends Form{
	public function __construct($arrData = null){
		parent::__construct('customer');
		$this->add(array(
				'name' => 'name',
				'type' => 'Text',
				'attributes' => array(
						'placeholder' => 'Tên chương trình khuyến mãi',
						'class' => 'form-control'
				),
				'options' => array(
				)
		));
		// Btn save
		$this->add(array(
				'name' => 'save_and_new',
				'type' => 'button',
				'attributes' => array(
						'class' => 'btn btn-default',
						'value' => 'true',
						'type'	=> 'submit'
				),
				'options' => array(
						'label' => 'Lưu làm bản nháp',
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
						'label' => 'Lưu & xuất bản',
				)
		));
		$this->add(array(
			'name' => 'code',
			'type' => 'Text',
			'attributes' => array(
				'placeholder' => 'Nhập mã khuyến mãi',
				'class' => 'form-control'
			),
			'options' => array(
			)
		));

		$this->add(array(
				'name'	=> 'category',
				'type'	=> 'select',
				'attributes'    => array(
						'class'     => 'form-control select2',
						'multiple'	=> 'multiple'
				),
				'options'	=> array(
						'value_options' => $arrData['category']->itemSelectBox(),
						'label'	=> 'Danh mục sản phẩm'
				),
		));

		$this->add(array(
			'name' => 'discount_usage_limit',
			'type' => 'Number',
			'attributes' => array(
				'class' => 'form-control'
			),
			'options' => array(
				'label' => 'Nhập số lần khuyến mãi',
			)
		));

		$this->add(array(
			'name' => 'type',
			'type' => 'Select',
			'attributes' => array(
				'class' => 'form-control'
			),
			'options' => array(
				'label' => 'Loại khuyến mãi',
				'value_options' => array(
					'0' => 'VND',
					'1' => 'Giảm %',
					'2' => 'Miễn phí vận chuyển'
				)
			)
		));

		$this->add(array(
			'name' => 'discount',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control',
				'placeholder' => '10% - 20.000 đ'
			),
			'options' => array(
				'label' => 'Giảm',
			)
		));


		$this->add(array(
				'name' => 'product_id[]',
				'type' => 'hidden',
				'attributes' => array(
						'class' => 'form-control'
				),
				'options' => array(
				)
		));
		$this->add(array(
				'name' => 'search_product',
				'type' => 'text',
				'attributes' => array(
					'class' => 'form-control',
					'placeholder' => 'Nhập từ khóa tìm kiếm ...(Tên sản phẩm, Tên variant, SKU, Tag)',
						'autocomplate' => 'off'
				),
				'options' => array(
						'label' => 'Tìm kiếm sản phẩm'
				)
		));
		$this->add(array(
			'name' => 'date_start',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control date-picker',
				'id' => "id-date-picker-1",
				'data-date-format' => 'dd-mm-yyyy',
				'placeholder' => '15-09-2016'
			),
			'options' => array(
				'label' => 'Ngày bắt đầu'
			)
		));

		$this->add(array(
			'name' => 'date_end',
			'type' => 'Text',
			'attributes' => array(
				'class' => 'form-control date-picker',
				'id' => "id-date-picker-1",
				'data-date-format' => 'dd-mm-yyyy',
				'placeholder' => '15-09-2016'
			),
			'options' => array(
				'label' => 'Ngày kết thúc'
			)
		));

		$this->add(array(
			'name' => 'never_expire',
			'type' => 'checkbox',
			'attributes' => array(
				'class' => '',
			),
			'options' => array(
		        'use_hidden_element' => true,
		        'checked_value' => '1',
		        'unchecked_value' => '0'
		    )
		));
	}
}
?>