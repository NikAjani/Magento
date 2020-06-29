<?php

class Ccc_Credit_Model_Credit_Transaction  extends Mage_Core_Model_Abstract {

	CONST CREDIT = "Credit";
	CONST DEBIT = "Debit";

	protected function _construct()
    {  
        $this->_init('credit/credit_transaction');
        $this->setFilePath();
    }

    public function setTransaction($observer)
    {

    	$customer = $observer->getCustomer();
        
        $oldCurrentBalance = $customer->getOrigData('credit_balance');

        $newCurrentBalance = $customer->getData('credit_balance');

        if ($oldCurrentBalance != $newCurrentBalance) {

            if ($oldCurrentBalance < $newCurrentBalance) {

                $this->setTransType(self::CREDIT);
                $this->setDetail('Balance Credited.');

            } else {

                $this->setTransType(self::DEBIT);
                $this->setDetail('Balance Debited.');

            }

            $this->setCustomerId($customer->getId());

            $this->setBalanceBeforeTransaction($oldCurrentBalance + $customer->getData('credit_limit_allowed'));

            $this->setBalanceAfterTransaction($newCurrentBalance + $customer->getData('credit_limit_allowed'));

            $this->setCredit(abs($newCurrentBalance - $oldCurrentBalance));
            
            $this->setCreatedDate(Mage::getModel('core/date')->gmtDate('Y-m-d H:i:s'));

            $this->save();
        }

        return true;
    }
}