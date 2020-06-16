<?php  

class Ccc_Process_Block_Adminhtml_Process extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_blockGroup = 'process';
        $this->_controller = 'adminhtml_process';
        $this->_headerText = $this->__('Process Grid');

       $this->_addButton("Manage Process Group", array(
            "label" => Mage::helper("process")->__("Manage Process Group"),
            "onclick" => "location.href = '" . $this->getUrl('*/process_group/index') . "';",
            "class" => "btn btn-danger",
        ));
         
        parent::__construct();
    }
}