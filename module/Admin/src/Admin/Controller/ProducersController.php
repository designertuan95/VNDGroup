<?php
namespace Admin\Controller;
use VND\Controller\AbstractController;
use Zend\View\Model\ViewModel;
class ProducersController extends AbstractController
{
	// Còn thiếu chức năng nếu trùng tên nhà sản xuất thì không cho phép thêm mới hoặc chỉnh sửa
	public $_option = array(
		'tableName'	=> 'Admin\Model\ProducerTable',
		'formName'	=> 'producer',
		'Paginator' => array(
			'ItemCountPerPage' => 5, // Số bài trên 1 trang
			'PageRange'		   => 5, // Số trang muốn hiển thị
			'countItem'		   => 0, // Tổng số bài viết
			'CurrentPageNumber' => 1, // Trang hiện tại
		)
	);
	public function indexAction()
	{
		// Setting Paginator Attribute
		$this->_option['Paginator']['countItem'] = $this->_tableObj->countItem(array('task' => 'parent_0'));
		$this->_option['Paginator']['CurrentPageNumber'] = $this->params()->fromRoute('page',1);
		// Get query and query type to filter data
		$Query = $this->getQuery();
		$arrData = $this->_option['Paginator'];
		$arrData['Query'] = $Query['key_search'];
		$listFilter = $this->_tableObj->listItem($option = array('task' => 'page'),$arrData);
		return new ViewModel(array(
			'listFilter' => $listFilter,
			'countItem'  => $this->_tableObj->countItem(),
			'Paginator' => \VND\ViewHelper\Paginator::createPaginator($this->_option['Paginator']),
			'form'		=> $this->getServiceLocator()->get('FormElementManager')->get('SearchFieldset')
		));
	}
	public function editAction()
	{ 
		// Edit action
		$id = $this->getId(null);
		try{
			$item  = $this->_tableObj->getItemById($id);
		}catch(\Exception $ex){
        	return $this->redirectAdmin('producers','index');
        }
        $this->_formObj->bind($item);
        // Get list Filter parent
        $request = $this->getRequest();
		if($request->isPost()){
			$this->_formObj->setData($request->getPost());
			if($this->_formObj->isValid()){
				$this->_tableObj->saveItem($this->_formObj->getData(),$id);
				return $this->redirectAdmin('producers','edit',$id);
			}else{
				print_r($this->_formObj->getMessages());
			}
		}
		return new ViewModel(array(
			'_formObj' => $this->_formObj
		));
	}
	public function addAction()
	{ // Add action
		$request = $this->getRequest();
		if($request->isPost()){
			$this->_formObj->setData($request->getPost());
			if($this->_formObj->isValid()){
				$ProducerTable = new \Admin\Model\Entity\ProducerEntity();
				$ProducerTable->exchangeArray($this->_formObj->getData());
				$id = $this->_tableObj->saveItem($ProducerTable,$id = null);
				return $this->redirectAdmin('producers','edit',$id);
			}else{
				print_r($this->_formObj->getMessages());
			}
		}
		return new ViewModel(array(
			'_formObj' => $this->_formObj
		));
	}
	public function deleteAction()
	{
		$this->_tableObj->deleteItem($this->getId());
		return $this->redirectAdmin('filters','index');
	}
}
?>