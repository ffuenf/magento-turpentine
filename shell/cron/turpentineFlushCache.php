<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'abstract.php';

class TurpentineFlushCache extends Mage_Shell_Abstract
{
    public function run()
    {
        if ($this->getArg('current')) {

            foreach (Mage::app()->getStores() as $store) {
                $this->_flushCurrentChanges($store);
            }

        }elseif ($this->getArg('all')) {

            foreach(Mage::app()->getStores() as $store){
                $this->_flushAllSpecialPrices($store);
            }

        }else{
            echo $this->usageHelp();
        }
    }

    /**
     * @param Mage_Core_Model_Store $store
     */
    protected function _flushAllSpecialPrices($store)
    {


        /** @var Mage_Catalog_Model_Resource_Product_Collection $products */
        $products = Mage::getResourceModel('catalog/product_collection')
            ->setStoreId($store->getId())
            ->addAttributeToFilter(
                'special_from_date', array('lteq' => now(true))
            )->addAttributeToFilter(
                array(
                    array('attribute' => 'special_to_date', 'gteq' => now(true)),
                    array('attribute' => 'special_to_date', 'null' => true)
                )
            )->addWebsiteFilter($store->getWebsiteId());

        $size = $products->getSize();
        if($size) {
            $msg = sprintf('process store %s and %s product(s) with all special prices', $store->getCode(), $size);
            Mage::getSingleton('core/resource_iterator')->walk($products->getSelect(), array(array($this, 'iteratorCallback')), array('size' => $size, 'msg' => $msg, 'store' => $store));
            echo PHP_EOL;
        }
    }

    protected function _flushCurrentChanges($store)
    {
        /** @var Mage_Catalog_Model_Resource_Product_Collection $products */
        $products = Mage::getResourceModel('catalog/product_collection')
            ->addStoreFilter($store->getId())
            ->addAttributeToFilter(
                array(
                    array('attribute' => 'special_from_date', 'eq' => now(true)),
                    array('attribute' => 'special_to_date', 'eq' => now(true))
                )
            )->addWebsiteFilter($store->getWebsiteId());

        $size = $products->getSize();
        if($size) {
            $msg = sprintf('process store %s and %s product(s) with special prices', $store->getCode(), $size);
            Mage::getSingleton('core/resource_iterator')->walk($products->getSelect(), array(array($this, 'iteratorCallback')), array('size' => $size, 'msg' => $msg, 'store' => $store));
            echo PHP_EOL;
        }
    }


    public function iteratorCallback($args)
    {
        $product = Mage::getModel('catalog/product')->setStoreId($args['store']->getId())->load($args['row']['entity_id']);
        if($product->getId()) {
            Mage::getModel('turpentine/observer_ban')->banProductPageCache(new Varien_Object(array('product' => $product)));
            echo sprintf('%s - %s%% %s/%s current SKU: %s',$args['msg'], round(100/$args['size'] * ($args['idx'] +1), 0), $args['idx'] +1, $args['size'], $product->getSku()) . "\r";
        }
        $product->reset();
    }


    /**
     * Get the usage string
     *
     * @return string
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php turpentineFlushCache.php -- [options]

        current          flush products where special prices will change today
        all              flush all products with special prices

        help                          This help
USAGE;
    }
}

$turpentineUrlCacheStatus = new TurpentineFlushCache();
$turpentineUrlCacheStatus->run();
