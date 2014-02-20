<?php
require('formsheet.php');
class ReturnedMaterialSlip extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 6.5;
	protected static $_unit = 'in';
	protected static $_orient = 'P';
	protected static $_available_line = 41;	
	protected static $_allot_subjects = 15;
	
	function ReturnedMaterialSlip(){
		$this->showLines = !true;
		$this->FPDF(ReturnedMaterialSlip::$_orient, ReturnedMaterialSlip::$_unit,array(ReturnedMaterialSlip::$_width,ReturnedMaterialSlip::$_height));
		$this->createSheet();
	}
	
	function hdr(){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 0.2,
			'width'=> 6,
			'height'=> 1.2,
			'cols'=> 30,
			'rows'=> 7,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=10;	
		$this->drawBox(0,0,30,7);

		$y=1;
		$this->centerText(0,$y++,'RETURNED MATERIAL SLIP',30,'b');
		$y+=0.75;
		
		$this->GRID['font_size']=8;	
		$this->centerText(0,$y,'SILANG WATER DISTRICT',30,'b');
		$y+=0.75;
		$this->centerText(0,$y,'(Agency)',30,'');
		$y+=1.25;
		
		$this->drawLine(4,'h');
		$this->drawLine(8,'v',array(4,3));
		$this->drawLine(18,'v',array(4,3));
		
		
		$this->drawLine($y+0.1,'h',array(2.5,5.5));
		$this->leftText(0.2,$y,'Division','','');
		$this->leftText(8.2,$y,'Responsibility Center','','');
		$this->drawLine($y+0.1,'h',array(20.25,4));
		$this->leftText(18.2,$y,'RIS No.','','');
		$this->drawLine($y+0.1,'h',array(26.5,3));
		$this->leftText(25,$y++,'Date','','');

		$this->drawLine($y+0.1,'h',array(2.5,5.5));
		$this->leftText(0.2,$y,'Code','','');
		$this->leftText(8.2,$y,'Office','','');
		
		$this->drawLine($y+0.1,'h',array(20.25,4));
		$this->leftText(18.2,$y,'SAI No.','','');
		
		$this->drawLine($y+0.1,'h',array(26.5,3));
		$this->leftText(25,$y++,'Date','','');


	}
	
	
	function table(){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 1.40,
			'width'=> 6,
			'height'=> 5.5,
			'cols'=> 30,
			'rows'=> 25,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=10;	
		$y = 0.8;
		//LABEL
		$this->centerText(0,$y,'REQUISITION',22,'b');
		$this->centerText(22,$y++,'ISSUANCE',8,'b');
		$this->GRID['font_size']=9;	
		$this->centerText(0,$y,'Stock No',3,'');
		$this->centerText(3,$y,'Unit',2,'');
		$this->centerText(5,$y,'Description',12,'');
		$this->centerText(17,$y,'Size',3,'');
		$this->centerText(20,$y,'Qty',2,'');
		$this->centerText(22,$y,'Qty',2,'');
		$this->centerText(24,$y,'Remarks',6,'');
		
		//BOX
		$this->drawBox(0,0,30,25);
		$this->drawMultipleLines(1,24,1,'h');
		$this->drawLine(3,'v',array(1,24));
		$this->drawLine(5,'v',array(1,24));
		$this->drawLine(17,'v',array(1,24));
		$this->drawLine(20,'v',array(1,24));
		$this->drawLine(22,'v');
		$this->drawLine(24,'v',array(1,24));
	}
	
	
	function ftr(){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 6.90,
			'width'=> 6,
			'height'=> 1.4,
			'cols'=> 30,
			'rows'=> 7,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=8;
		$y=1.8;		
		$this->leftText(0.2,$y++,'PURPOSE:','','b');
		$this->centerText(5,$y,'Returned by:',12,'b');
		$this->centerText(17,$y,'Approved by:',7,'b');
		$this->centerText(24,$y++,'Received by:',6,'b');
		$this->leftText(0.2,$y++,'Signature','','');
		$this->leftText(0.2,$y++,'Printed Name','','');
		$this->leftText(0.2,$y++,'Designation','','');
		$this->leftText(0.2,$y++,'Date','','');
		
		$this->drawBox(0,0,30,7);
		$this->drawMultipleLines(2,6,1,'h');
		$this->drawLine(5,'v',array(2,5));
		$this->drawLine(17,'v',array(2,5));
		$this->drawLine(24,'v',array(2,5));
		
	}
	
}
?>
	