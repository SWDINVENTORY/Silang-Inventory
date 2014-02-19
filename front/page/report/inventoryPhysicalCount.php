<?php //-->
include(realpath(__DIR__.'/../../../module/report/physical_count_report_sheet.php'));
class Front_Page_inventoryPhysicalCount extends Front_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'SWD-Inventory : Physical Inventory Count';
	protected $_class = 'phy-inv-count';
	protected $_template = '';
	protected $_errors = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		$reportType = "OFFICE SUPPLIES";
		$rc = new PCREPORT();
		$rc->hdr($reportType)
			->details()
			->data_box()
			->output();
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}