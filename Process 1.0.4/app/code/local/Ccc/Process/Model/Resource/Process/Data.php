<?php
class Ccc_Process_Model_Resource_Process_Data extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {  
        $this->_init('process/process_data', 'dataId');
    }  
}