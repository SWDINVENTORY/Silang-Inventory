<?php

class Staff extends Abstract_Model {
	/* Constants
	-------------------------------*/
	const COLLECTION = 'Staff_Collection';
	const SEARCH = 'Staff_Search';
	const MODEL = 'Staff_Model';
	
	const STAFF_TABLE = 'staff';
		
	const STAFF_ID = 'staff_id';
	const STAFF_NAME = 'staff_name';
	const STAFF_POSITION = 'staff_position';
	const STAFF_ID_NO = 'staff_id_no';
	const STAFF_CREATED = 'staff_created';
	const STAFF_UPDATED = 'staff_updated';
		
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_search		= self::SEARCH;
	protected $_collection	= self::COLLECTION;
	protected $_model		= self::MODEL;
	protected $_table		= self::STAFF_TABLE;
	protected $_primary		= self::STAFF_ID;
	protected $_database	= NULL;
	protected $_app			= NULL;

	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getSingleton(__CLASS__);
	}

	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function __construct() {
		$this->_app = Eden::i()->getActiveApp();
		$this->_database = $this->_app->getDatabase();
	}
	
	public function search() {
		return $this->_database
			->search()
			->setTable($this->_table)
			->setModel($this->_model);
	}

	public function getAll() {
		return $this->_getAll(
				array(
				Staff::STAFF_ID,
				Staff::STAFF_NAME,
				Staff::STAFF_POSITION,
				Staff::STAFF_ID_NO,
			->sortByStaffCreated('ASC')
			->getRows();
	}
	
	public function model($value = NULL, $key = 'user_id') {
		$model = $this->Supplier_Model()->setDatabase($this->_database);
		
		if(!is_null($value)) {
			
			$model->load($value, $key);
		}
		
		return $model;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}