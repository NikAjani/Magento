<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('credit/credit_transfer'))
    ->addColumn('transfer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'transfer_id')
    ->addColumn('to_customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'default' => null,
    ), 'to_customer_id')
    ->addColumn('from_customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'default' => null,
    ), 'from_customer_id')
    ->addColumn('transaction_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, null, array(
        'nullable' => false,
    ), 'transaction_amount')
    ->addColumn('transfer_status', Varien_Db_Ddl_Table::TYPE_INTEGER, 1, array(
        'nullable' => false
    ), 'transfer_status')
    ->addColumn('requested_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'default' => '0000-00-00',
    ), 'requested_date')
    ->addColumn('response_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'default' => '0000-00-00',
    ), 'response_date')
    ->addColumn('detail', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => true,
    ), 'detail');

$installer->getConnection()->createTable($table);

$installer->endSetup();
