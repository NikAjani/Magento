<?php

class Cybercom_Vendor_Block_Product_Grid extends Mage_Core_Block_Template
{
	public function getLoadedProductCollection()
	{
		$vendor = Mage::getSingleton('core/session')->getVendor();

		$collection = Mage::getModel('catalog/product')->getCollection()
	      ->addAttributeToSelect( '*' )
	      ->addAttributeToFilter('vendor', array($vendor->getId()))
	      ->addAttributeToFilter('vendor_status', array($vendor->getVendorStatusId('Approved')))
	      ->addAttributeToFilter('status', array(1));

    	return $collection;
	}

	public function getQty($product)
	{
		return Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
	}

	protected function _getStatusId($statusOption)
	{
		$vendorModel = Mage::getModel('vendor/vendor');

		return $statusId = array_search($statusOption,$vendorModel->getVendorStatusOptions());
	}
}

?>