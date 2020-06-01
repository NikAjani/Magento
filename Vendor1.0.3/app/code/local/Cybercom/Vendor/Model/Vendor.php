<?php

class Cybercom_Vendor_Model_Vendor extends Mage_Core_Model_Abstract {

	const STATUS_ENABLED = 1;
    const STATUS_ENABLED_LABEL = 'Enabled';
    const STATUS_DISABLED = 0;
    const STATUS_DISABLED_LABEL = 'Disabled';

    protected $vendorStatusOptions = null;
    
    protected function _construct()
    {  
        $this->_init('vendor/vendor');
        if($this->vendorStatusOptions == null)
            $this->setVendorStatusOptions();
        
    }  

    public function getStatusOptions()
    {
        return [
            self::STATUS_ENABLED => self::STATUS_ENABLED_LABEL,
            self::STATUS_DISABLED => self::STATUS_DISABLED_LABEL
        ];
    }

    public function setVendorStatusOptions()
    {
        $vendor_status = Mage::getModel('eav/config')->getAttribute('catalog_product', 'vendor_status');
        $options = $vendor_status->getSource()->getAllOptions(false);
        $stauts_options = array();
        foreach ($options as $option){
            $stauts_options[$option['value']] = $option['label'];
        }

        $this->vendorStatusOptions = $stauts_options;
        return $this;
    }

    public function getMassVendorStatusOptions()
    {
        $vendor_status = Mage::getModel('eav/config')->getAttribute('catalog_product', 'vendor_status');
        $options = $vendor_status->getSource()->getAllOptions(false);
        $stauts_options = array();
        foreach ($options as $option){
            $stauts_options[] = ['value' => $option['value'], 'label' => $option['label']];
        }

        return $stauts_options;
    }

    public function getVendorStatusOptions()
    {

        return $this->vendorStatusOptions;
    }

    public function getVendorStatusId($statusOption)
    {
        return array_search($statusOption,$this->vendorStatusOptions);
    }

    public function statusOptionArray()
    {

        $actionArray = [];

        foreach ($this->vendorStatusOptions as $key => $value) {
            
            $actionArray[] = [
                'caption' => $value,
                'url' => [
                    'base' => '*/product/changeVendorStatus',
                    'params'=>array('store'=>$this->getRequest()->getParam('store'), 'status' => $key)
                    ],
                'field' => 'id'
            ];
        }

        echo '<pre>';
        echo 'In';
        print_r($actionArray);
        die;

    }

}