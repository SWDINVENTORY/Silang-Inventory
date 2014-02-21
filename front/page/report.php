<?php //-->
front()->output(realpath(__DIR__.'/../../module/report/'));
$files = front('folder', realpath(__DIR__.'/../../module/report/'))->getFiles('/^((?!\_sheet).)*$/');
//front()->output($files);
foreach($files as $files){
	echo $files.'<br/>';
	include($files);
}
front()->output(get_included_files());
exit;
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
		$reportType = "OFFICE SUPPLIES";
		/*$rc = new PCREPORT();
		$rc->hdr($reportType)
			->details()
			->data_box()
			->output();*/
		$rc = new IssueOutReport();
		$rc->hdr()->details()->data_box()->output();
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}