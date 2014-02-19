<?php
include('physical_count_report_sheet.php');
$reportType = "OFFICE SUPPLIES";
$rc = new PCREPORT();
$rc->hdr($reportType)
	->details()
	->data_box()
	->output();
?>