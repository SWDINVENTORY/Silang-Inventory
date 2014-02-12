<?php //-->
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
		$this -> post = front() -> registry() -> get('post') -> getArray();
		$this -> request = front() -> registry() -> get('request', 'variables', '0');
		$this -> variables = front() -> registry() -> get('request', 'variables') -> getArray();
		$this -> get = front() -> registry() -> get('get') -> getArray();
		$this -> ia = $this -> Ia() -> getAll();

		if (isset($this -> post)) {
			$this -> _setErrors();
			//-> post validation

			if (empty($this -> _errors)) {
				$this -> _process();
				//-> post processing
			}
		}

		$this -> _body['ias'] = $this -> ia;
		$this -> _body['error'] = $this -> _errors;

		return $this -> _page();
	}

	/* Protected Methods
	 -------------------------------*/

	protected function _setErrors() {
	}

	protected function _process() {
		$request = strtolower($this -> request);
		switch ($request) {
			case 'furnish' :
				$this -> _add();
				break;
			case 'edit' :
				$this -> _edit();
				break;
			case 'delete' :
				$this -> _delete();
				break;
			default :
				$this -> _ia();
				break;
		}
	}

	protected function _add() {
		$post = $this -> post;
		unset($post['ia-dtl-table_length']);

		if (isset($post['ia_id']) && empty($post['ia_id'])) {
			if (isset($post['ia_dtl']) && is_array($post['ia_dtl']) && !empty($post['ia_dtl'])) {
				$ia_dtl = $post['ia_dtl'];
				unset($post['ia_dtl']);

				$total_amount = null;
				foreach ($ia_dtl as $dtl) {
					$total_amount = ($dtl['ia_dtl_item_cost'] * $dtl['ia_dtl_item_qty']) + $total_amount;
				}

				$post['ia_total'] = $total_amount;
				$post = array_filter($post);
				$post[Po::PO_CREATED] = date('Y-m-d H:i:s');
				$post[Po::PO_DELIV_DATE] = date('Y-m-d', strtotime(str_replace('-', '/', $post[Po::PO_DELIV_DATE])));
				$ia_id = $this -> Ia() -> add($post);
				$ia_details = array();
				foreach ($ia_dtl as $dtls) {
					$dtl = $dtls;
					$dtl[Po::PO_DTL_PO_ID] = $ia_id;
					$dtl[Po::PO_DTL_ITEM_CREATED] = date('Y-m-d H:i:s');
					$dtl_id = front() -> database() -> insertRow(Po::PO_DTL_TABLE, $dtl);
					$dtl['ia_dtl_id'] = $dtl_id;
					array_push($ia_details, $dtl);
				}

				$status = array();
				$status['status'] = 1;
				$status['msg'] = 'Successfully Created Purchase Order ' . $post[Po::PO_NO] . '!';
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

		if (!empty($post[Po::PO_ID]) && isset($post['edit-ia'])) {
			if ($post['ia_dtl'] && is_array($post['ia_dtl']) && !empty($post['ia_dtl'])) {
				$ia_id = $post[Po::PO_ID];
				$post['ia_created'] = date('Y-m-d H:i:s', strtotime($post['ia_created']));
				$ia_dtl = $post['ia_dtl'];
				unset($post['ia_dtl']);

				$total_amount = null;
				foreach ($ia_dtl as $dtl) {
					$total_amount = ($dtl['ia_dtl_item_cost'] * $dtl['ia_dtl_item_qty']) + $total_amount;
				}

				$post['ia_total'] = $total_amount;
				$post = array_filter($post);
				$post[Po::PO_DELIV_DATE] = date('Y-m-d', strtotime(str_replace('-', '/', $post[Po::PO_DELIV_DATE])));
				$filter[] = array('ia_id=%s', $post[Po::PO_ID]);
				front() -> database() -> updateRows(Po::PO_TABLE, $post, $filter);
				$ia_details = array();
				foreach ($ia_dtl as $dtls) {
					$dtl = $dtls;
					unset($filter);
					$filter[] = array('ia_dtl_id=%s', $dtl[Po::PO_DTL_ID]);
					unset($dtl[Po::PO_DTL_ITEM_CREATED]);
					unset($dtl[Po::PO_DTL_ID]);
					front() -> database() -> updateRows(Po::PO_DTL_TABLE, $dtl, $filter);
					array_push($ia_details, $dtl);
				}

				$status = array();
				$status['status'] = 1;
				$status['msg'] = 'Saved Changes Successfully on P.O. No.' . $post[Po::PO_NO];
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

	protected function _search() {
	}

	protected function _ia() {
		$post = $this -> post;
		if (isset($post['ia'])) {
			$ia = $this -> ia;
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
}
