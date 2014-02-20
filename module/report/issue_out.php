<?php
require('formsheet.php');
class issue extends Formsheet{
	protected static $_width = 4.25;
	protected static $_height = 11;
	protected static $_unit = 'in';
	protected static $_orient = 'P';	
	protected static $_available_line = 37;	
	protected static $_curr_page = 1;
	protected static $_allot_subjects = 15;
	
	function issue($data=null){
		$this->data =$data; 
		$this->showLines = !true;
		$this->FPDF(issue::$_orient, issue::$_unit,array(issue::$_width,issue::$_height));
		$this->createSheet();
	}
	
	function hdr($data,$total){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 0.3,
			'width'=> 3.867,
			'height'=> 1,
			'cols'=> 15,
			'rows'=> 8,	
		);	
		$this->section($metrics);
		$hdr = $data['IssueOut'];
		$this->GRID['font_size']=14;	
		$y = 1;
		$this->leftText(1.2,$y++,'CHILD JESUS OF PRAGUE SCHOOL',0,'b');
		$this->GRID['font_size']=9;	
		$this->leftText(2.4,$y++,'Brgy. Calumpang, Binangonan, Rizal, Philippines',0,'');
		$this->GRID['font_size']=13;
		$y ++;
		$this->leftText(4.3,$y++,'Bookstore Issue Out',0,'b');
		$this->GRID['font_size']=9;
		$y ++;
		$this->leftText(0,$y++,'Assessment No: '. $hdr['invoice_no'],0,'b');
		$this->leftText(0,$y,'OR No: '.$hdr['issue_out_no'],0,'b');
		$this->leftText(9,$y++,'OR Date: '.$hdr['issue_out_date'],0,'b');
		$this->leftText(0,$y,'Name : '.$hdr['full_name'],0,'b');
		$this->leftText(9,$y++,'Level/Type : '.$hdr['year_type'],0,'b');
		$y++;
		$this->leftText(0,$y++,'Total No. of Books: '.$total['books'],0,'b');		
		$this->leftText(0,$y++,'Total No. of Supplies: '.$total['supplies'],0,'b');		
		$this->leftText(0,$y,'Others Total: '.$total['others'],0,'b');		
		$this->leftText(9,$y++,'Total: '.$total['overall'],0,'b');
	}
		
	
	function details($data,$books,$supplies,$others){
		$metrics = array(
			'base_x'=> 0.2,
			'base_y'=> 2.25,
			'width'=> 3.867,
			'height'=> 0.855,
			'cols'=> 20,
			'rows'=> 4,	
		);	
		$this->section($metrics);
		//Books
		$y = 0;
		$count = 0;
		$max = 37;
		if(count($books) != 0){
			$this->GRID['font_size']=13;
			$this->centerText(0,$y-0.5,'Books Details',20,'b');
			$this->GRID['font_size']=9;
			$this->DrawLine($y,'h',array(0,20));
			$y+=0.8;
			$this->leftText(0.2,$y,'Description ',0,'b');
			$this->centerText(11,$y,'Order',3,'b');	
			$this->centerText(14,$y,'Served',3,'b');	
			$this->centerText(17,$y,'Variance',3,'b');
			$y+=0.2;
			$this->DrawLine($y++,'h',array(0,20));
			foreach($books as $b){
				$y-=0.2;
				$this->leftText(0.2,$y,$b['Product']['name'] ,0,'');	
				$this->centerText(11,$y,$b['order'],3,'');	
				$this->centerText(14,$y,$b['served'],3,'');	
				$this->centerText(17,$y++,$b['variance'],3,'');
				$y+=0.2;
				
				issue::$_available_line--;
				if(issue::$_available_line==0){	
					$this->createSheet();
					$this->hdr($data,$total);
					$this->section($metrics);
					$y = 0;
					$this->GRID['font_size']=13;
					$this->centerText(0,$y-0.5,'Books Details',18,'b');
					$this->GRID['font_size']=9;
					$this->leftText(12.5,$y-0.5,'(continuation)',20,'');
					$this->DrawLine($y,'h',array(0,20));
					$y+=0.8;
					$this->leftText(0.2,$y,'Description ',0,'b');
					$this->centerText(11,$y,'Order',3,'b');	
					$this->centerText(14,$y,'Served',3,'b');	
					$this->centerText(17,$y,'Variance',3,'b');
					$y+=0.2;		
					$this->DrawLine($y++,'h',array(0,20));
			
					issue::$_available_line=34;
					issue::$_curr_page++;
					$count = 0;
					
				}
				$count++;
			}
			if($count < $max){
				$this->rightText(19,40,' Page '.issue::$_curr_page,'','');
				issue::$_available_line-=3;
				$count+=3;
			}
			$y+=1.2;
		}
		
		if(count($supplies) != 0){
			//Supplies
			
			$start_ = $y;
			$this->GRID['font_size']=13;
			$this->centerText(0,$y-0.5,'Supplies Details',20,'b');
			$this->GRID['font_size']=9;
			$this->DrawLine($y,'h',array(0,20));
			$y+=0.8;
			$this->leftText(0.2,$y,'Description ',0,'b');
			$this->centerText(11,$y,'Order',3,'b');	
			$this->centerText(14,$y,'Served',3,'b');	
			$this->centerText(17,$y,'Variance',3,'b');
			$y+=0.2;
			$this->DrawLine($y++,'h',array(0,20));	
		
			foreach($supplies as $s){
				$y-=0.2;
				$this->leftText(0.2,$y,$s['Product']['name'] ,0,'');	
				$this->centerText(11,$y,$s['order'],3,'');	
				$this->centerText(14,$y,$s['served'],3,'');	
				$this->centerText(17,$y++,$s['variance'],3,'');
				$y+=0.2;
				issue::$_available_line--;
				if(issue::$_available_line==0){		
					$this->createSheet();
					$this->hdr($data,$total);
					$this->section($metrics);
					$y = 0;
					$this->GRID['font_size']=13;
					$this->centerText(0,$y-0.5,'Supplies Details',17,'b');
					$this->GRID['font_size']=9;
					$this->leftText(12.5,$y-0.5,'(continuation)',20,'');
					$this->DrawLine($y,'h',array(0,20));
					$y+=0.8;
					$this->leftText(0.2,$y,'Description ',0,'b');
					$this->centerText(11,$y,'Order',3,'b');	
					$this->centerText(14,$y,'Served',3,'b');	
					$this->centerText(17,$y,'Variance',3,'b');
					$y+=0.2;		
					$this->DrawLine($y++,'h',array(0,20));
			
					issue::$_available_line=34;
					issue::$_curr_page++;
					$this->rightText(19,40,' Page '.issue::$_curr_page,'','');
					$count = 0;
				}
				$count++;
			}
			
			if($count < $max){
				$this->rightText(19,40,' Page '.issue::$_curr_page,'','');
				issue::$_available_line-=3;
				$count+=3;
			}
			$y+=1.2;
		}
		if(count($others) != 0){
			//Others
			
			$start_ = $y;
			$this->GRID['font_size']=13;
			$this->centerText(0,$y-0.5,'Others',20,'b');
			$this->GRID['font_size']=9;
			$this->DrawLine($y,'h',array(0,20));
			$y+=0.8;
			$this->leftText(0.2,$y,'Description ',0,'b');
			$this->centerText(11,$y,'Order',3,'b');	
			$this->centerText(14,$y,'Served',3,'b');	
			$this->centerText(17,$y,'Variance',3,'b');
			$y+=0.2;
			$this->DrawLine($y++,'h',array(0,20));
			
			//pr($data);exit;
			foreach($others as $o){
					$y-=0.2;
					$this->leftText(0.2,$y,$o['Product']['name'] ,0,'');	
					$this->centerText(11,$y,$o['order'],3,'');	
					$this->centerText(14,$y,$o['served'],3,'');	
					$this->centerText(17,$y++,$o['variance'],3,'');
					$y+=0.2;
					
					issue::$_available_line--;
					if(issue::$_available_line==0){
						$this->createSheet();
						$this->hdr($data,$total);
						$this->section($metrics);
						$y = 0;
						$this->GRID['font_size']=13;
						$this->centerText(0,$y-0.5,'Others',18,'b');
						$this->GRID['font_size']=9;
						$this->leftText(12.5,$y-0.5,'(continuation)',20,'');
						$this->DrawLine($y,'h',array(0,20));
						$y+=0.8;
						$this->leftText(0.2,$y,'Description ',0,'b');
						$this->centerText(11,$y,'Order',3,'b');	
						$this->centerText(14,$y,'Served',3,'b');	
						$this->centerText(17,$y,'Variance',3,'b');
						$y+=0.2;		
						$this->DrawLine($y++,'h',array(0,20));
						issue::$_available_line=34;
						issue::$_curr_page++;
						$this->rightText(19,40,' Page '.issue::$_curr_page,'','');
						$count = 0;
					}
				$count++;
			}
			if($count < $max){
				$this->rightText(19,40,' Page '.issue::$_curr_page,'','');
				issue::$_available_line-=3;
				$count+=3;
			}
		}
	}
}	
	
?>
	