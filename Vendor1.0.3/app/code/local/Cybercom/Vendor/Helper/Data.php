<?php

class Cybercom_Vendor_Helper_Data extends Mage_Core_Helper_Abstract {

	public function getVendorUrl()
	{
		return Mage::getUrl('vendor/account/index');
	}

	public function getEditUrl()
	{
		return Mage::getUrl('vendor/account/edit');
	}

	public function getVendorLogoutUrl()
	{
		return Mage::getUrl('vendor/account/logout');
	}
	
}