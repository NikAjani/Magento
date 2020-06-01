<?php

class Cybercom_Vendor_Block_Account_Dashboard extends Mage_Core_Block_Template {

	function __construct()
	{
		parent::__construct();
	}

	public function getVendor()
	{	
		return Mage::getSingleton('core/session')->getVendor();
	}

}