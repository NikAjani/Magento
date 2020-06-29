<?php
class Ccc_Credit_Model_Resource_Credit_Transfer extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {  
        $this->_init('credit/credit_transfer', 'transfer_id');
    }  
}