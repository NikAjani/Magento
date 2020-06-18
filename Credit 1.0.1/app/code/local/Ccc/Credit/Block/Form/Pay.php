<?php
class Ccc_Credit_Block_Form_Pay extends Mage_Payment_Block_Form
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('credit/form/pay.phtml');
    }

    public function getCreditBalance()
    {
    	$customer = Mage::getSingleton('customer/session')->getCustomer();
        return $customer->getCreditBalance() + $customer->getCreditLimitAllowed();
    }

}