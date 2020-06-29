<?php

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($installer->getTable('credit/credit_transaction'))
    ->addColumn('transaction_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'transaction_id')
    ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'default' => null,
    ), 'order_id')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'default' => null,
    ), 'customer_id')
    ->addColumn('balance_before_transaction', Varien_Db_Ddl_Table::TYPE_DECIMAL, null, array(
        'nullable' => false,
    ), 'balance_before_transaction')
    ->addColumn('balance_after_transaction', Varien_Db_Ddl_Table::TYPE_DECIMAL, null, array(
        'nullable' => false,
    ), 'balance_after_transaction')
    ->addColumn('trans_type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array('nullable' => false), 'trans_type')
    ->addColumn('credit', Varien_Db_Ddl_Table::TYPE_DECIMAL, null, array('nullable' => false),
        'credit')
    ->addColumn('created_date', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'default' => '0000-00-00',
    ), 'created_date')
    ->addColumn('detail', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => true,
    ), 'detail');

$installer->getConnection()->createTable($table);

$installer->endSetup();
