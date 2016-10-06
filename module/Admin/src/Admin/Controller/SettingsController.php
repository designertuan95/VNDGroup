<?php
namespace Admin\Controller;
use Zend\View\Model\ViewModel;
use VND\Controller\AbstractController;
class SettingsController extends AbstractController{
	public $_option = array(
		'tableName'	=> 'Admin\Model\AttributeTable',
		'formName'	=> 'setting',
	);
	public function indexAction()
	{

	}
	public function addAction()
	{
		return new ViewModel(array(
			'_formObj'	=> $this->_formObj
		));
	}
	public function fileAction(){
		
	}
}
?>