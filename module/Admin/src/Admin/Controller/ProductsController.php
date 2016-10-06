<?php

namespace Admin\Controller;

use VND\Controller\AbstractController;
use Zend\View\Model\ViewModel;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator;

class ProductsController extends AbstractController {
	public $_option = array (
			'tableName' => 'Admin\Model\ProductTable',
			'formName' => 'product',
			'Paginator' => array (
					'ItemCountPerPage' => 5, // Số bài trên 1 trang
					'PageRange' => 2, // Số trang muốn hiển thị
					'countItem' => 0, // Tổng số bài viết
					'CurrentPageNumber' => 1 
			) // Trang hiện tại
 
	);

	public function indexAction() {
		$request = $this->getRequest();
		$formFilter = $this->getServiceLocator()->get('FormElementManager')->get('filterIndex');
		$formFilter->setData($request->getQuery());
		if($formFilter->isValid()) $filteValidate = $formFilter->getData();
		else return $this->redirectAdmin('products','index');
		$arrParams = array(
			'page' => 	$this->_option['Paginator'],
			'filterData' => $filteValidate,
		);
		// Set option paginator
		$this->_option ['Paginator'] ['countItem'] = $this->_tableObj->countItem ();
		$this->_option ['Paginator'] ['CurrentPageNumber'] = $this->params()->fromRoute('page', 1);
		$listItem = $this->_tableObj->listItem($option = array (
				'type' => 'Admin' 
		),$arrParams);
		$filter = $this->getServiceLocator()->get('Admin\Model\FilterTable');
		$data = $filter->itemSelectBox();
		
		return new ViewModel ( array (
				'formGeneral' => $this->_general ['form_general'],
				'sqlSelect' => $this->_tableObj->sqlSelect,
				'listItem' => $listItem,
				'Paginator' => \VND\ViewHelper\Paginator::createPaginator($this->_option ['Paginator']) ,
				'_formObj' => $formFilter,
		) );
	}
	public function editAction() {
		// Get Info Item
		$itemInfo = $this->_tableObj->getItemById($this->getId(null));
		$Album = $this->_tableObj->getAlbumImages($itemInfo->product_id);
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$flashMessenger = $this->FlashMessenger();
			$flashMessenger->setNamespace('product');
			$dataProduct = $this->getData($request);
			if($dataProduct != FALSE && $this->_tableObj->editItem($dataProduct, $itemInfo->product_id)){
				// Nếu có dữ liệu trả về là đúng hoặc không rỗng
				$flashMessenger->addSuccessMessage('Cập nhật sản phẩm thành công');
				$this->FlashMessenger()->getSuccessMessages();
				return $this->redirectAdmin('products','edit',$itemInfo->product_id);
			}else{
				$flashMessenger->addErrorMessage('Cập nhật không thành công, vui lòng nhập lại thông tin');
				$this->FlashMessenger()->getErrorMessages();
				return $this->redirectAdmin('products','edit',$itemInfo->product_id);
			}
			
		}
		$this->_formObj->bind($itemInfo);
		return new ViewModel ( array (
				'_formObj' => $this->_formObj,
				'data' => $this->_tableObj->data,
				'img' => array (
						'image' => $itemInfo->image,
						'albumImages' => $Album 
				),
				'id'	=> $itemInfo->product_id,
		) );
	}
	public function addAction() {
		$request = $this->getRequest ();
		if ($request->isPost()) {
			$flashMessenger = $this->FlashMessenger();
			$flashMessenger->setNamespace('product');
			$dataProduct = $this->getData($request);
			if($dataProduct != FALSE){
				// Nếu có dữ liệu trả về là đúng hoặc không rỗng
				$id = $this->_tableObj->insertItem($dataProduct);
				$flashMessenger->addSuccessMessage('Thêm mới sản phẩm thành công');
				$this->FlashMessenger()->getSuccessMessages();
				return $this->redirectAdmin('products','edit',$id);
			}else{
				$flashMessenger->addErrorMessage('Thêm mới không thành công, vui lòng nhập lại thông tin');
				$this->FlashMessenger()->getErrorMessages();
				return $this->redirectAdmin('products','add');
			}
		}
		return new ViewModel ( array (
				'_formObj' => $this->_formObj,
				'data' => $this->_tableObj->data 
		) );
	}
	public function getData($request)
	{
		// Get Data insert And edit action
		$arrData = $request->getPost()->toArray();
		$this->_formObj->setData($arrData);
		if ($this->_formObj->isValid()){
			$arrData = $this->_formObj->getData();
			if (! empty ($arrData['image'])) {
				foreach ($arrData['image'] as $key => $image) {
					if ($key == 0) {
						$arrData['image'] = $image;
					} else {
						$arrData['albumImages'][] = $image;
					}
				}
			}
			// Get Path
			if(empty($arrData['alias'])) $arrData['alias'] =  \VND\Plugins\Url::getUrlFormTitle($arrData['product_name']);
			$Product = new \Admin\Model\Entity\ProductEntity();
			$Product->exchangeArray($arrData);
			return $Product;
		}else{
			return false;
		}
	
	}
	// method change status item 
	public function changeStatusAction()
	{
		$request = $this->getRequest();
		$arrId = $this->getId($column = 'ids');
		$valueChange = 0;
		// Validate $id
		if ($request->isPost()) {
			$filter = $this->validatorAjax(array('task' => 'status'),$request->getPost());
			if ($filter->isValid()) {
				$valueChange = $filter->getValue('success');
			}
		}
		foreach($arrId as $id){
			// Set Conditions Update
			$arrParams = array('id' => $id,'column' => 'product_id');
			$this->_tableObj->updateColumn($arrData = array('status' => $valueChange),$arrParams);
		}
		echo 'Cập nhật trạng thái hiển thị của sản phẩm thành công';
		return $this->response;
	}
	public function deleteAction() {
		$id = $this->getId($column = 'ids');
		$this->_tableObj->deleteItem($id);
		if(!is_array($id)){
			// Nếu thực hiện xóa 1 sản phẩm thì thực hiện chuyển hướng về action = index.
			return $this->redirectAdmin('products','index');
		}
		// Xóa bằng ajax
		echo 'Xóa sản phẩm thành công';
	
		return $this->response;
	}
	public function deleteImagesAction() 
	{
		$request = $this->getRequest();
		// Xóa hình ảnh khỏi thư mục
		// Get table Product_image
		$objImages = $this->getServiceLocator()->get('Admin\Model\ProductImagesTable');
		$filter = $this->validatorAjax(array('task' => 'delete-images'),$request->getPost());
		if($filter->isValid()){
			// Product_id
			$prdId = $filter->getValue('prdId');
			// product_image_id
			$prdImgId = $filter->getValue('prdImgId');
			// linkImg
			$fileInfo = APPLICATION_PATH . $filter->getValue('imgLink');
			// Filte thumb
			$filetThumb = str_replace("/public/media/products/images/","/public/media/products/thumb/small/100.100_",$fileInfo);
			if($prdId != 0 && $prdImgId != 0){
				// Nếu product_id = 0 và product_image_id = 0 thì thực hiện xóa ảnh ở CSDL trong bảng product_image
				$arrImages = $objImages->deleteImages($prdImgId,$prdId);
			}
			// Thực hiện xóa file thumb và ảnh gốc
			echo (\VND\Plugins\Files::deleteFile($fileInfo) && \VND\Plugins\Files::deleteFile($filetThumb) ) ? 'Xóa ảnh thành công' : 'Xóa ảnh không thành công' ;
		}
		return $this->response;
	}
	// Phương thức upload ảnh ckeditor
	public function uploadAction() {
		$pathUpload = PATH_MEDIA . '/products/images';
		$pathThumb  = PATH_MEDIA . '/products/thumb/small';
		// Upload thumb
		$request = $this->getRequest();
		$filter = $this->validatorAjax(array('task' => 'images'),$request->getFiles());
		if($filter->isValid()){
			$files = ($request->getFiles());
			$Image  = \Upload\UploadImage::uploadImage($files['mediaImages'], $pathUpload, null, null);
			$thumb  = \Upload\UploadImage::uploadImage($files['mediaImages'],$pathThumb,100,100);
			echo \VND\ViewHelper\ImageView::viewAvatar($Image, $url = URL_MEDIA . '/products/images/');
		}else{
			echo 'Validator';
		}		
		return $this->response;
	}
	// Show Media //
	public function getDataFolder() {
		$dir_iterator = scandir ( PATH_MEDIA . '/products/thumb/small' );
		unset ( $dir_iterator [0], $dir_iterator [1] );
		$countItem = count($dir_iterator);
		// Set adapter
		$adapter = new \Zend\Paginator\Adapter\Null ( $countItem );
		$paginator = new \Zend\Paginator\Paginator ( $adapter );
		// Trang hiện tại
		$CurrentPageNumber = $this->params()->fromRoute('page',1);
		// Số ảnh muốn hiển thị
		$ItemCountPerPage = 10;
		$paginator->setCurrentPageNumber($CurrentPageNumber);
		// Số ảnh hiển thị trên 1 trang
		$paginator->setItemCountPerPage($ItemCountPerPage);
		// Số trang muốn hiển thị
		$paginator->setPageRange (1);
		$offset = ($CurrentPageNumber - 1) * $ItemCountPerPage;
		ksort($dir_iterator);
		$items = array_slice($dir_iterator, $offset, $ItemCountPerPage);

		return array (
				'html' => $items,
				'countPage' => $paginator->count() 
		);
	}
	public function getDataImagesAction() {
		$data = $this->getDataFolder();
		$xHtmlImgae = '';
		$items = $data ['html'];
		foreach ( $items as $image ) {
			$xHtmlImgae .= sprintf ( '<div class="col-md-3 image-to-choose">
            <div class="item" onclick="chooseProductImage(this)">
                <img src="%s">
            </div>
        </div>', \VND\ViewHelper\ImageView::viewAvatar ($image,$url = URL_MEDIA . '/products/thumb/small/' ) );
		}
		echo $xHtmlImgae;
		return $this->response;
	}
	public function showMediaFilesAction() {
		$xHtmlImgae = '';
		$data = $this->getDataFolder ();
		$countItem = $data ['countPage'];
		$items = $data ['html'];
		foreach ( $items as $image ) {
			$xHtmlImgae .= sprintf ( '<div class="col-md-3 image-to-choose">
            <div class="item" onclick="chooseProductImage(this)">
                <img src="%s">
            </div>
        </div>', \VND\ViewHelper\ImageView::viewAvatar ( $image, $url = URL_MEDIA . '/products/thumb/small/' ) );
		}
		$xHtml = '<style type="text/css">
			    .pagination > li > a, .pagination > li > span {
			    padding: 1px 10px;
			}.image-to-choose {
			    border: 1px solid #fff;
			    -moz-box-sizing: border-box;
			    box-sizing: border-box;
			    -webkit-box-sizing: border-box;
			    padding: 7px;
			}.chosen-image::before {
			    border: 2px solid #479ccf !important;
			    border-radius: 3px;
			    top: -3px;
			    right: -3px;
			    bottom: -3px;
			    left: -3px;
			}.p-arrow-prev {
			        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20viewBox%3D%220%200%2028%2028%22%3E%3Cstyle%20type%3D%22text%2Fcss%22%3Ecircle%2Cellipse%2Cline%2Cpath%2Cpolygon%2Cpolyline%2Crect%2Ctext%7Bfill%3A%23479ccf%20%21important%3B%20%7D%3C%2Fstyle%3E%3Cpath%20d%3D%22M23%2C24.7L12.5%2C14.2L23%2C3.7L20.3%2C1L7%2C14.2l13.3%2C13.3C20.3%2C27.5%2C23%2C24.7%2C23%2C24.7z%22%2F%3E%3C%2Fsvg%3E");
			    }
			
			    .p-state-disabled .p-arrow-prev {
			        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20viewBox%3D%220%200%2028%2028%22%3E%3Cstyle%20type%3D%22text%2Fcss%22%3Ecircle%2Cellipse%2Cline%2Cpath%2Cpolygon%2Cpolyline%2Crect%2Ctext%7Bfill%3A%23c3cfd8%20%21important%3B%20%7D%3C%2Fstyle%3E%3Cpath%20d%3D%22M23%2C24.7L12.5%2C14.2L23%2C3.7L20.3%2C1L7%2C14.2l13.3%2C13.3C20.3%2C27.5%2C23%2C24.7%2C23%2C24.7z%22%2F%3E%3C%2Fsvg%3E");
			    }
			
			    .p-arrow-next {
			        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20version%3D%221.1%22%20id%3D%22Layer_1%22%20x%3D%220px%22%20y%3D%220px%22%20viewBox%3D%220%200%2028%2028%22%20enable-background%3D%22new%200%200%2028%2028%22%20xml%3Aspace%3D%22preserve%22%3E%3Cstyle%20type%3D%22text%2Fcss%22%3Ecircle%2Cellipse%2Cline%2Cpath%2Cpolygon%2Cpolyline%2Crect%2Ctext%7Bfill%3A%23479ccf%20%21important%3B%20%7D%3C%2Fstyle%3E%3Cpath%20fill%3D%22%23329ECC%22%20d%3D%22M7%2C3.8l10.5%2C10.5L7%2C24.7l2.7%2C2.7L23%2C14.3L9.7%2C1C9.7%2C1%2C7%2C3.8%2C7%2C3.8z%22%2F%3E%3C%2Fsvg%3E");
			    }
			
			    .p-state-disabled .p-arrow-next {
			        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20version%3D%221.1%22%20id%3D%22Layer_1%22%20x%3D%220px%22%20y%3D%220px%22%20viewBox%3D%220%200%2028%2028%22%20enable-background%3D%22new%200%200%2028%2028%22%20xml%3Aspace%3D%22preserve%22%3E%3Cstyle%20type%3D%22text%2Fcss%22%3Ecircle%2Cellipse%2Cline%2Cpath%2Cpolygon%2Cpolyline%2Crect%2Ctext%7Bfill%3A%23c3cfd8%20%21important%3B%20%7D%3C%2Fstyle%3E%3Cpath%20fill%3D%22%23329ECC%22%20d%3D%22M7%2C3.8l10.5%2C10.5L7%2C24.7l2.7%2C2.7L23%2C14.3L9.7%2C1C9.7%2C1%2C7%2C3.8%2C7%2C3.8z%22%2F%3E%3C%2Fsvg%3E");
			    }
			
			    .p-arrow-prev, .p-arrow-next {
			        background-position: center center;
			        background-repeat: no-repeat;
			        background-size: contain;
			        display: block;
			        height: 30px;
			        text-indent: -9999px;
			        width: 16px;
			    }
			
			    .product-images-content .image-to-choose {
			        width: 20%;
			        float: left;
			        position: relative;
			    }
			
			    .product-images-content .image-to-choose .item {
			        width: 100%;
			        padding-bottom: 100%;
			        position: relative;
			    }
			
			    .product-images-content .image-to-choose .item::before {
			        border: thin solid #DCDCDC;
			        border-radius: 3px;
			        z-index: 1;
			        content: "";
			        position: absolute;
			        top: 0;
			        right: 0;
			        bottom: 0;
			        left: 0;
			    }
			
			    .product-images-content .image-to-choose .item > img {
			        position: absolute;
			        max-width: 100%;
			        max-height: 100%;
			        display: block;
			        top: 0;
			        right: 0;
			        bottom: 0;
			        left: 0;
			        margin: auto;
			    }
			
			    .product-images-content {
			        min-height: 232px;
			    }
			</style>
			<div class="product-images-content clearfix">
			     	' . $xHtmlImgae . '
			</div>
			
			
			<div class="p-grid-pager-boder row" style="float: left; margin-top: 18px; width: 100%;">
			    <ul class="pagination" style="float: right;">
			        <li class="disabled">
			            <a class="p-state-disabled p-link p-link-prev" href="javascript: void(0);" data-page-number="0">
			                <span class="p-icon p-arrow-prev"></span>
			            </a>
			        </li>
			        <li>
			            <a class="p-link p-link-next" href="javascript: void(0);" data-page-number="2">
			                <span class="p-icon p-arrow-next"></span>
			            </a>
			        </li>
			    </ul>
			</div>
			<script type="text/javascript">
			    var totalProductPageCount = parseInt(\'' . $countItem . '\');
			    $(".p-link").click(function () {
			        if (!$(this).hasClass("p-state-disabled")) {
			            var page = parseInt($(this).attr("data-page-number"));
			            $(".selected-product-image").find("input").val("");
			            if ($(this).hasClass("p-link-prev") && page > 0) {
			                $.ajax({
			                    url: \'/admin/products/getDataImages/page/\' + page,
			                    success: function (data) {
			                        $(".product-images-content").html(data);
			                        var prevPageNumber = page - 1;
			                        var nextPageNumber = page + 1;
			
			                        $(".p-link-prev").attr("data-page-number", prevPageNumber);
			                        if (prevPageNumber == 0) {
			                            $(".p-link-prev").addClass("p-state-disabled");
			                            $(".p-link-prev").parent().addClass("disabled");
			                        }
			                        if (nextPageNumber <= totalProductPageCount && $(".p-link-next").hasClass("p-state-disabled")) {
			                            $(".p-link-next").removeClass("p-state-disabled");
			                            $(".p-link-next").parent().removeClass("disabled");
			                        }
			                        $(".p-link-next").attr("data-page-number", nextPageNumber);
			                    }
			                });
			            } else if ($(this).hasClass("p-link-next") && page <= totalProductPageCount) {
			                $.ajax({
			                    url: \'/admin/products/getDataImages/page/\' + page,
			                    success: function (data) {
			                        $(".product-images-content").html(data);
			                        var prevPageNumber = page - 1;
			                        var nextPageNumber = page + 1;
			                        $(".p-link-next").attr("data-page-number", nextPageNumber);
			                        if (nextPageNumber > totalProductPageCount) {
			                            $(".p-link-next").addClass("p-state-disabled");
			                            $(".p-link-next").parent().addClass("disabled");
			                        }
			
			                        if (prevPageNumber > 0 && $(".p-link-prev").hasClass("p-state-disabled")) {
			                            $(".p-link-prev").removeClass("p-state-disabled");
			                            $(".p-link-prev").parent().removeClass("disabled");
			                        }
			                        $(".p-link-prev").attr("data-page-number", prevPageNumber);
			                    }
			                })
			            }
			        }
			    });
			</script>';
		echo $xHtml;
		return $this->response;
	}
	// End Show Media //
	public function validatorAjax($option = array(),$arrData){
		$result = false;
		$error  = false;
		$request = $this->getRequest();
		$filter = new \Zend\InputFilter\InputFilter();
		// Validator DeleteImagesAction
		switch ($option['task']){
			case  'delete-images' :
				// Validator and Filter Input
				$filter->add(array(
						'name' => 'prdId',
						'required' => true,
						'validators' => array(
							array(
							'name' => 'Digits',
							)
						)
				));
				$filter->add(array(
						'name' => 'prdImgId',
						'required' => true,
						'validators' => array(
								array(
										'name' => 'Digits',
										'min' => -1,
								)
						)
				));
				$filter->add(array(
						'name' => 'imgLink',
						'required' => FALSE,
				));
				// End Validator
				break;
			case  'images' :
				$filter->add(array(
					'name' => 'albumImages',
					'required' => false,
					'validators' => array(
						array(
						'name' => 'Zend\Validator\File\Size',
						'options' => array(
								'min' => 120,
								'max' => 6000000,
							),
						),
						array(
							'name' => 'Zend\Validator\File\Extension',
							'options' => array(
								'extension' => 'png,jpeg,jpg,gif',
							),
						),
						array(
							'name' => 'Zend\Validator\File\ImageSize',
							'options' => array(
								'minWidth' => 50,
								'minHeight' => 50,
							)
						),
						array(
							'name' => 'Zend\Validator\File\IsImage'
						),
					),
				));
				break;
			case 'status' : 
				$filter->add(array(
						'name' => 'success',
						'required' => true,
						'validators' => array(
							array(
							'name' => 'Digits',
							)
						)
				));
				
				break;
	
		}
		$filter->setData($arrData);
		return $filter;
	}
	
	public function searchProductAction(){
		$request = $this->getRequest();
		$formFilter = $this->getServiceLocator()->get('FormElementManager')->get('filterIndex');
		$formFilter->setData($request->getQuery());
		if($formFilter->isValid()) $filteValidate = $formFilter->getData();
		else return $this->redirectAdmin('products','index');
		$arrParams = array(
			'page' => 	$this->_option['Paginator'],
			'filterData' => $filteValidate,
		);
		// Set option paginator
		$this->_option ['Paginator'] ['countItem'] = $this->_tableObj->countItem();
		$this->_option ['Paginator'] ['CurrentPageNumber'] = $this->params()->fromRoute('page', 1);
		$listItem = $this->_tableObj->listItem($option = array (
				'type' => 'Admin' 
		),$arrParams);
		$xHtml = '<ul class="innerHtml play-block no-padding">';
		$type =  $request->getQuery('type');
		$line = 0;
		if($listItem->count() <= 0){
			$xHtml .= '<p class="margin-10"> Không tìm thấy sản phẩm nào</p>';
		}else{
			foreach ($listItem as $item){
			$line +=1;
			$imgThumb = str_replace("/public/media/products/images/","/public/media/products/thumb/small/100.100_",$item->image);
			$arrAdd = array(
				'product_id' => $item->product_id,
				'name' => $item->product_name,
				'image' => $imgThumb,
				'price' => $item->price,
				'quantity' => 1,
				'urlProduct' => '/admin/products/edit/'.$item->product_id,
				'line' 	=> $line,
			);
			$addLineItem = 'Order.Information.addLineItemOrder('.htmlentities(json_encode($arrAdd)).')';
			$xHtml .= sprintf('<li class="box-search-advance-head"><a href="javascript:void(0);" onclick="%s">
                    <img width="30" src="%s">
                    <span class="inline_block">%s</span></a>
                </li>',$addLineItem,$imgThumb,$item->product_name);
			}
		}
		
		
		$xHtml .= '</ul>';
		echo $xHtml;
		return $this->response;
	}
}
?>