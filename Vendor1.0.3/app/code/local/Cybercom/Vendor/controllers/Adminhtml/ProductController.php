<?php

class Cybercom_Vendor_Adminhtml_ProductController extends Mage_Adminhtml_Controller_Action {

	public function massVendorStatusAction()
	{

		$productIds = (array)$this->getRequest()->getParam('product');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
         $status     = (int)$this->getRequest()->getParam('vendor_status');
         date_default_timezone_set('Asia/Kolkata');
        try {
            Mage::getSingleton('catalog/product_action')
                ->updateAttributes($productIds, array('vendor_status' => $status), $storeId)
                ->updateAttributes($productIds, array('admin_response_date' => date("m-d-Y H:i:s",time ())), $storeId);

            $this->_getSession()->addSuccess(
                $this->__('Total of %d record(s) have been updated.', count($productIds))
            );
        }
        catch (Mage_Core_Model_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()
                ->addException($e, $this->__('An error occurred while updating the product(s) status.'));
        }

        $this->_redirect('*/catalog_product/', array('store'=> $storeId));
	}

      public function changeVendorStatusAction()
        {
            try{
        
            $productId = (array)$this->getRequest()->getParam('id');
            $storeId    = (int)$this->getRequest()->getParam('store', 0);
            $vendorStatus     = (int)$this->getRequest()->getParam('vendorStatus');
            date_default_timezone_set('Asia/Kolkata');

                Mage::getSingleton('catalog/product_action')
                    ->updateAttributes($productId, array('vendor_status' => $vendorStatus), $storeId)
                    ->updateAttributes($productId, array('admin_response_date' => date("m-d-Y H:i:s",time ())), $storeId);

                $this->_getSession()->addSuccess(
                    $this->__('Vendor status updated.')
                );
            }
            catch (Mage_Core_Model_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            } catch (Exception $e) {
                $this->_getSession()
                    ->addException($e, $this->__('An error occurred while updating the product(s) status.'));
            }

            $this->_redirect('*/catalog_product/', array('store'=> $storeId));

        }
}