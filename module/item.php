<?php

class Item extends Abstract_Model {
	/* Constants
	-------------------------------*/
	const COLLECTION = 'Item_Collection';
	const SEARCH = 'Item_Search';
	const MODEL = 'Item_Model';
	
	const ITEM_TABLE = 'item';
		
	const ITEM_ID = 'item_id';
	const ITEM_DESC = 'item_desc';
	const ITEM_UNIT_MEASURE = 'item_unit_measure';
	const ITEM_QTY = 'item_qty';
	const ITEM_ITEM_TYPE = 'item_item_type';
	const ITEM_STOCK_NO = 'item_stock_no';
	const ITEM_REMARKS = 'item_remarks';
	const ITEM_ARTICLE = 'item_article';
	const ITEM_CREATED = 'item_created';
	const ITEM_UPDATED = 'item_updated';
		
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_search		= self::SEARCH;
	protected $_collection	= self::COLLECTION;
	protected $_model		= self::MODEL;
	protected $_table		= self::ITEM_TABLE;
	protected $_primary		= self::ITEM_ID;

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
	public function getAll() {
		return $this->_getAll(
				array(
				Item::ITEM_ID,
				Item::ITEM_DESC,
				Item::ITEM_UNIT_MEASURE,
				Item::ITEM_QTY,
				Item::ITEM_ITEM_TYPE,
				Item::ITEM_STOCK_NO,
				Item::ITEM_REMARKS,
				Item::ITEM_ARTICLE))
			->sortByItemDesc('ASC')
			->getRows();
	}
	
	public function model($value = NULL, $key = 'user_id') {
		$model = $this->Item_Model()->setDatabase($this->_database);
		
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