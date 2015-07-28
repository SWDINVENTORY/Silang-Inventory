<?php
namespace Report;
class PCREPORT extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 14;
	protected static $_unit = 'in';
	protected static $_orient = 'L';	
	protected static $_available_line = 37;	
	protected static $_curr_page = 1;
	protected static $_allot_subjects = 15;
	
	function __construct(){
		$this->showLines = !true;
		parent::__construct(PCREPORT::$_orient, PCREPORT::$_unit,array(PCREPORT::$_width,PCREPORT::$_height));
		$this->createSheet();
	}
	
	function hdr($reportType){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 0.3,
			'width'=> 12.6,
			'height'=> 0.8,
			'cols'=> 60,
			'rows'=> 6,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=9;	
		$y = 1;
		$this->centerText(0,$y++,'REPORT ON THE PHYSICAL COUNT OF INVENTORIES',60,'b');
		$y ++;
		$this->centerText(0,$y,$reportType,60,'b');
		$this->drawline($y+0.1,'h',array(25.5,9));
		$y++;
		$this->centerText(0,$y++,'(Type of Inventory Item)',60,'');
		$y ++;
		$this->centerText(0,$y++,'As of <DATE>',60,'b');
		$y ++;
		$this->leftText(1,$y,'For which ',60,'');
		$this->GRID['font_size']=10;
		$this->leftText(6,$y,'Ariel L. Madlangsakay',60,'b');
		$this->drawline($y+0.1,'h',array(4,9));
		$this->leftText(13.1,$y,',',60,'');
		$this->GRID['font_size']=10;
		$this->leftText(15.5,$y,'Supply Officer C',60,'b');
		$this->drawline($y+0.1,'h',array(13.6,9));
		$this->leftText(22.8,$y,',',60,'');
		$this->GRID['font_size']=10;
		$this->leftText(24,$y,'SWD',60,'b');
		$this->drawline($y+0.1,'h',array(23.2,4));
		$this->GRID['font_size']=9;
		$this->leftText(27.5,$y,', is accountable, having assumed such accountability on',60,'');
		$this->drawline($y+0.1,'h',array(42.5,7));
		$y++;
		$this->centerText(4,$y,'(Accountable Officer)',9,'');
		$this->centerText(13.6,$y,'(Official Designation)',9,'');
		$this->centerText(23.2,$y,'(Agency/Oficce)',4,'');
		$this->centerText(42.5,$y++,'(Date of Assumption)',7,'');
		
		$y ++;
		return $this;
	}
	
	
	function data_box($start_index, $ROWS, $details){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 1.7,
			'width'=> 13.5,
			'height'=> 1.2,
			'cols'=> 60,
			'rows'=> 6,	
		);	
		$this->section($metrics);
		$this->GRID['font_size']=9;	
		$this->drawBox(0,0,60,32);
		$this->drawLine(2,'v',array(0,32));
		$this->drawLine(12,'v',array(0,32));
		$this->drawLine(28,'v',array(0,32));
		$this->drawLine(32,'v',array(0,32));
		$this->drawLine(35,'v',array(0,32));
		$this->drawLine(39,'v',array(0,32));
		$this->drawLine(42,'v',array(0,32));
		$this->drawLine(45,'v',array(0,32));
		$this->drawLine(48,'v',array(0,32));
		$this->drawLine(51,'v',array(0,32));
		$this->drawLine(3,'h');
		
		$this->centerText(0,2,'Item #',2,'b');
		$this->centerText(2,2,'Article',10,'b');
		$this->centerText(12,2,'Description',16,'b');
		$this->centerText(28,2,'Stock #',4,'b');
		$this->centerText(32,1.1,'Unit',3,'b');
		$this->centerText(32,2,'of',3,'b');
		$this->centerText(32,2.8,'Measure',3,'b');
		$this->centerText(35,1.1,'Unit',4,'b');
		$this->centerText(35,2,'Value',4,'b');
		$this->centerText(39,1.1,'Balance',3,'b');
		$this->centerText(39,2,'Per Card',3,'b');
		$this->centerText(39,2.8,'Qty.',3,'b');
		$this->centerText(42,1.1,'Balance',3,'b');
		$this->centerText(42,2,'Per Count',3,'b');
		$this->centerText(42,2.8,'Qty.',3,'b');
		$this->centerText(45,2,'Short',3,'b');
		$this->centerText(48,2,'Over',3,'b');
		$this->centerText(51,2,'Remarks',9,'b');
		//echo "<pre>";print_r($details);exit();
		$y =4;
		for ($ln = 0, $index = $start_index; $index < count($details); $ln++, $index++, $y++){
			$numbering = $index+1;
            $this->centerText(0,$y,$numbering,2,'');
           // $this->fitText(2,$y,$details[$index]['article_name'],10,'b');
            $this->fitText(2.1,$y,$details[$index]['article_name'],3.6,'b');
			$this->centerText(12,$y,$details[$index]['item_desc'],16,'b');
			$this->centerText(28,$y,$details[$index]['item_stock_no'],4,'b');
			$this->centerText(32,$y,$details[$index]['item_unit_measure'],3,'b'); 
			$this->centerText(35,$y,$details[$index]['unit_value'],4,'b');
			$this->centerText(39,$y,$details[$index]['balance_per_card'],3,'b');
			//$this->centerText(42,$y,$details[$index]['balance_per_card'],3,'b');
			$this->centerText(45,$y,$details[$index]['over'],3,'b');
			$this->centerText(48,$y,$details[$index]['xunder'],3,'b');
            if ($ln + 1 >= $ROWS) {
                return $index + 1;
            }
        }
        return $index + 1;
	
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
		
		$y = 34;
		$this->leftText(0,$y,'Submitted by: ',60,'');
		$this->leftText(0,$y+4,'NOMER M. LEGASPI/MARIA R. MACALINDONG/KEVIN T. AGUILAR/ARIEL L MADLANGSAKAY ',60,'b');
		$this->leftText(0,$y+5,'Member - Inventory Committee',60,'');
		
		$this->leftText(0,$y+8,'Noted by: ',60,'');
		$this->leftText(0,$y+12,'MARY GRACE E BAYBAY',60,'b');
		$this->leftText(0,$y+13,'DIVISION MANAGER C - GSD',60,'');
		
		$this->leftText(40,$y,'Verified by: ',60,'');
		$this->leftText(40,$y+4,'EMILIO F. RACELA, JR.',60,'b');
		$this->leftText(40,$y+5,'Chairman - Inventory Committee',60,'');
		
		$this->leftText(40,$y+8,'Approved by: ',60,'');
		$this->leftText(40,$y+12,'BONIFACIO B. DELA CRUZ',60,'b');
		$this->leftText(40,$y+13,'General Manager',60,'');
		return $this;
		
	}
}	
	
?>
	