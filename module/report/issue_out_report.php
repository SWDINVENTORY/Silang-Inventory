<?php
include('issue_out_report_sheet.php');
$rc = new IssueOutReport();
$rc->hdr()->details()->data_box()->output();
?>