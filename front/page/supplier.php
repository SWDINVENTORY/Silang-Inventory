<?php //-->

class Front_Page_Supplier extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory : Supplier(s)';
	protected $_class = 'supplier';
	protected $_template = '/supplier.phtml';
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
		
		$this->suppliers = $this->Supplier()->getAll();
		if(isset($this->post)) {
			$this->_setErrors();
			
			if(empty($this->_errors)) {
				$this->_process();
			}
		}
		
		$this->_body['suppliers'] = $this->suppliers;
		
		$this->_body['error'] = $this->_errors;
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _setErrors() {
		//validation for search
		if(isset($this->post['search'])) {
			if(!trim($this->post['keyword'])) {
        		$this->_errors['keyword'] = "Must not be empty!";
			}
			if(!trim($this->post['field'])) {
        		$this->_errors['field'] = "Choose one";
			}
        }
		
		//validation for add
		//TODO add validation
		if(isset($this->post['add-supplier'])) {
			if(!trim($this->post['name'])) {
        		$this->_errors['name'] = "Must not be empty!";
			}
			if(!trim($this->post['address'])) {
        		$this->_errors['address'] = "Must not be empty!";
			}
        }
	}

	protected function _process(){
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
				break;
		}
	}
	
	protected function _add() {
		$supplier = $this->post;
		$supplier[Supplier::SUPPLIER_CREATED] = date('Y-m-d H:i:s');
		$supplier[Supplier::SUPPLIER_UPDATED] = date('Y-m-d H:i:s');
		unset($supplier['id']);
		
		$this->Supplier()->add($supplier);
		header('Location: /supplier');
		return $this;
	}
	
	protected function _edit() {
		$supplier = $this->post;
				
		$this->Supplier()->model()->updateSupplier($supplier);
		header('Location: /supplier');
		return $this;
	}
	
	protected function _search() {
		$get = $this->get;
		$post = $this->post;
		$this->suppliers = array();
		
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
		$this->suppliers = front()->Supplier()->getMatchBy($field, $value);
		return $this;
	}
	/* Private Methods
	-------------------------------*/
}