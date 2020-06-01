<?php

class Ccc_Attribute_Block_Adminhtml_Attribute_Edit_Tab_System extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $model = Mage::registry('entity_attribute');

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('base_fieldset', array('legend'=>Mage::helper('catalog')->__('System Properties')));

        if ($model->getAttributeId()) {
            $fieldset->addField('attribute_id', 'hidden', array(
                'name' => 'attribute_id',
            ));
        }

        $yesno = array(
            array(
                'value' => 0,
                'label' => Mage::helper('catalog')->__('No')
            ),
            array(
                'value' => 1,
                'label' => Mage::helper('catalog')->__('Yes')
            ));

    

        $fieldset->addField('backend_type', 'select', array(
            'name' => 'backend_type',
            'label' => Mage::helper('catalog')->__('Data Type for Saving in Database'),
            'title' => Mage::helper('catalog')->__('Data Type for Saving in Database'),
            'options' => array(
                'text'      => Mage::helper('catalog')->__('Text'),
                'varchar'   => Mage::helper('catalog')->__('Varchar'),
                'static'    => Mage::helper('catalog')->__('Static'),
                'datetime'  => Mage::helper('catalog')->__('Datetime'),
                'decimal'   => Mage::helper('catalog')->__('Decimal'),
                'int'       => Mage::helper('catalog')->__('Integer'),
            ),
        ));

        $fieldset->addField('is_global', 'select', array(
            'name'  => 'is_global',
            'label' => Mage::helper('catalog')->__('Globally Editable'),
            'title' => Mage::helper('catalog')->__('Globally Editable'),
            'values'=> $yesno,
        ));

        $form->setValues($model->getData());

        if ($model->getAttributeId()) {
            $form->getElement('backend_type')->setDisabled(1);
            if ($model->getIsGlobal()) {
                #$form->getElement('is_global')->setDisabled(1);
            }
        } else {
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }

}
