<?php

class Ccc_Process_Block_Adminhtml_Process_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

	protected function _prepareForm()
  {

      $form = new Varien_Data_Form(
        array(
          'id' => 'edit_form',
          'action' => $this->getUrl('*/*/save',array('id' => $this->getRequest()->getParam('id'))),
          'method' => 'post',
        )
        );

        $fieldset = $form->addFieldset('group_form',
         array('legend'=>Mage::helper('process')->__('Process Group')));

         $fieldset->addField('name', 'text', array(
            'label'     => Mage::helper('process')->__('Name'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'process[name]',
          ));

         $fieldset->addField('model', 'text', array(
            'label'     => Mage::helper('process')->__('Model'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'process[model]',
          ));

         $fieldset->addField('processType', 'select', array(
            'label' => Mage::helper('process')->__('Process Type'),
            'class' => 'required-entry',
            'name'  => 'process[processType]',
            'values'   => $this->_getProcessTypeOptions(),
            'required'  => true
          ));

         $fieldset->addField('processGroupId', 'select', array(
            'label' => Mage::helper('process')->__('Process Group'),
            'class' => 'required-entry',
            'name'  => 'process[processGroupId]',
            'values'   => $this->_getGroupArray(),
            'required'  => true
          ));
      
        $form->setUseContainer(true);
        $this->setForm($form);

        if(Mage::registry('current_process')) {
           $form->setValues(Mage::registry('current_process')->getData());
        }
        return parent::_prepareForm();
  }

  protected function _getProcessTypeOptions()
   {
       return Mage::getModel('process/process')->getProcessTypeOptions();
   }

   protected function _getGroupArray()
   {
       return Mage::getModel('process/process')->getGroupArray();
   }
}