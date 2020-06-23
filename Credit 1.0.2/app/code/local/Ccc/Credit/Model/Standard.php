<?php

class Ccc_Credit_Model_Standard extends Mage_Payment_Model_Method_Abstract
{

    protected $_code = 'credit_payment';

    protected $_isInitializeNeeded      = true;
    protected $_canUseInternal          = true;
    protected $_canUseForMultishipping  = true;

    protected $_formBlockType = 'credit/form_pay';

 	public function getGrandTotal() {
        return Mage::getSingleton('checkout/session')->getQuote()->getData('grand_total');
    }

    public function validate()
    {
    	parent::validate();

        $customer = Mage::getSingleton('customer/session')->getCustomer();

        $creditUse = Mage::getModel('credit/credit')->getCreditUse($customer);

        if ($creditUse < $this->getGrandTotal()) 
             Mage::throwException(Mage::helper('credit')->__("Your credit balance is low."));

        return $this;
    }

}