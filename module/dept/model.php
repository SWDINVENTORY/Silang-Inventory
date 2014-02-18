<?php //-->

class Dept_Model extends Abstract_Model {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_primary = Dept::DEPT_ID;
	protected $_table	= Dept::DEPT_TABLE;

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

