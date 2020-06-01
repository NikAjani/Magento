<?php

class Cybercom_Vendor_Block_Adminhtml_Vendor_Edit_Tab_Account extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

      $form = new Varien_Data_Form();
      $this->setForm($form);
      
      $fieldset = $form->addFieldset('vendor_form',
         array('legend'=>Mage::helper('vendor')->__('Account information')));

       $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('vendor')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'vendor[name]',
        ));
      
      $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('vendor')->__('Email'),
          'class'     => 'validate-email',
          'required'  => true,
          'name'      => 'vendor[email]',
      ));

      $fieldset->addField('password', 'password', array(
          'label'     => Mage::helper('vendor')->__('Password'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'vendor[password]',
      ));

      $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('vendor')->__('Status'),
            'class' => 'required-entry',
            'name'  => 'vendor[status]',
            'values'   => $this->_getStatusOptions(),
            'value' => 'status',
            'required'  => true
        ));

    if(Mage::getSingleton('adminhtml/session')->getvendorData()) {
          $form = $form->setValues(Mage::getSingleton('adminhtml/session')->getvendorData());
          Mage::getSingleton('adminhtml/session')->setvendorData(null);
      } else if(Mage::registry('vendor_data')) {
         $form->setValues(Mage::registry('vendor_data')->getData());
      }

      return parent::_prepareForm();
  }

    protected function _getStatusOptions()
    {
        return Mage::getModel('vendor/vendor')->getStatusOptions();
    }
}