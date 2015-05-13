<?php

/**
* Class Nexcessnet_Turpentine_Model_Resource_Mysql4_UrlCacheStatus
*
* @author Oleksandr Velykzhanin <alexander.velykzhanin@flagbit.de>
*/
class Nexcessnet_Turpentine_Model_Resource_Mysql4_UrlCacheStatus extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct() {
        $this->_init('turpentine/url_cache_status', 'entity_id');
    }

    /**
     * Update or insert $expireAt date for $url
     *
     * @param string $url
     * @param Zend_Date $expireAt
     */
    public function updateUrl($url, Zend_Date $expireAt) {
        /** @var Varien_Db_Adapter_Interface $writeAdapter */
        $writeAdapter = $this->_getWriteAdapter();
        $expireStr = $expireAt->toString('YYYY-MM-dd HH:mm:ss');
        $writeAdapter->insertOnDuplicate($this->getMainTable(), array('url' => $url, 'expire_at' => $expireStr));
    }
}