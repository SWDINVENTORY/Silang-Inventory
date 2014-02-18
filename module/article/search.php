<?php //-->
class Article_Search extends Abstract_Search {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_collection	= Article::COLLECTION;
	protected $_model		= Article::MODEL;
	protected $_table		= Article::DEPT_TABLE;
	
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
			->setColumns('*')
			->sortByDeptCreated('ASC');
		return $search->getRows();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}