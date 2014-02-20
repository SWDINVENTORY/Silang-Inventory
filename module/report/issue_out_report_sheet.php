<?php
require('formsheet.php');
class IssueOutReport extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 13;
	protected static $_unit = 'in';
	protected static $_orient = 'L';	
	protected static $_available_line = 37;	
	protected static $_curr_page = 1;
	protected static $_allot_subjects = 15;
	
	function IssueOutReport(){
		$this->showLines = !true;
		$this->FPDF(IssueOutReport::$_orient, IssueOutReport::$_unit,array(IssueOutReport::$_width,IssueOutReport::$_height));
		$this->createSheet();
	}
	
	function hdr(){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 0.3,
			'width'=> 12.6,
			'height'=> 0.9,
			'cols'=> 60,
			'rows'=> 5,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=9;	
		$y = 1;
		$this->leftText(0,$y++,'SILANG WATER DISTRICT',60,'b');
		$this->leftText(0,$y++,'Silang, Cavite',60,'b');
		$y++;
		$this->leftText(0,$y++,'Report of Supplies Issued',60,'b');
		$this->leftText(0,$y++,'for the month <DATE>',60,'b');
		return $this;
	}
	
	
	function data_box(){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 1.7,
			'width'=> 12.6,
			'height'=> 0.8,
			'cols'=> 60,
			'rows'=> 6,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=8.5;	
		$this->drawBox(0,0,60,47);
		$this->drawLine(3,'v',array(0,47));
		$this->drawLine(6,'v',array(0,47));
		$this->drawLine(18.5,'v',array(0,47));
		$this->drawLine(31.5,'v',array(0,47));
		$this->drawLine(34,'v',array(0,47));
		$this->drawLine(37,'v',array(0,47));
		$this->drawLine(40,'v',array(0,47));
		$this->drawLine(43,'v',array(0,47));
		$this->drawLine(47,'v',array(0,47));
		$this->drawLine(52,'v',array(0,47));
		$this->drawLine(55,'v',array(0,47));
		$this->drawLine(3,'h');
		
		$this->centerText(0,2,'Date',3,'b');
		$this->centerText(3,2,'RIS NO.',3,'b');
		$this->centerText(6,2,'RC Description',13,'b');
		$this->centerText(18.5,2,'Inventory Description',13,'b');
		$this->centerText(31.5,1.5,'Qty',2.5,'b');
		$this->centerText(31.5,2.5,'Issued',2.5,'b');
		$this->centerText(34,1.5,'Unit',3,'b');
		$this->centerText(34,2.5,'Cost',3,'b');
		$this->centerText(37,1.5,'Total',3,'b');
		$this->centerText(37,2.5,'Cost',3,'b');
		$this->centerText(40,2,'Charging',3,'b');
		
		$this->centerText(43,1.5,'Total Per',4,'b');
		$this->centerText(43,2.5,'Charging',4,'b');
		$this->centerText(47,1.5,'Total Cost',5,'b');
		$this->centerText(47,2.5,'Per Charging',5,'b');
		$this->centerText(52,1.5,'Total Per',3,'b');
		$this->centerText(52,2.5,'RC',3,'b');
		$this->GRID['font_size']=8;	
		$this->centerText(55,1.5,'Total Cost Per RC',5,'b');
		$this->centerText(55,2.5,'As Per Charging',5,'b');
		
		
		return $this;
	
	}
	
	function details(){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 1.7,
			'width'=> 12.6,
			'height'=> 0.8,
			'cols'=> 60,
			'rows'=> 6,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=9;	
		return $this;
		
	}
}	
	
?>
	