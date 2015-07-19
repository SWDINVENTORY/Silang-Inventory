<?php //-->
$files = front('folder', realpath(__DIR__.'/../../module/report/'))->getFiles('/\_sheet/');

foreach($files as $files){
	include($files);
}

use Report\BinCard as BinCard;
use Report\IAReport as IAReport;
use Report\IssueOutReport as IssueOutReport;
use Report\MonthlyReport as MonthlyReport;
use Report\OldReusableStock as OldReusableStock;
use Report\PCREPORT as PCREPORT;
use Report\POReport as POReport;
use Report\RequisitionAndIssueSlip as RequisitionAndIssueSlip;
use Report\ReturnedMaterialSlip as ReturnedMaterialSlip;
use Report\SWDReport as SWDReport;
use Report\StockCard as StockCard;

class Front_Page_ReportFilter extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory : ';
	protected $_class = 'report';
	protected $_template = '/physical_count_report_filter.phtml';
	protected $_errors = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		$this->request = front()->registry()->get('request', 'variables','0');
		
		switch($this->request) {
			case 'physical-count':
				$this->_template = '\report_filter\physical_count_report_filter.phtml';
			break;
			case 'bin-card':
                $this->_title.='Bin Card Report';
				$this->_template = '\report_filter\bin_card.phtml';
			break;
			case 'issue-out': 
				$this->_title.='Issue Out Report';
				$this->_template = '\report_filter\issue_out_report.phtml';
			break;
			case 'monthly-report':
                $this->_title.='Monthly Report'; 
				$this->_template = '\report_filter\monthly_report.phtml';
			break;
			case 'monthly-recieving':
                $this->_title.='Monthly Recieving Report'; 
				$this->_template = '\report_filter\monthly_receiving.phtml';
			break;
			case 'ris': 
				$this->_template = '\report_filter\ris.phtml';
			break;
			case 'rms': 
				$this->_template = '\report_filter\rms.phtml';
			break;
			case 'old-reusable-stock': 
				$this->_template = '\report_filter\old_reusable_stock.phtml';
			break;
			case 'stock-card': 
				$this->_template = '\report_filter\stock_card.phtml';
			break;
			default:
				echo 'Report!';
			break;
		}

        return $this->_page();
        exit;
	}
    
	protected function report_BIN_CARD()
    {
        $rc= new BinCard();
        $rc->hdr();
        $rc->table();
        $rc->output();
    }
    
    protected function report_IA()
    {
        
    }
    
    protected function report_ISSUE_OUT()
    {
        $rc = new IssueOutReport();
        $rc->hdr()->details()->data_box()->output();
    }
    
    protected function report_MONTHLY()
    {
        $reportType = "SUPPLIES INVENTORY";
        $rc = new MonthlyReport();
        $rc->hdr($reportType)->details()->data_box()->output();
    }
    
    protected function report_PHYSICAL_COUNT()
    {
        $rc = new PCREPORT();
        $rc->hdr('Supplies')
            ->details()
            ->data_box()
            ->output();
    }
    
    protected function report_RIS()
    {	
        $rc= new RequisitionAndIssueSlip();
        $rc->hdr();
        $rc->table();
        $rc->ftr();
        $rc->output();
    }
    
    protected function report_RMS()
    {
        $rc= new ReturnedMaterialSlip();
        $rc->hdr();
        $rc->table();
        $rc->ftr();
        $rc->output();
    }
	
    protected function report_OLD_REUSABLE_STOCK()
    {
        $rc= new OldReusableStock();
        $rc->table();
        $rc->ftr();
        $rc->output();
    }
    
    protected function report_STOCK_CARD()
    {
        $rc = new StockCard();
        $rc->hdr()->details()->data_box()->output();
    }
    
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}