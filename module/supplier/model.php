<?php //-->

class Supplier_Model extends Abstract_Model {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_primary = Supplier::SUPPLIER_ID;
	protected $_table	= Supplier::SUPPLIER_TABLE;

	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	public function supplierUpdate($supplier) {
		$data = $supplier;
		front()->output($supplier);
		$data[Supplier::SUPPLIER_UPDATED] = date('Y-m-d H:i:s', time());
		$filter 	= array();
		$filter[]	= array(Supplier::SUPPLIER_ID.'=%s',
						$data[Supplier::SUPPLIER_ID]);

		$this->_database->updateRows($this->_table, $data, $filter);
	}
	
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/		
	
	/* Private Methods
	-------------------------------*/
}

