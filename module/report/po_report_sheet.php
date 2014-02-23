<?php
require('formsheet.php');
class POReport extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 13;
	protected static $_unit = 'in';
	protected static $_orient = 'P';
	protected static $_available_line = 41;	
	protected static $_allot_subjects = 15;
	
	function POReport(){
		$this->showLines = !true;
		$this->FPDF(POReport::$_orient, POReport::$_unit,array(POReport::$_width,POReport::$_height));
		$this->createSheet();
	}
	
	function hdr(){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 0.25,
			'width'=> 8,
			'height'=> 2,
			'cols'=> 40,
			'rows'=> 10,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=12;	

		$y=3;
		$this->drawLine($y,'h');
		$y+=3;		
		$this->drawLine($y,'h');
		$y+=2;		
		$this->drawLine($y,'h');		
		
		$y=1;
		$this->centerText(0,$y++,'PURCHASE ORDER',40,'b');
		$this->centerText(0,$y,'SILANG WATER DISTRICT',40,'b');
		$y+=0.7;
		$this->GRID['font_size']=10;	
		$this->centerText(0,$y++,'Agency Name',40,'');
		
		$this->drawLine(24.8,'v',array(3,3));
		$this->drawLine(26.8,'v',array(8,2));
		$this->drawLine($y+0.1,'h',array(3,20));
		$this->leftText(0.2,$y,'Supplier','','');
		
		$this->drawLine($y+0.1,'h',array(27.5,11.5));
		$this->leftText(25,$y++,'PO No.','','');
		
		$this->drawLine($y+0.1,'h',array(3,20));
		$this->leftText(0.2,$y,'Address','','');
		
		$this->drawLine($y+0.1,'h',array(27,12));
		$this->leftText(25,$y++,'Date','','');
		
		$this->drawLine($y+0.1,'h',array(3,20));
		$this->drawLine($y+0.1,'h',array(32,7));
		$this->leftText(25,$y++,'Mode of Procurement','','');
		
		$this->leftText(0.2,$y++,'Gentlemen:','','');
		$this->leftText(3,$y++,'Please furnish this office the following articles subject to the terms and conditions contained herein',40,'');
		
		$this->drawLine($y+0.1,'h',array(5.5,20));
		$this->leftText(0.2,$y,'Place of Delivery','','');
		
		$this->drawLine($y+0.1,'h',array(32,7));
		$this->leftText(27,$y++,'Delivery Term','','');
		
		$this->drawLine($y+0.1,'h',array(5.5,20));
		$this->leftText(0.2,$y,'Date of Delivery','','');
		
		$this->drawLine($y+0.1,'h',array(32,7));
		$this->leftText(27,$y++,'Payment Term','','');
		
		$this->drawBox(0,0,40,10);
	}
	
	function table(){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 2.3,
			'width'=> 8,
			'height'=> 7.5,
			'cols'=> 40,
			'rows'=> 45,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=10;
		$this->drawBox(0,0,40,45);
		//$this->drawLine(1,'h',array(10,15));
		$x=5;
		$x_ntrvl=5;
		$this->drawLine(2,'h');
		$this->drawLine(3,'v',array(0,43.5));
		$this->drawLine(8,'v',array(0,43.5));
		$this->drawLine(12,'v',array(0,43.5));
		$this->drawLine(31,'v',array(0,43.5));
		$this->drawLine(35,'v',array(0,43.5));
		$this->centerText(0,1.3,'Item No',3,'b');
		$this->centerText(3,1.3,'Unit',5,'b');
		$this->centerText(8,1.3,'Quantity',4,'b');
		$this->centerText(12,1.3,'Description',18,'b');
		$this->centerText(31,1.3,'Unit Cost',4,'b');
		$this->centerText(35,1.3,'Amount',5,'b');
		
		$this->drawLine(43.5,'h');
		$this->leftText(0.2,44.5,'(Total Amount in Words)','','');
	}
	
	function ftr(){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 9.85,
			'width'=> 8,
			'height'=> 3,
			'cols'=> 39,
			'rows'=> 15,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=10;
		$this->drawBox(0,0,39,15);
		$y=1;
		$this->leftText(2,$y++,'In case of failure to make the full delivery within the time specified above, a penalty of one-tenth (1/10) of one percent of ','','');
		$this->leftText(1,$y++,'everyday of delay shall be imposed.','','');
		
		$this->centerText(24,$y++,'Very truly yours,',12,'');
		$this->centerText(24,$y,'BONIFACIO B. DELA CRUZ',12,'b');
		$y+=0.75;
		$this->centerText(24,$y,'General Manager',12,'b');
		
		$this->drawLine($y+0.2,'h',array(24,12));
		$y+=0.75;
		$this->centerText(24,$y++,'(Authorized Official)',12,'');
		
		$this->leftText(1,$y,'Conforme:','','');
		$y+=1.25;
		$this->drawLine($y,'h',array(1,15));
		$y+=0.75;
		$this->centerText(1,$y,'Signature Over Printed Name',15,'');
		
		$y+=1.25;
		$this->drawLine($y,'h',array(1,15));
		$y+=0.75;
		$this->centerText(1,$y,'Date',15,'');
		
		$this->drawLine(11,'h');
		$this->drawLine(13,'v',array(11,4));
		$this->drawLine(26,'v',array(11,4));
		$y=11.75;
		$this->leftText(0.2,$y,'Requisition Office/Dept.:','','');
		$this->leftText(13.2,$y++,'Funds Available:','','');
		$this->leftText(26.2,$y++,'Amount:','','');
		
		$this->drawLine($y+0.2,'h',array(1,11));
		$this->centerText(0,$y,'FELIMON M. MADLANSACAY',13,'b');
		$this->drawLine($y+0.2,'h',array(14,11));
		$this->centerText(13,$y++,'MA. ANGELES SUMAGUI',13,'b');
		$this->centerText(0,$y,'(Authorized Official)',13,'');
		$this->centerText(13,$y,'Chief Accountant',13,'');
		$this->leftText(26.2,$y,'ALOBS No.:','','');
	}
}
?>
	