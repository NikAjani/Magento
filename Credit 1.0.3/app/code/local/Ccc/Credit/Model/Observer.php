<?php

class Ccc_Credit_Model_Observer
{

    public function afterOrder($observer)
    {
        $order   = $observer->getEvent()->getOrder();
        $payment = $order->getPayment();

        if ($payment->getMethodInstance()->getCode() != 'credit_payment') {
            return $this;
        }

        if ($order->canInvoice()) {

            $order->save();

            $creditModel = Mage::getModel('credit/credit');

            if (!$creditModel->verifyCreditPayment($observer)) {
                Mage::throwException(Mage::helper('credit')->__('Your credit balance is low.'));
            }

            unset($order);
            unset($payment);

        }

        return $this;
    }

    public function customerSaveAfter($observer)
    {
        $customer = $observer->getCustomer();

        $creditTansaction = Mage::getModel('credit/credit_transaction');

        if ($customer->getIsTransactionSkip() == false) {
            $creditTansaction->setTransaction($observer);
        }

        return $this;
    }

}
