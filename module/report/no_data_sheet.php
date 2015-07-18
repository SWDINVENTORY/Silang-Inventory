<?php
namespace Report;

class NoData extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 5.5;
	protected static $_unit = 'in';
	protected static $_orient = 'P';
	protected static $_available_line = 41;	
	protected static $_allot_subjects = 15;
	
	function __construct() {
		$this->showLines = !true;
		parent::__construct(NoData::$_orient, NoData::$_unit,array(NoData::$_width,NoData::$_height));
		$this->createSheet();
	}
	
	function hdr() {
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 0.25,
			'width'=> 5,
			'height'=> 1.2,
			'cols'=> 25,
			'rows'=> 6,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=14;
		$this->centerText(0,15,'NO DATA AVAILABLE',25,'b');
		
		
	}
	
}
?>
	