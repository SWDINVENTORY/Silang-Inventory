<?php //-->
include(realpath(__DIR__.'/../../module/report/inspection_acceptance_sheet.php'));
class Front_Page_Ia extends Front_Page {
	/* Constants
	 -------------------------------*/
	/* Public Properties
	 -------------------------------*/
	/* Protected Properties
	 -------------------------------*/
	protected $_title = 'SWD-Inventory : Inspection / Acceptance';
	protected $_class = 'ia';
	protected $_template = '/ia.phtml';
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
		$this->dept = $this->Dept()-> getAll();
		$this->article = $this->Article()-> getAll();
		
		if (isset($this -> post)) {
			$this -> _setErrors();
			//-> post validation

			if (empty($this -> _errors)) {
				$this -> _process();
				//-> post processing
			}
		}

		$this -> _body['depts'] = $this->dept;
		$this -> _body['articles'] = $this->article;
		$this -> _body['error'] = $this -> _errors;
		return $this -> _page();
	}

	/* Protected Methods
	 -------------------------------*/

	protected function _setErrors() {
	}

	protected function _process() {
		$request = strtolower($this -> request);
		unset($this->post['ia-dtl-table_length']);
		switch ($request) {
			case 'furnish':
				$this -> _add();
				break;
			case 'edit' :
				$this -> _edit();
				break;
			case 'delete' :
				$this -> _delete();
				break;
			case 'report':
				$this->_report();
				break;
			default :
				$this -> _ia();
				break;
		}
	}

	protected function _add() {
		$post = $this -> post;
		if (isset($post['ia_id']) && empty($post['ia_id'])) {
			if (isset($post['ia_dtl']) && is_array($post['ia_dtl']) && !empty($post['ia_dtl'])) {
				$ia_dtl = $post['ia_dtl'];
				unset($post['ia_dtl']);
				$this->_computeTotalAmount();
				$post['ia_is_partial'] = $this->is_partial;
				$post['ia_partial_qty'] = $this->partial_count;
				$post['ia_total_amount'] = $this->total_amount;
				if(!$is_partial){
					unset($post['ia_is_partial']);
					unset($post['ia_partial_qty']);
				}
				$post = array_filter($post);
				$post[Ia::IA_CREATED] = date('Y-m-d H:i:s');
				$ia_id = $this->Ia()->add($post);
				$ia_details = array();
				foreach ($ia_dtl as $dtls) {
					$dtl = $dtls;
					$dtl[Ia::IA_DTL_IA_ID] = $ia_id;
					unset($dtl['po_dtl_item_qty']);
					unset($dtl['po_dtl_item_cost']);
					$dtl[Ia::IA_DTL_ITEM_CREATED] = date('Y-m-d H:i:s');
					$dtl_id = front() -> database() -> insertRow(Ia::IA_DTL_TABLE, $dtl);
					$dtl['ia_dtl_id'] = $dtl_id;
					array_push($ia_details, $dtl);
				}

				$status = array();
				$status['status'] = 1;
				$status['msg'] = 'Successfully Inspected and Accepted Order '; //. $post[Ia:] . '!';
				$status['data'] = array('ia_id' => $ia_id, 'ia' => $post, 'ia_dtl' => $ia_details);
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
			if ($post['ia_dtl'] && is_array($post['ia_dtl']) && !empty($post['ia_dtl'])) {
				$ia_id = $post[Ia::IA_ID];
				$post['ia_created'] = date('Y-m-d H:i:s', strtotime($post['ia_created']));
				$ia_dtl = $post['ia_dtl'];
				unset($post['ia_dtl']);
				$this->_computeTotalAmount();
				$post['ia_total_amount'] = $this->total_amount;
				$post['ia_partial_qty'] = $this->partial_count;
				$post['ia_is_partial'] = $this->is_partial;
				$post = array_filter($post);
				$filter[] = array('ia_id=%s', $post[Ia::IA_ID]);
				front() -> database() -> updateRows(Ia::IA_TABLE, $post, $filter);
				$ia_details = array();
				foreach ($ia_dtl as $dtls) {
					$dtl = $dtls;
					if(isset($dtl[Ia::IA_DTL_ID]) && !empty($dtl[Ia::IA_DTL_ID])){
						unset($filter);
						$filter[] = array('ia_dtl_id=%s', $dtl[Ia::IA_DTL_ID]);
						unset($dtl[Po::PO_DTL_ITEM_QTY]);
						unset($dtl[Po::PO_DTL_ITEM_COST]);
						front() -> database() -> updateRows(Ia::IA_DTL_TABLE, $dtl, $filter);
					}
					if(!isset($dtl[Ia::IA_DTL_ID])){
						unset($dtl[Po::PO_DTL_ITEM_QTY]);
						unset($dtl[Po::PO_DTL_ITEM_COST]);
						unset($dtl[Ia::IA_DTL_ITEM_CREATED]);
						$dtl_id = front() -> database() -> insertRow(Ia::IA_DTL_TABLE, $dtl);
						$dtl['ia_dtl_id'] = $dtl_id;
					}
					array_push($ia_details, $dtl);
				}

				$status = array();
				$status['status'] = 0;
				$status['msg'] = 'Saved Changes Successfully on Inspection / Acceptance' . $post[Po::PO_NO];
				$status['data'] = array('ia_id' => $ia_id, 'ia' => $post, 'ia_dtl' => $ia_details);

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
		front() -> database() -> deleteRows('ia', array( array('(ia_id = %s)', $id)));
		$this -> _addMessage('Inspection/Acceptance Report Deleted', 'success', true);
		header('Location: /ia');
		exit ;
	}

	protected function _report() {
		if(isset($this->variables[1])) {
			$ia_id = $this->variables[1];
			$ia = $this->Ia()->getIa($ia_id);
			$ia['detail'] = $this->Ia()->getDetail($ia_id);
			front()->output($ia);
			exit;
		}
		$report = new report();
		$report->hdr()->data()->ftr()->output();
		exit;
	}

	protected function _ia() {
		$post = $this -> post;
		if (isset($post['ia'])) {
			$ia = $this ->Ia()->getAll();
			if ($post['ia'] != 'all') {
				$id = $post['ia'];
				if (is_numeric($id)) {
					$ia = $this -> Ia() -> getDetail($id);
				}
			}

			if (IS_AJAX) {
				header('Content-Type: application/json');
				$ret = array();
				$ret['data'] = $ia;
				echo json_encode($ret);
				exit ;
			}
		}
		return $this;
	}

	/* Private Methods
	 -------------------------------*/
	 
	private function _computeTotalAmount(){
		$this->total_amount = null;
		$this->partial_count = 0;
		$this->is_partial = 0;
		foreach ($this->post['ia_dtl'] as $dtl) {
			if($dtl['ia_dtl_item_qty'] < $dtl['po_dtl_item_qty']){
				$this->is_partial = 1;
				$this->partial_count+=(($dtl['po_dtl_item_qty'] - $dtl['ia_dtl_item_qty']));
			}
			$this->total_amount = ($dtl['po_dtl_item_cost'] * $dtl['ia_dtl_item_qty']) + $this->total_amount;
		}
	}
}
