<?php
	require '../config/define.php';
	include_once LIBRARY_PATH.'/Zend/Loader/AutoloaderFactory.php';
	// set path application
	chdir(dirname(__DIR__));
	// get path application
	# echo getcwd();
	if(!class_exists('\Zend\Loader\AutoloaderFactory'))
	{
		die('No success loader');
	}
	\Zend\Loader\AutoloaderFactory::factory(array(
		'Zend\Loader\StandardAutoloader'	=> array(
			'autoregister_zf'	=> true,
			'namespaces'		=> array(
				'VND'			=> LIBRARY_PATH.'/VND',
				'Upload'	=> VENDOR_PATH.'/Upload'

			),
		)
	));
	\Zend\Mvc\Application::init(require_once 'config/application.config.php')->run();
