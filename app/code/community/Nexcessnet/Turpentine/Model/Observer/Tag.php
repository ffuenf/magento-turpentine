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
    protected $_productIds = [];

    /**
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function setTagHeader(Varien_Event_Observer $observer)
    {
        /** @var Mage_Core_Controller_Varien_Front $front */
        $front = $observer->getFront();
        $response = $front->getResponse();
        $productIds = $this->getProductIds();

        if (!empty($productIds)) {
            // Need | in front and end to make regexp easier
            $response->setHeader('X-Varnish-Tag', '|' . implode('|', $productIds) . '|');
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function setCollectionProductIdsToRegistry(Varien_Event_Observer $observer)
    {
        /** @var Mage_Catalog_Model_Resource_Product_Collection $collection */
        $collection = $observer->getCollection();
        // Do not add to big product lists ("Allowed memory size ... exhausted" problem)
        if ($collection->count() === 0 || $collection->count() > 1000) {
            return;
        }
        $newIds = $collection->getColumnValues('entity_id');
        $this->addProductIds($newIds);
    }

    /**
     * @param Varien_Event_Observer $observer
     * @return void
     */
    public function setModelProductIdToRegistry(Varien_Event_Observer $observer)
    {
        /** @var Mage_Catalog_Model_Product $product */
        $product = $observer->getProduct();
        if (empty($product) || empty($product->getId())) {
            return;
        }
        $newIds = [$product->getId()];
        $this->addProductIds($newIds);
    }

    /**
     * @param array $productIds
     * @return void
     */
    protected function addProductIds(array $productIds)
    {
        $this->_productIds = array_merge($this->_productIds, $productIds);
        $this->_productIds = array_unique($this->_productIds);
    }

    /**
     * @return array
     */
    protected function getProductIds()
    {
        return $this->_productIds;
    }
}
