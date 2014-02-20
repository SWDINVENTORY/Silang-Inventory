<?php
	include('swd_report_sheet.php');
	$rc= new SWDReport();
	$rc->hdr();
	$rc->table();
	$rc->ftr();
	$rc->output();
?>