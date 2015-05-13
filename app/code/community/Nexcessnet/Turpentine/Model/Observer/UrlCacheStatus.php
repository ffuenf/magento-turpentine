<?php

/**
* Class Nexcessnet_Turpentine_Model_Observer_UrlCacheStatus
*
* @author Oleksandr Velykzhanin <alexander.velykzhanin@flagbit.de>
*/
class Nexcessnet_Turpentine_Model_Observer_UrlCacheStatus
{

    /**
     * Add url cache for pages that should be cached by Varnish
     *
     * @param Varien_Event_Observer $eventObject
     */
    public function addUrlCache(Varien_Event_Observer $eventObject) {
        if (!Mage::helper('turpentine/varnish')->shouldResponseUseVarnish()
            || Mage::registry('turpentine_nocache_flag')
            || http_response_code() == 404
            || Mage::helper('turpentine/esi')->isEsiRequest()
            || !Mage::helper('turpentine/crawler')->getSmartCrawlerEnabled()
            || $this->_hasInvalidParameters()
        ) {
            return;
        }
        $url = Mage::helper('core/url')->getCurrentUrl();
        Mage::getModel('turpentine/urlCacheStatus')->renewExpireAt($url);
    }

    /**
     * Check if request has invalid(not whitelisted) GET parameters
     *
     * @return bool
     */
    protected function _hasInvalidParameters() {
        $whitelistGetParams = Mage::helper('turpentine/data')->cleanExplode(',', Mage::getStoreConfig('turpentine_vcl/params/crawler_whitelist_get_params'));
        $whitelistGetParams = array_map('strtolower', $whitelistGetParams);
        $getLowercase = array_map('strtolower', array_keys($_GET));
        if (count($getLowercase) && count(array_diff($getLowercase, $whitelistGetParams))) {
            return true;
        }
        return false;
    }
}
