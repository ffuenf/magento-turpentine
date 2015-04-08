<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'abstract.php';

class TurpentineUrlCacheStatus extends Mage_Shell_Abstract
{

    const EXPIRE_LIMIT = 100;


    public function run()
    {
        if (!Mage::helper('turpentine/varnish')->getVarnishEnabled()){
            return;
        }

        $collection = Mage::getModel('turpentine/urlCacheStatus')->getCollection();
        $collection->addFieldToFilter('expire_at', array('lteq' => Mage::getSingleton('core/date')->gmtDate()))
            ->setOrder('expire_at', 'ASC')
            ->setPageSize(self::EXPIRE_LIMIT);

        /** @var Nexcessnet_Turpentine_Model_UrlCacheStatus $urlCacheStatus */
        foreach ($collection as $urlCacheStatus) {
            try {
                $urlCacheStatus->refreshCache();
            } catch (Exception $e) {
                echo $e->getMessage();
                Mage::logException($e);
            }
        }
    }
}

$turpentineUrlCacheStatus = new TurpentineUrlCacheStatus();
$turpentineUrlCacheStatus->run();