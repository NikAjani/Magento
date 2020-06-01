<?php

class Ccc_Attribute_Adminhtml_SetController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
        $this->_title($this->__('Catalog'))
             ->_title($this->__('Attributes'))
             ->_title($this->__('Manage Attribute Sets'));

        $this->_setTypeId();

        $this->loadLayout();
        $this->_setActiveMenu('attribute');
        

        $this->_addBreadcrumb(Mage::helper('catalog')->__('Catalog'), Mage::helper('catalog')->__('Catalog'));
        $this->_addBreadcrumb(
            Mage::helper('catalog')->__('Manage Attribute Sets'),
            Mage::helper('catalog')->__('Manage Attribute Sets'));

        $this->_addContent($this->getLayout()->createBlock('attribute/adminhtml_attribute_set_toolbar_main'));
      
        $this->_addContent($this->getLayout()->createBlock('attribute/adminhtml_attribute_set_grid'));

        $this->renderLayout();
    }

     public function editAction()
    {
        $this->_title($this->__('Catalog'))
             ->_title($this->__('Attributes'))
             ->_title($this->__('Manage Attribute Sets'));

        $this->_setTypeId();
        $attributeSet = Mage::getModel('eav/entity_attribute_set')
            ->load($this->getRequest()->getParam('id'));

        if (!$attributeSet->getId()) {
            $this->_redirect('*/*/index');
            return;
        }

        $this->_title($attributeSet->getId() ? $attributeSet->getAttributeSetName() : $this->__('New Set'));

        Mage::register('current_attribute_set', $attributeSet);

        $this->loadLayout();
        $this->_setActiveMenu('attribute');
       
        $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

        $this->_addBreadcrumb(Mage::helper('catalog')->__('Catalog'), Mage::helper('catalog')->__('Catalog'));
        $this->_addBreadcrumb(
            Mage::helper('catalog')->__('Manage Category Sets'),
            Mage::helper('catalog')->__('Manage Category Sets'));

        $this->_addContent($this->getLayout()->createBlock('attribute/adminhtml_attribute_set_main'));

        $this->renderLayout();
    }



    protected function _setTypeId()
    {
        Mage::register('entityType',
            Mage::getModel('catalog/category')->getResource()->getTypeId());
    }

    public function addAction()
    {
        $this->_title($this->__('Catalog'))
             ->_title($this->__('Attributes'))
             ->_title($this->__('Manage Attribute Sets'))
             ->_title($this->__('New Set'));

        $this->_setTypeId();

        $this->loadLayout();
        $this->_setActiveMenu('attribute');

        $this->_addContent($this->getLayout()->createBlock('attribute/adminhtml_attribute_set_toolbar_add'));

        $this->renderLayout();
    }


    public function saveAction()
    {
        $entityTypeId   = $this->_getEntityTypeId();
        $hasError       = false;
        $attributeSetId = $this->getRequest()->getParam('id', false);
        $isNewSet       = $this->getRequest()->getParam('gotoEdit', false) == '1';

        $model  = Mage::getModel('eav/entity_attribute_set')
            ->setEntityTypeId($entityTypeId);

        $helper = Mage::helper('adminhtml');

        try {
            if ($isNewSet) {
                $name = $helper->stripTags($this->getRequest()->getParam('attribute_set_name'));
                $model->setAttributeSetName(trim($name));
            } else {
                if ($attributeSetId) {
                    $model->load($attributeSetId);
                }
                if (!$model->getId()) {
                    Mage::throwException(Mage::helper('catalog')->__('This attribute set no longer exists.'));
                }
                $data = Mage::helper('core')->jsonDecode($this->getRequest()->getPost('data'));

                $data['attribute_set_name'] = $helper->stripTags($data['attribute_set_name']);

                $model->organizeData($data);
            }

            $model->validate();
            if ($isNewSet) {
                $model->save();
                $model->initFromSkeleton($this->getRequest()->getParam('skeleton_set'));
            }
            $model->save();
            $this->_getSession()->addSuccess(Mage::helper('catalog')->__('The attribute set has been saved.'));
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
            $hasError = true;
        } catch (Exception $e) {
            $this->_getSession()->addException($e,
                Mage::helper('catalog')->__('An error occurred while saving the attribute set.'));
            $hasError = true;
        }

        if ($isNewSet) {
            if ($hasError) {
                $this->_redirect('*/*/add');
            } else {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
            }
        } else {
            $response = array();
            if ($hasError) {
                $this->_initLayoutMessages('adminhtml/session');
                $response['error']   = 1;
                $response['message'] = $this->getLayout()->getMessagesBlock()->getGroupedHtml();
            } else {
                $response['error']   = 0;
                $response['url']     = $this->getUrl('*/*/');
            }
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));
        }
    }

    protected function _getEntityTypeId()
    {
        if (is_null(Mage::registry('entityType'))) {
            $this->_setTypeId();
        }
        return Mage::registry('entityType');
    }

}