<?php 

$installer = $this; 

$installer->startSetup(); 

$table = $installer->getConnection()
    ->newTable($installer->getTable('process/process'))
    ->addColumn('processId', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'processId')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => true,
        ), 'name')
    ->addColumn('processGroupId', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
        ), 'processGroupId')
    ->addColumn('model', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => true,
        ), 'model')
    ->addColumn('processType', Varien_Db_Ddl_Table::TYPE_INTEGER, 1, array(
        'nullable'  => true,
        'unsigned'  => true,
        ), 'processType')
    ->addForeignKey(
         $installer->getFkName('process/process', 'processGroupId', 'process/process_group','groupId'),
         'processGroupId',
         $installer->getTable('process/process_group'), 
         'groupId',
         Varien_Db_Ddl_Table::ACTION_CASCADE, 
         Varien_Db_Ddl_Table::ACTION_CASCADE);

$installer->getConnection()->createTable($table);
    
$installer->endSetup();