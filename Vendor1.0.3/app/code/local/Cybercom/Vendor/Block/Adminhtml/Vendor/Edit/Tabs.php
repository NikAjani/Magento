<?php

class Cybercom_Vendor_Block_Adminhtml_Vendor_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('vendor_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('vendor')->__('Account Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('vendor')->__('Account Information'),
          'title'     => Mage::helper('vendor')->__('Account Information'),
          'content'   => $this->getLayout()->createBlock('vendor/adminhtml_vendor_edit_tab_account')->toHtml(),
      ));
      
      return parent::_beforeToHtml();
  }
}