<?php
include('po_report_sheet.php');
	function recieve_data($datas){
	$rc= new POReport();
	$rc->hdr();
	$rc->table();
	$rc->ftr();
	$rc->output();
	}
?>