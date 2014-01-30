<?php //-->

class Po_Model extends Abstract_Model {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_primary =Po::PO_ID;
	protected $_table	= Po::PO_TABLE;

	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function __construct($data = array()) {
		
		$this->setTable(Po::PO_TABLE);
		
		parent::__construct($data);
	}
	
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/		
	/**
	 * Loads a po into the model
	 *
	 * @param mixed
	 * @param string
	 * @return this
	 */
	public function load($value, $key = 'po_id') {
		Po_Error::i()
			->argument(1, 'scalar')
			->argument(2, 'string');
			
		$row = $this->_database->getRow(Po::PO_TABLE, $key, $value);
		parent::__construct($row);
		return $this;
	}
	/* Private Methods
	-------------------------------*/
}

