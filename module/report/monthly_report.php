<?php
include('monthly_report_sheet.php');
//$reportType = "MATERIAL INVENTORY";
function recieve_data($datas){
	$reportType = "SUPPLIES INVENTORY";
	$rc = new MonthlyReport();
	$rc->hdr($reportType)->details()->data_box()->output();
}
?>