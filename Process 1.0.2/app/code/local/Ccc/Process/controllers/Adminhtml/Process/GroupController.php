<?php

class Ccc_Process_Adminhtml_Process_GroupController extends Mage_Adminhtml_Controller_Action {

	protected function _isAllowed()
	{
		return Mage::getSingleton('admin/session')->isAllowed('group/group');
	}

	public function indexAction()
	{
		$this->loadLayout();
		$this->_title('Process Group Grid');
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
			
			$groupModel = Mage::getModel('process/process_group');

			if($groupId = $this->getRequest()->getParam('id')) {
				
				if(!$groupModel->load($groupId))			
					throw new Exception('Process group not exist.');
			}

			Mage::register('current_process_group', $groupModel);

			$groupEditBlock = $this->getLayout()->createBlock('Ccc_Process_Block_Adminhtml_Process_Group_Edit');
		
			$this->loadLayout();
			$this->_setActiveMenu('process');
			$this->_addContent($groupEditBlock);
			$this->renderLayout();	
		 	
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			return $this->_redirect('*/*/index');
		}
	}

	public function saveAction()
	{
		try {
			
			$groupModel = Mage::getModel('process/process_group');

			if(!($this->getRequest()->isPost()))
				throw new Exception('Invalid request');

			if($groupId = $this->getRequest()->getParam('id')) {
				
				if(!$groupModel->load($groupId))			
					throw new Exception('Process group not exist.');
			}

			$groupData = $this->getRequest()->getPost('group');

			$groupModel->addData($groupData);

			if(!$groupModel->save())
				throw new Exception('Error in save process group');
			
			$this->_getSession()->addSuccess('Process group saved');

		} catch (Exception $e) {
			$this->_getSession()->addError($e->getMessage());
		}
		return $this->_redirect('*/*/index');
	}

	public function deleteAction() {

		Mage::getSingleton('adminhtml/session');
		
		try {

			$groupModel = Mage::getModel('process/process_group');
			

			if(($groupId = (int)$this->getRequest()->getParam('id'))) {

				if(!$groupId)
					throw new Exception('Id not found');

				if(!$groupModel->load($groupId)) 
					throw new Exception('Process group does not exist');

				if(!$groupModel->delete())
					throw new Exception('Error in delete record', 1);

					
				$this->_getSession()->addSuccess($this->__('Process group has been deleted.'));

			}  else {

				$group_ids = $this->getRequest()->getParam('group_id');

				if($group_ids == null)
					throw new Exception('Please select group');

				foreach ($group_ids as $id) {

					if(!$groupModel->load($id))
						throw new Exception('Group does not exist.');

					$groupModel->delete();
				}

				$this->_getSession()->addSuccess('Total '.count($group_ids).' records deleted.');

			}
			
		} catch (Exception $e) {
			Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
		}
		return $this->_redirect('*/*/');
	}

	public function exportCsvAction()
    {
        $fileName   = 'process_group.csv';
        $content    = $this->getLayout()->createBlock('process/adminhtml_process_group_grid')
        ->getCsvFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'process_group.xml';
        $content    = $this->getLayout()->createBlock('process/adminhtml_process_group_grid')
		->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

}
