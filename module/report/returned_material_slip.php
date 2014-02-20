<?php
include('returned_material_slip_sheet.php');

$rc= new ReturnedMaterialSlip();

$rc->hdr();
$rc->table();
$rc->ftr();
$rc->output();
?>