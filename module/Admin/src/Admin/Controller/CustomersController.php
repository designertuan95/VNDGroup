<?php
namespace Admin\Controller;
use VND\Controller\AbstractController;
use Zend\View\Model\ViewModel;
class CustomersController extends AbstractController
{
	public $_option = array(
		'tableName'	=> 'Admin\Model\CustomerTable',
		'formName'	=> 'customer',
	);
	public function indexAction()
	{
		$listItem = $this->_tableObj->listItem();
		return new ViewModel(array(
			'listItem' => $listItem
		));
	}

	public function addAction()
	{
		$request = $this->getRequest();
		if($request->isPost()){
			$entity  = new \Admin\Model\Entity\CustomerEntity();
			$entity->exchangeArray($request->getPost());
			$id =  $this->_tableObj->insertItem($entity);
			return $this->redirectAdmin('customers','edit',$id);
		}
		return new ViewModel(array(
			'_formObj'	=> $this->_formObj
		));
	}
	public function editAction()
	{
		$itemInfo = $this->_tableObj->getItemById($id = $this->getId(null),'customer_id');
		$request = $this->getRequest();
		if($request->isPost()){
			$entity  = new \Admin\Model\Entity\CustomerEntity();
			$entity->exchangeArray($request->getPost());
			$this->_tableObj->insertItem($entity,$itemInfo->customer_id);
			
			return $this->redirectAdmin('customers','edit',$itemInfo->customer_id);
		}
		$this->_formObj->bind($itemInfo);
		return new ViewModel(array(
			'_formObj'	=> $this->_formObj
		));
	}
	public function deleteAction() {
		$id = $this->getId($column = 'ids');
		$this->_tableObj->delete($column = 'customer_id',$table = 'customer',$id);
		if(!is_array($id)){
			// Nếu thực hiện xóa 1 sản phẩm thì thực hiện chuyển hướng về action = index.
			return $this->redirectAdmin('products','index');
		}
		// Xóa bằng ajax
		echo 'Xóa khách hàng thành công';
	
		return $this->response;
	}

	public function updateAjaxAction(){

		$request = $this->getRequest();
		$itemInfo = $this->_tableObj->getItemById($request->getPost('id'),'customer_id');
		if($request->isPost()){
			$entity  = new \Admin\Model\Entity\CustomerEntity();
			$entity->exchangeArray($request->getPost());
			$this->_tableObj->insertItem($entity,$itemInfo->customer_id);
			$itemInfo = $this->_tableObj->getItemById($itemInfo->customer_id,'customer_id');
			$message = array(
				'status' => true,
				'message' => 'Cập nhật thông tin khách hàng thành công',
				'infoItem' => get_object_vars($itemInfo)
			);
			echo json_encode($message);
		}
		return $this->response;
		
	}
	public function QuickAddAction()
	{
		$request = $this->getRequest();
		if($request->isPost()){
			$entity  = new \Admin\Model\Entity\CustomerEntity();
			$entity->exchangeArray($request->getPost());
			$id =  $this->_tableObj->insertItem($entity);
			if($id){
				$itemInfo = $this->_tableObj->getItemById($id,'customer_id');

				$message = array(
					'status' => true,
					'message' => 'Thêm mới khách hàng thành công',
					'infoItem' => get_object_vars($itemInfo)
				);
				
			}else{
				$message = array(
					'status' => true,
					'message' => 'Thêm mới khách hàng không thành công',
				);
			}
			echo json_encode($message);
		}
		return $this->response;
	}
	public function showInfoAction(){
		#echo $this->formElement($this->_formObj->get('lastname'));
		$id = $this->getRequest()->getPost('id');
		$itemInfo = $this->_tableObj->getItemById($id,'customer_id');

		echo '<div class="modal fade" id="editCustomer">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Thêm hoặc sửa thông tin giao hàng</h4>
              </div>
           <div class="modal-body">
              <!--ko if : !CustomerId()-->
              <form method="POST" action="/admin/customers/QuickAdd/">
              <input type="hidden" name="id"  value="'.$itemInfo->customer_id.'">
	              <div class="row">
				    <div class="form-group col-sm-6">
				        <label>Họ</label>
				         <input type="text" name="lastname" class="form-control" placeholder="Nguyễn Văn" value="'.$itemInfo->lastname.'">
				    </div>
				    <div class="form-group col-sm-6">
				        <label>Tên</label><input type="text" name="firstname" class="form-control" placeholder="Tuấn" value="'.$itemInfo->firstname.'">
				    </div>
				</div>

				<div class="row">
				    <div class="form-group col-sm-12">
				        <label>Email</label><input type="email" name="email" class="form-control" placeholder="vndgroupvn@gmail.com" value="'.$itemInfo->email.'">
				    </div>
				    <div class="form-group col-sm-12 ">
				       <div class="checkbox"><label class="radio"><input type="hidden" name="accepts_marketing" value="0"><input type="checkbox" name="accepts_marketing" value="1"> Khách hàng chấp nhận tiếp thị</label></div>
				    </div>
				</div>
				<div class="row">
				    <hr>
				    <div class="form-group col-sm-12">
				        <label>Địa chỉ</label>
				        <input type="text" name="address" class="form-control" value="">
				    </div>
				    <div class="form-group col-sm-6">
				        <label>Số điện thoại</label><input type="text" name="telephone" class="form-control" placeholder="VD : 01672050838" value="'.$itemInfo->telephone.'">
				    </div>
				    <div class="col-sm-6">
				      <div class="form-group">
				      <label>Postal / Zip Code</label><input type="text" name="address_zip" class="form-control" value="'.$itemInfo->address_zip.'">
				    </div>
				  </div>
				    
				</div>
				<div class="row">
				    <div class="form-group col-sm-6">
				        <label>Tỉnh/Thành phố</label>
				        <select name="city" class="form-control"><option value="1">Vĩnh Phúc</option>
				<option value="2">Hồ Chí Minh</option></select>
				    </div>
				    <div class="form-group col-sm-6">
				        <label>Quận/Huyện</label><select name="district" class="form-control"><option value="1">Sóc sơn</option>
				<option value="2">Đông Anh</option></select>
				    </div>
				</div>
				<div class="clear"></div>              
			</form>
            </div>
            <div class="modal-footer">
              <div class="pull-left">
                <a class="btn btn btn-default" data-toggle="modal" data-dismiss="modal">Đóng</a>
              </div>
              <div class="pull-right">
                <button type="button" onclick="Order.Customer.updateCustomer()" class="btn btn-primary">Lưu</button>
              </div>
            </div>
            </div>
        </div>
			</div>';
		return $this->response;
	}
	public function GetCustomerAction()
	{
		$request = $this->getRequest();
		$formFilter = $this->getServiceLocator()->get('FormElementManager')->get('filterIndex');
		$filteValidate = $request->getQuery();
		$this->_option ['Paginator']['countItem'] = $this->_tableObj->countItem();
		$this->_option ['Paginator']['CurrentPageNumber'] = $this->params()->fromRoute('page', 1);
		$this->_option ['Paginator']['ItemCountPerPage'] = 5; // Số bài trên 1 trang
		$this->_option ['Paginator']['PageRange'] = 2; // Số trang muốn hiển thị
		$arrParams = array(
			'page' => 	$this->_option['Paginator'],
			'filterData' => $filteValidate,
		);
		// Set option paginator
		
		$listItem = $this->_tableObj->listItem(array(),$arrParams);
		$xList = '';
		foreach ($listItem as $item) {
			# code...
			$itemInfo = get_object_vars($item);
			$itemInfo = json_encode($itemInfo);
			$xList .= '<li class="row">
					<a class="block-display" onclick="Order.Customer.selectCustomer('.htmlentities($itemInfo).')">
                            <div class="wrap-img inline_block vertical-align-t radius-cycle "><img class="thumb-image radius-cycle"  src="https://secure.gravatar.com/avatar/e94a11fd3fc4417cbc4520b2abb8f011.jpg?s=40&amp;d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2F18f9f20ec1a7be8020924ce0048b6ef2.jpg%3Fs%3D40" title="guest@haravan.com"></div>
                            <div class="inline_block">
                                
                                    <span>'.$item->fullname.'</span>
                               
                               

                                
                            </div> </a>
                        </li>';
		}
		$xHtml = '<ul class="no-padding">
                       '.$xList.'
                    
                        
                    </ul>';
                    echo $xHtml;
                    return $this->response;
	}
}
?>