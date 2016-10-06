<?php
namespace Admin\Form;
use Zend\Form\Form;
 use Zend\InputFilter\InputFilter;
class FilterIndexAction extends Form
{
	protected $inputFilter;
	public function __construct($arrData = null)
	{
		parent::__construct();
        $this->add(array(
            'name'          => 'Query',
            'type'          => 'text',
        	'attributes' => array(
        		'class' => "form-control",	
        		'style' => "border-radius: 0 !Important;",
        		'placeholder' => 'Nhập từ khóa cần tìm kiếm'
        	)
        ));
		$this->add(array(
            'name'          => 'filter_status',
            'type'          => 'SELECT',
            'attributes'    => array(
                'class'         => 'form-control select2',
            ),
            'options'       => array(
                'value_options'	=> array(
                	'' => 'Hiển thị',
					'1'	=> 'Hiện',
					'0'	=> 'Ẩn',
				)
            ),
        ));

        $this->add(array(
            'name'          => 'filter_collection',
            'type'          => 'SELECT',
            'attributes'    => array(
                'class'         => 'form-control select2',
            ),
            'options'       => array(
            	'empty_option'  => 'Danh mục sản phẩm',
                'value_options'	=> $arrData['category']->itemSelectBox(),
            ),
        ));
        $this->add(array(
        		'name'          => 'filter_group_product',
        		'type'          => 'SELECT',
        		'attributes'    => array(
        				'class'         => 'form-control select2',
        		),
        		'options'       => array(
        				'empty_option'  => 'Nhóm sản phẩm',
        				'value_options'	=> $arrData['group_product']->itemSelectBox(),
        		),
        ));
        $this->add(array(
        		'name'          => 'filter_vendor',
        		'type'          => 'SELECT',
        		'attributes'    => array(
        				'class'         => 'form-control select2',
        		),
        		'options'       => array(
        				'empty_option'  => 'Nhà sản xuất',
        				'value_options'	=> $arrData['producer']->itemSelectBox()
        		),
        ));
	}
	// Thực hiện validator và filter
    public function getInputFilter()
     {
     	if (!$this->inputFilter) {
     		$inputFilter = new InputFilter();
     		$inputFilter->add(array(
     				'name'     => 'Query',
     				'required' => false,
     				 
     		));
     		$inputFilter->add(array(
     				'name'     => 'filter_vendor',
     				'required' => false,
     				
     		));
     		$inputFilter->add(array(
     				'name'     => 'filter_status',
     				'required' => false,
     				 
     		));
     		$inputFilter->add(array(
     				'name'     => 'filter_group_product',
     				'required' => false,
     		
     		));
     		$inputFilter->add(array(
     				'name'     => 'filter_collection',
     				'required' => false,
     				 
     		));
     		$this->inputFilter = $inputFilter;
     	}
     
     	return $this->inputFilter;
     }
}
?>