<?php

class Ccc_Attribute_Block_Adminhtml_Attribute extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
    	$this->_blockGroup = 'attribute';
        $this->_controller = 'adminhtml_attribute';
        $this->_headerText = Mage::helper('attribute')->__('Manage Attributes');
        $this->_addButtonLabel = Mage::helper('attribute')->__('Add New Attribute');
        parent::__construct();
    }

}
