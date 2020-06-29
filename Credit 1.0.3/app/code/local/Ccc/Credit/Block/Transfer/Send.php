<?php

class Ccc_Credit_Block_Transfer_Send extends Mage_Core_Block_Template
{

    public function getRequestedData()
    {
        $customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();

        return $collection = Mage::getModel('credit/credit_transfer')
            ->getCollection()
            ->addFieldToFilter('from_customer_id', $customerId)
            ->addFieldToFilter('transfer_status', 1);
    }

    public function getStatus($statusValue)
    {
        $_statusOptions = Mage::getModel('credit/credit_transfer')->getStatusOptions();

        if(!array_key_exists($statusValue, $_statusOptions))
            return null;

        return $_statusOptions[$statusValue];

    }

    public function getCustomerEmail($customerId)
    {
        $customer = Mage::getModel('customer/customer');
        $websiteId = Mage::app()->getWebsite()->getId();

        $customer->setWebsiteId($websiteId);

        if(!($customer->load($customerId)->getId()))
            return null;

        return $customer->getEmail();
    }
}
