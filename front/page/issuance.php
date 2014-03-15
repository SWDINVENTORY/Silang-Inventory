<?php //-->
/**
 * Default logic to output a page
 */
class Front_Page_Issuance extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory : Issuance';
	protected $_class = 'ris';
	protected $_template = '/issuance.phtml';
	protected $_errors = null;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		$this -> post = front()->registry()->get('post')-> getArray();
		$this -> request = front()->registry()->get('request', 'variables', '0');
		$this -> variables = front() -> registry() -> get('request', 'variables') -> getArray();
		$this -> get = front() -> registry() -> get('get') -> getArray();
		
		if (isset($this -> post)) {
			$this -> _setErrors();
			//-> post validation

			if (empty($this -> _errors)) {
				$this -> _process();
				//-> post processing
			}
		}
		
		$this -> _body['error'] = $this -> _errors;
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _setErrors() {}

	protected function _process() {
		$request = strtolower($this -> request);
		unset($this->post['ris-dtl-table_length']);
		switch ($request) {
			case 'furnish':
				$this -> _add();
				break;
			default :
				$this -> _issuance();
				break;
		}
	}

	protected function _add() {
		$post = $this -> post;
		front()->output($post);
		exit;
		if (isset($post['ris_id']) && empty($post['ris_id'])) {
			if (isset($post['ris_dtl']) && is_array($post['ris_dtl']) &&
				!empty($post['ris_dtl'])) {
				$po = front()->database()
					->getRow('po', 'po_id', $post['ris_po_id']);
				if(!$po['po_is_cancelled'] && !$po['po_is_furnished']) {
					$ris_dtl = $post['ris_dtl'];
					unset($post['ris_dtl']);
					$this->_computeTotalAmount();
					$post['ris_is_partial'] = $this->is_partial;
					$post['ris_partial_qty'] = $this->partial_count;
					$post['ris_total_amount'] = $this->total_amount;
					if(!$this->is_partial){
						unset($post['ris_is_partial']);
						unset($post['ris_partial_qty']);
					}
					$post = array_filter($post);
					$post[Ia::IA_CREATED] = date('Y-m-d H:i:s');
					$ris_id = $this->Ia()->add($post);
					$ris_details = array();
					foreach ($ris_dtl as $dtls) {
						$dtl = $dtls;
						$dtl[Ia::IA_DTL_IA_ID] = $ris_id;
						unset($dtl['po_dtl_item_qty']);
						unset($dtl['po_dtl_item_cost']);
						$dtl[Ia::IA_DTL_ITEM_CREATED] = date('Y-m-d H:i:s');
						$dtl_id = front() -> database() -> insertRow(Ia::IA_DTL_TABLE, $dtl)
							->getLastInsertedId();
						
						if($dtl_id){
							$this->_itemToInventory($dtl);
						}
						$dtl['ris_dtl_id'] = $dtl_id;
						array_push($ris_details, $dtl);
					}
					$this->_updatePo($post['ris_po_id']);
					$status = array();
					$status['status'] = 1;
					$status['msg'] = 'Successfully Inspected and Accepted Order '; //. $post[Ia:] . '!';
					$status['data'] = array('ris_id' => $ris_id, 'ia' => $post, 'ris_dtl' => $ris_details);
					if (IS_AJAX) {
						header('Content-Type: application/json');
						echo json_encode($status);
						exit ;
					}
					$this -> _addMessage($status['msg'], 'success', true);
					header('Location: /ia');
					exit ;
				}
				$status = array();
				$status['status'] = 0;
				$status['msg'] = 'Sorry, Purchase Order is already cancelled or completed';

				if (IS_AJAX) {
					header('Content-Type: application/json');
					echo json_encode($status);
					exit ;
				}

				$this -> _addMessage($status['msg'], 'danger', true);
				header('Location: /ia');
				exit ;
			}

			$status = array();
			$status['status'] = 0;
			$status['msg'] = 'Sorry, Unable to furnish purchase order';

			if (IS_AJAX) {
				header('Content-Type: application/json');
				echo json_encode($status);
				exit ;
			}

			$this -> _addMessage($status['msg'], 'danger', true);
			header('Location: /ia');
			exit ;
		}
		return $this;
	}

	protected function _edit() {
		$post = $this -> post;
		unset($post['ia-dtl-table_length']);
		
		if (!empty($post[Ia::IA_ID]) && isset($post['edit-ia'])) {
			if ($post['ris_dtl'] && is_array($post['ris_dtl']) && !empty($post['ris_dtl'])) {
				$ris_id = $post[Ia::IA_ID];
				$post['ris_created'] = date('Y-m-d H:i:s', strtotime($post['ris_created']));
				$ris_dtl = $post['ris_dtl'];
				unset($post['ris_dtl']);
				$this->_computeTotalAmount();
				$post['ris_total_amount'] = $this->total_amount;
				$post['ris_partial_qty'] = $this->partial_count;
				$post['ris_is_partial'] = $this->is_partial;
				$post = array_filter($post);
				$filter[] = array('ris_id=%s', $post[Ia::IA_ID]);
				front() -> database() -> updateRows(Ia::IA_TABLE, $post, $filter);
				$ris_details = array();
				foreach ($ris_dtl as $dtls) {
					$dtl = $dtls;
					if(isset($dtl[Ia::IA_DTL_ID]) && !empty($dtl[Ia::IA_DTL_ID])){
						unset($filter);
						$filter[] = array('ris_dtl_id=%s', $dtl[Ia::IA_DTL_ID]);
						unset($dtl[Po::PO_DTL_ITEM_QTY]);
						unset($dtl[Po::PO_DTL_ITEM_COST]);
						front() -> database() -> updateRows(Ia::IA_DTL_TABLE, $dtl, $filter);
					}
					if(!isset($dtl[Ia::IA_DTL_ID])){
						unset($dtl[Po::PO_DTL_ITEM_QTY]);
						unset($dtl[Po::PO_DTL_ITEM_COST]);
						unset($dtl[Ia::IA_DTL_ITEM_CREATED]);
						$dtl_id = front() -> database() -> insertRow(Ia::IA_DTL_TABLE, $dtl);
						$dtl['ris_dtl_id'] = $dtl_id;
					}
					array_push($ris_details, $dtl);
				}

				$status = array();
				$status['status'] = 0;
				$status['msg'] = 'Saved Changes Successfully on Inspection / Acceptance' . $post[Po::PO_NO];
				$status['data'] = array('ris_id' => $ris_id, 'ia' => $post, 'ris_dtl' => $ris_details);

				if (IS_AJAX) {
					header('Content-Type: application/json');
					echo json_encode($status);
					exit ;
				}
				$this -> _addMessage($status['msg'], 'success', true);
				header('Location: /ia');
				exit ;
			}
		}
		$status = array();
		$status['status'] = 0;
		$status['msg'] = 'Sorry, Unable to save changes on purchase order';

		if (IS_AJAX) {
			header('Content-Type: application/json');
			echo json_encode($status);
			exit ;
		}

		$this -> _addMessage($status['msg'], 'danger', true);
		header('Location: /ia');
		exit ;
	}

	protected function _delete() {
		$ia = $this -> post;
		$variables = $this -> variables;

		if (isset($variables[1])) {
			$id = $variables[1];
		}
		front() -> database() -> deleteRows('ia', array( array('(ris_id = %s)', $id)));
		$this -> _addMessage('Inspection/Acceptance Report Deleted', 'success', true);
		header('Location: /ia');
		exit ;
	}

	protected function _report() {
		if(isset($this->variables[1])) {
			$ris_id = $this->variables[1];
			$ia = $this->Ia()->getIa($ris_id);
			$ia['detail'] = $this->Ia()->getDetail($ris_id);
			recieve_data($ia);
			exit;
		}
	}

	protected function _issuance() {
		$post = $this -> post;
		if (isset($post['ris_no'])) {
			$issuance = front()->database()->getRows('ris');
			if ($post['ris_no'] != 'all') {
				$ris_no = $post['ris_no'];
				if ($ris_no) {
					$issuance = front()->database()->getRow('ris','ris_no',$ris_no);
					$issuance['ris_dtl']=$this -> Requisition() -> getDetail($issuance['ris_id']);
					
				}
			}

			if (IS_AJAX) {
				header('Content-Type: application/json');
				$ret = array();
				$ret['data'] = $issuance;
				echo json_encode($ret);
				exit ;
			}
		}
		return $this;
	}

	
	/* Private Methods
	-------------------------------*/
}