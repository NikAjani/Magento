<?php

class Cybercom_Vendor_Adminhtml_VendorController extends Mage_Adminhtml_Controller_Action {

	protected function _isAllowed()
	{
		return Mage::getSingleton('admin/session')->isAllowed('vendor/vendor');
	}

	public function indexAction()
	{
		$this->loadLayout();
    	$this->_setActiveMenu('vendor');
		$this->_title($this->__("Vendor Grid"));
		$this->renderLayout();
	}

	public function newAction() {

		$vendorEditBlock = $this->getLayout()->createBlock('Cybercom_Vendor_Block_Adminhtml_Vendor_Edit');
		
		$this->loadLayout();
		$this->_setActiveMenu('vendor/manage');
		$this->_addContent($vendorEditBlock)
		->_addLeft($this->getLayout()->createBlock('vendor/adminhtml_vendor_edit_tabs'));
		$this->renderLayout();
	}

	public function editAction()
	{
		try {

			if(!$vendorId = $this->getRequest()->getParam('id')) {
				throw new Exception("vendor does not exist");
			}

			$vendorModel = Mage::getModel('vendor/vendor');
			
			if(!$vendorModel->load($vendorId))			
				throw new Exception('vendor not exist.');

			Mage::register('vendor_data', $vendorModel);

			$vendorEditBlock = $this->getLayout()->createBlock('Cybercom_Vendor_Block_Adminhtml_Vendor_Edit');
		
			$this->loadLayout();
			$this->_setActiveMenu('vendor/manage');
			$this->_addContent($vendorEditBlock)
			->_addLeft($this->getLayout()->createBlock('vendor/adminhtml_vendor_edit_tabs'));
			$this->renderLayout();	
		 	
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			return $this->_redirect('/vendor/index');
		}
	}

	public function saveAction() {

		try {
		
			if(!($this->getRequest()->isPost())){
				throw new Exception("Invalid request.");
			}

			$vendorData = $this->getRequest()->getPost('vendor');
			$vendorModel = Mage::getModel('vendor/vendor');

			if($vendorId = $this->getRequest()->getParam('id')) {
				if(!$vendorModel->load($vendorId))			
					throw new Exception('vendor not exist.');
			}else{
				$vendorModel['createdDate'] = date("Y-m-d H:i:s");;
			}

			$newVendorModel = Mage::getModel('vendor/vendor');

			if($newVendorModel->load($vendorData['email'], 'email')->getData()) {

				if($vendorModel->id != $newVendorModel->id)
					throw new Exception('Email already exist.');
			}

			$vendorData['password'] = md5($vendorData['password']);
			$vendorModel->addData($vendorData);

			if(!$vendorModel->save())
				throw new Exception('Error in save vendor');

			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Vendor saved'));		

		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());	
		}
		$this->_redirect('*/*/');
	}

	public function deleteAction() {

		Mage::getSingleton('adminhtml/session');
		
		try {

			$vendorModel = Mage::getModel('vendor/vendor');
			

			if(($vendorId = (int)$this->getRequest()->getParam('id'))) {

				if(!$vendorId)
					throw new Exception('Id not found');

				if(!$vendorModel->load($vendorId)) 
					throw new Exception('vendor does not exist');

				if($vendorModel->status == 1){
					$vendorName = $vendorModel->getName();
					$this->deleteAttributeValues('vendor',$vendorName);	
				}

				if(!$vendorModel->delete())
					throw new Exception('Error in delete record', 1);

					
				$this->_getSession()->addSuccess($this->__('The vendor has been deleted.'));

			}  else {

				$vendor_ids = $this->getRequest()->getParam('vendor_id');

				if($vendor_ids == null)
					throw new Exception('Please select vendor');

				foreach ($vendor_ids as $id) {

					if(!$vendorModel->load($id))
						throw new Exception('vendor does not exist.');

					$vendorModel->delete();
				}

				$this->_getSession()->addSuccess('Total '.count($vendor_ids).' records deleted.');

			}
			
		} catch (Exception $e) {
			Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
		}
		return $this->_redirect('/vendor/index');
	}

	

}