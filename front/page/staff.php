<?php //-->

class Front_Page_Staff extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory : Staff(s)';
	protected $_class = 'staff';
	protected $_template = '/staff.phtml';
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
		$this->variables = front()->registry()->get('request', 'variables');
		$this->get = front()->registry()->get('get')->getArray();
		
		
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
		if(isset($this->post['add-staff'])) {
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
					$this->_staff();
				break;
		}
	}
	
	protected function _add() {
		$staff = $this->post;
		unset($staff['create-staff']);
		$staff[staff::staff_CREATED] = date('Y-m-d H:i:s');
		$staff[staff::staff_UPDATED] = date('Y-m-d H:i:s');
		unset($staff['id']);
		if(empty($staff['id'])) {
			$this->staff()->add($staff);
			
			$status = array();
			$status['status'] = 0;
			$status['msg'] = 'Staff successfully added!';
			
			if(IS_AJAX) {
				header('Content-Type: application/json');
				echo json_encode($status);
				exit;
			}
				
			$this->_addMessage($status['msg'], 'success', true);
			header('Location: /staff');
			exit;
		}
		
		$status = array();
		$status['status'] = 0;
		$status['msg'] = 'Sorry, Unable to add staff';
		
		if(IS_AJAX) {
			header('Content-Type: application/json');
			echo json_encode($status);
			exit;
		}
			
		$this->_addMessage($status['msg'], 'danger', true);
		header('Location: /staff');
		exit;
		
		return $this;
	}
	
	protected function _edit() {
		$staff = $this->post;
		$status = array();
		unset($staff['edit-staff']);
		
		if(isset($staff['staff_id']) && !empty($staff['staff_id'])) {
			if($this->staff()->model()->staffUpdate($staff)) {
				$status['status'] = 0;
				$status['msg'] = 'Successfully saved changes on staff';
				
				if(IS_AJAX) {
					header('Content-Type: application/json');
					echo json_encode($status);
					exit;
				}
				
				$this->_addMessage($status['msg'], 'success', true);
				header('Location: /staff/');
				exit;
			}
		}
		$status['status'] = 0;
		$status['msg'] = 'Successfully saved changes on staff!';
		
		if(IS_AJAX) {
			header('Content-Type: application/json');
			echo json_encode($status);
			exit;
		}
		
		$this->_addMessage($status['msg'], 'success', true);
		header('Location: /staff/');
		exit;
		return $this;
	}
	
	protected function _search() {
		$get = $this->get;
		$post = $this->post;
		$this->staffs = array();
		
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
			$this->staffs = front()->staff()->getMatchBy($field, $value);
			$staff = array();
			if(IS_AJAX){
				foreach ($this->staffs as $temp) {
					array_push(
						$staff,
						array(
							'value' => $temp['staff_name'],
							'data' => $temp
						) 
					);
				}
				header('Content-Type: application/javascript');
				echo json_encode($staff);
				exit;
			}
		}
		
		return $this;
	}
	
	protected function _delete() {
		$staff = $this->post;
		$variables = $this->variables;
		
		if(!empty($staff)) {
			$id = $staff[staff::staff_ID];
		}
		if(isset($variables[1])) {
			$id = $variables[1];
		}
		
		front()->database()
			->deleteRows('staff', array(
				array('(staff_id = %s)',$id)
			));
			
		$this->_addMessage('staff Deleted', 'success', true);
		header('Location: /staff');
		exit;
	}
	
	protected function _staff() {
		$post = $this->post;
		$staffs = $this->staff()->getAll();
		
		if(IS_AJAX) {
				header('Content-Type: application/json');
				$ret = array();
				$ret['data'] = $staffs;
				echo json_encode($ret);
				exit;
			}
		return $this;
	}
	
	/* Private Methods
	-------------------------------*/
}