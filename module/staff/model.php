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
	
	public function staffUpdate($staff) {
		$data = $staff;
		front()->output($staff);
		$data[Staff::STAFF_UPDATED] = date('Y-m-d H:i:s', time());
		$filter 	= array();
		$filter[]	= array(Staff::STAFF_ID.'=%s',
						$data[Staff::STAFF_ID]);

		$this->_database->updateRows($this->_table, $data, $filter);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/		
	
	/* Private Methods
	-------------------------------*/
}

