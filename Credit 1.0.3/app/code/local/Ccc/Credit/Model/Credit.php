<?php

class Ccc_Credit_Model_Credit extends Mage_Core_Model_Abstract
{

    public function verifyCreditPayment($observer)
    {
        $order    = $observer->getEvent()->getOrder();
        $payment  = $order->getPayment();
        $customer = $order->getCustomer();

        $creditExchnageRatio = $this->getExchangeRatio($customer);

        $grandTotal = $order->getGrandTotal();

        if ($grandTotal > $this->getCreditUse($customer)) {
            return false;
        }

        $payment->setCreditUsed($order->getGrandTotal() * $creditExchnageRatio);
        $payment->setCreditExchangeRatio($creditExchnageRatio);
        $payment->save();

        Mage::register('before_balance', $this->getCurrentCreditBalance($customer));

        $customer->setCreditBalance($customer->getCreditBalance() - ($grandTotal * $creditExchnageRatio))
            ->setIsTransactionSkip(true)
            ->save();

        $this->setTransaction($observer);

        unset($order);
        unset($payment);
        unset($customer);

        return true;
    }

    public function setTransaction($observer)
    {

        $order    = $observer->getEvent()->getOrder();
        $payment  = $order->getPayment();
        $customer = $order->getCustomer();

        $transactionModel = Mage::getModel('credit/credit_transaction');

        $transactionModel->setOrderId($order->getId());

        $transactionModel->setCustomerId($customer->getId());

        $transactionModel->setBalanceBeforeTransaction(Mage::registry('before_balance'));

        Mage::unregister('before_balance');

        $transactionModel->setBalanceAfterTransaction($this->getCurrentCreditBalance($customer));

        $transactionModel->setTransType(Ccc_Credit_Model_Credit_Transaction::DEBIT);

        $transactionModel->setCredit($payment->getCreditUsed());

        $transactionModel->setCreatedDate(Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'));

        $transactionModel->setDetail('order places');

        $transactionModel->save();

        unset($order);
        unset($payment);
        unset($customer);

        return true;
    }

    public function getExchangeRatio($customer)
    {
        $creditExchnage = $customer->getCreditExchangeRatio();

        $config_exchange_ratio = Mage::getStoreConfig('credit/credit_group/credit_exchange', Mage::app()->getStore());

        return ($config_exchange_ratio > $creditExchnage) ? $config_exchange_ratio : $creditExchnage;
    }

    public function getCurrentCreditBalance($customer)
    {

        return $customer->getCreditLimitAllowed() + $customer->getCreditBalance();
    }

    public function getCreditUse($customer)
    {
        return $this->getCurrentCreditBalance($customer) /
        $this->getExchangeRatio($customer);
    }

}
