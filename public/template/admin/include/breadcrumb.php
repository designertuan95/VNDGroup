<?php
// Set title Controller
$controller         = $this->controller;
$titleController    = array(
    'index'         => array(
        'title' => 'Trang chủ',
        'icon' => '<i class="fa fa-credit-card"></i>'
    ),
    'orders'        => array(
        'title'=>'Đơn hàng',
        'icon' => '<i class="fa fa-credit-card"></i>'
    ),
    'products'      => array(
        'title'=>'sản phẩm',
        'icon' => '<i class="fa fa-tag"></i>'
    ),
    'collections'   => array(
        'title'=>'danh mục',
        'icon' => '<i class="fa fa-tags"></i>'
    ),
    'attributes'    => array(
        'title'=>'thuộc tính sản phẩm',
        'icon' => '<i class="fa fa-credit-card"></i>'
    ),
    'producers'     => array(
        'title'=>'nhà sản xuất',
        'icon' => '<i class="fa fa-credit-card"></i>'
    ),
    'customers'     => array(
        'title'=>'khách hàng',
        'icon' => '<i class="fa fa-users"></i>'
    ),
    'warehouse'     => array(
        'title'=>'tồn kho',
        'icon' => '<i class="fa fa-credit-card"></i>'
    ),
    'discounts'     => array(
        'title'=>'khuyến mãi',
        'icon' => '<i class="fa fa-bullhorn"></i>'
    ),
    'pages'         => array(
        'title'=>'trang nội dung',
        'icon' => '<i class="fa fa-file-text"></i>'
    ),
    'articles'      => array(
        'title'=>'bài viết',
        'icon' => '<i class="fa fa-comment"></i>'
    ),
    'links'         => array(
        'title'=>'menu',
        'icon' => '<i class="fa fa-sitemap"></i>'
    ),
    'themes'        => array(
        'title'=>'giao diện',
        'icon' => '<i class="fa fa-desktop"></i>'
    ),
    'filters'        => array(
        'title'=> 'Bộ lọc nâng cao',
        'icon' => '<i class="fa fa-desktop"></i>'
    ),
    'groupproducts'        => array(
        'title'=> 'Nhóm sản phẩm',
        'icon' => '<i class="fa fa-desktop"></i>'
    ),
    'settings'      => array(
        'title'=>' '
    )
);
$titleAction        = array(
    'add'           => 'Thêm mới',
    'index'         => 'No',
    'edit'          => 'Chỉnh sửa',
    'add-group'     => 'Thêm nhóm',
    'edit-group'    => 'Sửa nhóm'
);
$settingsTitle = array(
    'file'           => array(
        'icon' => '<i class="fa fa-folder"></i>', 
        'title'=> 'Quản lý file'
    ),
    'store'          => array(
        'icon' => '<i class="fa fa-cog"></i>', 
        'title'=> 'Cấu hình chung'
    ),
    'notifications'  => array(
        'icon' => '<i class="fa fa fa-bell"></i>', 
        'title'=> 'Cấu hình thông báo'
    ),
    'checkout'       => array(
        'icon' => '<i class="fa fa-shopping-cart"></i>', 
        'title'=> 'Cấu hình thanh toán'
    ),
    'shipping'       => array(
        'icon' => '<i class="fa fa-truck"></i>', 
        'title'=> 'Cấu hình vận chuyển'
    ),
    'account'           => array(
        'icon' => '<i class="fa fa-users"></i>', 
        'title'=> 'Tài khoản'
    ),
);

$urlAdd = ($controller == 'groupproducts') ? $this->url('AdminRoute/default',array('controller' => 'group-products','action' => 'add')) : $this->url('AdminRoute/default',array('controller' => $this->controller,'action' => 'add')) ;
?>
<div class="page-breadcrumbs ">
    <ul class=" pull-left breadcrumb">
        <?php
            if($controller != 'settings'){
                $action = ($this->action == 'index') ? '' : '/ '.$titleAction[$this->action] ;
                $xHtml   = sprintf('<li>%s</li><li class="active">%s</li><li>%s</li>',$titleController[$controller]['icon'],ucwords($titleController[$controller]['title']),$action);
            }elseif($controller === 'settings'){
                $xHtml   = sprintf('<li>%s</li><li class="active">%s</li>',$settingsTitle[$action]['icon'],$settingsTitle[$action]['title']);
            }
            echo $xHtml;
        ?>
        
        
    </ul>
    <div class='pull-right action breadcrumb-action'>
    	<?php
            if($this->action == 'index' || $this->action  == 'list'){
                if($controller != 'Index'){
                   $xHtmlAction = '<div class="btn-group"><button type="button" class="btn btn-default"> Xuất file</button><button type="button" class="btn btn-default"> Nhập file</button></div><a href="'.$urlAdd.'" type="button" class="btn btn-primary"> Thêm mới</a>';
                }
            }
            else{
               // $xHtmlAction = '<div class="btn-group btn-group-filter">
               //          <a href="javascript:void(0)" class="btn btn-default" bind-event-click="">Lưu &amp; Thêm mới</a>
               //          <button href="javascript:void(0)" class="btn btn-default btn-add">Lưu</button>
               //      </div>';
                $xHtmlAction = '';
            }
            echo $xHtmlAction;
        ?>
    	
    </div>
</div>