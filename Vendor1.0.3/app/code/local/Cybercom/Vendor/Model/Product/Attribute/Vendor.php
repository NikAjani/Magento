<?php


class Cybercom_Vendor_Model_Product_Attribute_Vendor extends Mage_Eav_Model_Entity_Attribute_Source_Abstract {

    public function getAllOptions() {

        $collection = Mage::getModel('vendor/vendor')->getCollection();
        ;

        $options[] = array('value'=>0,'label'=>'Select Vendor');
        foreach ($collection as $vendor){
            $options[] = array('value' => $vendor->getId(), 'label' => $vendor->getName());
    }

        return $options;
    }

}