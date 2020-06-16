<?php 

$installer = $this; 

$installer->startSetup(); 

$table = $installer->getConnection()
    ->newTable($installer->getTable('process/process_group'))
    ->addColumn('groupId', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'groupId')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, null, array(
        'nullable'  => true,
        ), 'name');

$installer->getConnection()->createTable($table);

$installer->endSetup();