<?php

class Ccc_Credit_Model_Standard extends Mage_Payment_Model_Method_Abstract
{
    // This is the identifier of our payment method
    protected $_code = 'credit_payment';
    protected $_isInitializeNeeded      = true;
    protected $_canUseInternal          = false;
    protected $_canUseForMultishipping  = false;
    protected $_formBlockType = 'credit/form_pay';

 	public function getGrandTotal() {
        return Mage::getSingleton('checkout/session')->getQuote()->getData('grand_total');
    }

    public function validate()
    {
    	parent::validate();

        $CurrentCreditBalance = $this->getCurrentCreditBalance() / $this->getExchangeRatio(); 
        if ($CurrentCreditBalance < $this->getGrandTotal()) 
             Mage::throwException(Mage::helper('credit')->__("Your credit balance is low."));

        return $this;
    }

    public function getExchangeRatio()
    {

        $creditExchnage = Mage::getSingleton('customer/session')->getCustomer()->getCreditExchangeRatio();

		$config_exchange_ratio = Mage::getStoreConfig('credit/credit_group/credit_exchange', Mage::app()->getStore());

        return ($config_exchange_ratio > $creditExchnage) ? $config_exchange_ratio : $creditExchnage;
    }

    public function getCurrentCreditBalance() {

        $customer = Mage::getSingleton('customer/session')->getCustomer();
        
        return $customer->getCreditLimitAllowed() + $customer->getCreditBalance();
    }
}