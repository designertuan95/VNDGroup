<?php
namespace Admin\Form;
use Zend\Form\Form;
class GroupProduct extends Form
{
	public function __construct()
	{
		parent::__construct('GroupProduct');
		$this->add(new \Admin\Form\SaveFieldset());
		$this->add(new \Admin\Form\GeneralFieldset());
		$this->add(array(
            'name'          => 'name',
            'type'          => 'Text',
            'attributes'    => array(
                'class'         => 'form-control',
            ),
            'options'       => array(
                    'label' => 'Tên nhóm',
            ),
        ));
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
            'name'          => 'sort_order',
            'type'          => 'number',
            'attributes'    => array(
                'class'         => 'form-control',
                'min'		=> 0
            ),
            'options'       => array(
                    'label' => 'Vị trí sắp xếp',
            ),
        ));

        $this->add(array(
        	'name' => 'status',
        	'type' => 'checkbox',
        	'options' => array(
		        'label' => 'Cho phép hiển thị ở trang chủ',
		        'checked_value' => '1',
		        'unchecked_value' => '0'
		    )
    	));
	}
}
?>