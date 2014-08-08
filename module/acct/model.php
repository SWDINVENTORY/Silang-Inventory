<?php //-->

class Acct_Model extends Abstract_Model {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_primary = Acct::ACCT_ID;
	protected $_table	= Acct::ACCT_TABLE;

	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/		
	
	/* Private Methods
	-------------------------------*/
}

