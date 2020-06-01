<?php

class Cybercom_Vendor_Block_Account_Edit extends Mage_Core_Block_Template
{
	public function getVendor()
	{
		return Mage::getSingleton('core/session')->getVendor();
	}
}

