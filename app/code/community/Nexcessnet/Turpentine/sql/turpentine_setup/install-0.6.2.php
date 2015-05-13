<?php
$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$connection = $installer->getConnection();

/**
 * turpentine_url_cache_status table
 */
$urlCacheStatusTable = $installer->getTable('turpentine/url_cache_status');
if ($connection->isTableExists($urlCacheStatusTable)) {
    $connection->dropTable($urlCacheStatusTable);
}
$urlCacheStatusTable = $connection->newTable($urlCacheStatusTable)
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary'  => true,
        ),
        'Entity Id'
    )
    ->addColumn(
        'url',
        Varien_Db_Ddl_Table::TYPE_TEXT,
        255,
        array(
            'nullable' => false,
        ),
        'Page Url'
    )
    ->addColumn(
        'expire_at',
        Varien_Db_Ddl_Table::TYPE_DATETIME,
        null,
        array(
            'nullable' => false,
        ),
        'Expire At'
    )
    ->addIndex(
        $installer->getIdxName(
            'turpentine/url_cache_status',
            array('url')
        ),
        array('url'),
        array('type' => 'UNIQUE')
    )
    ->setComment('Turpentine Url Cache Status Table');
$connection->createTable($urlCacheStatusTable);

$installer->endSetup();