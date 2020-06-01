<?php  

class Ccc_Process_Block_Adminhtml_Process_Group extends Mage_Adminhtml_Block_Widget_Grid_Container {

    public function __construct()
    {
        $this->_blockGroup = 'process';
        $this->_controller = 'adminhtml_process_group';
        $this->_headerText = $this->__('Process Group Grid');

       $this->_addButton("Manage Processes", array(
            "label" => Mage::helper("process")->__("Manage Processes"),
            "onclick" => "location.href = '" . $this->getUrl('*/processes/index') . "';",
            "class" => "btn btn-danger",
        ));
         
        parent::__construct();
    }
}