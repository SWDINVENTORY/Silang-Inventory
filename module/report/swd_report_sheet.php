<?php
namespace Report;

class SWDReport extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 13;
	protected static $_unit = 'in';
	protected static $_orient = 'P';
	protected static $_available_line = 41;	
	protected static $_allot_subjects = 15;
	
	function __construct(){
		$this->showLines = !true;
		parent::__construct(SWDReport::$_orient, SWDReport::$_unit,array(SWDReport::$_width,SWDReport::$_height));
		$this->createSheet();
	}
	
	function hdr(){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 0.25,
			'width'=> 8,
			'height'=> 1.5,
			'cols'=> 40,
			'rows'=> 7,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=12;	
		$y = 1.25;
		$this->drawLine($y+0.2,'h');
		$y+=1.25;
		$this->drawLine($y+0.2,'h');		
		
		$y=1;
		$this->centerText(0,$y,'SILANG WATER DISTRICT',40,'b');
		$y+=1.25;
		$this->GRID['font_size']=10;
		$this->centerText(0,$y,'(Agency)',40,'');
		
		$y+=1.75;
		$this->leftText(0.2,$y,'Department:','','b');
		$this->leftText(20,$y,'P.R. No.:','','b');
		$this->leftText(32,$y++,'Date:','','b');
		$this->leftText(20,$y,'SAI No.:','','b');
		$this->leftText(32,$y++,'Date:','','b');
		
		$this->leftText(0.2,$y,'Section:','','b');
		$this->leftText(20,$y,'ALOBS No.:','','b');
		$this->leftText(32,$y++,'Date:','','b');
		
		$this->drawBox(0,0,40,7);
	}
	
	function table(){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 1.9,
			'width'=> 8,
			'height'=> 8.5,
			'cols'=> 40,
			'rows'=> 55,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=10;
		$this->drawBox(0,0,40,55);
		//$this->drawLine(1,'h',array(10,15));
		$x=5;
		$x_ntrvl=5;
		$this->drawLine(2,'h');
		$this->drawLine(5,'v');
		$this->drawLine(10,'v');
		$this->drawLine(25,'v');
		$this->drawLine(28,'v');
		$this->drawLine(33,'v');
		$this->centerText(0,1.3,'Quantity',5,'b');
		$this->centerText(5,1.3,'Unit of Issue',5,'b');
		$this->centerText(10,1.3,'Unit of Issue',15,'b');
		$this->centerText(25,0.9,'Stock',3,'b');
		$this->centerText(25,1.7,'No.',3,'b');
		$this->centerText(28,0.9,'Estimated',5,'b');
		$this->centerText(28,1.7,'Unit Cost',5,'b');
		$this->centerText(33,0.9,'Estimated.',7,'b');
		$this->centerText(33,1.7,'Cost.',7,'b');
	}
	
	function ftr(){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 10.5,
			'width'=> 8,
			'height'=> 1.4,
			'cols'=> 40,
			'rows'=> 7,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=10;
		$this->drawBox(0,0,40,7);
		$this->drawLine(10,'v');
		$this->drawLine(25,'v');
		$this->drawMultipleLines(2,6,1,'h');
		$this->leftText(0.2,1.5,'Purpose:','','');
		$this->centerText(10,3.7,'Requested by:',15,'');
		$this->centerText(25.2,3.7,'Approved by:',15,'');
		$this->leftText(0.2,4.7,'Signature:','','');
		$this->leftText(0.2,5.7,'Printed Name:','','');
		$this->leftText(0.2,6.7,'Designation:','','');
	}
}
?>
	