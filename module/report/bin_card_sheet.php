<?php
namespace Report;

class BinCard extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 5.5;
	protected static $_unit = 'in';
	protected static $_orient = 'P';
	protected static $_available_line = 41;	
	protected static $_allot_subjects = 15;
	
	function __construct(){
		$this->showLines = !true;
		parent::__construct(BinCard::$_orient, BinCard::$_unit,array(BinCard::$_width,BinCard::$_height));
		$this->createSheet();
	}
	
	function hdr(){
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
		$y = 1;
		$this->centerText(0,$y++,'BIN CARD',25,'b');
		$this->centerText(0,$y++,'SILANG WATER DISTRICT',25,'b');
		$this->GRID['font_size']=10;	
		$this->centerText(0,$y++,'Agency',25,'');
		
		$y++;
		$this->drawLine($y+0.2,'h',array(6,13));
		$y++;
		$this->GRID['font_size']=9;	
		$this->centerText(0,$y++,'Description',25,'b');
		$this->leftText(0,$y,'Acct. Code:','','b');
		$this->leftText(8,$y,'Stock No.:','','b');
		//$this->drawLine($y+0.2,'h',array(3.5,7));
		$this->leftText(16,$y,'Re-Order Point:','','b');
		//$this->drawLine($y+0.2,'h',array(18,7));
	}
	
	function table(){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 1.8,
			'width'=> 5,
			'height'=> 6.2,
			'cols'=> 25,
			'rows'=> 31,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=9;
		$this->drawBox(0,0,25,31);
		$this->drawMultipleLines(2,30,1,'h');
		//$this->drawLine(1,'h',array(10,15));
		$x=5;
		$x_ntrvl=5;
		$this->drawLine($x,'v');
		$this->drawLine($x+=$x_ntrvl,'v');
		$this->drawLine($x+=$x_ntrvl,'v');
		$this->drawLine($x+=$x_ntrvl,'v');
		$this->centerText(0,1.3,'Date',5,'b');
		$this->centerText(5,1.3,'Reference',5,'b');
		$this->centerText(10,0.9,'Receipt',5,'b');
		$this->centerText(10,1.7,'Qty',5,'b');
		$this->centerText(15,0.9,'Issuance',5,'b');
		$this->centerText(15,1.7,'Qty',5,'b');
		$this->centerText(20,0.9,'Balance',5,'b');
		$this->centerText(20,1.7,'Qty',5,'b');
		$this->leftText(0,32,'For Property and Supply Unit Use','','b');
	}
}
?>
	