<?php

class Ccc_Credit_Model_Credit_Transfer extends Mage_Core_Model_Abstract
{

    const PENDING        = 1;
    const APPROVED       = 2;
    const REJECTED       = 3;
    const PENDING_LABEL  = "Pending";
    const APPROVED_LABEL = "Approved";
    const REJECTED_LABEL = "Rejected";

    protected function _construct()
    {
        $this->_init('credit/credit_transfer');
    }

    public function getStatusOptions()
    {
        return [
            self::PENDING  => self::PENDING_LABEL,
            self::APPROVED => self::APPROVED_LABEL,
            self::REJECTED => self::REJECTED_LABEL,
        ];
    }

    public function getRequestCount()
    {
        $customerId = Mage::getSingleton('customer/session')->getCustomer()->getId();

        $collection = $this->getCollection()
            ->addFieldToFilter('from_customer_id', $customerId)
            ->addFieldToFilter('transfer_status', 1);

        return count($collection->getData());
    }
}
