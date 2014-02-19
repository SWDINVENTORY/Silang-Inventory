<?php
	include('inspection_acceptance_sheet.php');
	$report = new report();
	$report->hdr();
	$report->data();
	$report->ftr();
	$report->output();
?>