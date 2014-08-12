<?php
namespace Report;

class MonthlyReport extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 11;
	protected static $_unit = 'in';
	protected static $_orient = 'L';	
	protected static $_available_line = 37;	
	protected static $_curr_page = 1;
	protected static $_allot_subjects = 15;
	
	function __construct(){
		$this->showLines = !true;
		parent::__construct(MonthlyReport::$_orient, MonthlyReport::$_unit,array(MonthlyReport::$_width,MonthlyReport::$_height));
		$this->createSheet();
	}
	
	function hdr($reportType){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 0.3,
			'width'=> 10.6,
			'height'=> 0.9,
			'cols'=> 50,
			'rows'=> 5,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=9;	
		$y = 1;
		$this->centerText(0,$y++,'SILANG WATER DISTRICT',50,'b');
		$this->centerText(0,$y++,'Silang, Cavite',50,'b');
		$y++;
		$this->centerText(0,$y++,$reportType,50,'b');
		$this->centerText(0,$y++,'for the month <DATE>',50,'b');
		return $this;
	}
	
	
	function data_box(){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 1.7,
			'width'=> 10.6,
			'height'=> 0.8,
			'cols'=> 50,
			'rows'=> 6,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=9;	
		$this->drawBox(0,0,50,47);
		$this->drawLine(3,'v',array(0,47));
		$this->drawLine(13,'v',array(0,47));
		$this->drawLine(27,'v',array(0,47));
		$this->drawLine(30,'v',array(0,47));
		$this->drawLine(34,'v',array(0,47));
		$this->drawLine(38,'v',array(0,47));
		$this->drawLine(42,'v',array(0,47));
		$this->drawLine(46,'v',array(0,47));
		$this->drawLine(3,'h');
		
		$this->centerText(0,2,'Item #',3,'b');
		$this->centerText(3,2,'Article',10,'b');
		$this->centerText(13,2,'Description',15,'b');
		$this->centerText(27,1.3,'Stock',3,'b');
		$this->centerText(27,2.3,'No.',3,'b');
		$this->centerText(30,1,'Beginning',4,'b');
		$this->centerText(30,1.9,'Balance',4,'b');
		$this->centerText(30,2.8,'Qty.',4,'b');
		$this->centerText(34,1.3,'Received',4,'b');
		$this->centerText(34,2.3,'Qty.',4,'b');
		$this->centerText(38,1.3,'Issued',4,'b');
		$this->centerText(38,2.3,'Qty.',4,'b');
		$this->centerText(42,1,'Returned',4,'b');
		$this->centerText(42,1.9,'Materials',4,'b');
		$this->centerText(42,2.8,'Qty.',4,'b');
		
		$this->centerText(46,1.3,'Ending',4,'b');
		$this->centerText(46,2.3,'Balance',4,'b');
		
		$this->centerText(12,2,'',15,'b');
		return $this;
	
	}
	
	function details(){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 1.7,
			'width'=> 10.6,
			'height'=> 0.8,
			'cols'=> 50,
			'rows'=> 6,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=9;	
		return $this;
		
	}
}	
	
?>
	