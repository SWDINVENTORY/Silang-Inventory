<?php
namespace Report;

class PCREPORT extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 13;
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
		$this->drawline($y+0.1,'h',array(4,9));
		$this->leftText(13.1,$y,',',60,'');
		$this->drawline($y+0.1,'h',array(13.6,9));
		$this->leftText(22.8,$y,',',60,'');
		$this->drawline($y+0.1,'h',array(23.2,4));
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
		$this->GRID['font_size']=9;	
		$this->drawBox(0,0,60,47);
		$this->drawLine(2,'v',array(0,47));
		$this->drawLine(12,'v',array(0,47));
		$this->drawLine(28,'v',array(0,47));
		$this->drawLine(32,'v',array(0,47));
		$this->drawLine(35,'v',array(0,47));
		$this->drawLine(39,'v',array(0,47));
		$this->drawLine(42,'v',array(0,47));
		$this->drawLine(45,'v',array(0,47));
		$this->drawLine(48,'v',array(0,47));
		$this->drawLine(51,'v',array(0,47));
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
	