<?php
namespace Report;

class StockCard extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 11;
	protected static $_unit = 'in';
	protected static $_orient = 'L';	
	protected static $_available_line = 37;	
	protected static $_curr_page = 1;
	protected static $_allot_subjects = 15;
	
	function __construct(){
		$this->showLines = !true;
		parent::__construct(StockCard::$_orient, StockCard::$_unit,array(StockCard::$_width,StockCard::$_height));
		$this->createSheet();
	}
	
	function hdr(){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 0.3,
			'width'=> 10.6,
			'height'=> 0.6,
			'cols'=> 50,
			'rows'=> 3,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=12;	
		$y = 1;
		$this->centerText(0,$y++,'STOCK CARD',50,'b');
		$this->drawLine($y+0.2,'h',array(20,10));
		$this->GRID['font_size']=10;	
		$this->centerText(0,$y++,'SILANG WATER DISTRICT',50,'b');		
		$this->centerText(0,$y++,'Agency',50,'');
		return $this;
	}
	
	function data_box(){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 1,
			'width'=> 10.6,
			'height'=> 0.9,
			'cols'=> 47,
			'rows'=> 6,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=8.5;	
		$this->drawBox(0,0,47,47);
		$x_ntrvl = 4;
		$x = 3;
		$this->drawLine($x,'v',array(3,44));
		$this->drawLine($x+=$x_ntrvl,'v',array(3,44));
		$this->drawLine($x+=$x_ntrvl,'v',array(0,47));
		$this->drawLine($x+=$x_ntrvl,'v',array(4,43));
		$this->drawLine($x+=$x_ntrvl,'v',array(4,43));
		$this->drawLine($x+=$x_ntrvl,'v',array(3,44));
		$this->drawLine($x+=$x_ntrvl,'v',array(4,43));
		$this->drawLine($x+=$x_ntrvl,'v',array(4,43));
		$this->drawLine($x+=$x_ntrvl,'v',array(0,47));
		$this->drawLine($x+=$x_ntrvl,'v',array(4,43));
		$this->drawLine($x+=$x_ntrvl,'v',array(4,43));
		$this->drawLine($x+=$x_ntrvl,'v',array(4,43));
		$this->drawLine(3,'h');
		$this->drawLine(4,'h',array(11,36));
		$this->drawLine(5,'h');
		$this->leftText(0.2,2,'Item:',3,'b');
		$this->leftText(11.2,2,'Description:',3,'b');
		$this->leftText(35.2,1.1,'Stock No.:',3,'b');
		$this->leftText(35.2,2.8,'Re-Order Point:',3,'b');
		
		$x_ntrvl = 4;
		$x_ntrvl3 = 8;
		$x = 3;
		$this->centerText(0,4.3,'Date',3,'b');
		
		$this->centerText($x,3.8,'Reference',$x_ntrvl,'b');
		$this->centerText($x+=$x_ntrvl,3.8,'Reference',$x_ntrvl,'b');
		
		$this->centerText(11,3.8,'Receipts',12,'b');
		$this->centerText(23,3.8,'Issuance',12,'b');
		$this->centerText(35,3.8,'Balance',12,'b');
		
		
		$x_ntrvl = 4;
		$x = 3;
		$this->centerText($x+=$x_ntrvl,4.8,'(IAR)',$x_ntrvl,'b');
		$this->centerText($x+=$x_ntrvl,4.8,'(RIS)',$x_ntrvl,'b');
		$this->centerText($x+=$x_ntrvl,4.8,'Qty',$x_ntrvl,'b');
		$this->centerText($x+=$x_ntrvl,4.8,'Unit Cost',$x_ntrvl,'b');
		$this->centerText($x+=$x_ntrvl,4.8,'Amount',$x_ntrvl,'b');
		$this->centerText($x+=$x_ntrvl,4.8,'Qty',$x_ntrvl,'b');
		$this->centerText($x+=$x_ntrvl,4.8,'Unit Cost',$x_ntrvl,'b');
		$this->centerText($x+=$x_ntrvl,4.8,'Amount',$x_ntrvl,'b');
		$this->centerText($x+=$x_ntrvl,4.8,'Qty',$x_ntrvl,'b');
		$this->centerText($x+=$x_ntrvl,4.8,'Unit Cost',$x_ntrvl,'b');
		$this->centerText($x+=$x_ntrvl,4.8,'Amount',$x_ntrvl,'b');
		
		$this->leftText(0,48,'For Property and Supply Unit Use','','b');
		return $this;
	
	}
	
	function details(){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 1.7,
			'width'=> 10.6,
			'height'=> 0.9,
			'cols'=> 50,
			'rows'=> 6,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=9;	
		return $this;
		
	}
}	
	
?>
	