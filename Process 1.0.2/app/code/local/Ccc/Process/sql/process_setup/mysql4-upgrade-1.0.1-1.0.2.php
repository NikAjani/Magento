<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()
    ->addColumn($installer->getTable('process/process'), 'filename', array(
        'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
        'nullable' => true,
        'after' => 'processType',
        'length' => 255,
        'comment' => 'Filename'
    ));

$table = $installer->getConnection()
    ->newTable($installer->getTable('process/process_data'))
    ->addColumn('dataId', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'dataId')
    ->addColumn('processId', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'unsigned'  => true,
    ), 'processId')
    ->addForeignKey(
        $installer->getFkName('process/process_data', 'processId', 'process/process', 'processId'),
        'processId',
        $installer->getTable('process/process'),
        'processId',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,     
    ), 'identifier')
    ->addColumn('data', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => true,
    ), 'data')
    ->addColumn('startTime', Varien_Db_Ddl_Table::TYPE_DATETIME, 255, array(
        'nullable'  => true,
    ), 'startTime')
    ->addColumn('endTime', Varien_Db_Ddl_Table::TYPE_DATETIME, 255, array(
        'nullable'  => true,
    ), 'endTime')
    ->addIndex(
            $installer->getIdxName('process/process_data', ['identifier']),
            ['identifier'],
            ['type' => 'unique']
        );

$installer->getConnection()->createTable($table);

$installer->endSetup();