<?php

/**
* Class Nexcessnet_Turpentine_Model_UrlCacheStatus
*
* @method string getUrl()
* @method $this setUrl(string $url)
*
* @author Oleksandr Velykzhanin <alexander.velykzhanin@flagbit.de>
*/
class Nexcessnet_Turpentine_Model_UrlCacheStatus extends Mage_Core_Model_Abstract
{

    const LOGFILE = 'turpentine_url_cache_status.log';

    /**
     * @var string
     */
    protected $_eventPrefix = 'turpentine_urlcachestatus';

    protected function _construct()
    {
        $this->_init('turpentine/urlCacheStatus');
    }

    /**
     * Request page by url and set new expire at
     *
     * @throws Exception
     */
    public function refreshCache()
    {
        $url = $this->getUrl();
        $client = Mage::helper('turpentine/cron')->getCrawlerClient();
        $client->setUri($url);
        Mage::helper('turpentine/debug')->logDebug('Crawling URL: %s', $url);
        try
        {
            $response = $client->request();
        } catch (Exception $e)
        {
            $message = sprintf('Error crawling URL (%s): %s', $url, $e->getMessage());
            throw new Exception($message);
        }
        if ($response->getStatus() == 404)
        {
            $this->delete();
            $message = sprintf('Url become 404: %s', $this->getUrl());
            Mage::helper('turpentine/debug')->logDebug($message);
            return;
        }
        $this->renewExpireAt();
    }

    /**
     * Set expire_at date to current(so they are expired) for all occurrences found by url $regexp
     *
     * @param string $regex
     */
    public function  expireByRegex($regex)
    {
        $collection = $this->getCollection();
        $collection->addFieldToFilter('url', array('regexp' => $regex));
        /** @var Nexcessnet_Turpentine_Model_UrlCacheStatus $urlCacheStatus */
        foreach ($collection as $urlCacheStatus)
        {
            $date = new Zend_Date();
            $this->getResource()->updateUrl($urlCacheStatus->getUrl(), $date);
        }
    }

    /**
     * Renew expire_at date to (currentDate + ttl) for $url or model's url
     *
     * @param string $url
     *
     * @throws Mage_Core_Exception
     */
    public function renewExpireAt($url = null)
    {
        if (is_null($url))
        {
            $url = $this->getUrl();
        }
        if (!$url)
        {
            Mage::throwException('Url should be set for renewing expire at');
        }
        $date = $this->getNextExpireAtDate($url);
        $this->getResource()->updateUrl($url, $date);
    }

    /**
     * Get next expire_at date for url
     *
     * @param string $url
     * @return Zend_Date
     */
    public function getNextExpireAtDate($url)
    {
        $currentTimestamp = Mage::getSingleton('core/date')->gmtTimestamp();
        $urlTtls = Mage::helper('turpentine/varnish')->getUrlTtls();
        $ttl = Mage::helper('turpentine/varnish')->getDefaultTtl();
        foreach ($urlTtls as $urlTtl)
        {
            if (preg_match('/' . $urlTtl['regex'] . '/', $url))
            {
                $ttl = $urlTtl['ttl'];
                break;
            }
        }
        $expireAtTimestamp = $currentTimestamp + (int)$ttl;
        $date = new Zend_Date($expireAtTimestamp);
        return $date;
    }
}