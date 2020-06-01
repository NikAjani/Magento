<?php

class Cybercom_Vendor_ProductController extends Mage_Core_Controller_Front_Action {

	protected function _isAllowed()
	{
		return Mage::getSingleton('core/session')->isAllowed('vendor/vendor');
	}

	public function gridAction()
	{
		
		try{
			$vendor = Mage::getSingleton('core/session')->getVendor();
			if(!$vendor){
				throw new Exception("Login first");
			}
			
			$this->loadLayout();
			$this->renderLayout();	

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());	
			$this->_redirect('*/account/login');
		}	
	}

	public function newAction()
	{
		
		try{
			$vendor = Mage::getSingleton('core/session')->getVendor();
			if(!$vendor){
				throw new Exception("Login first");
			}
			
			$this->loadLayout();
			$this->renderLayout();	

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());	
			$this->_redirect('*/*/grid');
		}	
	}

	public function editAction()
	{
		try{
			$vendor = Mage::getSingleton('core/session')->getVendor();
			if(!$vendor){
				throw new Exception("Login first");
			}
			$product = Mage::getModel('catalog/product');

			if(!($productId = $this->getRequest()->getParam('id'))) {
				throw new Exception('Id not found');
			}

			if(!$product->load($productId))
				throw new Exception('No record found');
				
			if($product->vendor != $vendor['id'])
				throw new Exception('No record found');

			Mage::register('product_data', $product);

			$this->loadLayout();
			$this->renderLayout();	

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());	
			$this->_redirect('*/*/grid');
		}
	}

	public function deleteAction()
	{
		try{

			$vendor = Mage::getSingleton('core/session')->getVendor();

			if(!$vendor){
				throw new Exception("Login first");
			}


			if(!($this->getRequest()->isPost())) {
				throw new Exception('Invalid request.');
			}

			$productIds = $this->getRequest()->getParam('productIds');
			date_default_timezone_set('Asia/Kolkata');

            Mage::getSingleton('catalog/product_action')->updateAttributes($productIds, array(
            	'vendor_status' => $vendor->getVendorStatusId('Deleted'),
        		'vendor_request_date'=>date("m-d-Y H:i:s",time ()
        		)), 0);

            Mage::getSingleton('core/session')->addSuccess(
                $this->__('Total of %d record(s) have been updated.', count($productIds))
            );

            $this->_redirect('*/*/grid');

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());	
			$this->_redirect('*/*/grid');
		}
	}

	public function saveAction()
	{
		try {

			date_default_timezone_set('Asia/Kolkata');

			$vendor = Mage::getSingleton('core/session')->getVendor();

			if(!$vendor){
				throw new Exception("Login first");
			}

			if(!$this->getRequest()->getPost())
				throw new Exception('Invalid request');
				

			$product = Mage::getModel('catalog/product');
			$productData = $this->getRequest()->getParam('product');

			if($productId = $this->getRequest()->getParam('id')){
				
				if(!$product->load($productId))
					throw new Exception('Product not exists.');

				Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
				$product->setVendorStatus($vendor->getVendorStatusId('Edited'));

			}else{
				$product->setVendorStatus($vendor->getVendorStatusId('New Added'));
				$product->setAttributeSetId(4); 
				$product->setStatus(1);
				$product->setFeatured(1); 
				$product->setVisibility(4);
				$product->setTaxClassId(0); 
				$product->setTypeId('simple');
				$product->setWebsiteIds(array(1)); 
				$product->setStoreId(0);
				$product->setVendor($vendor['id']);
				$product->setStockData(
	                    array(
	                        'use_config_manage_stock' => 0,
	                        'manage_stock' => 1,
	                        'is_in_stock' => 1,
	                        'qty' => $productData['stock_data']['qty'],
	                    )
	            );
			}

			$product->addData($productData);
			$product->setVendorRequestDate(date("m-d-Y H:i:s",time ()));

			$product->save();
		
			Mage::getSingleton('core/session')->addSuccess("Product Send for approval wait for response.");	

			$this->_redirect('*/*/grid');	

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());	
			$this->_redirect('*/*/grid');	
		}
	}

}