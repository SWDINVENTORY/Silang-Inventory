<?php
include('returned_material_slip_sheet.php');
function recieve_data($datas){
	$rc= new ReturnedMaterialSlip();
	$rc->hdr();
	$rc->table();
	$rc->ftr();
	$rc->output();
}
?>