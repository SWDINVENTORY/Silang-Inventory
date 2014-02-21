<?php
	include('old_reusable_stock.php');
	function recieve_data($datas){
		$rc= new OldReusableStock();
		$rc->table();
		$rc->ftr();
		$rc->output();
	}
?>