<?php
include('ior.php');
function recieve_data($datas){
	$rc = new IssueOutReceipt();
	$rc->hdr()->details()->data_box()->output();
}
?>
