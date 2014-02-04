<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
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
			$this->_setErrors();
			
			if(empty($this->_errors)) {
				$this->_process();
			}
		}
		
		$this->_body['pos'] = $this->po;
		$this->_body['error'] = $this->_errors;
		
		if(!empty($this->get)) {
			$get = $this->get;
			if(isset($get['po'])){
				if(strtolower($get['po']) == 'all') {
					if(IS_AJAX) {
						$po = array();
						$po['data'] = $this->po;
						header('Content-Type: application/javascript');
						echo json_encode($po);
						exit;
					}
				}
			}
			front()->output($_SERVER);
			exit;
		}
		
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
			default:
				break;
		}
	}
	
	protected function _add() {
		$po = $this->post;
		
		unset($po['po-dtl-table_length']);
		
		if(!isset($po['po_id'])) {
			if($po['po_dtl'] && is_array($po['po_dtl']) && !empty($po['po_dtl'])) {
				$po_dtl = $po['po_dtl'];
				unset($po['po_dtl']);
				
				$total_amount = null;
				foreach ($po_dtl as $dtl) {
					$total_amount = ($dtl['po_dtl_item_cost']*$dtl['po_dtl_item_qty'])+$total_amount;
				}
				
				$po['po_total'] = $total_amount;
				$po = array_filter($po);
				$po[Po::PO_CREATED] = date('Y-m-d H:i:s');
				$po[Po::PO_DELIV_DATE] = date('Y-m-d', strtotime(str_replace('-', '/', $po[Po::PO_DELIV_DATE])));
				$po_id = $this->Po()->add($po);
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
				if(IS_AJAX) {
					$status = array();
					$status['status'] = 0;
					$status['data'] = array(
							'po_id' => $po_id,
							'po' => $po,
							'po_dtl' => $po_details );
					header('Content-Type: application/javascript');
					echo json_encode($status);
					exit;
				}
			}
			if(IS_AJAX) {
					$status = array();
					$status['status'] = 1;
					$status['msg'] = 'Failed';
					header('Content-Type: application/javascript');
					echo json_encode($status);
					exit;
			}
		}
		header('Location: /po');
		return $this;
	}
	
	protected function _edit() {
		front()->output($this->post);
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
				array('po_supplier_id=%s',$id)
			));
		header('Location: /po');
		return $this;
	}
	
	protected function _search() {
		
	}
	/* Private Methods
	-------------------------------*/
}