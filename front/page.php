<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * The base class for any class that defines a view.
 * A view controls how templates are loaded as well as 
 * being the final point where data manipulation can occur.
 *
 * @package    Eden
 */
abstract class Front_Page extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_meta		= array();
	protected $_head 		= array();
	protected $_body 		= array();
	protected $_foot 		= array();
	protected $_messages	= array();
	
	protected $_request		= NULL;
	protected $_title 		= NULL;
	protected $_class 		= NULL;
	protected $_template 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __construct(Eden_Registry $request = NULL) {
		$this->_request = $request;
	}
	
	public function __toString() {
		try {
			$output = $this->render();
		} catch(Exception $e) {
			Eden_Error_Event::i()->exceptionHandler($e);
			return '';
		}
		
		if(is_null($output)) {
			return '';
		}
		
		return $output;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns a string rendered version of the output
	 *
	 * @return string
	 */
	abstract public function render();
	
	/* Protected Methods
	-------------------------------*/
	protected function _page() {
		$this->_head['page'] = $this->_class;
		$tpl = front()->path('template');
		$head = front()->trigger('head')->template($tpl.'/_head.phtml', $this->_head);
		//if logged out
		
		if(isset($_GET['logout'])) {
			session_destroy();
			header('Location: /login');
			//exit;
		}
		
		if(!isset($_SESSION['user'])) {
			$this->_template = '/login.phtml';
			$this->_title = 'SWD-Inventory : Login';
			$head = '';
		}
		//get the messages
		if(isset($_SESSION['messages']) && is_array($_SESSION['messages'])) {
			foreach($_SESSION['messages'] as $message) {
				$this->_addMessage($message['message'], $message['type']);
			}
			//front()->output($this->_messages);
			//exit;
			unset($_SESSION['messages']);
		}
		
		$this->_body['messages'] = $this->_messages;
		$body = front()->trigger('body')->template($tpl.$this->_template, $this->_body);
		$foot = front()->trigger('foot')->template($tpl.'/_foot.phtml', $this->_foot);
		//page
		return front()->template($tpl.'/_page.phtml', array(
			'meta' 			=> $this->_meta,
			'title'			=> $this->_title,
			'class'			=> $this->_class,
			'head'			=> $head,
			'body'			=> $body,
			'foot'			=> $foot));
	}
	
	protected function _addMessage($message, $type = NULL, $flash = false) {
		if($flash) {
			$_SESSION['messages'][] = array('type' => $type, 'message' => $message);
			return $this;
		}
		
		$this->_messages[] = array('type' => $type, 'message' => $message);
		return $this;
	}
	
	/* Private Methods
	-------------------------------*/
}