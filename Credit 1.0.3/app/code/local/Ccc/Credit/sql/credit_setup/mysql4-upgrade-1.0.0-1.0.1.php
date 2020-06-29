<?php


$setup = new Mage_Sales_Model_Resource_Setup('core_setup');
$setup->addAttribute('quote_payment', 'credit_used', array(
    'label'         => 'Credit Used',
    'type'          => 'int',
    'input'         => 'text',
    'visible'       => true,
));
$setup->addAttribute('quote_payment', 'credit_exchange_ratio', array(
    'label'         => 'Credit Exchange Ratio',
    'type'          => 'int',
    'input'         => 'text',
    'visible'       => true,
));
$setup->addAttribute('order_payment', 'credit_used', array(
    'label'         => 'Credit Used',
    'type'          => 'int',
    'input'         => 'text',
    'visible'       => true,
));
$setup->addAttribute('order_payment', 'credit_exchange_ratio', array(
    'label'         => 'Credit Exchange Ratio',
    'type'          => 'int',
    'input'         => 'text',
    'visible'       => true,
));

$this->endSetup();