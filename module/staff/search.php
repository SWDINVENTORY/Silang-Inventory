<?php //-->
class Staff_Search extends Abstract_Search {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_collection	= Staff::COLLECTION;
	protected $_model		= Staff::MODEL;
	protected $_table		= Staff::STAFF_TABLE;
	
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
	public function getAll() {
		$search = $this->Staff()->search()
			->setTable($this->_table)
			->setColumns(array(Staff::STAFF_ID, Staff::STAFF_NAME, Staff::STAFF_POSITION, Staff::STAFF_ID_NO Staff::STAFF_CREATED Staff::STAFF_UPDATED))
			->sortByStaffCreated('ASC');
		return $search->getRows();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}