<?php
	include('bin_card_sheet.php');
	$rc= new BinCard();
	$rc->hdr();
	$rc->table();
	$rc->output();
?>