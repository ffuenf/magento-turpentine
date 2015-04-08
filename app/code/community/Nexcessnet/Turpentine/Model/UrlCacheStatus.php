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
     * Reload page by url and set new expire at
     *
     * @throws Exception
     */
    public function refreshCache()
    {
        $ch = curl_init($this->getUrl());
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
        curl_exec($ch);
        $errNumber = curl_errno($ch);
        if ($errNumber) {
            $message = sprintf('Error while curl to url "%s": %s (%s)', $this->getUrl(), curl_error($ch), $errNumber);
            throw new Exception($message);
        }
        $info = curl_getinfo($ch);

        if ($info['http_code'] == 404) {
            $this->delete();
            $message = sprintf('Url become 404: %s', $this->getUrl());
            Mage::log($message, null, self::LOGFILE);

            return;
        }

        curl_close($ch);

        $this->renewExpireAt();
    }


    /**
     * @param string $regex
     */
    public function  expireByRegex($regex)
    {
        $collection = $this->getCollection();
        $collection->addFieldToFilter('url', array('regexp' => $regex));

        /** @var Nexcessnet_Turpentine_Model_UrlCacheStatus $urlCacheStatus */
        foreach ($collection as $urlCacheStatus) {
            $date = new Zend_Date();
            $this->getResource()->updateUrl($urlCacheStatus->getUrl(), $date);
        }
    }


    /**
     * @param string $url
     *
     * @throws Mage_Core_Exception
     */
    public function renewExpireAt($url = null)
    {
        if (is_null($url)) {
            $url = $this->getUrl();
        }

        if (!$url) {
            Mage::throwException('Url should be set for renewing expire at');
        }

        $date = $this->getNextExpireAtDate($url);
        $this->getResource()->updateUrl($url, $date);
    }


    /**
     * @return Zend_Date
     */
    public function getNextExpireAtDate($url)
    {
        $currentTimestamp  = Mage::getSingleton('core/date')->gmtTimestamp();

        $urlTtls = Mage::helper('turpentine/varnish')->getUrlTtls();
        $ttl     = Mage::helper('turpentine/varnish')->getDefaultTtl();

        foreach ($urlTtls as $urlTtl) {
            if (preg_match('/' . $urlTtl['regex'] . '/', $url)) {
                $ttl = $urlTtl['ttl'];
                break;
            }
        }

        $expireAtTimestamp = $currentTimestamp + (int) $ttl;
        $date              = new Zend_Date($expireAtTimestamp);

        return $date;
    }

}