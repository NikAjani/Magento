<?php

class Ccc_Process_Model_Product extends Mage_Core_Model_Abstract
{
	protected $identifier = 'sku';
	protected $requiredArray = ['name','sku','price'];

	public function _construct()
	{
		$this->_init('catalog/product');
	}

	public function getModel()
	{
		return Mage::getModel('catalog/product');
	}

	public function getIdentifier()
	{
		return $this->identifier;
	}

	public function readFile($fileData)
	{
	    $headers = $fileData[0];
	    unset($fileData[0]);

	    if(array_diff($this->requiredArray,$headers))
	    	throw new Exception("Required field not matched.");

        $indentifierName = $this->identifier;

        // $collection = Mage::getModel('process/data')->getCollection();
        // $collection = $collection->getData();
        // print_r(array_search('s1', $collection));
        // die;
	    foreach ($fileData as $row) {

	    	foreach ($headers as $key => $value) {
    			$row[$value] = $row[$key];
    			unset($row[$key]);
    		}

	    	if(array_key_exists($row[$indentifierName], $finalData) || in_array($row[$indentifierName], $collection)){
	    		$log_array[$row[$indentifierName]] = $row;
	    	}else 
	    		$finalData[$row[$indentifierName]] = $row;
	    	
	    }

	    // echo "<pre>";
	    // print_r($log_array);
	    // print_r($finalData);
	    // die;

	    return [
	    	'logData' => $log_array,
	    	'fileData' => $finalData
	    ];

	}
}	