<?php
namespace Admin\Controller;
use Zend\View\Model\ViewModel;
use VND\Controller\AbstractController;
class OrdersController extends AbstractController{
	public $_option = array(
		'tableName'	=> 'Admin\Model\OrderTable',
		'formName'	=> 'order',
	);
	public function indexAction()
	{

	}
	public function addAction()
	{
		$request = $this->getRequest();

		if($request->isPost()){
			$data = ($request->getPost());
			
			$this->_formObj->setData($data);
			if($this->_formObj->isValid()){
				$arrData = $this->_formObj->getData();
				// Thiết lập lại data 
				$objData = new \Admin\Model\Entity\OrderEntity();
				print_r($arrData);
				// $objData->exchangeArray($arrData);
				// $this->_tableObj->insertItem($objData);
			}else{
				print_r($this->_formObj->getMessages());
			}			
		}
		return new ViewModel(array(
			'_formObj'	=> $this->_formObj
		));
	}

	public function updateShippingAction()
	{
		$request = $this->getRequest();

		if($request->isPost()){
			$this->_formObj->bind($request->getPost());
			$data = ($request->getPost());
			echo '<div class="modal fade" id="UpdateShipping">
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
              <input type="hidden" name="id"  value="">
	              <div class="row">
					  <div class="col-sm-6">
					    <div class="form-group">
					      <label class="control-label strong" for="lastname">Họ</label>
					        <input class="form-control" id="LastName" name="LastName" placeholder="Nhập Họ" type="text" value="'.$data['lastname'].'" >
					    </div>
					  </div>
					  <div class="col-sm-6">
					    <div class="form-group">
					      <label class="control-label strong" for="FirstName">Tên</label>
					        <input class="form-control" id="FirstName" name="firstname" placeholder="Nhập Tên" type="text" value="'.$data['firstname'].'">
					        
					    </div>
					  </div>
					</div>

				<div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label strong" for="Company">Công ty</label>
                              <input class="form-control valid" id="Company" name="Company" placeholder="Nhập Công ty" type="text" value="Hà Nội" >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label strong" for="Phone">Số điện thoại</label>
                               <input class="form-control" id="Phone" name="Phone" placeholder="Nhập số điện thoại" type="text" value="'.$data['telephone'].'">
                          
                        </div>
                    </div>
                </div>
				<div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label strong" for="Address1">Địa chỉ</label>
                           <input class="form-control" name="address" placeholder="Nhập Địa chỉ" type="text" value="'.$data['address'].'">
                           
                    </div>
                </div>
            </div>
            <div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label strong" for="CountryId">Quốc gia</label>
							<div class="controls">
								<div class="controls">

									<select bind="country_id" bind-event-change="changeCountry()"
										class="form-control valid" id="CountryId" name="CountryId"
										style="width: 100%;" ><option value="1">United
											States</option>
										<option value="80">United Kingdom</option>
										<option value="81">United States minor outlying islands</option>
										<option value="82">Uruguay</option>
										<option value="83">Uzbekistan</option>
										<option value="84">Venezuela</option>
										<option value="85">Serbia</option>
										<option value="86">Afghanistan</option>
										<option value="87">Albania</option>
										<option value="88">Algeria</option>
										<option value="89">American Samoa</option>
										<option value="221">Tonga</option>
										<option value="222">Trinidad and Tobago</option>
										<option value="223">Tunisia</option>
										<option value="224">Turkmenistan</option>
										<option value="225">Turks and Caicos Islands</option>
										<option value="226">Tuvalu</option>
										<option value="227">Uganda</option>
										<option value="228">Vanuatu</option>
										<option value="229">Vatican City State (Holy See)</option>
										<option selected="selected" value="230">Việt Nam</option>
										<option value="231">Virgin Islands (British)</option>
										<option value="232">Virgin Islands (U.S.)</option>
										<option value="233">Wallis and Futuna Islands</option>
										<option value="234">Western Sahara</option>
										<option value="235">Yemen</option>
										<option value="236">Zambia</option>
										<option value="237">Zimbabwe</option>
									</select>
									<div class="has-error">
										<span class="help-block"><span class="field-validation-valid"
											data-valmsg-for="CountryId" data-valmsg-replace="true"></span></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label strong" for="Zip">Postal / Zip Code</label>
								<input class="form-control" id="Zip" name="Zip"
									placeholder="Nhập Postal / Zip Code" type="text" value="'.$data['Address_Zip'].'">
								
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
                <button type="button" onclick="Order.updateShipping()" class="btn btn-primary">Lưu</button>
              </div>
            </div>
            </div>
        </div>
			</div>';
		}

		return $this->response;
	}
}
?>