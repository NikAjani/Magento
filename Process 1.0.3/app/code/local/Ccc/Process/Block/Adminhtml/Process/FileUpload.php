<?php

class Ccc_Process_Block_Adminhtml_Process_FileUpload extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct()
    {
        $this->_blockGroup = 'process';
        $this->_controller = 'adminhtml_process';
        $this->_mode = 'fileUpload'; 
        
        $this->_headerText =  $this->__('File Upload');
        parent::__construct();
    }
}