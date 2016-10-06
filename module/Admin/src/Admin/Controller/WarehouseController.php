<?php
namespace Admin\Controller;
use VND\Controller\AbstractController;
use Zend\View\Model\ViewModel;
class WarehouseController extends AbstractController
{
	public $_option = array(
		'tableName'	=> 'Admin\Model\AttributeTable',
		'formName'	=> 'warehouse',
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
}
?>