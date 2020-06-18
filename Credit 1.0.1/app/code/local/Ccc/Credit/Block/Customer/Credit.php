<?php

class Ccc_Credit_Block_Customer_Credit extends Mage_Core_Block_Template
{

	public function getExchnageRatio()
	{

		$config_exchange_ratio = Mage::getStoreConfig('credit/credit_group/credit_exchange',Mage::app()->getStore());
		
		$customer = Mage::getSingleton('customer/session')->getCustomer();

		return ($config_exchange_ratio > $customer->getCreditExchangeRatio()) ? $config_exchange_ratio : $customer->getCreditExchangeRatio();
	}

	public function getCreditBalance()
	{
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		return $customer->getCreditBalance() + $customer->getCreditLimitAllowed();
	}

	public function getCreditLimit()
	{
		return Mage::getSingleton('customer/session')
							->getCustomer()
							->getCreditLimitAllowed();
	}
}