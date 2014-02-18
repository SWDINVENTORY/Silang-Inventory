<?php //-->
class Dept_Search extends Abstract_Search {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_collection	= Dept::COLLECTION;
	protected $_model		= Dept::MODEL;
	protected $_table		= Dept::DEPT_TABLE;
	
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
		$search = $this->Dept()->search()
			->setTable($this->_table)
			->setColumns(array(Dept::DEPT_ID, Dept::DEPT_NAME, Dept::DEPT_ALIAS, Dept::DEPT_CREATED))
			->sortByDeptCreated('ASC');
		return $search->getRows();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}