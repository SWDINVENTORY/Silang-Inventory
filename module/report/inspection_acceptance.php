<?php
	include('inspection_acceptance_sheet.php');
	function recieve_data($datas){
		$report = new report();
		$report->hdr();
		$report->data();
		$report->ftr();
		$report->output();
	}
?>