<?php //-->
include(realpath(__DIR__.'/../../module/report/requisition_and_issue_slip_sheet.php'));
use Report\RequisitionAndIssueSlip as RequisitionAndIssueSlip;
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
	protected $_class = 'issuance';
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
		unset($this->post['issuance-dtl-table_length']);
		switch ($request) {
			case 'furnish':
				$this -> _add();
				break;
			case 'report':
				$this -> _report();
				break;
			default :
				$this -> _issuance();
				break;
		}
	}

	protected function _add() {
		$post = $this -> post;
		
		if (isset($post['ris_id']) && !empty($post['ris_id'])) {
		
			if (isset($post['ris_dtl']) && is_array($post['ris_dtl']) &&
				!empty($post['ris_dtl'])) {
					$issuance_details =  $post['ris_dtl'];
					$issuance_id = $this->Issuance()->add(array(
						'issuance_no' => $post['issuance_no'],
						'issuance_ris_id' => $post['ris_id'],
						'created' => date('Y-m-d h:i:s', time())
					));
					
					
					foreach($issuance_details as $dtl) {
						front()->database()
							->insertRow('issuance_dtl', array(
								'issuance_dtl_issuance_id' => $issuance_id,
								'issuance_dtl_ris_dtl_id' => $dtl['ris_dtl_id'],
								'issuance_dtl_item_issued' => $dtl['issuance_dtl_item_issued'],
								'issuance_dtl_item_charging' => $dtl['issuance_dtl_item_charging'],
								'issuance_dtl_or_no' => $dtl['issuance_dtl_or_no'],
								'issuance_dtl_meter_no' => $dtl['issuance_dtl_meter_no'],
								'issuance_dtl_item_remarks' => $dtl['ris_dtl_item_remarks'],
								'issuance_dtl_item_created' => date('Y-m-d h:i:s', time())
							));
						$this->deductToMaster($dtl);
					}
					
					$status = array();
					$status['status'] = 1;
					$status['msg'] = 'Successfully Issued Requisition Order'; 
					
					if (IS_AJAX) {
						header('Content-Type: application/json');
						echo json_encode($status);
						exit ;
					}
					$this -> _addMessage($status['msg'], 'success', true);
					header('Location: /issuance');
					exit ;
				}
				
				$status = array();
				$status['status'] = 0;
				$status['msg'] = 'Sorry, Requisition Order is already cancelled or completed';

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
		$status['msg'] = 'Sorry, Unable to furnish issuance order';

		if (IS_AJAX) {
			header('Content-Type: application/json');
			echo json_encode($status);
			exit ;
		}

		$this -> _addMessage($status['msg'], 'danger', true);
		header('Location: /issuance');
		exit ;
		
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
			$issuance_id = $this->variables[1];
			$issuance = front()->database()
				->search('issuance')
				->innerJoinOn('ris', 'issuance_ris_id=ris_id')
				->filterByIssuanceId($issuance_id)
				->getRow();
				
			if(!empty($issuance)) {
				$issuance['ris_dtl'] = 
					front()->database()
						->search('issuance_dtl')
						->addFilter('issuance_dtl_issuance_id = %s', $issuance_id)
						->innerJoinOn('ris_dtl', 'issuance_dtl_ris_dtl_id = ris_dtl_id')
						->getRows();
				}
			//echo '<pre>';
			//print_r($issuance);exit;
				
			$report= new RequisitionAndIssueSlip($issuance);
			$report->hdr($issuance);
			$report->table($issuance);
			$report->ftr($issuance);
			$report->output();
			exit;
		}
	}

	protected function _issuance() {
		$post = $this -> post;
		
		if (isset($post['issuance'])) {
			$issuance = front()->database()
				->search('issuance')
				->innerJoinOn('ris', 'issuance_ris_id=ris_id')
				->getRows();
		}
		
		if (isset($post['ris_no'])) {
			
			$issuance = front()->database()->getRow('ris','ris_no',$post['ris_no']);
			$issuance['ris_dtl']=$this -> Requisition() -> getDetail($issuance['ris_id']);
		}
		
		if (isset($post['issuance_no'])) {
			
			$issuance = front()->database()->getRow('issuance','issuance_no',$post['issuance_no']);
			$issuance = $this -> Issuance() -> getDetail($issuance['issuance_id']);
		}
		
		if (IS_AJAX) {
			header('Content-Type: application/json');
			$ret = array();
			$ret['data'] = $issuance;
			echo json_encode($ret);
			exit ;
		}
		return $this;
	}

	protected function deductToMaster($item) {
		$match = front()->Item()
			->getMatchBy('item_stock_no', $item['ris_dtl_item_stock_no']);
		
		$match=$match[0];
		
		$item_qty = $match['item_qty'] - $item['issuance_dtl_item_issued'];
		
		$settings = array(
			'item_qty' => $item_qty
		);
		
		$filter[] = array('item_id=%s', $match['item_id']);
		
		front()->database()
			->updateRows('item',$settings, $filter);
			
		//Update Stock Level
		front()->database()
			->insertRow(array(
				'item_stock_level_item_id' => $match['item_id'],
				'item_stock_level_qty' => $item_qty,
				'item_stock_level_date' => date('Y-m-d H:i:s')
			));
		
		return true;
		
	}
	/* Private Methods
	-------------------------------*/
}