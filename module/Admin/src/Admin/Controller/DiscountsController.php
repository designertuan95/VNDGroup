<?php
namespace Admin\Controller;
use VND\Controller\AbstractController;
use Zend\View\Model\ViewModel;
class DiscountsController extends AbstractController
{
	public $_option = array(
		'tableName'	=> 'Admin\Model\CouponTable',
		'formName'	=> 'discount',
	);
	public function indexAction()
	{
		$listItem = $this->_tableObj->listItem();
		return new ViewModel(array(
			'listItem' => 	$listItem
		));
	}

	public function addAction()
	{
		$request = $this->getRequest();
		if($request->isPost()){
			$arrData = $request->getPost();
			$tableEntity = new \Admin\Model\Entity\CouponEntity();
			$tableEntity->exchangeArray($arrData);
			
			$id = $this->_tableObj->insertItem($tableEntity);
			return $this->redirectAdmin('discounts','edit',$id);
		}
		return new ViewModel(array(
			'_formObj'	=> $this->_formObj
		));
	}
	
	public function editAction()
	{
		$id = $this->getId(null);
		$itemDetail = $this->_tableObj->getItemById($id);
		$CouponProduct  = $this->getServiceLocator()->get('Admin\Model\CouponProductTable');
		$CouponCategory = $this->getServiceLocator()->get('Admin\Model\CouponCategoryTable');
		$CatInfo 		= $CouponCategory->itemSelectBox($itemDetail->coupon_id);
		$Prd = $CouponProduct->getItemById($itemDetail->coupon_id);
		$request = $this->getRequest();
		if($request->isPost()){
			$arrData = $request->getPost();
			$tableEntity = new \Admin\Model\Entity\CouponEntity();
			$tableEntity->exchangeArray($arrData);
			$this->_tableObj->insertItem($tableEntity,$id);
			return $this->redirectAdmin('discounts','edit',$id);
		}
		// Bind value
		$dateStart = date_create($itemDetail->date_start);
		$dateEnd  = date_create($itemDetail->date_end);
		$itemDetail->date_start = date_format($dateStart,'d-m-Y');
		$itemDetail->date_end   = date_format($dateEnd,'d-m-Y');
		$this->_formObj->bind($itemDetail);
		$this->_formObj->bind($CatInfo);
		return new ViewModel(array(
			'_formObj'	=> $this->_formObj,
			'prdInfo'	=> $Prd
		));
	}
	public function changeStatusAction()
	{
		$id = $this->getId(null);
		echo $this->_tableObj->changeStatus($id);
		return $this->redirectAdmin('discounts','index');
	}
	public function deleteAction() {
		$id = $this->getId(null);
		$this->_tableObj->deleteItem($id);
		return $this->redirectAdmin('discounts','index');
	}
}
?>