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
	public function articleUpdate($article) {
		$data = $article;
		$data[Article::ARTICLE_UPDATED] = date('Y-m-d H:i:s', time());
		$filter 	= array();
		$filter[]	= array(Article::ARTICLE_ID.'=%s',
						$data[Article::ARTICLE_ID]);
		$this->_database->updateRows($this->_table, $data, $filter);
	}
	/* Private Methods
	-------------------------------*/
}

