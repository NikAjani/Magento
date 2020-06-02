<?php

class Ccc_Process_Block_Adminhtml_Process_FileUpload_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {

      $form = new Varien_Data_Form(
      array(
        'id' => 'edit_form',
        'action' => $this->getUrl('*/*/fileUpload',array('id' => $this->getRequest()->getParam('id'))),
        'method' => 'post',
        'enctype' => 'multipart/form-data'
      )
      );

      $fieldset = $form->addFieldset('process_upload_form',
       array('legend'=>Mage::helper('process')->__('Upload CSV File')));

       $fieldset->addField('fielName', 'file', array(
          'label'     => Mage::helper('process')->__('File'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'process[fileName]',
        ));

      $form->setUseContainer(true);
      $this->setForm($form);

      return parent::_prepareForm();
  }
}