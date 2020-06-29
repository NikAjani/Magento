<?php
class Ccc_Credit_Model_Resource_Credit_Transfer_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {  
        $this->_init('credit/credit_transfer');
    }  
}