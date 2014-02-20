<?php
require('formsheet.php');
class OldReusableStock extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 11;
	protected static $_unit = 'in';
	protected static $_orient = 'L';
	protected static $_available_line = 41;	
	protected static $_allot_subjects = 15;
	
	function OldReusableStock(){
		$this->showLines = !true;
		$this->FPDF(OldReusableStock::$_orient, OldReusableStock::$_unit,array(OldReusableStock::$_width,OldReusableStock::$_height));
		$this->createSheet();
	}
	
	function table(){
		$metrics = array(
			'base_x'=> 0.3,
			'base_y'=> 0.25,
			'width'=> 10.4,
			'height'=> 6,
			'cols'=> 51,
			'rows'=> 30,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=10;	
		$y = 1;
		//LABEL
		$this->centerText(0,1.7,'Item #',3,'b');
		$this->centerText(3,1.7,'Article',10,'b');
		$this->centerText(13,1.7,'Description',14,'b');
		$this->centerText(27,1.7,'Stock #',4,'b');
		$this->centerText(31,0.9,'Beginning',4,'b');
		$this->centerText(31,1.7,'Balance',4,'b');
		$this->centerText(31,2.6,'Qty',4,'b');
		$this->centerText(35,1.7,'Received',4,'b');
		$this->centerText(35,2.6,'Qty',4,'b');
		$this->centerText(39,1.7,'Issued',4,'b');
		$this->centerText(39,2.6,'Qty',4,'b');
		
		$this->centerText(43,0.9,'Returned',4,'b');
		$this->centerText(43,1.7,'Material',4,'b');
		$this->centerText(43,2.6,'Qty',4,'b');
		$this->centerText(47,0.9,'Ending',4,'b');
		$this->centerText(47,1.7,'Balance',4,'b');
		$this->centerText(47,2.6,'Qty',4,'b');
		
		$this->centerText(0,5.75,'OLD / REUSABLE STOCK',51,'b');
		
		$this->drawBox(0,0,51,30);
		$this->drawLine(3,'h');
		$this->drawMultipleLines(6,29,1.5,'h');
		$x=27;
		$x_ntrvl=4;
		$this->drawLine(3,'v',array(0,3));
		$this->drawLine(13,'v',array(0,3));
		$this->drawLine($x,'v',array(0,3));
		$this->drawLine($x+=$x_ntrvl,'v',array(0,3));
		$this->drawLine($x+=$x_ntrvl,'v',array(0,3));
		$this->drawLine($x+=$x_ntrvl,'v',array(0,3));
		$this->drawLine($x+=$x_ntrvl,'v',array(0,3));
		$this->drawLine($x+=$x_ntrvl,'v',array(0,3));
	
		$x=27;
		$x_ntrvl=4;
		$this->drawLine(3,'v',array(6,24));
		$this->drawLine(13,'v',array(6,24));
		$this->drawLine($x,'v',array(6,24));
		$this->drawLine($x+=$x_ntrvl,'v',array(6,24));
		$this->drawLine($x+=$x_ntrvl,'v',array(6,24));
		$this->drawLine($x+=$x_ntrvl,'v',array(6,24));
		$this->drawLine($x+=$x_ntrvl,'v',array(6,24));
		$this->drawLine($x+=$x_ntrvl,'v',array(6,24));
	}
	
	
	function ftr(){
		$metrics = array(
			'base_x'=> 0.3,
			'base_y'=> 6.4,
			'width'=> 10.4,
			'height'=> 1.6,
			'cols'=> 51,
			'rows'=> 8,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=10;
		$y=2;
		$this->leftText(2,$y,'Prepared by:','','');
		$this->leftText(14,$y,'Checked by:','','');
		$this->leftText(26,$y,'Verified by:','','');
		$this->leftText(39,$y,'Noted by:','','');
		
		$y=4;
		$this->centerText(0,$y,'Nomet M. Legaspi',12.75,'');
		$this->centerText(12.75,$y,'Ariel L. Madlangsakay',12.75,'');
		$this->centerText(25.5,$y,'Mary Grace E. Babay',12.75,'');
		$this->centerText(38.25,$y,'Bonifacio dela Cruz',12.75,'');
		
		$y=4.25;
		$this->drawLine($y,'h',array(2.25,8));
		$this->drawLine($y,'h',array(15,8));
		$this->drawLine($y,'h',array(27.8,8));
		$this->drawLine($y,'h',array(40.75,8));
		$y=5;
		$this->centerText(0,$y,'Admin. Service Aide',12.75,'');
		$this->centerText(12.75,$y,'Acting Supply Officer - A',12.75,'');
		$this->centerText(25.5,$y,'Division Manager C - GSD',12.75,'');
		$this->centerText(38.25,$y,'General Manager',12.75,'');
	}
	
}
?>
	