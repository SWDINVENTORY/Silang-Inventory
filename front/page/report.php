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

class Front_Page_Report extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory : ';
	protected $_class = 'report';
	protected $_template = '';
	protected $_errors = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
	    $this->request = front()->registry()->get('request', 'variables','0');
        
        switch ($this->request) {
            case 'inventory-physical-count':
                    return $this->report_PHYSICAL_COUNT();
                break;
            case 'bin-card':
                    return $this->report_BIN_CARD();
                break;
            case 'issue-out':
                    return $this->report_ISSUE_OUT();
                break;
            case 'monthly-report':
                    return $this->report_MONTHLY();
                break;
            case 'ris':
					if(isset($_GET['ris_no'])){
						$data = $this->Requisition()->getByRisNo($_GET['ris_no']);//$CLONE THIS		
						return $this->report_RIS($data);
					}else{
						return $this->report_RIS(0);
					}
                break;
            case 'rms':
					return $this->report_RMS($data);
                break;
            case 'old-reusable-stock':
                    return $this->report_OLD_REUSABLE_STOCK();
                break;
            case 'stock-card':
                    return $this->report_STOCK_CARD();
                break;
            default:
                return $this->_page();
                break;
        }
		/*$reportType = "OFFICE SUPPLIES";
		
		$rc = new IssueOutReport();
		$rc->hdr()->details()->data_box()->output();
		return $this->_page();*/
		echo $this->request;
        return $this->_page();
        exit;
	}
    
	protected function get_RIS($ris_no = 12345)
	{
		$requisition = $this->Requisition->getByRisNo($ris_no);
		$requisition['ris_dtl']= $this->Requisition
			->getDetail($requisition['ris_id']);
		return $requisition;
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
    
    protected function report_RIS($data)
    {	
		$rc= new RequisitionAndIssueSlip($data);
        $rc->hdr();
        $rc->table();
        $rc->ftr();
        $rc->output();
    }
    
    protected function report_RMS($data)
    {
        $rc= new ReturnedMaterialSlip($data);
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