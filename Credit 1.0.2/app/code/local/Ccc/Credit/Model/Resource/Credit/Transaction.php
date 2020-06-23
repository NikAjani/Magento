<?php
class Ccc_Credit_Model_Resource_Credit_Transaction extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {  
        $this->_init('credit/credit_transaction', 'transaction_id');
    }  
}