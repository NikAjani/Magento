<?php
$installer = $this;

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();


$setup->addAttribute('customer', 'credit_balance', array(
    'group'                      => 'Customer Credit',
    'label'                      => 'Credit balance',
    'type'                       => 'decimal',
    'input'                      => 'text',
    'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'                    => true,
    'default'                    => '0',
    'required'                   => false,
    'user_defined'               => true,
    'searchable'                 => false,
    'filterable'                 => false,
    'comparable'                 => false,
    'visible_on_front'           => false,
    'visible_in_advanced_search' => false,
    'unique'                     => false,
));


$attribute = Mage::getSingleton('eav/config')
    ->getAttribute('customer', 'credit_balance');
    
$attribute->setData(
        'used_in_forms',
        array(
            'adminhtml_customer',
        )
    )
    ->save();

$setup->addAttribute('customer', 'credit_limit_allowed', array(
    'group'                      => 'Customer Credit',
    'label'                      => 'Credit limit',
    'type'                       => 'decimal',
    'input'                      => 'text',
    'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'                    => true,
    'default'                    => '0',
    'required'                   => false,
    'user_defined'               => true,
    'searchable'                 => false,
    'filterable'                 => false,
    'comparable'                 => false,
    'visible_on_front'           => false,
    'visible_in_advanced_search' => false,
    'unique'                     => false,
));



Mage::getSingleton('eav/config')
    ->getAttribute('customer', 'credit_limit_allowed')
    ->setData(
        'used_in_forms',
        array(
            'adminhtml_customer',
        )
    )
    ->save();

$setup->addAttribute('customer', 'credit_exchange_ratio', array(
    'group'                      => 'Customer Credit',
    'label'                      => 'Credit Exchange Ratio',
    'type'                       => 'decimal',
    'input'                      => 'text',
    'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'                    => true,
    'default'                    => '1',
    'required'                   => false,
    'user_defined'               => true,
    'searchable'                 => false,
    'filterable'                 => false,
    'comparable'                 => false,
    'visible_on_front'           => false,
    'visible_in_advanced_search' => false,
    'unique'                     => false,
));


Mage::getSingleton('eav/config')
    ->getAttribute('customer', 'credit_exchange_ratio')
    ->setData(
        'used_in_forms',
        array(
            'adminhtml_customer',
        )
    )
    ->save();

$installer->endSetup();
