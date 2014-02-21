<?php //-->

class Front_Page_Article extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory : Articles';
	protected $_class = 'article';
	protected $_template = '/article.phtml';
	protected $_errors = array();
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		$this->post = front()->registry()->get('post')->getArray();
		$this->request = front()->registry()->get('request', 'variables','0');
		$this->get = front()->registry()->get('get')->getArray();
		$this->variables = front()->registry()->get('request', 'variables')->getArray();
		
		if(isset($this->post)) {
			$this->_setErrors();
			
			if(empty($this->_errors)) {
				$this->_process();
			}
		}
				
		$this->_body['error'] = $this->_errors;
		
		return $this->_page();
	}
	/* Protected Methods
	-------------------------------*/
	protected function _setErrors() {}
	protected function _process() {
		$request = strtolower($this->request);
		switch ($request) {
			case 'add':
					$this->_add();
				break;
			case 'edit':
					$this->_edit();
				break;
			case 'delete':
					$this->_delete();
				break;
			case 'search':
					$this->_search();
				break;
			default:
					$this->_article();
				break;
		}
	}
	protected function _add() {
		$article = $this->post;
		unset($article['create-article']);
		$article[Article::ARTICLE_CREATED] = date('Y-m-d H:i:s');
		$article[Article::ARTICLE_UPDATED] = date('Y-m-d H:i:s');
		unset($article['id']);
		if(empty($article['id'])){
			$this->Article()->add($article);
			
			$status = array();
			$status['status'] = 0;
			$status['msg'] = 'Article successfully added!';
			
			if(IS_AJAX) {
				header('Content-Type: application/json');
				echo json_encode($status);
				exit;
			}
				
			$this->_addMessage($status['msg'], 'success', true);
			header('Location: /article');
			exit;
		}
		
		$status = array();
		$status['status'] = 0;
		$status['msg'] = 'Sorry, Unable to add article';
		
		if(IS_AJAX) {
			header('Content-Type: application/json');
			echo json_encode($status);
			exit;
		}
			
		$this->_addMessage($status['msg'], 'danger', true);
		header('Location: /article');
		exit;
		
		return $this;
	}
	protected function _edit() {
		$article = $this->post;
		$status = array();
		unset($article['edit-article']);
		
		if(isset($article['article_id']) && !empty($article['article_id'])) {
			if($this->Article()->model()->articleUpdate($article)) {
				$status['status'] = 0;
				$status['msg'] = 'Successfully saved changes on article';
				
				if(IS_AJAX) {
					header('Content-Type: application/json');
					echo json_encode($status);
					exit;
				}
				
				$this->_addMessage($status['msg'], 'success', true);
				header('Location: /article/');
				exit;
			}
		}
		$status['status'] = 0;
		$status['msg'] = 'Successfully saved changes on article!';
		
		if(IS_AJAX) {
			header('Content-Type: application/json');
			echo json_encode($status);
			exit;
		}
		
		$this->_addMessage($status['msg'], 'success', true);
		header('Location: /article/');
		exit;
		return $this;
	}
	protected function _search() {}
	protected function _delete() {
		$article = $this->post;
		$variables = $this->variables;
		
		if(!empty($article)) {
			$id = $article[Article::ARTICLE_ID];
		}
		if(isset($variables[1])) {
			$id = $variables[1];	
			front()->database()
				->deleteRows('article', array(
					array('(article_id = %s)',$id)
				));
			
			$this->_addMessage('Article Deleted', 'success', true);
		}
		header('Location: /article');
		exit;
	}
	protected function _article() {
		$post = $this->post;
		$articles = $this->Article()->getAll();;
		
		if(IS_AJAX) {
				header('Content-Type: application/json');
				$ret = array();
				$ret['data'] = $articles;
				echo json_encode($ret);
				exit;
			}
		return $this;
	}
	/* Private Methods
	-------------------------------*/
}