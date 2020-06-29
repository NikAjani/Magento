<?php

class Ccc_Credit_TransferController extends Mage_Core_Controller_Front_Action
{

    public function preDispatch()
    {
        parent::preDispatch();

        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);

            Mage::getSingleton('core/session')
                ->addSuccess(Mage::helper('credit')->__('Please sign in or create a new account'));
        }
    }

    public function requestAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function requestPostAction()
    {
        try{

            $requestData = array_filter($this->getRequest()->getParam('credit'));

            if((!$requestData['email']) || (!$requestData['amount']))
                throw new Exception('Please enter valid detail');

            $customer = Mage::getModel('customer/customer');
            $websiteId = Mage::app()->getWebsite()->getId();

            $customer->setWebsiteId($websiteId);

            if(!($customer->loadByEmail($requestData['email'])->getId()))
                throw new Exception('Customer not exists');

            $customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();

            if($customerId == $customer->getId())
                throw new Exception('Please enter valid email id');
                

            $transferModel = Mage::getModel('credit/credit_transfer');

            $transferData = [
                'from_customer_id' => $customer->getId(),
                'to_customer_id' => $customerId,
                'transaction_amount' => $requestData['amount'],
                'transfer_status' => 1,
                'detail' => 'Transfer amount request',
                'requested_date' => Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s')
            ];

            $transferModel->addData($transferData)->save();

            Mage::getSingleton('core/session')->addSuccess("Your request hase been submited");

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage()); 
        }
        
        $this->_redirect('*/transfer/request');
    }

    public function sendAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function upiSendAction()
    {
        try{

            $upiData = array_filter($this->getRequest()->getParam('credit'));

            if((!$upiData['email']) || (!$upiData['amount']))
                throw new Exception('Please enter valid detail');

            $customer = Mage::getModel('customer/customer');
            $websiteId = Mage::app()->getWebsite()->getId();

            $customer->setWebsiteId($websiteId);

            if(!($customer->loadByEmail($upiData['email'])->getId()))
                throw new Exception('Customer not exists');

            $customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();

            if($customerId == $customer->getId())
                throw new Exception('Please enter valid email id');

            $customer2 = Mage::getModel('customer/customer');
            $websiteId = Mage::app()->getWebsite()->getId();

            $customer2->setWebsiteId($websiteId);

            if(!($customer2->load($customerId)->getId()))
                throw new Exception('Customer not exists');

            $customerBalance = Mage::getModel('credit/credit')->getCurrentCreditBalance($customer2);

            if($customerBalance < $upiData['amount'])
                throw new Exception('Not enough balance for transfer');

            $customer2->setCreditBalance($customer2->getCreditBalance() - ($upiData['amount']));

            $customer2->save();

            $customer->setCreditBalance($customer->getCreditBalance() + ($upiData['amount']));

            $customer->save();

            Mage::getSingleton('core/session')->addSuccess("Your transfer sucesssed.");

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage()); 
        }
        
        $this->_redirect('*/transfer/send');
    }

    public function approveAction()
    {
        try{

            if(!($transferId = $this->getRequest()->getParam('id')))
                throw new Exception('Transfer id not found');
                
            $transferModel = Mage::getModel('credit/credit_transfer');

            if(!($transferModel->load($transferId)->getId())) 
                throw new Exception('No data found for transfer');
                
            $customer = Mage::getModel('customer/customer');
            $websiteId = Mage::app()->getWebsite()->getId();

            if(!($customer->load($transferModel->getToCustomerId())))
                throw new Exception('customer not exists');
            
            $customerBalance = Mage::getModel('credit/credit')->getCurrentCreditBalance($customer);

            if($customerBalance < $transferModel->getTransactionAmount())
                throw new Exception('Not enough balance for transfer');

            $customer->setCreditBalance($customer->getCreditBalance() + ($transferModel->getTransactionAmount()));

            $customer->save();

            if(!($customer->load($transferModel->getFromCustomerId())))
                throw new Exception('From customer not exists');

            $customer->setCreditBalance($customer->getCreditBalance() - ($transferModel->getTransactionAmount()));

            $customer->save();

            $transferModel->setTransferStatus(2);
            $transferModel->setResponseDate(Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'));
            $transferModel->setDetail('Transfered request Approved');

            $transferModel->save();

            Mage::getSingleton('core/session')->addSuccess("Your transfer sucesssed");

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage()); 
        }
        
        $this->_redirect('*/transfer/send');
    }

    public function rejectAction()
    {
        try{

            if(!($transferId = $this->getRequest()->getParam('id')))
                throw new Exception('Transfer id not found');
                
            $transferModel = Mage::getModel('credit/credit_transfer');

            if(!($transferModel->load($transferId)->getId())) 
                throw new Exception('No data found for transfer');
                
            $transferModel->setTransferStatus(3);
            $transferModel->setResponseDate(Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'));
            $transferModel->setDetail('Transfered request rejected');

            $transferModel->save();

            Mage::getSingleton('core/session')->addSuccess("Your transfer sucesssed");

        } catch (Exception $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage()); 
        }
        
        $this->_redirect('*/transfer/send');
    }
}
