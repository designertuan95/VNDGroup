<?php
define('APPLICATION_PATH',realpath(dirname(__DIR__)));
define('PUBLIC_PATH',APPLICATION_PATH.'/public');
define('LIBRARY_PATH',APPLICATION_PATH.'/library');
define('VENDOR_PATH',APPLICATION_PATH.'/vendor');
define('PATH_TEMPLATE',PUBLIC_PATH.'/template');
define('PATH_APPLICATION','/');
define('URL_PUBLIC',PATH_APPLICATION.'public');
define('URL_TEMPLATE',URL_PUBLIC.'/template');
define('PATH_MEDIA',PUBLIC_PATH.'/media');
define('URL_MEDIA',URL_PUBLIC.'/media');
define('APPLICATION_URL','/');

?>