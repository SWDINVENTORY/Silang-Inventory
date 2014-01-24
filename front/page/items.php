<?php //-->

class Front_Page_Items extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory : Item(s)';
	protected $_class = 'item';
	protected $_template = '/items.phtml';
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
		$this->fields = array(
				'Description' => 'item_desc',
				'Stock No' => 'item_stock_no',
				'Remarks' => 'item_remark',
				'Type' => 'item_type',
				'Article' => 'item_article'
				);
		
		$this->items = $this->Item()->getAll();
		
		if(isset($this->post)) {
			$this->_setErrors();
			
			if(empty($this->_errors)) {
				$this->_process();
			}
		}
		
		$this->_body['items'] = $this->items;
		
		$this->_body['error'] = $this->_errors;
		$this->_body['fields'] = $this->fields;
		
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _setErrors() {}

	protected function _process() {
		$request = strtolower($this->request);
		switch ($request) {
			case 'add':
					$this->_add($this->post);
				break;
			case 'edit':
					$this->_edit($this->post);
				break;
			case 'delete':
					$this->_delete($this->post);
				break;
			case 'search':
					$this->_search();
				break;
			default:
				break;
		}
	}
	
	protected function _add() {
		$item = $this->post;
		$item[Item::ITEM_CREATED] = date('Y-m-d H:i:s');
		$item[Item::ITEM_UPDATED] = date('Y-m-d H:i:s');
		unset($item['id']);
		$this->Item()->add($item);
		header('Location: /items');
		return $this;
	}
	
	protected function _search() {
		$get = $this->get;
		$post = $this->post;
		$this->item = array();
		
		$field = NULL;
		$value = NULL;
		
		if(!empty($get)) {
			if(!empty($get['field']) && !empty($get['keyword'])) {
				$field = $get['field'];
				$value = $get['keyword'];
			}
		}
		
		if(!empty($post)) {
			if(!empty($post['field']) && !empty($post['keyword'])) {
				$field = $post['field'];
				$value = $post['keyword'];
			}
		}
		$this->suppliers = front()->Item()->get($field, $value);
		return $this;
	}
	/* Private Methods
	-------------------------------*/
	
	
}