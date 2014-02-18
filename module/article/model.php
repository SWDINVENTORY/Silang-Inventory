<?php //-->

class Article_Model extends Abstract_Model {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_primary = Article::ARTICLE_ID;
	protected $_table	= Article::ARTICLE_TABLE;

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
	
	/* Private Methods
	-------------------------------*/
}

