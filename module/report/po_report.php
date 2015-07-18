<?php
		echo "<pre>";print_r($datas);exit();
include('po_report_sheet.php');
	function recieve_data($datas){
		$ROWS = 36;
		$next_index = 0;
		$item_count = count($item);
		$total_page = ceil($item_count/$ROWS);
		$rc= new POReport();
		for($x=0;$x<$total_page;$++){
			$rc->hdr($datas);
			$total_amount = $rc->table($datas);
			$rc->ftr($datas,$total_amount);
			if($total_page-1 != $x){
				$rc->createSheet();
			}
		}
		
		$rc->output();
	}
?>