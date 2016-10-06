<?php
$arrMenu    = array(
    array(
        'title' => 'Trang chủ',
        'icon' => '<i class="menu-icon fa fa-home"></i>',
        'class' => 'a',
        'id' => 'a',
        'link' => '/'
    ),
    array(
        'title' => 'Đơn hàng',
        'icon' => '<i class="menu-icon fa fa-credit-card"></i>',
        'class' => 'a',
        'id' => 'a',
        'link' => $this->url('AdminRoute/default',array('controller'=> 'orders'))
    ),
    array(
        'title' => 'Sản phẩm',
        'icon' => '<i class="menu-icon fa fa-tag"></i>',
        'class' => 'a',
        'id' => 'a',
        'link' => $this->url('AdminRoute/default',array('controller'=> 'products')),
        'parent'    => array(
            array(
                'title' => 'Danh sách phẩm',
                'icon' => '',
                'class' => 'a',
                'id' => 'a',
                'link' => $this->url('AdminRoute/default',array('controller'=> 'products'))
            ),
            array(
                'title' => 'Thuộc tính sản phẩm',
                'icon' => '',
                'class' => 'a',
                'id' => 'a',
                'link' => $this->url('AdminRoute/default',array('controller'=> 'attributes')),
            ),
            array(
                'title' => 'Nhóm sản phẩm',
                'icon' => '',
                'class' => 'a',
                'id' => 'a',
                'link' => $this->url('AdminRoute/default',array('controller'=> 'group-products'))
            ),
            array(
                'title' => 'Nhà cung cấp',
                'icon' => '',
                'class' => 'a',
                'id' => 'a',
                'link' => $this->url('AdminRoute/default',array('controller'=> 'producers'))
            ),
            array(
                'title' => 'Bộ lọc nâng cao',
                'icon' => '',
                'class' => 'a',
                'id' => 'a',
                'link' => $this->url('AdminRoute/default',array('controller'=> 'filters'))
            ),
        )
    ),
    
    array(
        'title' => 'Danh mục sản phẩm',
        'icon' => '<i class="menu-icon fa fa-tags"></i>',
        'class' => 'a',
        'id' => 'a',
        'link' => $this->url('AdminRoute/default',array('controller'=> 'collections'))
    ),
    array(
        'title' => 'Khách hàng',
        'icon' => '<i class="menu-icon fa fa-users"></i>',
        'class' => 'a',
        'id' => 'a',
        'link' => $this->url('AdminRoute/default',array('controller'=> 'customers'))
    ),
    array(
        'title' => 'Quản lý tồn kho',
        'icon' => '<i class="menu-icon fa fa-ambulance"></i>',
        'class' => 'a',
        'id' => 'a',
        'link' => $this->url('AdminRoute/default',array('controller'=> 'customers'))
    ),
    array(
        'title' => 'Khuyễn mãi',
        'icon' => '<i class="menu-icon fa fa-volume-up"></i>',
        'class' => 'a',
        'id' => 'a',
        'link' => $this->url('AdminRoute/default',array('controller'=> 'discounts'))
    ),
    array(
        'title' => 'Trang nội dung',
        'icon' => '<i class="menu-icon fa fa-file-text"></i>',
        'class' => 'a',
        'id' => 'a',
        'link' => $this->url('AdminRoute/default',array('controller'=> 'pages'))
    ),
    array(
        'title' => 'Blog',
        'icon' => '<i class="menu-icon fa fa-comment"></i>',
        'class' => 'a',
        'id' => 'a',
        'link' => $this->url('AdminRoute/default',array('controller'=> 'articles'))
    ),
    array(
        'title' => 'Menu',
        'icon' => '<i class="menu-icon fa fa-sitemap"></i>',
        'class' => 'a',
        'id' => 'a',
        'link' => $this->url('AdminRoute/default',array('controller'=> 'links'))
    ),
    array(
        'title' => 'Giao diện',
        'icon' => '<i class="menu-icon fa fa-desktop"></i>',
        'class' => 'a',
        'id' => 'a',
        'link' => $this->url('AdminRoute/default',array('controller'=> 'themes'))
    ),
    array(
        'title' => 'File',
        'icon' => '<i class="menu-icon fa fa-folder-open"></i>',
        'class' => 'a',
        'id' => 'a',
        'link' => $this->url('AdminRoute/default',array('controller'=> 'settings','action'=>'file'))
    ),
    array(
        'title' => 'Cấu hình',
        'icon' => '<i class="menu-icon fa fa-cogs"></i>',
        'class' => 'a',
        'id' => 'a',
        'link' => 'a',
        'parent'    => array(
            array(
                'title' => 'Cấu hình chung',
                'icon' => '<i class="menu-icon fa folder-cog"></i>',
                'class' => 'a',
                'id' => 'a',
                'link' => $this->url('AdminRoute/default',array('controller'=> 'settings','action'=>'store'))
            ),
            array(
                'title' => ' Thông báo',
                'icon' => '<i class="menu-icon fa folder-rss></i>',
                'class' => 'a',
                'id' => 'a',
                'link' => $this->url('AdminRoute/default',array('controller'=> 'settings','action'=>'notifications'))
            ),
            array(
                'title' => 'Thanh toán',
                'icon' => '<i class="menu-icon fa folder-shopping-cart"></i>',
                'class' => 'a',
                'id' => 'a',
                'link' => $this->url('AdminRoute/default',array('controller'=> 'settings','action'=>'checkout'))
            ),
            array(
                'title' => 'Vận chuyển',
                'icon' => '<i class="menu-icon fa folder-truct"></i>',
                'class' => 'a',
                'id' => 'a',
                'link' => $this->url('AdminRoute/default',array('controller'=> 'settings','action'=>'shipping'))
            ),
            array(
                'title' => 'Tài khoản',
                'icon' => '<i class="menu-icon fa folder-user"></i>',
                'class' => 'a',
                'id' => 'a',
                'link' => $this->url('AdminRoute/default',array('controller'=> 'settings','action'=>'account'))
            ),
        )
    ),
    array(
        'title' => 'Demo Page',
        'icon'  => '',
        'class' => '',
        'id'    => '',
        'link'  => 'file:///C:/Users/desig/Desktop/products-WB06R48S4/publish/html/index.html'
    )
);
$htmlMenu = '';
foreach($arrMenu as $val)
{
   
   if(!isset($val['parent']))
   {
        $htmlMenu .= sprintf('<li><a href="%s">%s<span class="menu-text">%s</span></a></li>',$val['link'],$val['icon'],$val['title']);
   }
   else
   {
        $xHtmlParent = '';
        foreach($val['parent'] as $menuParent)
        {
            $xHtmlParent    .= sprintf('<li>
                    <a href="%s"><span class="menu-text">%s</span></a></li>',$menuParent['link'],$menuParent['title']);
        }
        $htmlMenu   .= sprintf('<li>
            <a href="%s" class="menu-dropdown">%s<span class="menu-text"> %s </span><i class="menu-expand"></i></a><ul class="submenu">%s</ul></li>',$val['link'],$val['icon'],$val['title'],$xHtmlParent);
   }
}
?>
<div class="page-sidebar " id="sidebar">
    <!-- Page Sidebar Header-->
    <div class="sidebar-header-wrapper">
        <a href="#" class="navbar-brand">
                    <small>
                        <img src="<?php echo URL_TEMPLATE ?>/admin/assets/img/Aperam_Logo.svg.png" />" alt="" />
                    </small>
                </a>
    </div>
    <!-- /Page Sidebar Header -->
    <!-- Sidebar Menu -->
    <ul class="nav sidebar-menu">
        <?php echo $htmlMenu; ?>
    </ul>
    <!-- /Sidebar Menu -->
</div>  