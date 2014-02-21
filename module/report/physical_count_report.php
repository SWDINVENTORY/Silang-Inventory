<?php
include('physical_count_report_sheet.php');
function recieve_data($datas){
	$reportType = "OFFICE SUPPLIES";
	$rc = new PCREPORT();
	$rc->hdr($reportType)->details()->data_box()->output();
}
?>