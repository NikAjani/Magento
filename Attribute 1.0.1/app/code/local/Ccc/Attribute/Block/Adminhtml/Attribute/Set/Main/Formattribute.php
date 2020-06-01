<?php

class Ccc_Attribute_Block_Adminhtml_Attribute_Set_Main_Formattribute extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('set_fieldset', array('legend'=>Mage::helper('catalog')->__('Add New Attribute')));

        $fieldset->addField('new_attribute', 'text',
            array(
                'label' => Mage::helper('catalog')->__('Name'),
                'name' => 'new_attribute',
                'required' => true,
            )
        );

        $fieldset->addField('submit', 'note',
            array(
            'text' => $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setData(array(
                    'label'     => Mage::helper('catalog')
                    ->__('Add Attribute'),'onclick'   => 'this.form.submit();',))
                    ->toHtml(),
                ));

        $form->setUseContainer(true);
        $form->setMethod('post');
        $this->setForm($form);
    }
}
