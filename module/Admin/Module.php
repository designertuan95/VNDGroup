<?php
namespace Admin;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
class Module
{
	public $adapter;
	public function onBootstrap(MvcEvent $e)
	{
		$eventManager 			= $e->getApplication()->getEventManager();
		$ModuleRouteListener 	= new ModuleRouteListener();
		$ModuleRouteListener->attach($eventManager);
		$eventManager->attach('dispatch',array($this,'loadConfig'));

	}
	public function getFormElementConfig()
	{
		return array(
            'factories' => array(
            	'filterIndex' => function($sm){
            		$arrData = array();
            		$arrData['group_product'] = $sm->getServiceLocator()->get('Admin\Model\GroupDisplayHomeTable');
                    $arrData['producer'] = $sm->getServiceLocator()->get('Admin\Model\ProducerTable');
                    $arrData['category'] = $sm->getServiceLocator()->get('Admin\Model\CategoryTable');
            		$myForm = new \Admin\Form\FilterIndexAction($arrData);
            		$myForm->setInputFilter($myForm->getInputFilter());
            		return $myForm;
            	},
                'general' => function($sm){
                    $myForm = new \Admin\Form\GeneralFieldset();
                    return $myForm;
                },
                'attribute'	=> function($sm){
                    $GroupTable = $sm->getServiceLocator()->get('Admin\Model\AttributeGroupTable');
                	$myForm	= new \Admin\Form\Attribute($GroupTable);
                    $myForm->setInputFilter(new \Admin\Form\Filter\AttributeFilter());
                	return $myForm;
                },
                'SearchFieldset' => function($sm){
                    $myForm = new \Admin\Form\SearchFieldset();
                    return $myForm;
                },
                'filter' => function($sm){
                    $myForm = new \Admin\Form\Filter();
                    $myForm->setInputFilter(new \Admin\Form\Filter\FilterFilter());
                    return $myForm;
                },
                'product'	=> function($sm){
                    $arrData = array();
                    $arrData['group_product'] = $sm->getServiceLocator()->get('Admin\Model\GroupDisplayHomeTable');
                    $arrData['producer'] = $sm->getServiceLocator()->get('Admin\Model\ProducerTable');
                    $arrData['category'] = $sm->getServiceLocator()->get('Admin\Model\CategoryTable');
                    $arrData['filter']   = $sm->getServiceLocator()->get('Admin\Model\FilterTable');
                    $myForm = new \Admin\Form\Product($arrData);
                    $myForm->setInputFilter(new \Admin\Form\Filter\ProductFilter());
                	return $myForm;
                },
                'order'	=> function($sm){
                	 $myForm = new \Admin\Form\Order();
                	 $myForm->setInputFilter(new \Admin\Form\Filter\OrderFilter());
                	 return $myForm;
                },
                'producer'	=> function($sm){
                	$myForm = new \Admin\Form\Producer();
                    $myForm->setInputFilter(new \Admin\Form\Filter\ProducerFilter());
                    return $myForm;
                },
                'group_product'  => function($sm){
                    $myForm = new \Admin\Form\GroupProduct();
                    $myForm->setInputFilter(new \Admin\Form\Filter\GroupProductFilter());
                    return $myForm;
                },
                
                'collection'	=> function($sm){
                	return new \Admin\Form\Collection();
                },
                'customer'	=> function($sm){
                	return new \Admin\Form\Customer();
                },
                'warehouse'	=> function($sm){
                	return new \Admin\Form\Warehouse();
                },
                'discount'	=> function($sm){
                	$arrData = array();
                	$arrData['category'] = $sm->getServiceLocator()->get('Admin\Model\CategoryTable');
                	return new \Admin\Form\Discount($arrData);
                },
                'page'	=> function($sm){
                	return new \Admin\Form\Page();
                },
                'article'	=> function($sm){
                	return new \Admin\Form\Article();
                },
                'link'	=> function($sm){
                	return new \Admin\Form\Link();
                },
                'theme'	=> function($sm){
                	return new \Admin\Form\Theme();
                },
                'file'	=> function($sm){
                	return new \Admin\Form\File();
                },
                'setting'	=> function($sm){
                	return new \Admin\Form\Setting();
                }


            )
        );
	}
	public function getConfig()
	{
		$config = include __DIR__ . '/config/module.config.php';
	 	return $config;
	}
	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\StandardAutoloader'	=> array(
				'namespaces'	=> array(
					__NAMESPACE__	=> __DIR__.'/src/'.__NAMESPACE__,
				),
			)
		);
	}
	public function loadConfig(MvcEvent $e)
	{
		
	}
	public function getServiceConfig()
    {
        // Tool lấy code thêm model
        // $fileData = scandir(__DIR__.'/src/Admin/Model/');
        // $fileDataEntity = scandir(__DIR__.'/src/Admin/Model/Entity/');
        // unset($fileData[0],$fileData[1],$fileData[2]);
        // unset($fileDataEntity[0],$fileDataEntity[1]);
        // $xHtmlCode = '';
        // foreach($fileData as $Filename){
        //     $tmpName = explode('.',$Filename);
        //     $nameTable = 'Admin\Model\\'.$tmpName[0].'Table';
        //     $nameTableGateway = $tmpName[0].'TableGateway';
        //     $classTable  = '\Admin\Model\\'.$tmpName[0];
        //     $classEntity = '\Admin\Model\Entity\\'.$tmpName[0].'Entity()';
        //     $xHtmlCode .= sprintf("'%s' =>  function(\$sm) {
        //             \$tableGateway = \$sm->get('%s');
        //             \$table = new %s(\$tableGateway);
        //             return \$table;
        //         },
        //         '%s' => function (\$sm) {
        //             \$dbAdapter = \$sm->get('Zend\Db\Adapter\Adapter');
        //             \$resultSetPrototype = new ResultSet();
        //             \$resultSetPrototype->setArrayObjectPrototype(new %s);
        //             return new TableGateway('%s', \$dbAdapter, null, \$resultSetPrototype);
        //         },",$nameTable,$nameTableGateway,$classTable,$nameTableGateway,$classEntity,strtolower($tmpName[0]));
        // }
        $arrModel = array(
         'factories' => array(
                'Admin\Model\ProducerTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProducerTableGateway');
                    $table = new \Admin\Model\Producer($tableGateway);
                    return $table;
                },
                'ProducerTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\ProducerEntity());
                    return new TableGateway('producer', $dbAdapter, null, $resultSetPrototype);
                },
                'Admin\Model\AttributeTable' =>  function($sm) {
                    $tableGateway = $sm->get('AttributeTableGateway');
                    $table = new \Admin\Model\Attribute($tableGateway);
                    return $table;
                },
                'AttributeTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\AttributeEntity());
                    return new TableGateway('attribute', $dbAdapter, null, $resultSetPrototype);
                },

                'Admin\Model\AttributeGroupTable' =>  function($sm) {
                    $tableGateway = $sm->get('AttributeGroupTableGateway');
                    $table = new \Admin\Model\AttributeGroup($tableGateway);
                    return $table;
                },
                'AttributeGroupTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\AttributeGroupEntity());
                    return new TableGateway('attribute_group', $dbAdapter, null, $resultSetPrototype);
                },
                'Admin\Model\CategoryTable' =>  function($sm) {
                    $tableGateway = $sm->get('CategoryTableGateway');
                    $table = new \Admin\Model\Category($tableGateway);
                    return $table;
                },
                'CategoryTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\CategoryEntity());
                    return new TableGateway('category', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\CouponTable' =>  function($sm) {
                    $tableGateway = $sm->get('CouponTableGateway');
                    $table = new \Admin\Model\Coupon($tableGateway);
                    return $table;
                },
                'CouponTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\CouponEntity());
                    return new TableGateway('coupon', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\CouponCategoryTable' =>  function($sm) {
                    $tableGateway = $sm->get('CouponCategoryTableGateway');
                    $table = new \Admin\Model\CouponCategory($tableGateway);
                    return $table;
                },
                'CouponCategoryTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\CouponCategoryEntity());
                    return new TableGateway('coupon_category', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\CouponProductTable' =>  function($sm) {
                    $tableGateway = $sm->get('CouponProductTableGateway');
                    $table = new \Admin\Model\CouponProduct($tableGateway);
                    return $table;
                },
                'CouponProductTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\CouponProductEntity());
                    return new TableGateway('coupon_product', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\CustomerTable' =>  function($sm) {
                    $tableGateway = $sm->get('CustomerTableGateway');
                    $table = new \Admin\Model\Customer($tableGateway);
                    return $table;
                },
                'CustomerTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\CustomerEntity());
                    return new TableGateway('customer', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\EntityTable' =>  function($sm) {
                    $tableGateway = $sm->get('EntityTableGateway');
                    $table = new \Admin\Model\Entity($tableGateway);
                    return $table;
                },
                'EntityTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\EntityEntity());
                    return new TableGateway('entity', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\GroupCustomerTable' =>  function($sm) {
                    $tableGateway = $sm->get('GroupCustomerTableGateway');
                    $table = new \Admin\Model\GroupCustomer($tableGateway);
                    return $table;
                },
                'GroupCustomerTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\GroupCustomerEntity());
                    return new TableGateway('groupcustomer', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\GroupDisplayHomeTable' =>  function($sm) {
                    $tableGateway = $sm->get('GroupDisplayHomeTableGateway');
                    $table = new \Admin\Model\GroupDisplayHome($tableGateway);
                    return $table;
                },
                'GroupDisplayHomeTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\GroupDisplayHomeEntity());
                    return new TableGateway('group_display_home', $dbAdapter, null, $resultSetPrototype);
                },
                'Admin\Model\GroupProductTable' =>  function($sm) {
                    $tableGateway = $sm->get('GroupProductTableGateway');
                    $table = new \Admin\Model\GroupProduct($tableGateway);
                    return $table;
                },
                'GroupProductTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\GroupProductEntity());
                    return new TableGateway('group_product', $dbAdapter, null, $resultSetPrototype);
                },
                'Admin\Model\ProductFilterTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProductFilterTableGateway');
                    $table = new \Admin\Model\ProductFilter($tableGateway);
                    return $table;
                },
                'ProductFilterTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\ProductFilterEntity());
                    return new TableGateway('product_filter', $dbAdapter, null, $resultSetPrototype);
                },

                'Admin\Model\MenuTable' =>  function($sm) {
                    $tableGateway = $sm->get('MenuTableGateway');
                    $table = new \Admin\Model\Menu($tableGateway);
                    return $table;
                },
                'MenuTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\MenuEntity());
                    return new TableGateway('menu', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\OrderTable' =>  function($sm) {
                    $tableGateway = $sm->get('OrderTableGateway');
                    $table = new \Admin\Model\Order($tableGateway);
                    return $table;
                },
                'OrderTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\OrderEntity());
                    return new TableGateway('order', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\OrderHistoryTable' =>  function($sm) {
                    $tableGateway = $sm->get('OrderHistoryTableGateway');
                    $table = new \Admin\Model\OrderHistory($tableGateway);
                    return $table;
                },
                'OrderHistoryTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\OrderHistoryEntity());
                    return new TableGateway('orderhistory', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\OrderProductTable' =>  function($sm) {
                    $tableGateway = $sm->get('OrderProductTableGateway');
                    $table = new \Admin\Model\OrderProduct($tableGateway);
                    return $table;
                },
                'OrderProductTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\OrderProductEntity());
                    return new TableGateway('orderproduct', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\OrderStatusIdTable' =>  function($sm) {
                    $tableGateway = $sm->get('OrderStatusIdTableGateway');
                    $table = new \Admin\Model\OrderStatusId($tableGateway);
                    return $table;
                },
                'OrderStatusIdTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\OrderStatusIdEntity());
                    return new TableGateway('orderstatusid', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\ProductTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProductTableGateway');
                    $table = new \Admin\Model\Product($tableGateway);
                    return $table;
                },
                'ProductTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\ProductEntity());
                    return new TableGateway('product', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\ProductAttributeTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProductAttributeTableGateway');
                    $table = new \Admin\Model\ProductAttribute($tableGateway);
                    return $table;
                },
                'ProductAttributeTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\ProductAttributeEntity());
                    return new TableGateway('productattribute', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\ProductCategoryTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProductCategoryTableGateway');
                    $table = new \Admin\Model\ProductCategory($tableGateway);
                    return $table;
                },
                'ProductCategoryTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\ProductCategoryEntity());
                    return new TableGateway('product_category', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\ProductDetailTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProductDetailTableGateway');
                    $table = new \Admin\Model\ProductDetail($tableGateway);
                    return $table;
                },
                'ProductDetailTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\ProductDetailEntity());
                    return new TableGateway('product_detail', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\ProductDetailAttributeTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProductDetailAttributeTableGateway');
                    $table = new \Admin\Model\ProductDetailAttribute($tableGateway);
                    return $table;
                },
                'ProductDetailAttributeTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\ProductDetailAttributeEntity());
                    return new TableGateway('product_detail_attribute', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\ProductImagesTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProductImagesTableGateway');
                    $table = new \Admin\Model\ProductImages($tableGateway);
                    return $table;
                },
                'ProductImagesTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\ProductImagesEntity());
                    return new TableGateway('product_images', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\ProductTagsTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProductTagsTableGateway');
                    $table = new \Admin\Model\ProductTags($tableGateway);
                    return $table;
                },
                'ProductTagsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\ProductTagsEntity());
                    return new TableGateway('producttags', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\TagsTable' =>  function($sm) {
                    $tableGateway = $sm->get('TagsTableGateway');
                    $table = new \Admin\Model\Tags($tableGateway);
                    return $table;
                },
                'TagsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\TagsEntity());
                    return new TableGateway('tags', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\UserTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserTableGateway');
                    $table = new \Admin\Model\User($tableGateway);
                    return $table;
                },
                'UserTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\UserEntity());
                    return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\UserGroupTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserGroupTableGateway');
                    $table = new \Admin\Model\UserGroup($tableGateway);
                    return $table;
                },
                'UserGroupTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\UserGroupEntity());
                    return new TableGateway('usergroup', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\VndOptionTable' =>  function($sm) {
                    $tableGateway = $sm->get('VndOptionTableGateway');
                    $table = new \Admin\Model\VndOption($tableGateway);
                    return $table;
                },
                'VndOptionTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\VndOptionEntity());
                    return new TableGateway('vndoption', $dbAdapter, null, $resultSetPrototype);
                },'Admin\Model\WarehouseTable' =>  function($sm) {
                    $tableGateway = $sm->get('WarehouseTableGateway');
                    $table = new \Admin\Model\Warehouse($tableGateway);
                    return $table;
                },
                'WarehouseTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\WarehouseEntity());
                    return new TableGateway('warehouse', $dbAdapter, null, $resultSetPrototype);
                },
                'Admin\Model\FilterTable' => function ($sm){
                    $tableGateway = $sm->get('FilterTableGateway');
                    $table = new \Admin\Model\Filter($tableGateway);
                    return $table;
                },
                'FilterTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new \Admin\Model\Entity\FilterEntity());
                    return new TableGateway('filter', $dbAdapter, null, $resultSetPrototype);
                },
            )
        );
        return $arrModel;
     }
	public function getViewHelperConfig(){
// 		return array(
// 			'invokables' => array(
// 				'ElementError' => 'VND\ViewHelper\Helper\ElementError'
// 			)
// 		);
	}
}
?>