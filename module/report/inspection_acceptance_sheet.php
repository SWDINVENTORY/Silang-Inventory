<?php
namespace Report;

class IAReport extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 11;
	protected static $_unit = 'in';
	protected static $_orient = 'P';	
	protected static $_allot_subjects = 15;
	
	function __construct($data=null){
		$this->data =$data; 
		$this->showLines = !true;
		parent::__construct(IAReport::$_orient, IAReport::$_unit,array(IAReport::$_width,IAReport::$_height));
		$this->createSheet();
		return $this;
	}
	function hdr($hdr){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 0.5,
			'width'=> 8,
			'height'=> 2,
			'cols'=> 42,
			'rows'=> 16,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=12;	
		$y = 1;
		$this->DrawBox(0,-1,42,82,'');
		$this->DrawImage(7.80,-.10,.80,.80, realpath(__DIR__.'/image/logo.jpg'));
		$this->centerText(0,$y++,'INSPECTION AND ACCEPTANCE REPORT',42,'b');
		$y ++;
		$this->centerText(0,$y++,'SILANG WATER DISTRIC',42,'b');
		$this->drawLine($y-.90,'h',array(16,10));
		$y+.90;
		$this->GRID['font_size']=10;	
		$this->centerText(0,$y++,'Agency',42,'i');
		$y +=3;
		$this->drawLine(6.80,'h',array(0,42));
		$this->leftText(2,8,'Supplier:','','i');
		$this->leftText(6,7.9,$hdr['supplier_name'],'','i');
		$this->drawLine(8.10,'h',array(5,15));
		$this->leftText(28,8,'LAR No.:','','i');
		$this->leftText(32,7.9,$hdr['ia_no'],'','i');
		$this->drawLine(8.10,'h',array(31,10));
		$this->leftText(2,11,'PO No.:','','i');
		$this->centerText(7,10.9,$hdr['po_no'],'','i');
		$this->drawLine(11.10,'h',array(5,4));
		$this->leftText(10,11,'Date:','','i');
		$this->centerText(14.5,10.9,date('M d, Y',strtotime($hdr['po_deliv_date'])),'','i');
		$this->drawLine(11.10,'h',array(12,5));
		$this->leftText(18,11,'Inv. No.:','','i');
		$this->leftText(21.5,10.9,$hdr['ia_inv_no'],'','i');
		$this->drawLine(11.10,'h',array(21,4));
		$this->leftText(26,11,'DR. No.:','','i');
		$this->leftText(29.5,10.9,$hdr['ia_dr_no'],'','i');
		$this->drawLine(11.10,'h',array(29,4));
		$this->leftText(34,11,'Date:','','i');
		$this->leftText(36.3,10.9,date('M d, Y',strtotime($hdr['ia_created'])),'','i');
		$this->drawLine(11.10,'h',array(36,5));
		$this->leftText(2,14,'Requisitioning Office/Dept.:','','i');
		$this->leftText(12,14,$hdr['dept_name'],'','i');
		$this->drawLine(14.20,'h',array(0,42));
		$this->drawLine(14.40,'h',array(0,42));
		return $this;
	}
	
	function data($detail){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=>2.5,
			'width'=> 8,
			'height'=> 5.6,
			'cols'=> 42,
			'rows'=> 37,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=12;	
		$this->drawLine(.20,'h',array(0,42));
		$this->drawLine(34.40,'h',array(0,42));
		$this->drawLine(35.80,'h',array(0,42));
		$this->drawLine(37.30,'h',array(0,42));
		$this->drawLine(5,'v',array(-1.30,35.60));
		$this->drawLine(9,'v',array(-1.30,35.60));
		$this->drawLine(13,'v',array(-1.30,35.60));
		$this->drawLine(31,'v',array(-1.30,35.60));
		$this->drawLine(36,'v',array(-1.30,37.10));
		$this->drawLine(21,'v',array(35.80,17.90));
		$this->GRID['font_size']=10;
		$this->leftText(1,-.10,'Stock No.','','b');
		$this->leftText(6,-.10,'Unit','','b');
		$this->leftText(9.5,-.10,'Quantity','','b');
		$this->leftText(20,-.10,'Description','','b');
		$this->leftText(32,-.10,'Unit Cost','','b');
		$this->leftText(36.5,-.10,'Total Amount','','b');
		$this->leftText(20,35.60,'TOTAL','','b');
		$this->centerText(0,36.90,'INSPECTION',21,'b');
		$this->centerText(21,36.90,'ACCEPTANCE',21,'b');
		$this->GRID['font_size']=8;
		$this->drawLine(52.70,'h',array(0,42));
		$this->centerText(0,53.50,'Inspection Office/Inspection Committee',21,'i');
		$this->centerText(21,53.50,'Property Unit',21,'i');
		$this->GRID['font_size']=9;
		$y = 1.5;
		$total_per_item=0;
		$total=0;
		foreach($detail['detail'] as $dtl){
			$total+=$total_per_item = $dtl['po_dtl_item_cost']*$dtl['ia_dtl_item_qty'];
			 $this->centerText(1,$y, isset($dtl['item_stock_no'])?$dtl['item_stock_no']:'',3,'');
			 $this->centerText(5.5,$y, $dtl['po_dtl_item_unit'],3,'');
			 $this->centerText(9.5,$y, $dtl['ia_dtl_item_qty'],3,'');
			 $this->leftText(14,$y,$dtl['po_dtl_item_desc'],'','');
			 $this->rightText(32.5,$y,number_format($dtl['po_dtl_item_cost'], 2, '.', ','),3,'');
			 $this->rightText(38,$y,number_format($total_per_item, 2, '.', ','),3,'');
			 $y++;
		}
		$y+=25;
		//echo "<pre>";print_r($detail);exit();
		$this->leftText(14,$y+=2,$detail['po_purpose'],'','b');
		$this->leftText(14,$y+=2.5,$detail['ia_is_partial']?'PARTIAL DELIVERY':'FULL DELIVERY','','b');
		$this->GRID['font_size']=12;
		$this->SetTextColor(250,0,0);
		$this->leftText(14,$y+1.5,isset($detail['detail'][0]['po_dtl_item_type'])?$detail['detail'][0]['po_dtl_item_type']:'','','b');
		$this->GRID['font_size']=9;
		$this->SetTextColor(0,0,0);
		$this->rightText(38,35.60,number_format($total, 2, '.', ','),3,'');
		return $this;
	}
	
	function ftr($detail){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=>8.15,
			'width'=> 8,
			'height'=> 2.3,
			'cols'=> 42,
			'rows'=> 16,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=10;	
		$this->leftText(1,2,'Date Inspected: '.date('F d, Y',strtotime($detail['dept_created'])),'','');
		$this->leftText(22,2,'Date Received:','','');
		//echo "<pre>";print_r($detail);exit();
		
		$this->GRID['font_size']=12;
		$this->leftText(24.25,3.8,!$detail['ia_is_partial']?'x':'',1,'');
		$this->leftText(24.25,5,$detail['ia_is_partial']?'x':'',1,'');
		$this->leftText(3.3,3.8,'x',1,'');
		$this->GRID['font_size']=10;
		$this->DrawBox(3,3,1,1,'');
		$this->DrawBox(24,3,1,1,'');
		$this->DrawBox(24,4.20,1,1,'');
		//$this->fitText(1,3,'Inspected, verified and found in order as to quantity and specifications.',2,$style='');
		$this->fitParagraph(5,3.90,'Inspected, verified and found in order as to quantity and specifications.',10);
		$this->fitParagraph(26,3.90,'Complete',10);
		$this->fitParagraph(26,4.90,'Partial (pls. specify quantity) '.$detail['ia_partial_qty'].($detail['ia_partial_qty']>1?' items':' item'),10);
		//inspectors
		$this->GRID['font_size']=8;
		$this->drawLine(7.50,'h',array(.40,7.60));
		$this->drawLine(11.30,'h',array(.40,7.60));
		$this->drawLine(14.30,'h',array(.40,7.60));
		//$this->leftText(1,8.20,'EDGARDO F. AMBULO','','');
		//$this->leftText(1,12,'ANASTACIO CALDERON','','');
		//$this->leftText(1,15.20,'MA. ANGELES SUMAGUI','','');
		
		//$this->leftText(12,8.20,'MARIO ATIENZA','','');
		//$this->leftText(12,12,'DENNIS B. ANARNA','','');
		//$this->leftText(11.70,15.20,'REQUESTING DIVISION','','');
		$this->drawLine(7.50,'h',array(11,7.60));
		$this->drawLine(11.30,'h',array(11,7.60));
		$this->drawLine(14.30,'h',array(11,7.60));
		
		//ACCEPTANCE
		$this->drawLine(8.30,'h',array(22,7.60));
		$this->drawLine(12,'h',array(22,8.10));
		$this->leftText(23,9,'NOMER LEGASPI','','');
		$this->leftText(22,10.80,'Checked by:','','');
		$this->leftText(32,10.80,'Noted by:','','');
		$this->leftText(23,13,'ARIEL MADLANGSAKAY','','');
		$this->leftText(23.10,14,'Acting Supply Officer - A','','');
		
		$this->drawLine(12,'h',array(32.50,8.20));
		$this->leftText(33,13,'MARY GRACE E. BAYBAY','','');
		$this->leftText(33.10,14,'Division Manager C - GSD','','');
		
		$this->drawLine(8.30,'h',array(32.5,8.10));
		$this->leftText(33,9,'VICTORINA ZAMORA, JR.','','');
		return $this;
	}
	
}
?>
	