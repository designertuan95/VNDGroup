<?php
namespace Admin\Form;
use Zend\Form\Form;
use Admin\Model\AttributeGroup;
class Attribute extends Form
{
	public function __construct(AttributeGroup $group)
	{
		parent::__construct();
        $this->add(array(
            'name'          => 'attribute_id',
            'type'          => 'Hidden',
        ));
		$this->add(array(
            'name'          => 'name',
            'type'          => 'Text',
            'attributes'    => array(
                'class'         => 'form-control',
                'placeholder'   => 'Vd : màu sắc, dung lượng ...'
            ),
            'options'       => array(
                    'label' => 'Tên thuộc tính',
            ),
        ));

        $this->add(array(
            'name'          => 'sort_order',
            'type'          => 'number',
            'attributes'    => array(
                'class'         => 'form-control',
            ),
            'options'       => array(
                    'label' => 'Vị trí sắp xếp',
            ),
        ));

        $this->add(array(
        	'name'	=> 'attribute_group_id',
        	'type'	=> 'select',
            'attributes'    => array(
                'class'         => 'form-control select2',
            ),
        	'options'	=> array(
                'label' => 'Chọn thuộc tính cha',
        		'empty_option'	=> 'Chọn thuộc tính gốc ...',
        		'value_options' => $group->itemSelectBox(),

    		),
    		
    	));

        $this->add(array(
            'name'          => 'save_group_attribute',
            'type'          => 'button',
            'attributes'    => array(
                'class' => 'btn btn-blue',
                'type'  => 'submit',
                'value' => '1'
            ),
            'options'       => array(
                    'label' => 'Lưu làm nhóm thuộc tính',
            ),
        ));
        $this->add(array(
            'name'          => 'save_attribute',
            'type'          => 'button',
            'attributes'    => array(
                'class' => 'btn btn-blue',
                'type'  => 'submit',
                'value' => '1'
            ),
            'options'       => array(
                    'label' => 'Lưu thuộc tính',
            ),
        ));
	}
}
?>