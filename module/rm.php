<?php

class Rm extends Abstract_Model {
	/* Constants
	-------------------------------*/
	const COLLECTION = 'Rm_Collection';
	const SEARCH = 'Rm_Search';
	const MODEL = 'Rm_Model';
	
	const RM_TABLE = 'rm';
	const RM_ID = 'rm_id';
	const RM_NO = 'rm_no';
		
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_search		= self::SEARCH;
	protected $_collection	= self::COLLECTION;
	protected $_model		= self::MODEL;
	protected $_table		= self::RM_TABLE;
	protected $_primary		= self::RM_ID;
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

	public function model($value = NULL, $key = 'rm_id') {
		$model = $this->Rm_Model()->setDatabase($this->_database);
		
		if(!is_null($value)) {
			$model->load($value, $key);
		}
		
		return $model;
	}
	
	public function getAll() {
		return $this->_getAll('*')
			->getRows();
	}
	
	public function getRm($id) {
		if(!isset($id)){
			return array();
		}
		return $this->search()
			->filterByRmId($id)
			->getRow();
	}
	
	public function getByRmNo($rm_no = null){
		if(!isset($rm_no)){
			return array();
		}
		$rm = $this->search()
			->filterByRmNo($rm_no)
			->getRow();
		$rm['rm_dtl'] = $this->Rm()
			->getDetail($rm['rm_id']);
		
		return $rm;
	}
	
	public function getDetail($id) {
		return $this
			->_getAll('*')
			->addFilter('rm_id = %s', $id)
			->innerJoinOn('rm_dtl', 'rm_id = rm_dtl_rm_id')
			->innerJoinOn('ris_dtl', 'rm_dtl_ris_dtl_id = ris_dtl_id')
			->getRows();
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}