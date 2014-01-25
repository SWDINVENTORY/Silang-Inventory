<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Front_Page_Po extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory : Purchase Order';
	protected $_class = 'po';
	protected $_template = '/po.phtml';
	protected $_errors = null;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		$this->post = front()->registry()->get('post')->getArray();
		$this->request = front()->registry()->get('request', 'variables','0');
		$this->get = front()->registry()->get('get')->getArray();
		
		if(isset($this->post)) {
			$this->_setErrors();
			
			if(empty($this->_errors)) {
				$this->_process();
			}
		}
		
		//$this->_body['po'] = $this->po;
		
		$this->_body['error'] = $this->_errors;
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	
	protected function _setErrors() { }
	
	protected function _process(){
		$request = strtolower($this->request);
		switch ($request) {
			case 'furnish':
					$this->_add();
				break;
			default:
				break;
		}
	}
	
	protected function _add() {
		$po = $this->post;
		front()->output($po);
		exit;
		header('Location: /po');
		return $this;
	}
	
	/* Private Methods
	-------------------------------*/
}