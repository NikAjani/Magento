<?php

class Ccc_Credit_Model_Observer {

    public function afterOrder($observer)
    {
        $order    = $observer->getEvent()->getOrder();
        $payment  = $order->getPayment();
        $customer = $order->getCustomer();

        if ($payment->getMethodInstance()->getCode() != 'credit_payment') {
            return $this;
        }

        if ($order->canInvoice()) {
            
            $order->save();
            
            $creditExchnageRatio = $this->getExchangeRatio($customer);
            
            $payment->setCreditUsed($order->getGrandTotal() * $creditExchnageRatio);
            $payment->setCreditExchangeRatio($creditExchnageRatio);
            $payment->save();
            
            $grandTotal = $order->getGrandTotal();


            $currentCredit = ($this->getCurrentCreditBalance($customer)) / $creditExchnageRatio;

            if ($grandTotal > $currentCredit) {
                Mage::throwException(Mage::helper('credit')->__('Your credit balance is low.'));
            }

            $customer->setCreditBalance($customer->getCreditBalance()-($grandTotal*$creditExchnageRatio))->save();
            
        }

        return $this;
    }

	public function getExchangeRatio($customer)
	{
		$creditExchnage = $customer->getCreditExchangeRatio();

		$config_exchange_ratio = Mage::getStoreConfig('credit/credit_group/credit_exchange', Mage::app()->getStore());

		return ($config_exchange_ratio > $creditExchnage) ? $config_exchange_ratio : $creditExchnage;

	}

    public function getCurrentCreditBalance($customer) {

        return $customer->getCreditLimitAllowed() + $customer->getCreditBalance();
    }
}