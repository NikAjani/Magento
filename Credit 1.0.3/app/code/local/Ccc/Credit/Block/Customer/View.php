<?php

class Ccc_Credit_Block_Customer_View extends Mage_Core_Block_Template
{

    public function getTransaction()
    {
        $customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();

        return $collection = Mage::getModel('credit/credit_transaction')
            ->getCollection()
            ->addFieldToFilter('customer_id', $customerId)
            ->setOrder('transaction_id', 'desc');
    }

    public function getExchnageRatio()
    {

        $config_exchange_ratio = Mage::getStoreConfig('credit/credit_group/credit_exchange', Mage::app()->getStore());

        $customer = Mage::getSingleton('customer/session')->getCustomer();

        return ($config_exchange_ratio > $customer->getCreditExchangeRatio()) ? $config_exchange_ratio : $customer->getCreditExchangeRatio();
    }

    public function getCreditBalance()
    {
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        return $customer->getCreditBalance() + $customer->getCreditLimitAllowed();
    }

    public function getCreditLimit()
    {
        return Mage::getSingleton('customer/session')
            ->getCustomer()
            ->getCreditLimitAllowed();
    }

    public function getRequestCount()
    {
        return Mage::getModel('credit/credit_transfer')->getRequestCount();
    }
}
