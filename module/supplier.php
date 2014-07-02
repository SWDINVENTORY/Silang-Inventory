<?php

class Supplier extends Abstract_Model {
	/* Constants
	-------------------------------*/
	const COLLECTION = 'Supplier_Collection';
	const SEARCH = 'Supplier_Search';
	const MODEL = 'Supplier_Model';
	
	const SUPPLIER_TABLE = 'supplier';
		
	const SUPPLIER_ID = 'supplier_id';
	const SUPPLIER_NAME = 'supplier_name';
	const SUPPLIER_ADDRESS = 'supplier_address';
	const SUPPLIER_TEL_NO = 'supplier_tel_no';
	const SUPPLIER_TIN = 'supplier_tin';
	const SUPPLIER_VAT = 'supplier_vat';
	const SUPPLIER_CREATED = 'supplier_created';
	const SUPPLIER_UPDATED = 'supplier_updated';
		
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_search		= self::SEARCH;
	protected $_collection	= self::COLLECTION;
	protected $_model		= self::MODEL;
	protected $_table		= self::SUPPLIER_TABLE;
	protected $_primary		= self::SUPPLIER_ID;
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
				Supplier::SUPPLIER_ID,
				Supplier::SUPPLIER_NAME,
				Supplier::SUPPLIER_TIN,
				Supplier::SUPPLIER_VAT,
				Supplier::SUPPLIER_ADDRESS,
				Supplier::SUPPLIER_TEL_NO))
			->sortBySupplierCreated('ASC')
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