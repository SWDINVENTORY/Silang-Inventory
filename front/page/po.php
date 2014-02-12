<?php //-->

class Front_Page_Po extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory : Purchase Order';
	protected $_class = 'po';
	protected $_template = '/po.phtml';
	protected $_errors = null;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		$this->post = front()->registry()->get('post')->getArray();
		$this->request = front()->registry()->get('request', 'variables','0');
		$this->variables = front()->registry()->get('request', 'variables')->getArray();
		$this->get = front()->registry()->get('get')->getArray();
		$this->po = $this->Po()->getAll();
		
		if(isset($this->post)) {
			$this->_setErrors(); //-> post validation
			
			if(empty($this->_errors)) {
				$this->_process(); //-> post processing
			}
		}
		
		$this->_body['pos'] = $this->po;
		$this->_body['error'] = $this->_errors;

		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	
	protected function _setErrors() { }
	
	protected function _process(){
		$request = strtolower($this->request);
		switch ($request) {
			case 'furnish':
					$this->_add();
				break;
			case 'edit':
					$this->_edit();
				break;
			case 'delete':
					$this->_delete();
				break;
			default:
					$this->_po();
				break;
		}
	}
	
	protected function _add() {
		$post = $this->post;
		unset($post['po-dtl-table_length']);
		
		if(isset($post['po_id']) && empty($post['po_id'])) {
			if(isset($post['po_dtl']) && is_array($post['po_dtl']) && !empty($post['po_dtl'])) {
				$po_dtl = $post['po_dtl'];
				unset($post['po_dtl']);
				
				$total_amount = null;
				foreach ($po_dtl as $dtl) {
					$total_amount = ($dtl['po_dtl_item_cost']*$dtl['po_dtl_item_qty'])+$total_amount;
				}
				
				$post['po_total'] = $total_amount;
				$post = array_filter($post);
				$post[Po::PO_CREATED] = date('Y-m-d H:i:s');
				$post[Po::PO_DELIV_DATE] = date('Y-m-d', strtotime(str_replace('-', '/', $post[Po::PO_DELIV_DATE])));
				$po_id = $this->Po()->add($post);
				$po_details = array();
				foreach ($po_dtl as $dtls) {
					$dtl = $dtls;
					$dtl[Po::PO_DTL_PO_ID] = $po_id;
					$dtl[Po::PO_DTL_ITEM_CREATED] = date('Y-m-d H:i:s'); 
					$dtl_id = front()->database()
						->insertRow(Po::PO_DTL_TABLE, $dtl);
					$dtl['po_dtl_id'] = $dtl_id;
					array_push($po_details, $dtl);
				}
				
				$status = array();
					$status['status'] = 1;
					$status['msg'] = 'Successfully Created Purchase Order '.$post[Po::PO_NO].'!';
					$status['data'] = array(
							'po_id' => $po_id,
							'po' => $post,
							'po_dtl' => $po_details );
				if(IS_AJAX) {
					header('Content-Type: application/json');
					echo json_encode($status);
					exit;
				}
				$this->_addMessage($status['msg'], 'success', true);
				header('Location: /po');
				exit;
			}
			
			$status = array();
			$status['status'] = 0;
			$status['msg'] = 'Sorry, Unable to furnish purchase order';
			
			if(IS_AJAX) {
				header('Content-Type: application/json');
				echo json_encode($status);
				exit;
			}
			
			$this->_addMessage($status['msg'], 'danger', true);
			header('Location: /po');
			exit;
		}
		return $this;
	}
	
	protected function _edit() {
		$post = $this->post;
		unset($post['po-dtl-table_length']);

		if(!empty($post[Po::PO_ID]) && isset($post['edit-po'])) {
			if($post['po_dtl'] && is_array($post['po_dtl']) && !empty($post['po_dtl'])) {
				$po_id = $post[Po::PO_ID]; 	
				$post['po_created'] = date('Y-m-d H:i:s',strtotime($post['po_created']));
				$po_dtl = $post['po_dtl'];
				unset($post['po_dtl']);
				
				$total_amount = null;
				foreach ($po_dtl as $dtl) {
					$total_amount = ($dtl['po_dtl_item_cost']*$dtl['po_dtl_item_qty'])+$total_amount;
				}
				
				$post['po_total'] = $total_amount;
				$post = array_filter($post);
				$post[Po::PO_DELIV_DATE] = date('Y-m-d', strtotime(str_replace('-', '/', $post[Po::PO_DELIV_DATE])));
				$filter [] = array('po_id=%s', $post[Po::PO_ID]);
				front()->database()
					->updateRows(Po::PO_TABLE, $post, $filter);
				$po_details = array();
				foreach ($po_dtl as $dtls) {
					$dtl = $dtls;
					unset($filter);
					$filter[] = array('po_dtl_id=%s', $dtl[Po::PO_DTL_ID]); 
					unset($dtl[Po::PO_DTL_ITEM_CREATED]);
					unset($dtl[Po::PO_DTL_ID]);
					front()->database()
						->updateRows(Po::PO_DTL_TABLE, $dtl, $filter);
					array_push($po_details, $dtl);
				}

				$status = array();
					$status['status'] = 1;
					$status['msg'] = 'Saved Changes Successfully on P.O. No.'.$post[Po::PO_NO];
					$status['data'] = array(
							'po_id' => $po_id,
							'po' => $post,
							'po_dtl' => $po_details );
							
				if(IS_AJAX) {
					header('Content-Type: application/json');
					echo json_encode($status);
					exit;
				}
				$this->_addMessage($status['msg'], 'success', true);
				header('Location: /po');
				exit;
			}
		}
		$status = array();
		$status['status'] = 0;
		$status['msg'] = 'Sorry, Unable to save changes on purchase order';
		
		if(IS_AJAX) {
			header('Content-Type: application/json');
			echo json_encode($status);
			exit;
		}
		
		$this->_addMessage($status['msg'], 'danger', true);
		header('Location: /po');
		exit;
	}

	protected function _delete() {
		$po = $this->post;
		$variables = $this->variables;
		if(!empty($po)) {
			$id = $po[Po::PO_SUPPLIER_ID];
		}
		if(isset($variables[1])) {
			$id = $variables[1];
		}
		front()->database()
			->deleteRows('po', array(
				array('(po_id = %s)',$id)
			));
		$this->_addMessage('Purchase Order Deleted', 'success', true);
		header('Location: /po');
		exit;
	}

	protected function _search() {}
	
	protected function _po() {
		$post = $this->post;
		if(isset($post['po'])) {
			$po = $this->po;
			if($post['po']!= 'all') {
				$id = $post['po'];
				if(is_numeric($id)) {
					$po = $this->Po()->getDetail($id);
				}		
			}
			
			if(IS_AJAX) {
				header('Content-Type: application/json');
				$ret = array();
				$ret['data'] = $po;
				echo json_encode($ret);
				exit;
			}
		}
		return $this;
	}
	
	/* Private Methods
	-------------------------------*/
}