<?php

class Ccc_Process_Block_Adminhtml_Process_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
    
    protected function _construct()
    {
        $this->_blockGroup = 'process';
        $this->_controller = 'adminhtml_process';

        $this->_mode = 'edit';

        $this->_headerText =  $this->__('File Upload');
    }}