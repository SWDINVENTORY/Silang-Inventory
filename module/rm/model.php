<?php //-->

class Rm_Model extends Abstract_Model {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_primary = Rm::RM_ID;
	protected $_table	= Rm::RM_TABLE;

	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($data = array()) {
		
		$this->setTable(Rm::RM_TABLE);
		
		parent::__construct($data);
	}
	
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/		

	public function load($value, $key = 'ia_id') {
		Ia_Error::i()
			->argument(1, 'scalar')
			->argument(2, 'string');
			
		if(is_array($value)) {
			return $this->set($value);
		}
		
		$row = $this->_database->getRow($this->_table, $key, $value);
		
		if(is_null($row)) {
			return $this;
		}
		
		return $this->set($row);
	}
	/* Private Methods
	-------------------------------*/
}

