<?php //-->
class Supplier_Search extends Abstract_Search {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_collection	= Supplier::COLLECTION;
	protected $_model		= Supplier::MODEL;
	protected $_table		= Supplier::SUPPLIER_TABLE;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}

	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function getAll() {
		$search = $this->Supplier()->search()
			->setTable($this->_table)
			->setColumns(array(Supplier::SUPPLIER_ID, Supplier::SUPPLIER_NAME, Supplier::SUPPLIER_ADDRESS, Supplier::SUPPLIER_TEL_NO))
			->sortBySupplierCreated('ASC');
		return $search->getRows();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}