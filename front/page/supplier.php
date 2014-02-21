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
					$this->_supplier();
				break;
		}
	}
	
	protected function _add() {
		$supplier = $this->post;
		unset($supplier['create-supplier']);
		$supplier[Supplier::SUPPLIER_CREATED] = date('Y-m-d H:i:s');
		$supplier[Supplier::SUPPLIER_UPDATED] = date('Y-m-d H:i:s');
		unset($supplier['id']);
		if(empty($supplier['id'])){
			$this->Supplier()->add($supplier);
			
			$status = array();
			$status['status'] = 0;
			$status['msg'] = 'Supplier successfully added!';
			
			if(IS_AJAX) {
				header('Content-Type: application/json');
				echo json_encode($status);
				exit;
			}
				
			$this->_addMessage($status['msg'], 'success', true);
			header('Location: /supplier');
			exit;
		}
		
		$status = array();
		$status['status'] = 0;
		$status['msg'] = 'Sorry, Unable to add supplier';
		
		if(IS_AJAX) {
			header('Content-Type: application/json');
			echo json_encode($status);
			exit;
		}
			
		$this->_addMessage($status['msg'], 'danger', true);
		header('Location: /supplier');
		exit;
		
		return $this;
	}
	
	protected function _edit() {
		$supplier = $this->post;
		$status = array();
		unset($supplier['edit-supplier']);
		
		if(isset($supplier['supplier_id']) && !empty($supplier['supplier_id'])) {
			if($this->Supplier()->model()->supplierUpdate($supplier)) {
				$status['status'] = 0;
				$status['msg'] = 'Successfully saved changes on supplier';
				
				if(IS_AJAX) {
					header('Content-Type: application/json');
					echo json_encode($status);
					exit;
				}
				
				$this->_addMessage($status['msg'], 'success', true);
				header('Location: /supplier/');
				exit;
			}
		}
		$status['status'] = 0;
		$status['msg'] = 'Successfully saved changes on supplier!';
		
		if(IS_AJAX) {
			header('Content-Type: application/json');
			echo json_encode($status);
			exit;
		}
		
		$this->_addMessage($status['msg'], 'success', true);
		header('Location: /supplier/');
		exit;
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
		
		if(isset($field) && isset($value)) {
			$this->suppliers = front()->Supplier()->getMatchBy($field, $value);
			$supplier = array();
			if(IS_AJAX){
				foreach ($this->suppliers as $temp) {
					array_push(
						$supplier,
						array(
							'value' => $temp['supplier_name'],
							'data' => $temp
						) 
					);
				}
				header('Content-Type: application/javascript');
				echo json_encode($supplier);
				exit;
			}
		}
		
		return $this;
	}
	
	protected function _delete() {
		$supplier = $this->post;
		$variables = $this->variables;
		
		if(!empty($supplier)) {
			$id = $supplier[Supplier::SUPPLIER_ID];
		}
		if(isset($variables[1])) {
			$id = $variables[1];
		}
		front()->database()
			->deleteRows('supplier', array(
				array('(supplier_id = %s)',$id)
			));
			
		$this->_addMessage('Supplier Deleted', 'success', true);
		header('Location: /supplier');
		exit;
	}
	
	protected function _supplier() {
		$post = $this->post;
		$suppliers = $this->suppliers;
		
		if(IS_AJAX) {
				header('Content-Type: application/json');
				$ret = array();
				$ret['data'] = $suppliers;
				echo json_encode($ret);
				exit;
			}
		return $this;
	}
	
	/* Private Methods
	-------------------------------*/
}