<?php

class Ccc_Process_Block_Adminhtml_Process_Group_Edit_Form extends Mage_Adminhtml_Block_Widget_Form {

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
              'name'      => 'group[name]',
            ));
        
          $form->setUseContainer(true);
          $this->setForm($form);

          if(Mage::registry('current_process_group')) {
             $form->setValues(Mage::registry('current_process_group')->getData());
          }
          return parent::_prepareForm();
    }

}