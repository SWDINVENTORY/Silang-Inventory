<?php
include('stock_card_sheet.php');
function recieve_data($datas){
	$rc = new StockCard();
	$rc->hdr()->details()->data_box()->output();
}
?>