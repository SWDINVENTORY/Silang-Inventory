<?php //-->
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT_DIR')) {
	define('ROOT_DIR', dirname(dirname(__FILE__)).DS);
}
if (!defined('WEB_DIR')) {
	define('WEB_DIR', dirname(__FILE__).DS);
}
if (!defined('FRONT_DIR')) {
	define('FRONT_DIR', dirname(dirname(__FILE__)).DS.'front'.DS);
}
if($_SERVER['REQUEST_URI'] == '/assets' 
	|| strpos($_SERVER['REQUEST_URI'], '/assets/') === 0
	|| strpos($_SERVER['REQUEST_URI'], '/assets?') === 0) {
	require('assets.php');
} else { 
	require('front.php'); 
}