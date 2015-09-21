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
	
	function hdr($data){
		//echo "<pre>";
		//print_r($data);
		//exit;
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
		$this->centerText(0,$y++,($data['agency'])?$data['agency']:'SILANG WATER DISTRICT',50,'b');		
		$this->centerText(0,$y++,'Agency',50,'');
		return $this;
	}
	
	function data_box($data){
	//	echo "<pre>";
		//print_r ($data);exit;
		
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
		$this->SetDrawColor(0,0,0);
		$this->SetFillColor(255,255,255);
		$this->DrawBox(0,5,11,1.5,'FD');
		$this->DrawBox(11,5,36,1.5,'D');
		$this->DrawBox(0,45.5,11,1.5,'FD');
		$this->DrawBox(11,45.5,36,1.5,'D');
		$this->drawLine(3,'h');
		$this->drawLine(4,'h',array(11,36));
		$this->drawLine(5,'h');
		$this->leftText(0.2,2,'Item:  '.$data['desc'] ,3,'b');
		$this->leftText(11.2,2,'Description:',3,'b');
		$this->leftText(35.2,1.1,'Stock No.:  '.$data['stock_no'],3,'b');
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
		$x = -1;
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
	
	function details($data){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 1.8,
			'width'=> 10.6,
			'height'=> 0.9,
			'cols'=> 47,
			'rows'=> 6,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=9;	

		
		$y = 1;
		$begbal = true;
		foreach($data as $data ) {
			$x_ntrvl = 4;
			$x_ntrvl3 = 8;
			$x = 3;
			if($begbal){
				$y=0.75;
				$this->centerText(0,$y, 'Beginning Balance',11,'I');
				$this->centerText(35,$y,$data['curr_qty'],$x_ntrvl,'u');
				$this->centerText(39,$y,number_format((double)$data['curr_cost'],2,'.',','),$x_ntrvl,'u');
				$this->centerText(43,$y,number_format((double)$data['curr_amt'],2,'.',','),$x_ntrvl,'u');
				$y+=1.25;
				$begbal=false;
				
			}
			
			$this->centerText(0,$y, date('M d', strtotime($data['date'])),3,'');
			$this->centerText($x,$y,$data['received_ref'],$x_ntrvl,'');
			$this->centerText($x+=$x_ntrvl,$y,$data['issued_ref'],$x_ntrvl,'');
			$this->centerText($x+=$x_ntrvl,$y,$data['received_qty'],$x_ntrvl,'');
			$this->centerText($x+=$x_ntrvl,$y,$data['received_cost'],$x_ntrvl,'');
		    $this->centerText($x+=$x_ntrvl,$y,$data['received_amt'],$x_ntrvl,'');
			$this->centerText($x+=$x_ntrvl,$y,$data['issued_qty'],$x_ntrvl,'');
			$this->centerText($x+=$x_ntrvl,$y,number_format((double)$data['issued_cost'],2,'.',','),$x_ntrvl,'');
			$this->centerText($x+=$x_ntrvl,$y,number_format((double)$data['issued_amt'],2,'.',','),$x_ntrvl,'');
			$this->centerText($x+=$x_ntrvl,$y,$data['bal_qty'],$x_ntrvl,'');
            $this->centerText($x+=$x_ntrvl,$y,number_format((double)$data['bal_cost'],2,'.',','),$x_ntrvl,'');
            $this->centerText($x+=$x_ntrvl,$y,number_format((double)$data['bal_amt'],2,'.',','),$x_ntrvl,'');
			$y++;
		}
		$y=41.25;
		$this->centerText(0,$y, 'Ending Balance',11,'I');
		$this->centerText(35,$y,$data['bal_qty'],$x_ntrvl,'u');
		$this->centerText(39,$y,number_format((double)$data['bal_cost'],2,'.',','),$x_ntrvl,'u');
		$this->centerText(43,$y,number_format((double)$data['bal_amt'],2,'.',','),$x_ntrvl,'u');
	
		
		return $this;
		
	}
}	
	
?>
	