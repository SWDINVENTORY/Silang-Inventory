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
	const ITEM_SIZE = 'item_size';
	const ITEM_UNIT_MEASURE = 'item_unit_measure';
	const ITEM_QTY = 'item_qty';
	const ITEM_ACCT_NO = 'item_acct_no';
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
			$all =  $this->_database
				->query(
					$this->_database
					->select('*')
					->from('item')
					->innerJoin('article', 'article_id = item_article_id', false)
					//->innerJoin('(SELECT * FROM item_costs ORDER BY item_cost_updated DESC) i', 'item_cost_item_id=item_id', false)
					->sortBy('item_stock_no', 'ASC')
					->groupBy('item_id'));
					
			for($i=0; $i<count($all); $i++) {
				$average_cost = front()->database()
					->search()
					->setTable('item_cost')
					->setColumns('round(sum(item_cost_qty * item_cost_unit_cost)/ sum(item_cost_qty), 2) as unit_average_cost')
					->filterByItemCostItemId($all[$i]['item_id'])
					->getRow();
					
				$all[$i]['item_cost_unit_cost'] = $average_cost['unit_average_cost'];
			}
			//print_r($all);
			//exit;
			
			return $all;
	}
	
	public function model($value = NULL, $key = 'item_id') {
		$model = $this->Item_Model()->setDatabase($this->_database);
		
		if(!is_null($value)) {
			$model->load($value, $key);
		}
		
		return $model;
	}
	
	public function search() {
		return $this->_database
			->search()
			->setTable($this->_table)
			->setModel($this->_model);
	}
	
	public static function getByStockNo($stock_no=null) {
	
	
		$item = front()->database()
			->search()
			->setTable('item')
			->setColumns('item_id', 'item_unit_measure', 'item_type', 'item_stock_no', 'item_desc', 'item_article_id', 'item_acct_no', 'item_size')
			->filterByItemStockNo($stock_no)
			->getRow();
		
		$average_cost = front()->database()
			->search()
			->setTable('item_cost')
			->setColumns('round(sum(item_cost_qty * item_cost_unit_cost)/ sum(item_cost_qty), 2) as unit_average_cost')
			->innerJoinOn('item', 'item_id = item_cost_item_id')
			->filterByItemStockNo($stock_no)
			->getRow();
		
		$item['item_cost_unit_cost'] = $average_cost['unit_average_cost'];
		
		return $item;
	}
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}