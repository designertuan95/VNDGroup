<?php
namespace Admin\Controller;
use VND\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\InputFilter\InputFilter;

class AttributesController extends AbstractController
{
	public $_option = array(
		'tableName'	=> 'Admin\Model\AttributeTable',
		'formName'	=> 'attribute',
		'Paginator' => array(
			'ItemCountPerPage' => 5, // Số bài trên 1 trang
			'PageRange'		   => 2, // Số trang muốn hiển thị
			'countItem'		   => 0, // Tổng số bài viết
			'CurrentPageNumber' => 1, // Trang hiện tại
		)
	);
	public function getGroupTable(){
		return $this->getServiceLocator()->get('Admin\Model\AttributeGroupTable');
	}
	public function insertItem($tableObj,$action)
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if(!$id){
		    return $this->redirect()->toRoute('AdminRoute/default', array(
		        'controller' => 'attributes',
		        'action' => $action
		     ));
		}
		// Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try{
        	$item = $tableObj->getItemById($id);
        }catch(\Exception $ex){
        	return $this->redirect()->toRoute('AdminRoute/default', array(
		        'controller' => 'attributes',
		        'action' => 'index'
		    ));
        }
		$request = $this->getRequest();
		$this->_formObj->bind($item);
		$request = $this->getRequest();
		if($request->isPost()){
			$this->_formObj->setData($request->getPost());
			if($this->_formObj->isValid()){
				$tableObj->saveItem($item);
				$this->redirectAdmin('attributes','index');
			}
			else{
				print_r($this->_formObj->getMessages());
			}
		}
		return new ViewModel(array(
			'id'	=> $id
		));
	}
	public function addItem($tableObj)
	{
		$request = $this->getRequest();
		if($request->isPost() )
		{
			$this->_formObj->setData($request->getPost());
			if($this->_formObj->isValid()){
				$AttributeTable = new \Admin\Model\Entity\AttributeEntity();
				$AttributeTable->exchangeArray($this->_formObj->getData());
				$tableObj->saveItem($AttributeTable);
				$this->redirectAdmin('attributes','index');
			}
			else{
				print_r($this->_formObj->getMessages());
			}
		}
	}
	public function deleteItem($tableObj)
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		$request = $this->getRequest();
		if($request->isPost()){
			$validator = new \Zend\Validator\Digits();
			$error = array();
			$id = array();
			$data = $request->getPost();
			// Object to array
			$data = get_object_vars($data);
			foreach($data['idSanPham'] as $idItem){
				if($validator->isValid($idItem)){
					$id[] = $idItem;
				}else{
					$error[] = $validator->getMessages();
				}
			}
		}
		$tableObj->deleteItem($id,$option = array('task' => 'item'));
		$this->redirectAdmin('attributes','index');
	}
	public function indexAction()
	{
		// Setting Paginator Attribute
		$this->_option['Paginator']['countItem'] = $this->_tableObj->countItem();
		$this->_option['Paginator']['CurrentPageNumber'] = $this->params()->fromRoute('page',1);
		$listAttr	= $this->_tableObj->listItem(array('type' => 'page'),$this->_option['Paginator']);
		$listGroup  = $this->getGroupTable()->listItem();
		$type_search  = (int) $this->params()->fromQuery('page', 0);
		$valueSearch = $this->params()->fromQuery('Query');
		if(!empty($valueSearch)){
			if($type_search == 1) $listGroup = $this->getGroupTable()->listItem($option  = array('type' => 'search'),$data = array('Query' => $valueSearch)); 
			elseif($type_search == 2) $listAttr = $this->_tableObj->listItem($option  = array('type' => 'search'),$data = array('Query' => $valueSearch));
		}
		
		// Attribute Group Table
		return new ViewModel(array(
			'data'		=> $listAttr,
			'listGroup' => $listGroup,
			'_formObj'  => $this->_formObj,
			'Paginator' => \VND\ViewHelper\Paginator::createPaginator($this->_option['Paginator'])
		));
	}
	public function editAction()
	{
		$this->insertItem($this->_tableObj,'add-group');
		return new ViewModel(array(
			'_formObj'	=> $this->_formObj
		));
	}
	public function addAction()
	{
		$this->addItem($this->_tableObj);
		return new ViewModel(array(
			'_formObj'	=> $this->_formObj
		));
	}

	public function deleteAction()
	{
		$this->deleteItem($this->_tableObj);
		return $this->response;
	}
	public function deleteGroupAction()
	{
		$this->deleteItem($this->getGroupTable());
		return $this->response;
	}
	public function addGroupAction()
	{
		$this->addItem($this->getGroupTable());
		return new ViewModel(array(
			'_formObj'	=> $this->_formObj
		));
	}
	
	public function editGroupAction()
	{
		$tableObj = $this->getGroupTable();
		$this->insertItem($tableObj,'add-group');
		return new ViewModel(array(
			'_formObj'	=> $this->_formObj
		));
	}
}
?>