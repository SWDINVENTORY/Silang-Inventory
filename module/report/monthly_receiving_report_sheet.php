<?php
namespace Report;

class MonthlyReceivingReport extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 13;
	protected static $_unit = 'in';
	protected static $_orient = 'L';	
	protected static $_available_line = 37;	
	protected static $_curr_page = 1;
	protected static $_allot_subjects = 15;
	
	function __construct(){
		$this->showLines = !true;
		parent::__construct(MonthlyReceivingReport::$_orient, MonthlyReceivingReport::$_unit,array(MonthlyReceivingReport::$_width,MonthlyReceivingReport::$_height));
		$this->createSheet();
	}
	
	function hdr($reportType,$month){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 0.3,
			'width'=> 12.6,
			'height'=> 0.9,
			'cols'=> 50,
			'rows'=> 5,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=11;	
		$y = 1;
		$this->centerText(0,$y++,'Silang Water District',50,'b');
		$this->GRID['font_size']=10;	
		$this->centerText(0,$y++,'MONTHLY RECEIVING REPORT',50,'b');
		$this->GRID['font_size']=9;	
		$this->centerText(0,$y++,'For the Month of '.date('F Y',strtotime($month)),50,'b');
		return $this;
	}
	
	function data_box($h,$data){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 1,
			'width'=> 12.6,
			'height'=> 4.8+$h,
			'cols'=> 44,
			'rows'=> 25,	
		);	
		
		$this->section($metrics);
		$this->GRID['font_size']=9;	
		$this->drawBox(0,0,$metrics['cols'],$metrics['rows']);
		$this->drawLine(2,'v');
		$this->drawLine(3.5,'v');
		$this->drawLine(10,'v');
		$this->drawLine(12,'v');
		$this->drawLine(13.5,'v');
		$this->drawLine(15,'v');
		$this->drawLine(23,'v');
		$this->drawLine(26,'v');
		$this->drawLine(29,'v');
		$this->drawLine(30.5,'v');
		$this->drawLine(33.5,'v');
		$this->drawLine(36,'v',array(1,$metrics['rows']-1));
		$this->drawLine(39,'v',array(1,$metrics['rows']-1));
		$this->drawLine(2.75,'h');
		$this->drawLine(1,'h',array(33.5,10.5));
		
		$this->centerText(0,1.5,'DATE',2,'b');
		$this->centerText(2,1.1,'IAR',1.5,'b');
		$this->centerText(2,1.9,'NO.',1.5,'b');
		$this->centerText(3.5,1.5,'SUPPLIER',6.5,'b');
		$this->centerText(10,1.1,'Inv.#/',2,'b');
		$this->centerText(10,1.9,'DR#',2,'b');
		$this->centerText(12,1.5,'Qty',1.5,'b');
		$this->centerText(13.5,1.5,'Unit',1.5,'b');
		$this->centerText(15,1.5,'DESCRIPTION',8,'b');
		$this->centerText(23,1.5,'Unit Cost',3,'b');
		$this->centerText(26,1.5,'Total Amt.',3,'b');
		$this->centerText(29,1.5,'PO #',1.5,'b');
		$this->centerText(30.5,1.5,'Remarks',3,'b');
		$this->centerText(33.5,0.7,'DESTINATION',10.5,'b');
		$this->centerText(33.5,2,'Division',2.5,'');
		$this->centerText(36,2,'Account',3,'');	
		$this->GRID['font_size']=8;
		$this->centerText(39,1.7,'Purpose/Accountable',5,'');
		$this->centerText(39,2.3,'Employee',5,'');
		
		$y=3.5;

		
		
		//echo '<pre>';
		//print_r($data);exit;
		$this->GRID['font_size']=7;	
		foreach($data as $d){
			$ttl_amt = $d['unit_cost']*$d['ia_dtl_item_qty'];
			$this->centerText(0,$y,date('M d',strtotime($d['ia_date'])),2,'');
			$this->centerText(2,$y,$d['ia_no'],1.5,'');
			$this->GRID['font_size']=6;	
			$this->centerText(3.5,$y,$d['supplier_name'],6.5,'');
			$this->GRID['font_size']=7;	
			$this->centerText(10,$y,$d['ia_inv_no'].' / '.$d['ia_dr_no'],2,'');
			$this->centerText(12,$y,$d['ia_dtl_item_qty'],1.5,'');
			$this->centerText(13.5,$y,$d['item_unit_measure'],1.5,'');
			$this->centerText(15,$y,$d['item_desc'],8,'');
			$this->centerText(23,$y,number_format($d['unit_cost'], 2 ),3,'');
			$this->centerText(26,$y,number_format($ttl_amt,2),3,'');
			$this->centerText(29,$y,$d['po_no'],1.5,'');
			$this->centerText(33.5,$y,$d['dept_name'],2.5,'');
			$this->centerText(36,$y,$d['po_account_no'],3,'');	
			$this->centerText(39,$y,$d['po_purpose'],5,'');
			$y++;
		}
	 	return $this;
		
	}
	
	
	function ftr(){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 5.8,
			'width'=> 12.6,
			'height'=> 2.2,
			'cols'=> 44,
			'rows'=> 13,	
		);	
		$this->section($metrics);
		
		$y = 1;
		$this->GRID['font_size']=9;
		$this->leftText(13,$y,'TOTAL','','b');
		$this->rightText(26,$y,'0.00','','b');
		$this->drawLine($y+0.2,'h',array(23,3.2));
		$this->drawLine($y+0.4,'h',array(23,3.2));
		$y+=2;
		
		$this->rightText(29,$y,'0.00','','b');
		$this->leftText(13,$y++,'Non - Stock Items','','');
		
		$this->rightText(29,$y,'0.00','','b');
		$this->leftText(13,$y++,'Stock - Chlorine','','');
		
		$this->rightText(29,$y,'0.00','','b');
		$this->leftText(13,$y++,'Stock - Building Equipments','','');
		
		$this->rightText(29,$y,'0.00','','b');
		$this->leftText(13,$y++,'Stock - Cleaning Materials','','');
		
		$this->rightText(29,$y,'0.00','','b');
		$this->leftText(13,$y++,'Stock - Paint Materials','','');
		
		$this->rightText(29,$y,'0.00','','b');
		$this->leftText(13,$y++,'Stock - Office Supplies','','');
		
		$this->rightText(29,$y,'0.00','','b');
		$this->leftText(13,$y++,'Stock - Pipes','','');
		
		$this->rightText(29,$y,'0.00','','b');
		$this->leftText(13,$y++,'Stock - Water Meter','','');
		
		
		$this->rightText(29,$y,'0.00','','b');
		$this->leftText(13,$y,'GRAND TOTAL','','b');
		$this->drawLine($y+0.2,'h',array(26,3.2));
		$this->drawLine($y+0.4,'h',array(26,3.2));
		$y+=2;
		$this->leftText(0,$y,'NOMER M. LEGASPI','','b');
		$this->leftText(8,$y,'ARIEL L. MADLANGSAKAY','','b');
		$this->leftText(25,$y,'MARY GRACE E. BAYBAY','','b');
		$this->leftText(36,$y++,'BONIFACION B. DELA CRUZ','','b');
		$this->leftText(0,$y,'Admin. Services Aide','','');
		$this->leftText(8,$y,'Acting Supply Officer - A','','');
		$this->leftText(25,$y,'Division Manager C - GENERAL SERVICES','','');
		$this->leftText(36,$y,'General Manager','','');
		
		return $this;
		
	}
}	
	
?>
	