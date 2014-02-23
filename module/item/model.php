<?php //-->

class Item_Model extends Abstract_Model {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_primary = Item::ITEM_ID;
	protected $_table	= Item::ITEM_TABLE;

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
	public function itemUpdate($data) {
		$data[Item::ITEM_UPDATED] = date('Y-m-d H:i:s', time());
		$filter 	= array();
		$filter[]	= array(Item::ITEM_ID.'=%s',
			$data[Item::ITEM_ID]);
		unset($data[Item::ITEM_ID]);
		return $this->_database->updateRows($this->_table, $data, $filter);
	}
	/* Private Methods
	-------------------------------*/
}

