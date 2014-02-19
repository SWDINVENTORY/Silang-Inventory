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
	const ITEM_STOCK_NO = 'item_stock_no';
	const ITEM_REMARKS = 'item_remarks';
	const ITEM_ARTICLE_ID = 'item_article_id';
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
			return $this->_database
				->query(
					$this->_database
					->select('*')
					->from('item')
					->innerJoin('article', 'article_id = item_article_id', false)
					->innerJoin('(SELECT * FROM item_cost ORDER BY item_cost_updated DESC) i', 'item_cost_item_id=item_id', false)
					->sortBy('item_desc', 'ASC')
					->groupBy('item_id'));
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