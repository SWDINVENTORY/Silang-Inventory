<?php
App::import('Vendor','bin_card');

$rc= new BinCard();
$rc->hdr();
$rc->table();
$rc->output();
?>