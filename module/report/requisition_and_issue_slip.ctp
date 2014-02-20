<?php
App::import('Vendor','requisition_and_issue_slip');

$rc= new RequisitionAndIssueSlip();

$rc->hdr();
$rc->table();
$rc->ftr();
$rc->output();
?>