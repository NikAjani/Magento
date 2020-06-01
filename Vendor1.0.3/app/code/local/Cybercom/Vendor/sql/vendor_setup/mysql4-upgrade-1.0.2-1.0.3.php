<?php
 
$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$installer->startSetup();
 
$setup->addAttribute('catalog_product', 'vendor_status', array(
    'group'         => 'General',
    'input'         => 'select',
    'type'          => 'text',
    'label'         => 'Vendor Status',
    'backend'       => '',
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
    'option'     => array (
        'values' => array(
            0 => 'New Added',
            1 => 'Edited',
            2 => 'Deleted',
            3 => 'Approved',
            4 => 'Rejected',
        )
    ),
));


$setup->addAttribute('catalog_product', 'vendor_request_date', array(
    'group'         => 'General',
    'input'         => 'date',
    'type'          => 'text',
    'label'         => 'Vendor Request Date',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'user_defined'  => 1,
    'searchable'    => 1,
    'filterable'    => 0,
    'comparable'    => 1,
    'visible_on_front' => 1,
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front'    => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));


$setup->addAttribute('catalog_product', 'admin_response_date', array(
    'group'         => 'General',
    'input'         => 'date',
    'type'          => 'text',
    'label'         => 'Admin Response Date',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'user_defined'  => 1,
    'searchable'    => 1,
    'filterable'    => 0,
    'comparable'    => 1,
    'visible_on_front' => 1,
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front'    => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));


$installer->endSetup();
