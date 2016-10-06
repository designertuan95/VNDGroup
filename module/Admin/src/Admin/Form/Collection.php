<?php
namespace Admin\Form;
use Zend\Form\Form;
class Collection extends Form
{
	public function __construct()
	{
		parent::__construct('collection');
		$this->add(new \Admin\Form\GeneralFieldset());
		$this->add(array(
			'name' => 'name',
			'type' => 'text',
			'attributes' => array(
			   'class' => 'form-control',
			   'placeholder' => 'VD : Điện máy, tủ lạnh, máy giặt ...'
			),
			'options'   => array(
			    'label' => 'Tên danh mục'
			)
		));

		$this->add(array(
			'name'	=> 'image',
			'type'	=> 'File',
			'attributes'  => array(
				'class'	=> 'form-control',
			),
			'options'     => array(
				'label'	  => 'Hình ảnh'
			)
		));

		$this->add(array(
        	'name'	=> 'collection_group_id',
        	'type'	=> 'select',
            'attributes'    => array(
                'class'         => 'form-control',
            ),
        	'options'	=> array(
                'label' => 'Chọn danh mục cha',
        		'empty_option'	=> 'Chọn danh mục gốc ...',
        		'value_options' => array(
					'0' => 'French',
                    '1' => 'English',
                    '2' => 'Japanese',
                    '3' => 'Chinese',
    			),

    		),
    		
    	));
	}
}
?>