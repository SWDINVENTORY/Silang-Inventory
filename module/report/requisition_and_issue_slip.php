<?php
	include('requisition_and_issue_slip_sheet.php');
	$rc= new RequisitionAndIssueSlip();
	$rc->hdr();
	$rc->table();
	$rc->ftr();
	$rc->output();
?>