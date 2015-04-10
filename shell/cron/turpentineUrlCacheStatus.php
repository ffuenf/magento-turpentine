<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'abstract.php';

class TurpentineUrlCacheStatus extends Mage_Shell_Abstract
{


    public function run()
    {
        if ($this->getArg('help')) {
            echo $this->usageHelp();
            return;
        }

        if (!Mage::helper('turpentine/varnish')->getVarnishEnabled()){
            return;
        }

        $collection = Mage::getModel('turpentine/urlCacheStatus')->getCollection();
        $collection->addFieldToFilter('expire_at', array('lteq' => Mage::getSingleton('core/date')->gmtDate()))
            ->setOrder('expire_at', 'ASC');


        $limit = $this->getArg('limit');
        if ($limit !== false) {
            $collection->setPageSize($limit);
        }

        /** @var Nexcessnet_Turpentine_Model_UrlCacheStatus $urlCacheStatus */
        foreach ($collection as $urlCacheStatus) {
            try {
                $urlCacheStatus->refreshCache();
            } catch (Exception $e) {
                Mage::helper('turpentine/debug')->logWarn($e->getMessage());
                echo $e->getMessage();
            }
        }
    }

    /**
     * Get the usage string
     *
     * @return string
     */
    public function usageHelp() {
        return <<<USAGE
Usage:  php turpentineUrlCacheStatus.php -- [options]

        --limit <indexer>             Limit urls count per on execution
        help                          This help

USAGE;
    }
}

$turpentineUrlCacheStatus = new TurpentineUrlCacheStatus();
$turpentineUrlCacheStatus->run();