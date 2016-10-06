<?php
$HomeRoute = array(
	'type'		=> 'Zend\Mvc\Router\Http\Literal',
	'options'	=> array(
		'route'	=> '/admin',
		'defaults'	=> array(
			'__NAMESPACE__'	=> 'Admin\Controller',
			'controller'	=> 'Index',
			'action'		=> 'index'
		)
	),
	'may_terminate'	=> true,
	'child_routes'	=> array(
		'default'	=> 	array(
			'type'	=> 'Segment',
			'options'	=> array(
				'route'	=> '/[:controller[/:action]][/]',
				'constraints'	=> array(
					'controller'	=> '[a-zA-Z0-9_-]*',
					'action'	=> '[a-zA-Z0-9_-]*'
				),
				'defaults'	=> array(

				),
			)
		),
	),
);
$AdminRoute = array(
	'type'		=> 'Zend\Mvc\Router\Http\Literal',
	'options'	=> array(
		'route'	=> '/admin',
		'defaults'	=> array(
			'__NAMESPACE__'	=> 'Admin\Controller',
			'controller'	=> 'Index',
			'action'		=> 'index'
		)
	),
	'may_terminate'	=> true,
	'child_routes'	=> array(
		'default'	=> 	array(
			'type'	=> 'Segment',
			'options'	=> array(
				'route'	=> '/[:controller[/:action][/:id]][/]',
				'constraints'	=> array(
					'controller'	=> '[a-zA-Z0-9_-]*',
					'action'		=> '[a-zA-Z0-9_-]*',
					'id'			=> '[0-9]*',
					'page'			=> '[0-9*]'
				),
				'defaults'	=> array(

				),
			)
		),
		'paginator' => array(
			'type'	=> 'Segment',
			'options' => array(
				'route' => '/:controller[/:action]/page[/:page][/]',
				'constraints'	=> array(
					'controller'	=> '[a-zA-Z0-9_-]*',
					'action'		=> '[a-zA-Z0-9_-]*',
					'page'			=> '[0-9*]*'
				),
			)
		),
	),
);
return array(
	'controllers'	=> array(
		'invokables'	=> array(
			'Admin\Controller\Index'		=> 'Admin\Controller\IndexController',
			'Admin\Controller\Products'		=> 'Admin\Controller\ProductsController',
			'Admin\Controller\Orders'		=> 'Admin\Controller\OrdersController',
			'Admin\Controller\Collections'	=> 'Admin\Controller\CollectionsController',
			'Admin\Controller\Customers'	=> 'Admin\Controller\CustomersController',
			'Admin\Controller\Discounts'	=> 'Admin\Controller\DiscountsController',
			'Admin\Controller\Pages'		=> 'Admin\Controller\PagesController',
			'Admin\Controller\Articles'		=> 'Admin\Controller\ArticlesController',
			'Admin\Controller\Links'		=> 'Admin\Controller\LinksController',
			'Admin\Controller\Themes'		=> 'Admin\Controller\ThemesController',
			'Admin\Controller\Settings'		=> 'Admin\Controller\SettingsController',
			'Admin\Controller\Attributes'	=> 'Admin\Controller\AttributesController',
			'Admin\Controller\Producers'	=> 'Admin\Controller\ProducersController',
			'Admin\Controller\Warehouse'	=> 'Admin\Controller\WarehouseController',
			'Admin\Controller\Attributegroup'	=> 'Admin\Controller\AttributegroupController',
			'Admin\Controller\Filters'			=> 'Admin\Controller\FiltersController',
			'Admin\Controller\Group-Products'	=> 'Admin\Controller\GroupProductsController',
			'Admin\Controller\Test'	=> 'Admin\Controller\TestController',
		)
		
	),	
	'view_manager'	=> array(
		'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
		'template_path_stack'		=> array(__DIR__.'/../view'),
		'template_map'	=> array(
			'layout/layout'	=> PATH_TEMPLATE.'/admin/index.phtml',
			'error/404'		=> PATH_TEMPLATE.'/error/index.phtml',
			'error/index'	=> PATH_TEMPLATE.'/error/index.phtml',

		),
		'default_template_suffix'	=> 'phtml',
		'layout'					=> 'layout/layout'
	),
	'view_helpers'	=> array(
		'invokables' => array(
				'ELementError'		=> 'VND\ViewHelper\Helper\ELementError',
		),
	),
	'router'		=> array(
		'routes'		=> array(
			'HomeRoute'		=> $HomeRoute,
			'AdminRoute'	=> $AdminRoute
		)
	),
)
?>