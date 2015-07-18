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
		$this->centerText(0,$y++,'SILANG WATER DISTRICT',42,'b');
		$this->drawLine($y-.90,'h',array(16,10));
		$y+.90;
		$this->GRID['font_size']=10;	
		$this->centerText(0,$y++,'Agency',42,'i');
		$y +=3;
		$this->drawLine(6.80,'h',array(0,42));
		$this->leftText(2,9,'Supplier:','','i');
		$this->leftText(6,8.9,$hdr['supplier_name'],'','i');
		$this->drawLine(9.10,'h',array(5,15));
		$this->leftText(28,9,'IAR No.:','','i');
		$this->leftText(32,8.9,$hdr['ia_no'],'','i');
		$this->drawLine(9.10,'h',array(31,10));
		$this->leftText(2,11,'PO No.:','','i');
		$this->centerText(7,10.9,$hdr['po_no'],'','i');
		$this->drawLine(11.10,'h',array(5,4));
		$this->leftText(10,11,'Date:','','i');
		$this->centerText(14.5,10.9,date('M d, Y',strtotime($hdr['po_date'])),'','i');
		$this->drawLine(11.10,'h',array(12,5));
		$this->leftText(18,11,'Inv. No.:','','i');
		$this->leftText(21.5,10.9,$hdr['ia_inv_no'],'','i');
		$this->drawLine(11.10,'h',array(21,4));
		$this->leftText(26,11,'DR. No.:','','i');
		$this->leftText(29.5,10.9,$hdr['ia_dr_no'],'','i');
		$this->drawLine(11.10,'h',array(29,4));
		$this->leftText(34,11,'Date:','','i');
		$this->leftText(36.3,10.9,date('M d, Y',strtotime($hdr['ia_date'])),'','i');
		$this->drawLine(11.10,'h',array(36,5));
		$this->leftText(2,14,'Requisitioning Office/Dept.:','','i');
		$this->leftText(12,14,$hdr['dept_name'],'','i');
		$this->drawLine(14.20,'h',array(0,42));
		$this->drawLine(14.40,'h',array(0,42));
		return $this;
	}
	
	function data($detail,$start_index=0,$ROWS=0,$total_amount=0){
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
		$total=$total_amount;
		$line_ctr=0;
		//echo "<pre>";print_r($detail['detail']);exit();
		for($ln=0,$index=$start_index;$index<count($detail['detail']);$index++,$ln++){
			$total+=$total_per_item = $detail['detail'][$index]['po_dtl_item_cost']*$detail['detail'][$index]['ia_dtl_item_qty'];
			$this->centerText(1,$y, isset($detail['detail'][$index]['po_dtl_stock_no'])?$detail['detail'][$index]['po_dtl_stock_no']:'',3,'');
			$this->centerText(5.5,$y, $detail['detail'][$index]['po_dtl_item_unit'],3,'');
			$this->centerText(9.5,$y, $detail['detail'][$index]['ia_dtl_item_qty'],3,'');
			//$this->leftText(14,$y,$detail['detail'][$index]['po_dtl_item_desc'],'','');
			$line_break = $this->fitParagraph(14,$y,$detail['detail'][$index]['po_dtl_item_desc'],14,$align='l',$lnbrk=1);
			$this->rightText(32.5,$y,number_format($detail['detail'][$index]['po_dtl_item_cost'], 2, '.', ','),3,'');
			$this->rightText(38,$y,number_format($total_per_item, 2, '.', ','),3,'');
			$y++;
			$y=$y+($line_break-1);
			$line_ctr++;
			if($line_ctr>=$ROWS){
				$return = array('next_index'=>$index+1,'total_amount'=>$total);
				$this->rightText(38,35.60,number_format($total, 2, '.', ','),3,'');
				break;
			}else{
				if(count($detail['detail'])==$index+1){
					$this->rightText(38,35.60,number_format($total, 2, '.', ','),3,'');
				}
			}
		}
		$y = 27;
		//echo "<pre>";print_r($detail);exit();
		$this->fitParagraph(14,$y+=2,$detail['po_purpose'],14,$align='l',$lnbrk=1,'b');
		//$this->leftText(14,$y+=2,$detail['po_purpose'],'','b');
		$this->leftText(14,$y+=2.5,$detail['ia_is_partial']?'PARTIAL DELIVERY':'FULL DELIVERY','','b');
		$this->GRID['font_size']=12;
		$this->SetTextColor(250,0,0);
		$this->leftText(14,$y+1,isset($detail['detail'][0]['po_dtl_item_type'])?$detail['detail'][0]['po_dtl_item_type']:'','','b');
		$this->GRID['font_size']=9;
		$this->SetTextColor(0,0,0);
		//$this->rightText(38,35.60,number_format($total, 2, '.', ','),3,'');
		$this->GRID['font_size']=10;
		$this->leftText(14,34,('Account No.:'),'','b');
		$this->leftText(19,34,$detail['po_account_no'],'','b');
		$return = array('next_index'=>$index+1,'total_amount'=>$total);
		return $return;
	}
	
	function ftr($detail,$page,$total_page){
		
		//$this->showLines = true;
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
		$this->leftText(1,2,'Date Inspected: '.date('M d, Y',strtotime($detail['ia_date_inspected'])),'','i');
		$this->drawLine(2.1,'h',array(6,6));
		$this->leftText(22,2,'Date Received: '.date('M d, Y',strtotime($detail['ia_date_inspected'])),'','i');
		$this->drawLine(2.1,'h',array(27,6));
		
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
		$y = 7.25;
		$x=1;
		$ay=9;
		$ax=23;

		
		$this->leftText(0.5,8.2,'EDGARDO AMBULO','','');
		$this->centerText(0,8.2,'PILIPINO DIMAS',21,'');
		$this->rightText(20.5,8.2,'ANASTACIO CALDERON','','');
		
		
		$this->leftText(0.5,11,'DENNIS ANARNA','','');
		$this->centerText(0,11,'RENAN CALABANO',21,'');
		$this->rightText(20.5,11,'ROBIN BELANDRES','','');
		
		$this->leftText(0.5,14,'KEVIN AGUILAR','','');
		$this->centerText(0,14,'LILIBETH COROTAN',21,'');
		$this->rightText(20.5,14,'REQUESTING DIVISION','','');
		
		$this->drawLine(7,'h',array(0,21));
		$this->drawLine(10,'h',array(0,21));
		$this->drawLine(13,'h',array(0,21));
		
		//ACCEPTANCE
		$this->drawLine(8.30,'h',array(22,8));
		$this->drawLine(8.30,'h',array(33,8));
		$this->leftText(21.5,7,'Accepted by:','','');
		$this->centerText(22,9,'NOMER LEGASPI',8,'');
		$this->centerText(33,9,'VICTORINA ZAMORA, JR.',8,'');
		
		
		$this->leftText(21.5,11,'Checked by:','','');
		$this->leftText(32,11,'Noted by:','','');
		
		
		
		$this->drawLine(13,'h',array(22,8));
		$this->centerText(22,14,'ARIEL MADLANGSAKAY',8,'');
		$this->centerText(22,15,'Acting Supply Officer - A',8,'');
		$this->centerText(22,16,'Chairman - Inspectorate Committee ',8,'');
		
		$this->drawLine(13,'h',array(33,8));
		$this->centerText(33,14,'MARY GRACE E. BAYBAY',8,'');
		$this->centerText(33,14.7,'Division Manager C - GSD',8,'');
		
		$this->GRID['font_size']=8;
		$this->rightText(41,18.5,'page: '.($page+1).' of '.$total_page,'','');
		return $this;
	}
	
}
?>
	