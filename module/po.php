<?php

class Po extends Abstract_Model {
	/* Constants
	-------------------------------*/
	const COLLECTION = 'Po_Collection';
	const SEARCH = 'Po_Search';
	const MODEL = 'Po_Model';
	
	const PO_TABLE = 'po';
	const SUPPLIER_TABLE = 'supplier';
		
	const PO_ID = 'po_id';
	const PO_NO = 'po_no';
	const PO_SUPPLIER_ID = 'po_supplier_id';
	const PO_PROC_MOD = 'po_proc_mod';
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
	const PO_IS_FURNISHED = 'po_is_furnished';
	const PO_CREATED = 'po_created';
	
	const PO_DTL_TABLE = 'po_dtl';
	
	const PO_DTL_ID = 'po_dtl_id';
	const PO_DTL_PO_ID = 'po_dtl_po_id';
	const PO_DTL_ITEM_NO = 'po_dtl_item_no';
	const PO_DTL_ITEM_UNIT = 'po_dtl_item_unit';
	const PO_DTL_ITEM_QTY= 'po_dtl_item_qty';
	const PO_DTL_ITEM_DESC= 'po_dtl_item_desc';
	const PO_DTL_ITEM_COST= 'po_dtl_item_cost';
	const PO_DTL_ITEM_CREATED = 'po_dtl_item_created';
		
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

	public function model($value = NULL, $key = 'po_id') {
		$model = $this->Po_Model()->setDatabase($this->_database);
		
		if(!is_null($value)) {
			$model->load($value, $key);
		}
		
		return $model;
	}
	
	public function getAll() {
		return $this->_getAll('*')
			->innerJoinOn(Po::SUPPLIER_TABLE, 'po_supplier_id=supplier_id')
			->sortByPoNo('ASC')
			->getRows();
	}
	
	public function getPo($value) {
		return $this->search()
			->setColumns('*')
			->filterByPoId($value)
			->innerJoinOn(Po::SUPPLIER_TABLE, 'po_supplier_id=supplier_id')
			->getRow();	
	}
	
	public function getByPoNo($value) {
		return $this->search()
			->setColumns('*')
			->filterByPoNo($value)
			->innerJoinOn(Po::SUPPLIER_TABLE, 'po_supplier_id=supplier_id')
			->getRow();	
	}
	
	public function getDetail($id) {
		return $this
			->_getAll(array(
				Po::PO_DTL_ID,
				Po::PO_DTL_PO_ID,
				Po::PO_DTL_ITEM_NO,
				Po::PO_DTL_ITEM_UNIT,
				Po::PO_DTL_ITEM_QTY,
				Po::PO_DTL_ITEM_DESC,
				Po::PO_DTL_ITEM_COST,
				Po::PO_DTL_ITEM_CREATED
			))
			->addFilter('po_id = %s', $id)
			->leftJoinOn(Po::PO_DTL_TABLE, 'po_id = po_dtl_po_id')
			->innerJoinOn('article', 'article_id = po_dtl_article_id')
			->getRows();
	}
	
	public function getItemMatch($name = NULL) {
		return $this->_database
			->search()
			->setTable(Po::PO_DTL_TABLE)
			->setColumns(array(Po::PO_DTL_ITEM_DESC))
			->addFilter('(po_dtl_item_desc LIKE %s )', '%'.$name.'%')
			->getRows();
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}