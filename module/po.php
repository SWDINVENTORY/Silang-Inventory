<?php

class Po extends Abstract_Model {
	/* Constants
	-------------------------------*/
	const COLLECTION = 'Po_Collection';
	const SEARCH = 'Po_Search';
	const MODEL = 'Po_Model';
	
	const PO_TABLE = 'po';
		
	const PO_ID = 'po_id';
	const PO_NO = 'po_no';
	const PO_PROCMOD = 'po_procmod';
	const PO_DELIV_PLACE = 'po_deliv_place';
	const PO_DELIV_DATE = 'po_deliv_date';
	const PO_DELIV_TERM = 'po_deliv_term';
	const PO_PAY_TERM = 'po_pay_term';
	const PO_TOTAL = 'po_total';
	const PO_AUTH_OFF = 'po_auth_off';
	const PO_REQ_OFF = 'po_req_off';
	const PO_FUNDS_OFF = 'po_funds_off';
	const PO_AMOUNT = 'po_amount';
	const PO_ALOBS_NO = 'po_alobs_no';
	const PO_CREATED = 'po_created';
		
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_search		= self::SEARCH;
	protected $_collection	= self::COLLECTION;
	protected $_model		= self::MODEL;
	protected $_table		= self::PO_TABLE;
	protected $_primary		= self::PO_ID;
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

	public function model($value = NULL, $key = 'user_id') {
		$model = $this->Po_Model()->setDatabase($this->_database);
		
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