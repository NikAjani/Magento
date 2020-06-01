<?php


class Ccc_Attribute_Block_Adminhtml_Attribute_Set_Toolbar_Main extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('attribute/set/toolbar/main.phtml');
    }

    protected function _prepareLayout()
    {
        $this->setChild('addButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('catalog')->__('Add New Set'),
                    'onclick'   => 'setLocation(\'' . $this->getUrl('*/*/add') . '\')',
                    'class' => 'add',
                ))
        );
        return parent::_prepareLayout();
    }

    protected function getNewButtonHtml()
    {
        return $this->getChildHtml('addButton');
    }

    protected function _getHeader()
    {
        return Mage::helper('catalog')->__('Manage Attribute Sets');
    }

    protected function _toHtml()
    {
        Mage::dispatchEvent('adminhtml_catalog_product_attribute_set_toolbar_main_html_before', array('block' => $this));
        return parent::_toHtml();
    }
}
