<?php
 
$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$installer->startSetup();
 
$setup->addAttribute('catalog_product', 'vendor', array(
    'group'         => 'General',
    'input'         => 'select',
    'type'          => 'text',
    'label'         => 'Vendor',
    'backend'       => '',
    'source'        => 'vendor/product_attribute_vendor',
    'visible'       => true,
    'required'        => false,
    'user_defined' => true,
    'searchable' => true,
    'filterable' => true,
    'comparable'    => true,
    'visible_on_front' => true,
    'visible_in_advanced_search'  => true,
    'is_html_allowed_on_front' => true,
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));
 
$installer->endSetup();