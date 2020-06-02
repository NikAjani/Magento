<?php

$installer = $this;

$installer->startSetup();

$installer->getConnection()
    ->addColumn($installer->getTable('process/process'), 'row_per_request', array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable' => true,
        'after' => 'filename',
        'default' => 100,
        'comment' => 'Row Per Request'
    ));

$installer->endSetup();