<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'abstract.php';

class TurpentineUrlCacheStatus extends Mage_Shell_Abstract
{

    const INSTANCES_COUNT = 10;
    const LIMIT = 100;
    const DELIMITER = ',';
    const LOCK_FILE_PATTERN = 'url_warm_lock_%s.lock';

    /**
    * 1. If we have "part" defined - refresh cache for that part (ids are got from file)
    * 2. If we don't have "ids" - execute instances with ids
    */
    public function run()
    {
        if ($this->getArg('help'))
        {
            echo $this->usageHelp();
            return;
        }
        if (!Mage::helper('turpentine/varnish')->getVarnishEnabled() || !Mage::helper('turpentine/crawler')->getSmartCrawlerEnabled())
        {
            echo "Varnish or smart crawler is disabled";
            return;
        }
        if ($this->getArg('part'))
        {
            $this->runPart((int) $this->getArg('part'));
            return;
        }
        $this->createInstances();
    }

    public function createInstances()
    {
        $instancesCount = self::INSTANCES_COUNT;
        if ($this->getArg('instances'))
        {
            $instancesCount = (int) $this->getArg('instances');
        }
        $limit = self::LIMIT;
        if ($this->getArg('limit'))
        {
            $limit = (int) $this->getArg('limit');
        }
        $instanceNumber = 1;
        $collection = $this->_getCollection($limit, $instanceNumber);
        $lastPage   = $collection->getLastPageNumber();
        while ($instanceNumber <= $instancesCount && $instanceNumber <= $lastPage)
        {
            $ids = array();
            $collection = $this->_getCollection($limit, $instanceNumber);
            foreach ($collection as $item)
            {
                $ids[] = $item->getId();
            }
            do
            {
                $created = $this->_createInstance($instanceNumber, $ids);
                $instanceNumber++;
            } while (!$created && $instanceNumber <= $instancesCount && $instanceNumber <= $lastPage);
        }
    }

    /**
    * @param int|null $pageSize
    * @param int|null $page
    *
    * @return Nexcessnet_Turpentine_Model_Resource_Mysql4_UrlCacheStatus_Collection
    */
    protected function _getCollection($pageSize = null, $page = null)
    {
        $collection = Mage::getModel('turpentine/urlCacheStatus')->getCollection();
        $collection->addFieldToFilter('expire_at', array('lteq' => Mage::getSingleton('core/date')->gmtDate()))
            ->setOrder('expire_at', 'ASC');
        if (!is_null($pageSize))
        {
            $collection->setPageSize($pageSize);
        }
        if (!is_null($page))
        {
            $collection->setCurPage($page);
        }
        return $collection;
    }

    /**
    * Fill in part file with ids to execute and start another php process to process that ids
    *
    * @param $instanceNumber
    * @param $ids
    *
    * @return bool
    */
    protected function _createInstance($instanceNumber, $ids)
    {
        $idsFile = $this->_getIdsFile($instanceNumber, 'w');
        if (!$idsFile)
        {
            Mage::helper('turpentine/debug')->logInfo("Instance with number {$instanceNumber} already running");
            return false;
        }
        fputs($idsFile, implode(self::DELIMITER, $ids));
        fclose($idsFile);
        $command = __FILE__ . sprintf(' --part %s', $instanceNumber);
        exec('php ' . $command . ' > /dev/null 2>&1 &');
        return true;
    }

    /**
    * Run part number $number
    *
    * @param $number
    */
    public function runPart($number)
    {
        $idsFile = $this->_getIdsFile($number);
        if (!$idsFile)
        {
            Mage::helper('turpentine/debug')->logInfo("Crawler part file is locked {$number}");
            return;
        }
        $ids = explode(self::DELIMITER, fgets($idsFile));
        $collection = Mage::getModel('turpentine/urlCacheStatus')->getCollection();
        $collection->addFieldToFilter('expire_at', array('lteq' => Mage::getSingleton('core/date')->gmtDate()))
            ->setOrder('expire_at', 'ASC')
                ->addFieldToFilter('entity_id', array('in' => $ids));
        /** @var Nexcessnet_Turpentine_Model_UrlCacheStatus $urlCacheStatus */
        foreach ($collection as $urlCacheStatus)
        {
            try
            {
                $urlCacheStatus->refreshCache();
            }
            catch (Exception $e)
            {
                Mage::helper('turpentine/debug')->logWarn($e->getMessage());
                echo $e->getMessage();
            }
        }
        fclose($idsFile);
    }

    /**
    * Get file with ids for process with $mode or return false if file is locked by other process
    *
    * @param $number
    * @param $mode
    *
    * @return bool|resource
    */
    protected function _getIdsFile($number, $mode = 'r')
    {
        $number   = (int) $number;
        $locksDir = Mage::getConfig()->getVarDir('turpentine/locks');
        $lockName = $locksDir . DS . sprintf(self::LOCK_FILE_PATTERN, $number);
        $lockFile = fopen($lockName, $mode);
        if (!$this->_lockFile($lockFile))
        {
            return false;
        }
        return $lockFile;
    }

    /**
    * Try to lock file
    *
    * @param resource $file
    *
    * @return bool
    */
    protected function _lockFile($file)
    {
        $result = false;
        if (flock($file, LOCK_EX | LOCK_NB))
        {
            $result = true;
        }
        return $result;
    }

    /**
    * Get the usage string
    *
    * @return string
    */
    public function usageHelp()
    {
        return <<<USAGE
            Usage:  php turpentineUrlCacheStatus.php -- [options]
        --instances <count>           Create "count" instances for warmup (optional, default 10)
        --limit <count>               Limit urls count per on execution (optional, default 100)
        --part <number>               Execute warmup for part urls by ids from part file url_warm_lock_<number>.lock
        help                          This help
        Note:
        In most cases you should use "instances" and "limit" parameter. "part" parameter can be usable only when you
        have file with ids.
        USAGE;
    }
}

$turpentineUrlCacheStatus = new TurpentineUrlCacheStatus();
$turpentineUrlCacheStatus->run();
