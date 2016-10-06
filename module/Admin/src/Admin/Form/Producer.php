<?php
namespace Admin\Form;
use Zend\Form\Form;
class Producer extends Form
{
	public function __construct()
	{
		parent::__construct('producer');
		$this->add(new \Admin\Form\SaveFieldset());
		$this->add(array(
			'name'	=> 'name',
			'type'	=> 'text',
			'attributes'  => array(
				'class'	=> 'form-control'
			),
			'options'     => array(
				'label'	  => 'Tên nhà sản xuất'
			)
		));
		$this->add(array(
			'name'	=> 'describe',
			'type'	=> 'Textarea',
			'attributes'  => array(
				'class'	=> 'form-control',
				'rows'	=> '5'
			),
			'options'     => array(
				'label'	  => 'Mô tả'
			)
		));

		$this->add(array(
			'name'	=> 'image',
			'type'	=> 'File',
			'attributes'  => array(
				'class'	=> 'form-control',
				'rows'	=> '5'
			),
			'options'     => array(
				'label'	  => 'Hình ảnh'
			)
		));
	}
}
?>