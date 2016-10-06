<?php
namespace Admin\Form;
use Zend\Form\Form;
class Product extends Form
{
	public function __construct($arrData = null)
	{
		parent::__construct();
		$this->add(array(
			'name'	=> 'product_name',
			'type'	=> 'Text',
			'attributes'    => array(
                'class'         => 'form-control',
                'placeholder'   => 'Vd : Apple, Samsung, LG ...',
                'required' => 'required',
				'data-bv-message' => "Tên sản phẩm không được để trống"
            ),
            'options'		=> array(
            	'label'		=> 'Tên sản phẩm'
        	)
		));
		$this->add(array(
			'name'	=> 'describe',
		 	'type'	=> 'Textarea',
		 	'attributes'	=> array(
		 		'rows'	=> '10',
				'class' => 'form-control summernote',
				'id'	=> 'ckeditor'
				
		 	),
		 	'options'		=> array(
            	'label'		=> 'Mô tả'
        	)
		));
		$this->add(array(
			'name' => 'product_image_id',
			'type' => 'hidden'
		));
		$this->add(array(
			'name'	=> 'model',
			'type'	=> 'Text',
			'attributes'    => array(
                'class'         => 'form-control',
                'placeholder'   => 'Vd : IPHONE 7 ...',
            ),
            'options'		=> array(
            	'label'		=> 'Model'
        	)
		));
		$this->add(array(
			'name'	=> 'price',
			'type'	=> 'text',
			'attributes'	=> array(
				'class'			=> 'form-control',
				'required' => true,
			),
			'options'		=> array(
				'label'		=> 'Giá'
			)
		));
		$this->add(array(
			'name'	=> 'listed_price',
			'type'	=> 'text',
			'attributes'	=> array(
				'class'			=> 'form-control',
				'placeholder'	=> 'Giá so sánh với giá thị trường (Không bắt buộc nhập)',
			),
			'options'		=> array(
				'label'		=> 'Giá so sánh'
			)
		));

		$this->add(array(
			'name'	=> 'albumImages',
			'type'	=> 'FILE',
			'attributes'	=> array(
				'class'		=> 'hide',
				'multiple'	=> 'multiple',
				'id' 	=> 'fileUpload'
			),
		));
		$this->add(array(
			'name'	=> 'SKU',
			'type'	=> 'Text',
			'attributes'	=> array(
				'class'			=> 'form-control'
			),
			'options'		=> array(
				'label'		=> 'Mã sản phẩm'
			)
		));
		$this->add(array(
			'name'	=> 'Barcode',
			'type'	=> 'Text',
			'attributes'	=> array(
				'class'			=> 'form-control'
			),
			'options'		=> array(
				'label'		=> 'BarCode'
			)
		));

		$this->add(array(
			'name'	=> 'inventory_policy',
			'type'	=> 'Select',
			'attributes'	=> array(
				'class'			=> 'form-control '
			),

			'options'		=> array(
				'label'		=> 'Chính sách tồn kho',
				'value_options'	=> array(
					'0'	=> 'Không cho phép quản lý tồn kho',
					'1'	=> 'Cho phép quản lý tồn kho',
				)
			)
		));
		$this->add(array(
			'name'	=> 'quantity',
			'type'	=> 'number',
			'attributes'	=> array(
				'class'			=> 'form-control'
			),
			'options'		=> array(
				'label'		=> 'Số lượng'
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
	    	'name'	=> 'producer_id',
	    	'type'	=> 'select',
	        'attributes'    => array(
	            'class'         => 'form-control select2',
	        ),
	    	'options'	=> array(
	    		'value_options' => $arrData['producer']->itemSelectBox(),
				'label'	=> 'Nhà sản xuất'
			),
    	));
    	$this->add(array(
	    	'name'	=> 'group_product',
	    	'type'	=> 'select',
	        'attributes'    => array(
	            'class'     => 'form-control select2',
	            'multiple'	=> 'multiple'
	        ),
	    	'options'	=> array(
	    		'value_options' => $arrData['group_product']->itemSelectBox(),
				'label'	=> 'Nhóm sản phẩm'
			),
    	));

    	$this->add(array(
	    	'name'	=> 'filter_id',
	    	'type'	=> 'select',
	        'attributes'    => array(
	            'class'     => 'form-control select2',
	            'multiple'	=> 'multiple'
	        ),
	    	'options'	=> array(
	    		'value_options' => $arrData['filter']->itemSelectBox(),
				'label'	=> 'Bộ lọc '
			),
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
}
?>