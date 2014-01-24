<?php //-->
class Item_Search extends Abstract_Search {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_collection	= Item::COLLECTION;
	protected $_model		= Item::MODEL;
	protected $_table		= Item::ITEM_TABLE;
	
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
		$search = $this->Item()->search()
			->setTable($this->_table)
			->setColumns(
				array(Item::ITEM_ID,
					Item::ITEM_DESC,
					Item::ITEM_UNIT_MEASURE,
					Item::ITEM_QTY,
					Item::ITEM_STOCK_NO,
					Item::ITEM_REMARKS,
					Item::ITEM_ITEM_TYPE,
					Item::ITEM_ARTICLE,
					Item::ITEM_CREATED,
					Item::ITEM_UPDATED,
				))
			->sortByItemDesc('ASC');
		return $search->getRows();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}