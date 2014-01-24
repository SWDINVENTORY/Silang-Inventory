<?php //-->

class Abstract_Directory extends Eden_Class {
	/* Constants
	-------------------------------*/	
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_app 		= NULL;
	protected $_search		= NULL;
	protected $_collection	= NULL;
	protected $_model		= NULL;
	protected $_table		= NULL;
	protected $_primary		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/	
	/* Magic
	-------------------------------*/
	public function __construct() {		
		$this->_app = Eden::i()->getActiveApp();
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Return search
	 *
	 * @param string
	 * @return Eden_Mysql_Search
	 */
	public function search() {
		$search = $this->_search;
		return $this->$search();
	}
	
	/**
	 * Return model
	 *
	 * @param scalar|null
	 * @param string
	 * @return Eden_Mysql_Model
	 */
	public function model($value = NULL, $column = NULL) {
		Abstract_Error::i()
			->argument(1, 'scalar', 'array', 'null')
			->argument(2, 'string', 'null');
		
		$model = $this->_model;
		$model = $this->$model();
		
		if(is_null($value)) {
			return $model;
		}
		
		if(is_array($value)) {
			return $model->set($value);
		}
		
		if(is_null($column)) {
			$column = $this->_primary;
		}
		
		$row = $this->_app->getDatabase()->getRow($this->_table, $column, $value);
		
		if(is_null($row)) {
			return $model;
		}
		
		return $model->set($row);
	}
	
	/**
	 * Return collection
	 *
	 * @param array
	 * @return Eden_Mysql_Collection
	 */
	public function collection(array $list = array()) {		
		$collection = $this->_collection;
		return $this->$collection()->set($list);
	}
	
	public function add($data) {
		$db = $this->_app->getDatabase();
		$db->insertRow($this->_table, $data);
		return $db->getLastInsertedId();
	}

	public function update($data) {
		return $this->model($data)->save($this->_table);
	}
	
	public function get($field, $keyword) {
		return $this->search()
			->setTable($this->_table)
			->addFilter($field.' LIKE \'%'.$keyword.'%\'')
			->getRows();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}