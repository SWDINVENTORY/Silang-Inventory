<?php //-->

class Front_Page_Items extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory : Items';
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
		$article = $this->Article()->getAll();
		
		if(isset($this->post)) {
			$this->_setErrors();
			
			if(empty($this->_errors)) {
				$this->_process();
			}
		}
		
		$this->_body['articles'] = $article;
		$this->_body['error'] = $this->_errors;
		
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _setErrors() {}

	protected function _process() {
		$request = strtolower($this->request);
		switch ($request) {
			case 'create':
					$this->_add($this->post);
				break;
			case 'edit':
					$this->_edit($this->post);
				break;
			case 'delete':
					$this->_delete($this->post);
				break;
			default :
				$this -> _item();
				break;
		}
	}
	
	protected function _add() {
		$item = $this->post;
		if(isset($item['item_id']) && empty($item['item_id'])){
			$item = array_filter($item);
			$item[Item::ITEM_CREATED] = date('Y-m-d H:i:s');
			$item[Item::ITEM_UPDATED] = date('Y-m-d H:i:s');
			if(!empty($item['item_cost_unit_cost'])){
				$item_unit_cost = $item['item_cost_unit_cost'];
				unset($item['item_cost_unit_cost']);
			}
			$item_id = $this->Item()->add($item);
			if($item_unit_cost) {
				front()->database()
					->insertRow('item_cost', array(
						'item_cost_item_id' =>$item_id,
						'item_cost_qty' => $item['item_qty'],
						'item_cost_unit_cost' => $item_unit_cost,
						'item_cost_updated' => $item[Item::ITEM_UPDATED]
					));
			}
			header('Location: /items');
			exit;
		}
		
		return $this;
	}
	
	protected function _edit() {
		$item = $this->post;
		
		if(isset($item['edit-item']) && !empty($item['item_id'])){
			$item = array_filter($item);
			unset($item['item_cost_unit_cost']);
			if($this->Item()->model()->itemUpdate($item)){
				$status = array();
				$status['status'] = 1;
				$status['msg'] = 'Saved changes successfully!';
				if (IS_AJAX) {
					header('Content-Type: application/json');
					echo json_encode($status);
					exit ;
				}
				$this -> _addMessage($status['msg'], 'success', true);
				header('Location: /items');
				exit;
			}
			
		}
		return $this;
	}
	
	protected function _search() {
		$get = $this->get;
		$post = $this->post;
		$this->items = array();
		
		$field = NULL;
		$value = NULL;
		
		if(!empty($get)) {
			if(!empty($get['field']) && !empty($get['keyword'])) {
				$field = $get['field'];
				$value = $get['keyword'];
			}
		}
		if(isset($post['search'])){
			if(!empty($post['field']) && !empty($post['keyword'])) {
				$field = $post['field'];
				$value = $post['keyword'];
			}
		}
		if(isset($field) && isset($value)) {
			$this->items = front()->Item()->getMatchBy($field, $value);
			if(IS_AJAX){
				header('Content-Type: application/javascript');
				echo json_encode($this->items);
				exit;
			}
		}
		
		return $this;
	}
	
	protected function _item() {
		$post = $this -> post;
		if (isset($post['item'])) {
			$items = $this -> Item()->getAll();
			if ($post['item'] != 'all') {
				$id = $post['item'];
				if (is_numeric($id)) {
					$items = $this -> Item() -> getDetail($id);
				}
			}

			if (IS_AJAX) {
				header('Content-Type: application/json');
				$ret = array();
				$ret['data'] = $items;
				echo json_encode($ret);
				exit ;
			}
		}
		return $this;
	}
	
	protected function _item2() {
		$post = $this -> post;
		if (isset($post['item'])) {
			$items = $this -> Item()->getAll();
			if ($post['item'] != 'all') {
				$id = $post['item'];
				if (is_numeric($id)) {
					$items = $this -> Item() -> getDetail($id);
				}
			}
			
			if(isset($post['item']) && !empty($post['item'])) {
				$item_stock_no = $post['item'];
				$items = $this->Item()->getBy('item_stock_no', '"'.$item_stock_no.'"');
			}


			if (IS_AJAX) {
				header('Content-Type: application/json');
				$ret = array();
				$ret['data'] = $items;
				echo json_encode($ret);
				exit ;
			}
		}
		return $this;
	}
	/* Private Methods
	-------------------------------*/
	
	
}