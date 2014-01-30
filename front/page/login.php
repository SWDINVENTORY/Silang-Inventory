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
		return $this->_page();
	}
}
