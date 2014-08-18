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
use Carbon\Carbon as Carbon;

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
        $this->get = front()->registry()->get('get');
        
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
					return $this->report_RMS('');
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
       
	   //echo '<pre>';
       $head = $this->Item()->getByStockNo($this->get['stock_no']);
       

       $bin_card_data = array();
       $bin_card_data['header'] = array(
            'account_no' => $head['item_acct_no'],
            'stock_no' => $head['item_stock_no'],
            'reorder_point' => '',
            'description' => $head['item_desc'].' '.$head['item_size']
       );
	   
	   $query = sprintf("( SELECT
			issuance_dtl.issuance_dtl_item_created AS date,
			issuance.issuance_no AS ref, 
			'' AS received_qty,
			issuance_dtl.issuance_dtl_item_issued AS issued_qty,
			'' AS bal_qty
			FROM
				issuance_dtl
			INNER JOIN ris_dtl ON ris_dtl.ris_dtl_id = issuance_dtl.issuance_dtl_ris_dtl_id
			INNER JOIN item ON item.item_stock_no = ris_dtl.ris_dtl_item_stock_no
			INNER JOIN issuance ON issuance.issuance_id = issuance_dtl.issuance_dtl_issuance_id
			WHERE
				item.item_stock_no = '%s'
			AND (
				issuance_dtl.issuance_dtl_item_created >= '%s'
				AND issuance_dtl.issuance_dtl_item_created < '%s'
				)
			)
			UNION
				(
					SELECT
						ia_dtl.ia_dtl_item_created AS date,
						ia.ia_no AS ref,
						ia_dtl.ia_dtl_item_qty AS received_qty,
						'' AS issued_qty,
						'' AS bal_qty
					FROM
						item
					INNER JOIN po_dtl ON item.item_stock_no = po_dtl.po_dtl_stock_no
					INNER JOIN ia_dtl ON po_dtl.po_dtl_id = ia_dtl.ia_dtl_po_dtl_id
					INNER JOIN ia ON ia_dtl.ia_dtl_ia_id = ia.ia_id
					WHERE
						item.item_stock_no = '%s'
					AND (
						ia_dtl.ia_dtl_item_created >= '%s'
						AND ia_dtl.ia_dtl_item_created < '%s'
					)
				)
			ORDER BY
				date",
			$this->get['stock_no'],
			date('Y-m-d H:i:s', strtotime($this->get['from_date'])),
			date('Y-m-d H:i:s', strtotime($this->get['to_date'])),
			$this->get['stock_no'],
			date('Y-m-d H:i:s', strtotime($this->get['from_date'])),
			date('Y-m-d H:i:s', strtotime($this->get['to_date']))
		);

	   $bin_card_data['detail'] =front()->database()
			->query($query);
        
		$limit_ng_linya_na_kasya_sa_papel = 57;
		$data_chunk = array_chunk($bin_card_data['detail'], $limit_ng_linya_na_kasya_sa_papel,true);
		$total_page = count($data_chunk);
        
		//echo '<pre>';
		foreach($data_chunk as $data) {
		    //print_r($data);exit;
		    $rc= new BinCard();
		    $rc->hdr($bin_card_data['header']);
			$rc->table($data);
            $rc->output();
		}
		
		
        
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
