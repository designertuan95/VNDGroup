<?php
namespace Admin\Controller;
use Zend\View\Model\ViewModel;
use VND\Controller\AbstractController;
class TestController extends AbstractController{
	public $_option = array(
		'tableName'	=> 'Admin\Model\AttributeTable',
		'formName'	=> 'order',
	);
	public function indexAction()
	{

	}
	public function addAction()
	{
		$request = $this->getRequest();
		$form = new \Admin\Form\Test();
		if($request->isPost()){
			$data = ($request->getPost());
			print_r($data);
		}
		return new ViewModel(array(
			'_formObj'	=> $form
		));
	}
}
?>