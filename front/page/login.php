<?php

class Front_Page_Login extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory : Login';
	protected $_class = 'login';
	protected $_template = '/login.phtml';
	protected $_errors = null;
	
	public function render() {		
		if(isset($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
			if($_POST['username'] == 'admin' &&  $_POST['password'] == 'password') {
				$_SESSION['user'] = 'me';
				header('Location: /');
				exit;
			}
			
			if($_POST['username'] == 'admin' &&  $_POST['password'] == 'admin') {
				$_SESSION['user'] = 'me';
				header('Location: /');
				exit;
			}
			
			if($_POST['username'] == 'accounting' &&  $_POST['password'] == 'accounting') {
				$_SESSION['user'] = 'me';
				header('Location: /');
				exit;
			}
		}
		return $this->_page();
	}
}
