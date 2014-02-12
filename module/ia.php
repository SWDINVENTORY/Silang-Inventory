<?php

class Ia extends Abstract_Model {
	/* Constants
	-------------------------------*/
	const COLLECTION = 'Ia_Collection';
	const SEARCH = 'Ia_Search';
	const MODEL = 'Ia_Model';
	
	const IA_TABLE = 'ia';
	const SUPPLIER_TABLE = 'supplier';
	
	const IA_ID = 'ia_id';
	const IA_NO = 'ia_no';
	const IA_PO_ID = 'ia_po_id';
	const IA_INV_NO = 'ia_inv_no';
	const IA_DR_NO = 'ia_dr_no';
	const IA_REQ_DEPT_ID = 'ia_req_dept_id';
	const IA_TOTAL_AMOUNT = 'ia_total_amount';
	const IA_STATUS = 'ia_status';
	const IA_DATE_INSPECTED = 'ia_date_inspected';
	const IA_DATE_IS_VERIFIED = 'ia_date_is_verified';
	const IA_DATE_RECEIVED = 'ia_date_received';
	const IA_IS_PARTIAL = 'ia_is_partial';
	const IA_IS_PARTIAL_QTY = 'ia_is_partial_qty';
	const IA_CREATED = 'ia_created';
	
	const IA_DTL_TABLE = 'ia_dtl';
	
	const IA_DTL_ID = 'ia_dtl_id';
	const IA_DTL_PO_DTL_ID = 'ia_dtl_po_dtl_id';
	const IA_DTL_ITEM_QTY= 'ia_dtl_item_qty';
	const IA_DTL_ITEM_COST= 'ia_dtl_item_cost';
	const IA_DTL_ITEM_CREATED = 'ia_dtl_item_created';
		
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_search		= self::SEARCH;
	protected $_collection	= self::COLLECTION;
	protected $_model		= self::MODEL;
	protected $_table		= self::IA_TABLE;
	protected $_primary		= self::IA_ID;
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

	public function model($value = NULL, $key = 'ia_id') {
		$model = $this->Ia_Model()->setDatabase($this->_database);
		
		if(!is_null($value)) {
			$model->load($value, $key);
		}
		
		return $model;
	}
	
	public function getAll() {
		return $this->_getAll('*')
			->innerJoinOn(Po::PO_TABLE, 'po_id=ia_po_id')
			->innerJoinOn(Supplier::SUPPLIER_TABLE, 'po_supplier_id= supplier_id')
			->sortByIaNo('ASC')
			->getRows();
	}
	
	public function getDetail($id) {
		return $this
			->_getAll(array(
				Ia::IA_DTL_ID,
				Ia::IA_DTL_PO_DTL_ID,
				Ia::IA_DTL_ITEM_QTY,
				Ia::IA_DTL_ITEM_CREATED,
				Po::PO_DTL_ITEM_DESC,
				Po::PO_DTL_ITEM_UNIT,
				Po::PO_DTL_ITEM_QTY,
				Po::PO_DTL_ITEM_COST,
			))
			->addFilter('ia_id = %s', $id)
			->leftJoinOn(Ia::IA_DTL_TABLE, 'ia_id = ia_dtl_ia_id')
			->innerJoinOn(Po::PO_DTL_TABLE, 'ia_dtl_po_dtl_id = po_dtl_id')
			->getRows();
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}