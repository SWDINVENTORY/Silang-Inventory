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
	
	function hdr($reportType,$fromMonth,$toMonth){
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
		
		if(date('Y',strtotime($fromMonth)) == date('Y',strtotime($toMonth))){
			$dt = date('F',strtotime($fromMonth)).' - '.date('F, Y',strtotime($toMonth));
		}else{
			$dt =date('F, Y',strtotime($fromMonth)).' - '.date('F, Y',strtotime($toMonth));
		}
		
		$this->centerText(0,$y++,'for the month of '.$dt,50,'b');
		return $this;
	}
	
	
	function data_box($detail,$page_no){
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
		$this->drawBox(0,0,50,40);
		$this->drawLine(3,'v',array(0,40));
		$this->drawLine(13,'v',array(0,40));
		$this->drawLine(27,'v',array(0,40));
		$this->drawLine(30,'v',array(0,40));
		$this->drawLine(34,'v',array(0,40));
		$this->drawLine(38,'v',array(0,40));
		$this->drawLine(42,'v',array(0,40));
		$this->drawLine(46,'v',array(0,40));
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
		
		$y=4;
		($page_no == 1)?$ctr=1:$ctr=(--$page_no*36)+1;
		foreach($detail as $d){
			$this->centerText(0,$y,'Item '.$ctr++,3,'');
			$this->centerText(3,$y,$d['article'],10,'');
			$this->centerText(13,$y,$d['desc'],15,'');
			$this->centerText(27,$y,$d['stock_no'],3,'');
			$this->centerText(30,$y,$d['bal_start'],4,'');
			$this->centerText(34,$y,$d['received_qty'],4,'');
			$this->centerText(38,$y,$d['issued_qty'],4,'');
			$this->centerText(42,$y,$d['returned_qty'],4,'');
			$this->centerText(46,$y,$d['bal_qty'],4,'');
			$y++;
		}
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
		
		$y = 42;
		$this->GRID['font_size']=9;
		$this->leftText(3,$y,'Prepared by:',3,'');
		$this->GRID['font_size']=8;
		$this->leftText(3,$y+3,'NOMER M. LEGASPI',3,'');
		$this->leftText(3,$y+4,'Admin. Service Aide',3,'');
		
		$this->GRID['font_size']=9;
		$this->leftText(15,$y,'Checked by:',3,'');
		$this->GRID['font_size']=8;
		$this->leftText(15,$y+3,'Ariel Madlangsakay',3,'');
		$this->leftText(15,$y+4,'Acting Supply Officer - A',3,'');
		
		$this->GRID['font_size']=9;
		$this->leftText(27,$y,'Verified by:',3,'');
		$this->GRID['font_size']=8;
		$this->leftText(27,$y+3,'Mary Grace E. Baybay',3,'');
		$this->leftText(27,$y+4,'Division Manager C - GSD',3,'');
		
		$this->GRID['font_size']=9;
		$this->leftText(41,$y,'Noted by:',3,'');
		$this->GRID['font_size']=8;
		$this->leftText(41,$y+3,'Bonifacio Dela Cruz',3,'');
		$this->leftText(41,$y+4,'General Manager',3,'');
		return $this;
		
	}
}	
	
?>
	