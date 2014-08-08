<?php
class Acct extends Abstract_Model {
	/* Constants
	-------------------------------*/
	const COLLECTION = 'Acct_Collection';
	const SEARCH = 'Acct_Search';
	const MODEL = 'Acct_Model';
	
	const ACCT_TABLE = 'acct';
		
	const ACCT_ID = 'acct_id';
	const ACCT_NO = 'acct_no';
	const ACCT_DESC = 'acct_desc';
	const ACCT_CREATED = 'acct_created';
	const ACCT_UPDATED = 'acct_updated';
		
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_search		= self::SEARCH;
	protected $_collection	= self::COLLECTION;
	protected $_model		= self::MODEL;
	protected $_table		= self::ACCT_TABLE;
	protected $_primary		= self::ACCT_ID;
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
			->sortByAcctCreated('ASC')
			->getRows();
	}
	
	public function model($value = NULL, $key = 'user_id') {
		$model = $this->Acct_Model()->setDatabase($this->_database);
		
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