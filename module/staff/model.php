<?php //-->

class Staff_Model extends Abstract_Model {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_primary = Staff::STAFF_ID;
	protected $_table	= Staff::STAFF_TABLE;

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

