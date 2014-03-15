<?php
	include('inspection_acceptance_sheet.php');
	function recieve_data($datas){
		//echo "<pre>";print_r($datas);exit();
		$report = new report();
		$report->hdr($datas);
		$report->data($datas);
		$report->ftr();
		$report->output();
	}
?>