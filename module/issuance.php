<?php

class Issuance extends Abstract_Model {
	/* Constants
	-------------------------------*/
	const COLLECTION = 'Issuance_Collection';
	const SEARCH = 'Issuance_Search';
	const MODEL = 'Issuance_Model';
	
	const ISSUANCE_TABLE = 'issuance';
	const ISSUANCE_ID = 'issuance_id';
		
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_search		= self::SEARCH;
	protected $_collection	= self::COLLECTION;
	protected $_model		= self::MODEL;
	protected $_table		= self::ISSUANCE_TABLE;
	protected $_primary		= self::ISSUANCE_ID;
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

	public function model($value = NULL, $key = 'issuance_id') {
		$model = $this->Issuance_Model()->setDatabase($this->_database);
		
		if(!is_null($value)) {
			$model->load($value, $key);
		}
		
		return $model;
	}
	
	public function getAll() {
		return $this->_getAll('*')
			->getRows();
	}
	
	public function getIssuance($id) {
		if(!isset($id)){
			return array();
		}
		return $this->search()
			->filterByIssuanceId($id)
			->getRow();
	}
	
	public function getByIssuanceNo($issuance_no = null){
		if(!isset($issuance_no)){
			return array();
		}
		$issuance = $this->search()
			->filterByIssuanceNo($issuance_no)
			->getRow();
		$issuance['issuance_dtl'] = $this->Issuance()
			->getDetail($issuance['issuance_id']);
		
		return $issuance;
	}
	
	public function getDetail($id) {
		return $this
			->_getAll('*')
			->addFilter('issuance_id = %s', $id)
			->innerJoinOn('issuance_dtl', 'issuance_id = issuance_dtl_issuance_id')
			->innerJoinOn('ris_dtl', 'issuance_dtl_ris_dtl_id = ris_dtl_id')
			->getRows();
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}