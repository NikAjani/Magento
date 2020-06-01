<?php 

$installer = $this; 

$installer->startSetup(); 

$table = $installer->getConnection()
    ->newTable($installer->getTable('vendor'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Id')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, null, array(
        'nullable'  => true,
        ), 'name')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, 1, null, array(
        'nullable'  => true,
        ), 'status')
    ->addColumn('email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, null, array(
        'nullable'  => true,
        ), 'email')
    ->addColumn('password', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, null, array(
        'nullable'  => true,
        ), 'password')
    ->addColumn('createdDate', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => true,
        ), 'createdDate');

$installer->getConnection()->createTable($table);

$installer->endSetup();
