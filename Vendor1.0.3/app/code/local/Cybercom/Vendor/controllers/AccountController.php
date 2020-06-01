<?php

class Cybercom_Vendor_AccountController extends Mage_Core_Controller_Front_Action {

	protected function _isAllowed()
	{
		return Mage::getSingleton('core/session')->isAllowed('vendor/vendor');
	}

	public function indexAction()
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
			$this->_redirect('*/*/login');
		}
	}

	public function loginAction()
	{
		$this->loadLayout();
        $this->renderLayout();
	}

	public function loginPostAction()
	{
		try {

			if(!$this->getRequest()->isPost())
				throw new Exception('Invalid request', 1);

			$vendorModel = Mage::getModel('vendor/vendor');
			$loginData = $this->getRequest()->getPost('login');

			if(!$vendorModel->load($loginData['username'], 'email')) 
				throw new Exception('Please enter valid detail');

			if($vendorModel->password != md5($loginData['password']))
				throw new Exception('Please enter valid detail');

			Mage::getSingleton('core/session')->setVendor($vendorModel);

			$this->_redirect('*/*/index');
				

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			$this->_redirect('*/*/login');
		}
	}

	public function createAction()
	{
		$this->loadLayout();
        $this->renderLayout();
	}

	public function saveAction() {

		try {
		
			if(!($this->getRequest()->isPost())){
				throw new Exception("Invalid request.");
			}

			$vendorData = $this->getRequest()->getPost('vendor');
			$vendorModel = Mage::getModel('vendor/vendor');
			$confirmPassword = $this->getRequest()->getPost('confirmation');
			date_default_timezone_set('Asia/Kolkata');
			
			if($confirmPassword !== $vendorData['password']){
				throw new Exception("Password does not match with confirm password");
			}

			$vendorModel->load($vendorData['email'], 'email');

			if($vendorModel->getData())
			{
				throw new Exception('Email already exists.',);
			}

			$vendorData['password'] = md5($vendorData['password']);

			$vendorModel->addData($vendorData);
			$vendorModel['status'] = '1';
			$vendorModel['createdDate'] = date("Y-m-d H:i:s", time());

			if(!$vendorModel->save())
				throw new Exception('Error in save vendor');

			Mage::getSingleton('core/session')->addSuccess(Mage::helper('core')->__('Vendor saved'));	

			$this->_redirect('*/*/login');	

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			$this->_redirect('*/*/create');	
		}
		
	}

	public function logoutAction()
	{
		Mage::getSingleton('core/session')->unsVendor();
		$this->_redirect('*/*/login');
	}

	public function editAction()
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
			$this->_redirect('*/*/login');
		}
	}

	public function productAction()
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
			$this->_redirect('*/*/login');
		}
	}

	public function editPostAction()
	{
		try {
		
			if(!($this->getRequest()->isPost())){
				throw new Exception("Invalid request.");
			}

			$vendorData = $this->getRequest()->getPost('vendor');
			$vendorModel = Mage::getSingleton('core/session')->getVendor();

			if($vendorModel->password != md5($vendorData['currentPassword']))
				throw new Exception('Please Enter Valid Password');

			$changePassword = $this->getRequest()->getPost('change_password');

			if($changePassword){
				$password = $this->getRequest()->getPost('password');

				$vendorModel['password'] = md5($password);
				$msg = "Password Changed.";
			} else
				$msg = "Vendor Saved.";

			$newVendorModel = Mage::getModel('vendor/vendor');

			if($vendorModel->email != $vendorData['email']) {
				$newVendorModel->load($vendorData['email'], 'email');

				if($newVendorModel->getData())
					throw new Exception('Email already exists');
			}

			$vendorModel->addData($vendorData);

			if(!$vendorModel->save())
				throw new Exception('Error in save vendor');

			Mage::getSingleton('core/session')->addSuccess(Mage::helper('core')->__($msg));

			$this->_redirect('*/*/index');		

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());	
			$this->_redirect('*/*/edit');
		}
		
	}
	

}