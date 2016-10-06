<?php
namespace Admin\Form;
use Zend\Form\Form;
class Article extends Form{
	public function __construct(){
		parent::__construct('article');
		$this->add(new \Admin\Form\GeneralFieldset());
		$this->add(array(
			'name'	=> 'name',
			'type'	=> 'Text',
			'attributes' => array(
			  'placeholder' => 'Nhập tiêu đề bài viết',
			  'class'  => 'form-control'
			),
			'options' => array(
				'label' => 'Tiêu đề *',
				'label_attributes' => array(
					'class' => 'control-label strong'
				)
			)
		));

		$this->add(array(
			'name' => 'Author',
			'type' => 'select',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Tác giả',
				'label_attributes' => array(
					'class' => 'radio'
				),
				'value_options' => array(
					'12' => 'Tuấn Nguyễn'
				)
			)
		));

		$this->add(array(
			'name' => 'collections',
			'type' => 'select',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Danh mục',
				'label_attributes' => array(
					'class' => 'radio'
				),
				'value_options' => array(
					'12' => 'Tin tức',
					'0' => '-----------'
				)
			)
		));

		$this->add(array(
			'name' => 'theme_option',
			'type' => 'select',
			'attributes' => array(
				'class' => 'form-control',
			),
			'options' => array(
				'label' => 'Khung giao diện',
				'label_attributes' => array(
					'class' => 'radio'
				),
				'value_options' => array(
					'12' => 'Tin tức',
					'0' => '-----------'
				)
			)
		));
	}
}
?>