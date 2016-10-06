<?php
namespace Admin\Form;
use Zend\Form\Form;
use Admin\Model\AttributeGroup;
class Filter extends Form
{
	public function __construct()
	{
		parent::__construct();
        $this->add(new \Admin\Form\SaveFieldset());
        $this->add(array(
            'name'          => 'filter_id',
            'type'          => 'Hidden',
        ));
		$this->add(array(
            'name'          => 'name',
            'type'          => 'Text',
            'attributes'    => array(
                'class'         => 'form-control',
                'placeholder'   => 'Nhóm bộ lọc'
            ),
            'options'       => array(
                    'label' => 'Tên bộ lọc',
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
            'name'          => 'parent_id',
            'type'          => 'number',
            'attributes'    => array(
                'class'         => 'form-control',
            ),
            'options'       => array(
                    'label' => 'parent_id',
            ),
        ));
	}
}
?>