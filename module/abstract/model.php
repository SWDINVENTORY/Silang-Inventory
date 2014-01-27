<?php //-->

class Abstract_Model extends Eden_Sql_Model {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_primary = NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Magic
	-------------------------------*/
	public function __construct() {
		$this->_database = Eden::i()->getActiveApp()->getDatabase();
	}
	
	/* Public Methods
	-------------------------------*/
	public function search() {
		return $this->_database
			->search()
			->setTable($this->_table)
			->setModel($this->_model);
	}
	
	public function getMatchBy($field, $keyword) {
		return $this->search()
			->setTable($this->_table)
			->addFilter($field.' LIKE \'%'.$keyword.'%\'')
			->getRows();
		
	}
	
	public function getBy($field, $keyword) {
		return $this->search()
			->setTable($this->_table)
			->addFilter('('.$field.' = '.$keyword.')' )
			->getRows();
		
	}
	
	public function add($data) {
		return $this->_database
				->insertRow($this->_table, $data)
				->getLastInsertedId();
	}
	
		
	protected function _getAll($fields) {
		return $this->search()
			->setColumns($fields);
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}

