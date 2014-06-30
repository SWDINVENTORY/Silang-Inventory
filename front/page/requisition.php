<?php //-->

class Front_Page_Requisition extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory :  Requisition / Issue';
	protected $_class = 'ris';
	protected $_template = '/requisition.phtml';
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
	
	protected function itemByStockNo() {
		$post = $this->post;
		$item = array();
		if(isset($post['stock_no'])) {
			$item = $this->Item()->getByStockNo($post['stock_no']);
		}
		if (IS_AJAX) {
				header('Content-Type: application/json');
				$ret = array();
				$ret['data'] = $item;
				echo json_encode($ret);
				exit ;
			}
			exit;
		//return $this;
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
			case 'bystockno':
					$this->itemByStockNo();
				break;
			default :
				$this -> _requisition();
				break;
		}
	}

	protected function _add() {
		$post = $this -> post;
		
		//If id for requisition
		if (isset($post['ris_id']) && empty($post['ris_id'])) {
			if (isset($post['ris_dtl']) && is_array($post['ris_dtl']) &&
				!empty($post['ris_dtl'])) {
					$post['ris_created']=date('Y-m-d H:i:s');
					unset($post['ris_id']);
					unset($post['ris_dtl']);
					unset($post['furnish']);
					
					front()->database()
						->insertRow('ris', $post);
					
					$status = array();
					$status['status'] = 1;
					$status['msg'] = 'Successfully Created Requisition '.$post['ris_no'].'!';
					
					if(IS_AJAX){
						header('Content-Type: application/json');
						echo json_encode($status);
						exit;
					}

					$this->_addMessage($status['msg'], 'success', true);
					header('Location: /requisition');
					exit;
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
			header('Location: /requisition');
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

	protected function _requisition() {
		$post = $this -> post;
		
		if (isset($post['ris'])) {
			$requisition = $this ->Requisition()->getAll();
			if ($post['ris'] != 'all') {
				$id = $post['ris'];
				if (is_numeric($id)) {
					$requisition = $this -> Requisition() -> getDetail($id);
				}
			}

			if (IS_AJAX) {
				header('Content-Type: application/json');
				$ret = array();
				$ret['data'] = $requisition;
				echo json_encode($ret);
				exit ;
			}
		}
		return $this;
	}

	
	/* Private Methods
	-------------------------------*/
}