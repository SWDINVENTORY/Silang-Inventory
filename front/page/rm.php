<?php //-->
include(realpath(__DIR__.'/../../module/report/returned_material_slip_sheet.php'));
use Report\ReturnedMaterialIssueSlip as ReturnedMaterialIssueSlip;
/**
 * Default logic to output a page
 */
class Front_Page_Rm extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory : Returned Materials';
	protected $_class = 'rm';
	protected $_template = '/rm.phtml';
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
		unset($this->post['rm-dtl-table_length']);
		switch ($request) {
			case 'furnish':
				$this -> _add();
				break;
			case 'report':
				$this -> _report();
				break;
			default :
				$this -> _rm();
				break;
		}
	}

	protected function _add() {
		$post = $this -> post;
		echo '<pre>';
		print_r($post);
		echo 'isset = '.isset($post['rm_id']);
		
		if (isset($post['rm_id']) && empty($post['rm_id'])) {
		
			if (isset($post['rm_dtl']) && is_array($post['rm_dtl']) && !empty($post['rm_dtl'])) {
					$rm_details =  $post['rm_dtl'];
					$rm_id = $this->Rm()->add(array(
						'rm_no' => $post['rm_no'],
						'rm_ris_id' => $post['ris_id'],
						'rm_created' => date('Y-m-d h:i:s', time())
					));
					echo 'RMID:'.$rm_id;
			}else {
				echo '<br/> 2 false';
			}
		}else {
			echo '<br/> 1 false';
		}
		exit;
		if (isset($post['rm_id']) && !empty($post['rm_id'])) {
		
			if (isset($post['rm_dtl']) && is_array($post['rm_dtl']) && !empty($post['rm_dtl'])) {
					$rm_details =  $post['rm_dtl'];
					$rm_id = $this->Rm()->add(array(
						'rm_no' => $post['rm_no'],
						'rm_issuance_id' => $post['issuance_id'],
						'rm_created' => date('Y-m-d h:i:s', time())
					));
					
					
					foreach($rm_details as $dtl) {
						front()->database()
							->insertRow('rm_dtl', array(
								'rm_dtl_rm_id' => $rm_id,
								'rm_dtl_ris_dtl_id' => $dtl['ris_dtl_id'],
								'rm_dtl_item_returned' => $dtl['rm_dtl_item_returned'],
								'rm_dtl_item_charging' => $dtl['rm_dtl_item_charging'],
								'rm_dtl_remarks' => $dtl['rm_dtl_remarks'],
								'rm_dtl_item_created' => date('Y-m-d h:i:s', time())
							));
					}
					
					$status = array();
					$status['status'] = 1;
					$status['msg'] = 'Successfully Returned'; 
					
					print_r($status);
					exit;
					
					if (IS_AJAX) {
						header('Content-Type: application/json');
						echo json_encode($status);
						exit ;
					}
					$this -> _addMessage($status['msg'], 'success', true);
					header('Location: /rm');
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
		$status['msg'] = 'Sorry, Unable to furnish returning of materials';

		if (IS_AJAX) {
			header('Content-Type: application/json');
			echo json_encode($status);
			exit ;
		}

		$this -> _addMessage($status['msg'], 'danger', true);
		header('Location: /rm');
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
			$rm_id = $this->variables[1];
			$rm = front()->database()
				->search('rm')
				->innerJoinOn('ris', 'rm_ris_id=ris_id')
				->filterByRmId($rm_id)
				->getRow();
				
			if(!empty($rm)) {
				$rm['ris_dtl'] = 
					front()->database()
						->search('rm_dtl')
						->addFilter('rm_dtl_rm_id = %s', $rm_id)
						->innerJoinOn('ris_dtl', 'rm_dtl_ris_dtl_id = ris_dtl_id')
						->getRows();
				}
			//echo '<pre>';
			//print_r($rm);exit;
				
			$report= new ReturnedMaterialIssueSlip($rm);
			$report->hdr($rm);
			$report->table($rm);
			$report->ftr($rm);
			$report->output();
			exit;
		}
	}

	protected function _rm() {
		$post = $this -> post;
		$rm = [];
		
		if (isset($post['rm'])) {
			$rm = front()->database()
				->search('rm')
				->innerJoinOn('ris', 'rm_ris_id=ris_id')
				->getRows();
		}
		
		if (isset($post['issuance_no'])) {
			
			$rm = front()->database()
				->search()
				->setTable('issuance')
				->innerJoinOn('ris', 'ris_id=issuance_ris_id')
				->filterByIssuanceNo($post['issuance_no'])
				->getRow();
				
			$rm['rm_dtl'] = front()->database()
				->search()
				->setTable('issuance')
				->innerJoinOn('issuance_dtl', 'issuance_id=issuance_dtl_id')
				->innerJoinOn('ris_dtl', 'issuance_dtl_ris_dtl_id=ris_dtl_id')
				->filterByIssuanceNo($post['issuance_no'])
				->getRows();
		}
		
		if (IS_AJAX) {
			header('Content-Type: application/json');
			$ret = array();
			$ret['data'] = $rm;
			echo json_encode($ret);
			exit ;
		}
		return $this;
	}

	
	/* Private Methods
	-------------------------------*/
}