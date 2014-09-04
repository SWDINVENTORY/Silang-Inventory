<?php //-->
$files = front('folder', realpath(__DIR__.'/../../module/report/'))->getFiles('/\_sheet/');
ini_set('max_execution_time', 300);

foreach ($files as $files) {
    include ($files);
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
        $this->request = front()->registry()->get('request', 'variables', '0');
        $this->get = front()->registry()->get('get');

        if (empty($_GET)) {
            exit ;
        }

        switch ($this->request) {
            case 'inventory-physical-count' :
                return $this->report_PHYSICAL_COUNT();
                break;
            case 'bin-card' :
                return $this->report_BIN_CARD();
                break;
            case 'issue-out' :
                return $this->report_ISSUE_OUT();
                break;
            case 'monthly-report' :
                return $this->report_MONTHLY();
                break;
            case 'ris' :
                if (isset($_GET['ris_no'])) {
                    $data = $this->Requisition()->getByRisNo($_GET['ris_no']);
                    
                    return $this->report_RIS($data);
                }
                    return $this->report_RIS(0);
                break;
            case 'rms' :
                return $this->report_RMS('');
                break;
            case 'old-reusable-stock' :
                return $this->report_OLD_REUSABLE_STOCK();
                break;
            case 'stock-card' :
                return $this->report_STOCK_CARD();
                break;
            default :
                return $this->_page();
                break;
        }

        return $this->_page();
        exit ;
    }

    protected function get_RIS($ris_no = 12345) {
        $requisition = $this->Requisition->getByRisNo($ris_no);
        $requisition['ris_dtl'] = $this->Requisition->getDetail($requisition['ris_id']);
        return $requisition;
    }

    protected function report_BIN_CARD() {
        
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
			issuance.issuance_id AS tid,
			-1 AS flag,
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
						ia.ia_id AS tid,
						1 AS flag,
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
				date", $this->get['stock_no'], date('Y-m-d H:i:s', strtotime($this->get['from_date'])), date('Y-m-d H:i:s', strtotime($this->get['to_date'])), $this->get['stock_no'], date('Y-m-d H:i:s', strtotime($this->get['from_date'])), date('Y-m-d H:i:s', strtotime($this->get['to_date'])));

        $bin_card_data['detail'] = front()->database()->query($query);

        for ($i = 0; $i < count($bin_card_data['detail']); $i++) {
            $bal = front()->database()->search('item_stock_level')->filterByItemStockLevelTid($bin_card_data['detail'][$i]['tid'])->addFilter('item_stock_level_flag = %s', $bin_card_data['detail'][$i]['flag'])->getRow();
            $bin_card_data['detail'][$i]['date'] = date('M d', strtotime($bin_card_data['detail'][$i]['date']));
            $bin_card_data['detail'][$i]['bal_qty'] = $bal['item_stock_level_qty'];
        }

        $limit_ng_linya_na_kasya_sa_papel = 57;
        $data_chunk = array_chunk($bin_card_data['detail'], $limit_ng_linya_na_kasya_sa_papel, true);
        $total_page = count($data_chunk);

        foreach ($data_chunk as $data) {
            $rc = new BinCard();
            $rc->hdr($bin_card_data['header']);
            $rc->table($data);
            $rc->output();
        }

    }

    protected function report_IA() {

    }

    protected function report_ISSUE_OUT() {
        
        $issued = front()->database()
            ->search()
            ->setTable('issuance')
            ->setColumns(array('issuance.created',
                'ris_no',
                'ris_division',
                'ris_dtl_item_desc',                
                'ris_dtl_item_size',
                'issuance_charging',
                'issuance_dtl_item_issued',
                'ris_dtl_item_cost',
                '(issuance_dtl.issuance_dtl_item_issued*ris_dtl.ris_dtl_item_cost) AS total_cost',
                'ris_dtl_item_stock_no',
                'issuance_dtl_item_created'                
            ))
            ->innerJoinOn('issuance_dtl', 'issuance_dtl_issuance_id = issuance_id')
            ->innerJoinOn('ris', 'ris_id = issuance_ris_id')
            ->innerJoinOn('ris_dtl', 'ris_dtl_id = issuance_dtl_ris_dtl_id')
            ->addFilter('issuance_dtl.issuance_dtl_item_created >= %s', date('Y-m-d h:i:s', strtotime($this->get['from_date'])))
            ->addFilter('issuance_dtl.issuance_dtl_item_created < %s', date('Y-m-d h:i:s', strtotime($this->get['to_date'])))
            ->getRows();
        
        
        
        $datas = array(
            'headers' => array('date' => date( 'M d, Y', strtotime($this->get['from_date']))
                .' - '
                .date( 'M d, Y', strtotime($this->get['to_date']))),
            'details' => array()
        );
        
        $issued_item = array();
        
        for ($i = 0; $i < count($issued); $i++) {
            $index = $issued[$i]['ris_division'].' - '.$issued[$i]['ris_dtl_item_stock_no'];
            if(!isset($issued_item[$index])) {
                $issued_item[$index] = array(
                    'date' => date('m/d/Y', strtotime($issued[$i]['created'])),
                    'ris_no' => $issued[$i]['ris_no'],
                    'rc_desc' => $issued[$i]['ris_division'],
                    'inv_desc' => $issued[$i]['ris_dtl_item_desc'].' '.$issued[$i]['ris_dtl_item_size'],
                    'issued_qty' => $issued[$i]['issuance_dtl_item_issued'],
                    'unit_cost' => $issued[$i]['ris_dtl_item_cost'],
                    'total_cost' => $issued[$i]['total_cost'],
                    'charging' => $issued[$i]['issuance_charging'],
                    'total_per_charge' => 'NONE',
                    'total_cost_percharge' => 'NONE',
                    'total_per_rc' => 'NONE',
                    'total_per_rc_as_percharge' => 'NONE'
                );
            }
            
            if(isset($issued_item[$index])) {
                $issued_item[$index]['issued_qty'] += $issued[$i]['issuance_dtl_item_issued'];
                $issued_item[$index]['total_cost'] = $issued_item[$index]['unit_cost']*$issued_item[$index]['issued_qty'];
            }
               
        }
        foreach ($issued_item as $item) {
            array_push($datas['details'], $item);
        }

        $ROWS = 50;
        $next_index = 0;
        $data_count = count($datas['details']);
        $total_page = ceil($data_count / $ROWS);
        $rc = new IssueOutReport();

        for ($x = 1; $x <= $total_page; $x++) {
            $rc->hdr($datas['headers']);
            $next_index = $rc->data_box($next_index, $ROWS, $datas['details']);
            if ($x < $total_page) {
                $rc->createSheet();
            }
        }
        $rc->output();
    }

    protected function report_MONTHLY() {
        $query_1 = sprintf("( SELECT
			issuance_dtl.issuance_dtl_item_created AS `date`,
			issuance.issuance_no AS ref,
			issuance.issuance_id AS tid,
			item.item_id,
			CONCAT(item.item_desc, '', item.item_size) as `desc`,
			item.item_stock_no,
			article.article_name,
			-1 AS flag,
			'' AS received_qty,
			issuance_dtl.issuance_dtl_item_issued AS issued_qty,
			'' AS bal_qty
			FROM
				issuance_dtl
			INNER JOIN ris_dtl ON ris_dtl.ris_dtl_id = issuance_dtl.issuance_dtl_ris_dtl_id
			INNER JOIN item ON item.item_stock_no = ris_dtl.ris_dtl_item_stock_no
			INNER JOIN article ON article_id = item.item_article_id
			INNER JOIN issuance ON issuance.issuance_id = issuance_dtl.issuance_dtl_issuance_id
			WHERE
				issuance_dtl.issuance_dtl_item_created >= '%s'
				AND issuance_dtl.issuance_dtl_item_created < '%s'	
			)
			UNION
				(
					SELECT
						ia_dtl.ia_dtl_item_created AS `date`,
						ia.ia_no AS ref,
						ia.ia_id AS tid,
						item.item_id,
						CONCAT(item.item_desc, '', item.item_size) as `desc`,
						item.item_stock_no,
						article.article_name,
						1 AS flag,
						ia_dtl.ia_dtl_item_qty AS received_qty,
						'' AS issued_qty,
						'' AS bal_qty
					FROM
						item
					INNER JOIN po_dtl ON item.item_stock_no = po_dtl.po_dtl_stock_no
					INNER JOIN article ON article_id = item.item_article_id
					INNER JOIN ia_dtl ON po_dtl.po_dtl_id = ia_dtl.ia_dtl_po_dtl_id
					INNER JOIN ia ON ia_dtl.ia_dtl_ia_id = ia.ia_id
					WHERE
						ia_dtl.ia_dtl_item_created >= '%s'
						AND ia_dtl.ia_dtl_item_created < '%s'
				)
			ORDER BY 
					date ASC, item_id", 
					date('Y-m-d H:i:s', strtotime($this->get['from_month'])),
					date('Y-m-d H:i:s', strtotime($this->get['to_month'])),
					date('Y-m-d H:i:s', strtotime($this->get['from_month'])), date('Y-m-d H:i:s', strtotime($this->get['to_month']))
		);

        $month_data['detail'] = front()->database()->query($query_1);
        $temp = array();

        for ($i = 0; $i < count($month_data['detail']); $i++) {
            $index = $month_data['detail'][$i]['item_id'].' - '.$month_data['detail'][$i]['article_name'];
            
            //echo $index.' received_qty -> '.$month_data['detail'][$i]['received_qty'];
            //echo ' issued_qty -> '.$month_data['detail'][$i]['issued_qty'].' <br/>';
            
            if (isset($temp[$index])) {
                if(is_numeric($month_data['detail'][$i]['received_qty'])) {
                     $temp[$index]['received_qty'] += $month_data['detail'][$i]['received_qty'];     
                }
                if(is_numeric($month_data['detail'][$i]['issued_qty'])) {
                    $temp[$index]['issued_qty'] += $month_data['detail'][$i]['issued_qty'];
                }                
            }
            
            if (!isset($temp[$index])) {
                $temp[$index] = array(
                    'date' => $month_data['detail'][$i]['date'],
                    'article' => $month_data['detail'][$i]['article_name'],
                    'desc' => $month_data['detail'][$i]['desc'],
                    'item_id' => $month_data['detail'][$i]['item_id'],
                    'stock_no' => $month_data['detail'][$i]['item_stock_no'],
                    'bal_start' => '',
					'returned_qty' => '',
                    'received_qty' => $month_data['detail'][$i]['received_qty'],
                    'issued_qty' => $month_data['detail'][$i]['issued_qty'],
					'bal_qty' => $month_data['detail'][$i]['bal_qty'],
                );
            }
        
            /*$bal = front()->database()
             ->search('item')
             ->filterByItemId($month_data['detail'][$i]['item_id'])
             ->getRow();

             $month_data['detail'][$i]['bal_qty'] = $bal['item_qty'];*/
        }
        // echo '<pre>';
        // print_r($month_data);
        // print_r($temp);
        // exit ;
		
		$reportType = "SUPPLIES INVENTORY";  
		$data_chunk = array_chunk($temp, 46,true);
		$total_page = count($data_chunk);
		
		$rc = new MonthlyReport();
		foreach($data_chunk as $key => $data){
			$page_no = $key+1;
			$rc->hdr($reportType,$this->get['from_month'],$this->get['to_month']);
			$rc->details();
			$rc->data_box($data);
			if($total_page > $page_no ) $rc->createSheet();
		}
        $rc->output();
    }

    protected function report_PHYSICAL_COUNT() {
        $rc = new PCREPORT();
        $rc->hdr('Supplies')->details()->data_box()->output();
    }

    protected function report_RIS($data) {
        $rc = new RequisitionAndIssueSlip($data);
        $rc->hdr();
        $rc->table();
        $rc->ftr();
        $rc->output();
    }

    protected function report_RMS($data) {
        $rc = new ReturnedMaterialSlip($data);
        $rc->hdr();
        $rc->table();
        $rc->ftr();
        $rc->output();
    }

    protected function report_OLD_REUSABLE_STOCK() {
        $rc = new OldReusableStock();
        $rc->table();
        $rc->ftr();
        $rc->output();
    }

    protected function report_STOCK_CARD() {
        $head = $this->Item()->getByStockNo($this->get['stock_no']);

        $stock_card_data = array();
        $stock_card_data['header'] = array(
            'agency' => 'SILANG WATER DISTRICT',
            'stock_no' => $head['item_stock_no'],
            'desc' => $head['item_desc'].' '.$head['item_size']
        );

        $query = sprintf("( SELECT
                issuance_dtl.issuance_dtl_item_created AS date,
                -1 AS flag,
				issuance.issuance_id AS tid,
				'' AS received_ref,
                '' AS received_cost,
                '' AS received_qty,
				'' AS received_amt,
				issuance.issuance_no AS issued_ref,
                ris_dtl.ris_dtl_item_cost AS issued_cost,
                issuance_dtl.issuance_dtl_item_issued AS issued_qty,
				ris_dtl.ris_dtl_item_cost * issuance_dtl.issuance_dtl_item_issued AS issued_amt,
                '' AS bal_qty,
                ris_dtl.ris_dtl_item_cost AS bal_cost,
                '' AS bal_amt
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
                        1 AS flag,
						ia.ia_id AS tid,
						ia.ia_no AS received_ref,
                        po_dtl.po_dtl_item_cost AS received_cost,
                        ia_dtl.ia_dtl_item_qty AS received_qty,
                        ia_dtl.ia_dtl_item_qty * po_dtl.po_dtl_item_cost AS received_amt,
						'' AS issued_ref,
                        '' AS issued_cost,
                        '' AS issued_qty,
                        '' AS issued_amt,
                        '' AS bal_qty,
                        po_dtl.po_dtl_item_cost AS bal_cost,
                        '' AS bal_amt
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
                date", $this->get['stock_no'], date('Y-m-d H:i:s', strtotime($this->get['from_date'])), date('Y-m-d H:i:s', strtotime($this->get['to_date'])), $this->get['stock_no'], date('Y-m-d H:i:s', strtotime($this->get['from_date'])), date('Y-m-d H:i:s', strtotime($this->get['to_date'])));

        $stock_card_data['detail'] = front()->database()->query($query);

        for ($i = 0; $i < count($stock_card_data['detail']); $i++) {
            $bal = front()->database()->search('item_stock_level')->filterByItemStockLevelTid($stock_card_data['detail'][$i]['tid'])->addFilter('item_stock_level_flag = %s', $stock_card_data['detail'][$i]['flag'])->getRow();
            $stock_card_data['detail'][$i]['date'] = date('M d', strtotime($stock_card_data['detail'][$i]['date']));
            $stock_card_data['detail'][$i]['bal_qty'] = $bal['item_stock_level_qty'];
            $stock_card_data['detail'][$i]['bal_amt'] = number_format($bal['item_stock_level_qty'] * $stock_card_data['detail'][$i]['bal_cost'], 2, '.', ',');
        }

        $rc = new StockCard();
        $rc->hdr($stock_card_data['header'])->details($stock_card_data['detail'])->data_box($stock_card_data['header'])->output();
    }

    /* Protected Methods
     -------------------------------*/
    /* Private Methods
     -------------------------------*/
}
