<?php
include('po_report_sheet.php');
	function recieve_data($datas){
		//echo "<pre>";print_r($datas);exit();
		$rc= new POReport();
		$rc->hdr($datas);
		$total_amount = $rc->table($datas);
		$rc->ftr($datas,$total_amount);
		$rc->output();
	}
?>