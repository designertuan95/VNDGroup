<?php
return array(
	'modules'	=> array(
		'Admin',
	),
	'module_listener_options'	=> array(
		'module_paths'	=> array(
			'./module',
			'./vendor'
		),
		'config_glob_paths'	=> array(
			'config/autoload/{,*.}{global,local}.php'
		)
	),
	'service_manager'		=> array(

	)
);
?>