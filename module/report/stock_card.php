<?php
include('stock_card_sheet.php');
$rc = new StockCard();
$rc->hdr()->details()->data_box()->output();
?>