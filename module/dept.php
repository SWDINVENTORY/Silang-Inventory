<?php
class Dept extends Abstract_Model {
	/* Constants
	-------------------------------*/
	const COLLECTION = 'Dept_Collection';
	const SEARCH = 'Dept_Search';
	const MODEL = 'Dept_Model';
	
	const DEPT_TABLE = 'dept';
		
	const DEPT_ID = 'dept_id';
	const DEPT_NAME = 'dept_name';
	const DEPT_ALIAS = 'dept_alias';
	const DEPT_CREATED = 'dept_created';
		
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_search		= self::SEARCH;
	protected $_collection	= self::COLLECTION;
	protected $_model		= self::MODEL;
	protected $_table		= self::DEPT_TABLE;
	protected $_primary		= self::DEPT_ID;
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
		return $this->_getAll('*')
			->sortByDeptCreated('ASC')
			->getRows();
	}
	
	public function model($value = NULL, $key = 'user_id') {
		$model = $this->Dept_Model()->setDatabase($this->_database);
		
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