<?php //-->
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT_DIR')) {
	define('ROOT_DIR', dirname(dirname(__FILE__)).DS);
}
if (!defined('WEBROOT_DIR')) {
	define('WEBROOT_DIR', dirname(__FILE__).DS);
}

if($_SERVER['REQUEST_URI'] == '/assets' 
	|| strpos($_SERVER['REQUEST_URI'], '/assets/') === 0
	|| strpos($_SERVER['REQUEST_URI'], '/assets?') === 0) {
	require('assets.php');
} else { 
	require('front.php'); 
}