<?php

class Ccc_Process_Block_Adminhtml_Process_Group_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
    
    public function __construct()
    {
        $this->_blockGroup = 'process';
        $this->_controller = 'adminhtml_process_group';
        parent::__construct();
    }

    public function getHeaderText()
    {
        if( Mage::registry('current_process_group') && Mage::registry('current_process_group')->getId()) {
            return Mage::helper('process')->__("Edit", $this->htmlEscape(Mage::registry('current_process_group')->getTitle()));
        } else {
            return Mage::helper('process')->__('Add');
        }
    }
}