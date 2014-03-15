<?php
require('formsheet.php');
class POReport extends Formsheet{
	protected static $_width = 8.5;
	protected static $_height = 13;
	protected static $_unit = 'in';
	protected static $_orient = 'P';
	protected static $_available_line = 41;	
	protected static $_allot_subjects = 15;
	
	function POReport(){
		$this->showLines = !true;
		$this->FPDF(POReport::$_orient, POReport::$_unit,array(POReport::$_width,POReport::$_height));
		$this->createSheet();
	}
	
	function hdr($datas){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 0.25,
			'width'=> 8,
			'height'=> 2,
			'cols'=> 40,
			'rows'=> 10,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=12;	

		$y=3;
		$this->drawLine($y,'h');
		$y+=3;		
		$this->drawLine($y,'h');
		$y+=2;		
		$this->drawLine($y,'h');		
		
		$y=1;
		$this->centerText(0,$y++,'PURCHASE ORDER',40,'b');
		$this->centerText(0,$y,'SILANG WATER DISTRICT',40,'b');
		$y+=0.7;
		$this->GRID['font_size']=10;	
		$this->centerText(0,$y++,'Agency Name',40,'');
		
		$this->drawLine(24.8,'v',array(3,3));
		$this->drawLine(26.8,'v',array(8,2));
		$this->drawLine($y+0.1,'h',array(3,20));
		$this->leftText(0.2,$y,'Supplier','','');
		$this->leftText(4,$y,$datas['supplier_name'],'','');
		
		
		$this->drawLine($y+0.1,'h',array(27.5,11.5));
		$this->leftText(28,$y,$datas['po_no'],'','');
		$this->leftText(25,$y++,'PO No.','','');
		
		$this->drawLine($y+0.1,'h',array(3,20));
		$this->leftText(0.2,$y,'Address','','');
		$this->leftText(4,$y,$datas['supplier_address'],'','');
		
		$this->drawLine($y+0.1,'h',array(27,12));
		$this->leftText(28,$y,date('F d, Y',strtotime($datas['po_created'])),'','');
		$this->leftText(25,$y++,'Date','','');
		
		$this->drawLine($y+0.1,'h',array(3,20));
		$this->drawLine($y+0.1,'h',array(32,7));
		$this->leftText(33,$y,$datas['po_proc_mod'],'','');
		$this->leftText(25,$y++,'Mode of Procurement','','');
		//echo "<pre>";print_r($datas);exit();
		$this->leftText(0.2,$y++,'Gentlemen:','','');
		$this->leftText(3,$y++,'Please furnish this office the following articles subject to the terms and conditions contained herein',40,'');
		
		$this->drawLine($y+0.1,'h',array(5.5,20));
		$this->leftText(6,$y,$datas['po_deliv_place'],'','');
		$this->leftText(0.2,$y,'Place of Delivery','','');
		
		$this->drawLine($y+0.1,'h',array(32,7));
		$this->leftText(33,$y,$datas['po_deliv_term'],'','');
		$this->leftText(27,$y++,'Delivery Term','','');
		
		$this->drawLine($y+0.1,'h',array(5.5,20));
		$this->leftText(6,$y,date('F d, Y',strtotime($datas['po_deliv_date'])),'','');
		$this->leftText(0.2,$y,'Date of Delivery','','');
		
		$this->drawLine($y+0.1,'h',array(32,7));
		$this->leftText(33,$y,$datas['po_pay_term'],'','');
		$this->leftText(27,$y++,'Payment Term','','');
		
		$this->drawBox(0,0,40,10);
	}
	
	function convert_number_to_words($number) {
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' point ';
		$dictionary  = array(
			0                   => 'zero',
			1                   => 'one',
			2                   => 'two',
			3                   => 'three',
			4                   => 'four',
			5                   => 'five',
			6                   => 'six',
			7                   => 'seven',
			8                   => 'eight',
			9                   => 'nine',
			10                  => 'ten',
			11                  => 'eleven',
			12                  => 'twelve',
			13                  => 'thirteen',
			14                  => 'fourteen',
			15                  => 'fifteen',
			16                  => 'sixteen',
			17                  => 'seventeen',
			18                  => 'eighteen',
			19                  => 'nineteen',
			20                  => 'twenty',
			30                  => 'thirty',
			40                  => 'fourty',
			50                  => 'fifty',
			60                  => 'sixty',
			70                  => 'seventy',
			80                  => 'eighty',
			90                  => 'ninety',
			100                 => 'hundred',
			1000                => 'thousand',
			1000000             => 'million',
			1000000000          => 'billion',
			1000000000000       => 'trillion',
			1000000000000000    => 'quadrillion',
			1000000000000000000 => 'quintillion'
		);

		if (!is_numeric($number)) {
			return false;
		}

		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
			// overflow
			trigger_error(
				'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
				E_USER_WARNING
			);
			return false;
		}

		if ($number < 0) {
			return $negative . $this->convert_number_to_words(abs($number));
		}

		$string = $fraction = null;

		if (strpos($number, '.') !== false) {
			list($number, $fraction) = explode('.', $number);
		}

		switch (true) {
			case $number < 21:
				$string = $dictionary[$number];
				break;
			case $number < 100:
				$tens   = ((int) ($number / 10)) * 10;
				$units  = $number % 10;
				$string = $dictionary[$tens];
				if ($units) {
					$string .= $hyphen . $dictionary[$units];
				}
				break;
			case $number < 1000:
				$hundreds  = $number / 100;
				$remainder = $number % 100;
				$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
				if ($remainder) {
					$string .= $conjunction . $this->convert_number_to_words($remainder);
				}
				break;
			default:
				$baseUnit = pow(1000, floor(log($number, 1000)));
				$numBaseUnits = (int) ($number / $baseUnit);
				$remainder = $number % $baseUnit;
				$string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
				if ($remainder) {
					$string .= $remainder < 100 ? $conjunction : $separator;
					$string .= $this->convert_number_to_words($remainder);
				}
				break;
		}

		if (null !== $fraction && is_numeric($fraction)) {
			$string .= $decimal;
			$words = array();
			foreach (str_split((string) $fraction) as $number) {
				$words[] = $dictionary[$number];
			}
			$string .= implode(' ', $words);
		}

		return $string;
	}
	function table($datas){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 2.3,
			'width'=> 8,
			'height'=> 7.5,
			'cols'=> 40,
			'rows'=> 45,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=10;
		$this->drawBox(0,0,40,45);
		$x=5;
		$x_ntrvl=5;
		$this->drawLine(2,'h');
		$this->drawLine(3,'v',array(0,43.5));
		$this->drawLine(8,'v',array(0,43.5));
		$this->drawLine(12,'v',array(0,43.5));
		$this->drawLine(31,'v',array(0,43.5));
		$this->drawLine(35,'v',array(0,43.5));
		$this->centerText(0,1.3,'Item No',3,'b');
		$this->centerText(3,1.3,'Unit',5,'b');
		$this->centerText(8,1.3,'Quantity',4,'b');
		$this->centerText(12,1.3,'Description',18,'b');
		$this->centerText(31,1.3,'Unit Cost',4,'b');
		$this->centerText(35,1.3,'Amount',5,'b');
		$y=3;
		$total_amount=0;
		foreach($datas['detail'] as $detail){
			$this->centerText(3,$y,$detail['po_dtl_item_unit'],5,'');
			$this->centerText(7.5,$y,$detail['po_dtl_item_qty'],5,'');
			$this->leftText(12.5,$y,$detail['po_dtl_item_desc'],18,'');
			$this->rightText(30.5,$y,number_format($detail['po_dtl_item_cost'], 2, '.', ','),4,'');
			$this->rightText(34.5,$y,number_format($detail['po_dtl_item_qty']*$detail['po_dtl_item_cost'], 2, '.', ','),5,'');
			$total_amount +=($detail['po_dtl_item_qty']*$detail['po_dtl_item_cost']);
			$y++;
		}
		
		$this->drawLine(43.5,'h');
		$amount_in_words = $this->convert_number_to_words($total_amount);
		$this->leftText(0.2,44.5,'(Total Amount in Words)             '.strtoupper($amount_in_words).' PESOS','','');
		return $total_amount;
	}
	
	function ftr($datas,$total_amount){
		$metrics = array(
			'base_x'=> 0.25,
			'base_y'=> 9.85,
			'width'=> 8,
			'height'=> 3,
			'cols'=> 39,
			'rows'=> 15,	
		);
		$this->section($metrics);
		$this->GRID['font_size']=10;
		$this->drawBox(0,0,39,15);
		$y=1;
		$this->leftText(2,$y++,'In case of failure to make the full delivery within the time specified above, a penalty of one-tenth (1/10) of one percent of ','','');
		$this->leftText(1,$y++,'everyday of delay shall be imposed.','','');
		
		$this->centerText(24,$y++,'Very truly yours,',12,'');
		$this->centerText(24,$y,$datas['po_auth_off'],12,'b');
		$y+=0.75;
		//$this->centerText(24,$y,'General Manager',12,'b');
		
		$this->drawLine($y+0.2,'h',array(24,12));
		$y+=0.75;
		$this->centerText(24,$y++,'(Authorized Official)',12,'');
		
		$this->leftText(1,$y,'Conforme:','','');
		$y+=1.25;
		$this->drawLine($y,'h',array(1,15));
		$y+=0.75;
		$this->centerText(1,$y-1,$datas['po_conforme'],15,'');
		$this->centerText(1,$y,'Signature Over Printed Name',15,'');
		
		$y+=1.25;
		$this->drawLine($y,'h',array(1,15));
		$y+=0.75;
		$this->centerText(1,$y,'Date',15,'');
		
		$this->drawLine(11,'h');
		$this->drawLine(13,'v',array(11,4));
		$this->drawLine(26,'v',array(11,4));
		$y=11.75;
		$this->leftText(0.2,$y,'Requisition Office/Dept.:','','');
		$this->leftText(13.2,$y++,'Funds Available:','','');
		$this->leftText(26.2,$y++,'Amount:  Php '.number_format($total_amount, 2, '.', ','),'','');
		
		$this->drawLine($y+0.2,'h',array(1,11));
		$this->centerText(0,$y,$datas['po_req_off'],13,'b');
		$this->drawLine($y+0.2,'h',array(14,11));
		$this->centerText(13,$y++,$datas['po_funds_off'],13,'b');
		$this->centerText(0,$y,'(Authorized Official)',13,'');
		$this->centerText(13,$y,'Chief Accountant',13,'');
		$this->leftText(26.2,$y,'ALOBS No.: '.$datas['po_alobs_no'],'','');
	}
}
?>
	