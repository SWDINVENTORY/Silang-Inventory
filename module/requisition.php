<?php

class Requisition extends Abstract_Model {
	/* Constants
	-------------------------------*/
	const COLLECTION = 'Requisition_Collection';
	const SEARCH = 'Requisition_Search';
	const MODEL = 'Requisition_Model';
	
	const REQUISITION_TABLE = 'ris';
	
	const REQUISITION_ID = 'ris_id';
	
	const REQUISITION_DTL_TABLE = 'ris_dtl';
	
	const REQUISITION_DTL_ID = 'ris_dtl_id';
	const REQUISITION_DTL_REQUISITION_ID = 'ris_dtl_ris_id';
	const REQUISITION_DTL_PO_DTL_ID = 'ris_dtl_po_dtl_id';
	const REQUISITION_DTL_ITEM_QTY= 'ris_dtl_item_qty';
	const REQUISITION_DTL_ITEM_CREATED = 'ris_dtl_item_created';
		
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_search		= self::SEARCH;
	protected $_collection	= self::COLLECTION;
	protected $_model		= self::MODEL;
	protected $_table		= self::REQUISITION_TABLE;
	protected $_primary		= self::REQUISITION_ID;
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

	public function model($value = NULL, $key = 'ris_id') {
		$model = $this->Requisition_Model()->setDatabase($this->_database);
		
		if(!is_null($value)) {
			$model->load($value, $key);
		}
		
		return $model;
	}
	
	public function getAll() {
		return $this->_getAll('*')
			->sortByRisNo('ASC')
			->getRows();
	}
	
	public function getRequisition($id) {
		if(!isset($id)){
			return array();
		}
		return $this->search()
			->filterByRequisitionId($id)
			->getRow();
	}
	
	public function getDetail($id) {
		return $this
			->_getAll('*')
			->addFilter('ris_id = %s', $id)
			->innerJoinOn('ris_dtl', 'ris_id = ris_dtl_ris_id')
			->getRows();
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}