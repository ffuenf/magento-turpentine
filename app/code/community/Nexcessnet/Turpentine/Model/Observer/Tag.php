<?php

/**
 * @author Oleksandr Velykzhanin <alexander.velykzhanin@flagbit.de>
 */
class Nexcessnet_Turpentine_Model_Observer_Tag
{
    /**
     * Product ids that were loaded on page
     * @var array
     */
    protected $_productIds = array();

    /**
     * @param Varien_Event_Observer $observer
     */
    public function setTagHeader(Varien_Event_Observer $observer)
    {
        /** @var Mage_Core_Controller_Varien_Front $front */
        $front = $observer->getFront();
        $response = $front->getResponse();
        $productIds = $this->_productIds;

        if (!empty($productIds)) {
            $productIds = array_unique($productIds);
            // Need | in front and end to make regexp easier
            $response->setHeader('X-Varnish-Tag', '|' . implode('|', $productIds) . '|');
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function setCollectionProductIdsToRegistry(Varien_Event_Observer $observer)
    {
        /** @var Mage_Catalog_Model_Resource_Product_Collection $collection */
        $collection = $observer->getCollection();
        $newIds = $collection->getColumnValues('entity_id');
        $this->_productIds = array_merge($this->_productIds, $newIds);
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function setModelProductIdToRegistry(Varien_Event_Observer $observer)
    {
        $product = $observer->getProduct();
        $newIds = array($product->getId());
        $this->_productIds = array_merge($this->_productIds, $newIds);
    }
}
