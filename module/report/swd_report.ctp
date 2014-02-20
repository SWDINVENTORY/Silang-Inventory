<?php
App::import('Vendor','swd_report');

$rc= new SWDReport();
$rc->hdr();
$rc->table();
$rc->ftr();
$rc->output();
?>