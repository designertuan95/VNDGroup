<?php
namespace Admin\Controller;
use VND\Controller\AbstractController;
use Zend\View\Model\ViewModel;
class FiltersController extends AbstractController
{
	public $_option = array(
		'tableName'	=> 'Admin\Model\FilterTable',
		'formName'	=> 'filter',
		'Paginator' => array(
			'ItemCountPerPage' => 3, // Số bài trên 1 trang
			'PageRange'		   => 2, // Số trang muốn hiển thị
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
		$id = $this->getId();
		try{
			$item  = $this->_tableObj->getItemById($id);
		}catch(\Exception $ex){
        	return $this->redirectAdmin('filters','index');
        }
        // Get list Filter parent
        $listItemParent = $this->_tableObj->listItem(
			array('task' => 'list-parent'),
			array('parent_id' => $item->filter_id)
		);
        $request = $this->getRequest();
		if($request->isPost()){
			$validate = $this->validateForm($request->getPost());
			$status = ($this->_tableObj->saveItem($validate['success'],$id));
			if(empty($status['error'])) return $this->redirectAdmin('filters','edit',$id);
		}
		return new ViewModel(array(
			'data' => array('Filter' => $item, 'list-parent' => $listItemParent),
			'_formObj' => $this->_formObj
		));
	}
	public function addAction()
	{ // Add action
		$request = $this->getRequest();
		if($request->isPost()){
			$validate = $this->validateForm($request->getPost());
			$id = $this->_tableObj->saveItem($validate['success']);
			return $this->redirectAdmin('filters','edit',$id);
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
	public function validateForm(){
		$request = $this->getRequest();
		$error = array();
		$data = array();
		$this->_formObj->setData($request->getPost());
		$filterData = $request->getPost('filter');
		if($this->_formObj->isValid()){
			// set data filter_group
			$data['filter_group'] = $this->_formObj->getData();
			if(!empty($filterData)){
				// Not empty filter child
				foreach($filterData as $filter){
					$this->_formObj->setData($filter);
					if($this->_formObj->isValid()){
						// set data filter
						$data['filter'][] = $this->_formObj->getData();
					}else{
						$error['filter'][] = $this->_formObj->getMessages();
					}
				}
			}
		}else{
			$error['filter_group'] = $this->_formObj->getMessages();
		}
		return array(
			'success' => $data,
			'error'  => $error,
		);
	}
}
?>