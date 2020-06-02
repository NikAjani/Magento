<?php

class Ccc_Process_Adminhtml_ProcessesController extends Mage_Adminhtml_Controller_Action {


	protected function _isAllowed()
	{
		return Mage::getSingleton('admin/session')->isAllowed('process/process');
	}


	public function indexAction()
	{
		$this->loadLayout();
		$this->_title('Process Grid');
		$this->_setActiveMenu('process');
		$this->renderLayout();
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

	public function editAction()
	{
		try {
			
			$processModel = Mage::getModel('process/process');

			if($processId = $this->getRequest()->getParam('id')) {
				
				if(!$processModel->load($processId))			
					throw new Exception('Process not exist.');
			}

			Mage::register('current_process', $processModel);

			$processEditBlock = $this->getLayout()->createBlock('Ccc_Process_Block_Adminhtml_Process_Edit');
		
			$this->loadLayout();
			$this->_setActiveMenu('process');
			$this->_addContent($processEditBlock);
			$this->renderLayout();	
		 	
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			return $this->_redirect('*/*/index');
		}
	}

	public function saveAction()
	{
		try {
			
			$processModel = Mage::getModel('process/process');

			if(!($this->getRequest()->isPost()))
				throw new Exception('Invalid request');

			if($processId = $this->getRequest()->getParam('id')) {
				
				if(!$processModel->load($processId))			
					throw new Exception('Process not exist.');
			}

			$processData = $this->getRequest()->getPost('process');

			$processModel->addData($processData);

			if(!$processModel->save())
				throw new Exception('Error in save process ');
			
			$this->_getSession()->addSuccess('Process saved');

		} catch (Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		}
		return $this->_redirect('*/*/index');

	}

	public function deleteAction() {

		Mage::getSingleton('adminhtml/session');
		
		try {

			$processModel = Mage::getModel('process/process');
			

			if(($processId = (int)$this->getRequest()->getParam('id'))) {

				if(!$processId)
					throw new Exception('Id not found');

				if(!$processModel->load($processId)) 
					throw new Exception('Process does not exist');

				if(!$processModel->delete())
					throw new Exception('Error in delete record', 1);

				$this->_getSession()->addSuccess($this->__('Process has been deleted.'));

			}  else {

				$process_ids = $this->getRequest()->getParam('process_id');

				if($process_ids == null)
					throw new Exception('Please select group');

				foreach ($process_ids as $id) {

					if(!$processModel->load($id))
						throw new Exception('Process does not exist.');

					$processModel->delete();
				}

				$this->_getSession()->addSuccess('Total '.count($process_ids).' records deleted.');

			}
			
		} catch (Exception $e) {
			Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
		}
		return $this->_redirect('*/*/');
	}

	public function uploadFileAction()
	{
		try {
			
			$processModel = Mage::getModel('process/process');

			if($processId = $this->getRequest()->getParam('id')) {
				
				if(!$processModel->load($processId)->getId())			
					throw new Exception('Process not exist.');
			}

			
			$fileUploadBlock = $this->getLayout()->createBlock('Ccc_Process_Block_Adminhtml_Process_FileUpload');
		
			$this->loadLayout();
			$this->_setActiveMenu('process');
			$this->_addContent($fileUploadBlock);
			$this->renderLayout();	
		 	
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			return $this->_redirect('*/*/index');
		}
	}

	public function fileUploadAction()
	{
		try {

			if(!($this->getRequest()->isPost())){
				throw new Exception("Invalid request");
			}

			$processModel = Mage::getModel('process/process');

			if($processId = $this->getRequest()->getParam('id')) {
				
				if(!$processModel->load($processId)->getId())			
					throw new Exception('Process not exist.');
			}

			if(!$processModel->fileUpload('process[fileName]'))
				throw new Exception('Error in file upload');
				
			Mage::getSingleton('adminhtml/session')->addSuccess('File uploaded.');

		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}

		$this->_redirect('*/*/');
	}

	public function readFileAction()
	{

		try {
			
			$processModel = Mage::getModel('process/process');

			if(!$processId = $this->getRequest()->getParam('id')) 
				throw new Exception("Invalid Request", 1);

			if(!$processModel->load($processId)->getId()) 
					throw new Exception("No Data Found");

			if (!$processModel->filename) 
				throw new Exception("No file uploaded yet.");	
			
			if(!$processModel->readFile())
				throw new Exception('Error in file read');
				
			Mage::getSingleton('adminhtml/session')->addSuccess('File read.');

		 	
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}
		return $this->_redirect('*/*/index');
	}

	public function importAction()
	{
		try {
			
			$processModel = Mage::getModel('process/process');

			if(!$processId = $this->getRequest()->getParam('id')) 
				throw new Exception("Invalid Request", 1);

			if(!$processModel->load($processId)->getId()) 
					throw new Exception("No Data Found");
			
			if(!$processModel->importData())
				throw new Exception('Error in data import');
				
			Mage::getSingleton('adminhtml/session')->addSuccess('Import sucessed.');

		 	
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}
		return $this->_redirect('*/*/index');
	}

	public function cleanDataAction()
	{
		try {
			
			$processModel = Mage::getModel('process/process');

			if(!$processId = $this->getRequest()->isPost()) 
				throw new Exception("Invalid Request", 1);

			$process_ids = $this->getRequest()->getParam('process_id');
			
			if(!$process_ids)
				throw new Exception('Please select process');

			foreach ($process_ids as $processId) {
				if(!$processModel->load($processId)->getId())
					throw new Exception('No process found');
				$processModel->cleanData();
			}

			if(!$processModel->cleanData())
				throw new Exception('Error in clean data');
				
			Mage::getSingleton('adminhtml/session')->addSuccess('Data cleaned');

		 	
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}
		return $this->_redirect('*/*/index');
	}

	public function exportCsvAction()
    {
        $fileName   = 'process.csv';
        $content    = $this->getLayout()->createBlock('process/adminhtml_process_grid')
        ->getCsvFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'process.xml';
        $content    = $this->getLayout()->createBlock('process/adminhtml_process_grid')
		->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }


}
