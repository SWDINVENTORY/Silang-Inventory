<?php
	include('bin_card_sheet.php');
	function recieve_data($datas){
		$rc= new BinCard();
		$rc->hdr();
		$rc->table();
		$rc->output();
	}
?>