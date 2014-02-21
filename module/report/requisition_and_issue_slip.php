<?php
	include('requisition_and_issue_slip_sheet.php');
	function recieve_data($datas){
		$rc= new RequisitionAndIssueSlip();
		$rc->hdr();
		$rc->table();
		$rc->ftr();
		$rc->output();
	}
?>