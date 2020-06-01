<?php

class Cybercom_Vendor_Block_Product_New extends Mage_Core_Block_Template
{
		public function getProduct()
	{
		return Mage::registry('product_data');		
	}

	public function getQty($product)
	{
		return Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty();
	}

}

?>