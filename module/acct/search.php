<?php //-->
class Acct_Search extends Abstract_Search {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_collection	= Acct::COLLECTION;
	protected $_model		= Acct::MODEL;
	protected $_table		= Acct::ACCT_TABLE;
	
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
		$search = $this->Acct()->search()
			->setTable($this->_table)
			->setColumns(array(Acct::ACCT_ID, Acct::ACCT_NO, Acct::ACCT_DESC, Acct::ACCT_CREATED, Acct::ACCT_UPDATED))
			->sortByAcctId('ASC');
		return $search->getRows();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}