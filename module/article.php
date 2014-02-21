<?php
class Article extends Abstract_Model {
	/* Constants
	-------------------------------*/
	const COLLECTION = 'Article_Collection';
	const SEARCH = 'Article_Search';
	const MODEL = 'Article_Model';
	
	const ARTICLE_TABLE = 'article';
		
	const ARTICLE_ID = 'article_id';
	const ARTICLE_NAME = 'article_name';
	const ARTICLE_INVENTORY_TYPE = 'article_inventory_type';
	const ARTICLE_CREATED = 'article_created';
	const ARTICLE_UPDATED = 'article_updated';
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_search		= self::SEARCH;
	protected $_collection	= self::COLLECTION;
	protected $_model		= self::MODEL;
	protected $_table		= self::ARTICLE_TABLE;
	protected $_primary		= self::ARTICLE_ID;
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
		return $this->_getAll('*')
			->sortByArticleName('ASC')
			->getRows();
	}
	public function model($value = NULL, $key = 'article_id') {
		$model = $this->Article_Model()->setDatabase($this->_database);
		
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