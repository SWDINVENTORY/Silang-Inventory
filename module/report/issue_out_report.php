<?php
include('issue_out_report_sheet.php');
function recieve_data($datas){
	$rc = new IssueOutReport();
	$rc->hdr()->details()->data_box()->output();
}
?>