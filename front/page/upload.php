<?php //-->

class Front_Page_Upload extends Front_Page {
    /* Constants
     -------------------------------*/
    /* Public Properties
     -------------------------------*/
    /* Protected Properties
     -------------------------------*/
    protected $_title = 'SWD-Inventory : Item Image Upload';
    protected $_class = 'upload';
    protected $_template = '/uploads.phtml';
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
        return $this->_page();
    }
    /* Protected Methods
     -------------------------------*/
    /* Private Methods
     -------------------------------*/
}
