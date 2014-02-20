<?php
App::import('Vendor','returned_material_slip');

$rc= new ReturnedMaterialSlip();

$rc->hdr();
$rc->table();
$rc->ftr();
$rc->output();
?>