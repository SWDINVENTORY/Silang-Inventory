<?php
	include('no_data_sheet.php');
	function recieve_data($datas){
		$rc= new BinCard();
		$rc->hdr();
		$rc->table();
		$rc->output();
	}
?>