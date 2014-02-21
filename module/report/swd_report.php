<?php
	include('swd_report_sheet.php');
	function recieve_data($datas){
		$rc= new SWDReport();
		$rc->hdr();
		$rc->table();
		$rc->ftr();
		$rc->output();
	}
?>