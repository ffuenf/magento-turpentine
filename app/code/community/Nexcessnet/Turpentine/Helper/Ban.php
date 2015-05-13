<?php
/**
* Nexcess.net Turpentine Extension for Magento
* Copyright (C) 2012  Nexcess.net L.L.C.
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License along
* with this program; if not, write to the Free Software Foundation, Inc.,
* 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

class Nexcessnet_Turpentine_Helper_Ban extends Nexcessnet_Turpentine_Helper_Core
{

    /**
     * Get the regex for banning a product page from the cache, including
     * any parent products for configurable/group products
     *
     * @param  Mage_Catalog_Model_Product | Mage_Catalog_Model_Resource_Product_Collection $product
     * @return string
     */
    public function getProductBanRegex($product) {
        $urlPatterns = array();
        if ($product instanceof Mage_Catalog_Model_Resource_Product_Collection) {
            foreach ($product as $productObject) {
                if ($productObject->getUrlKey()) {
                    $urlPatterns[] = $productObject->getUrlKey();
                }
            }
        } else
        {
            if ($product->getUrlKey()) {
                $urlPatterns[] = $product->getUrlKey();
            }
        }
        if (empty($urlPatterns)) {
            $urlPatterns[] = "##_NEVER_MATCH_##";
        }
        $pattern = sprintf('(?:%s)', implode('|', $urlPatterns));
        return $pattern;
    }

    /**
     * Get parent products of a configurable or group product
     *
     * @param  Mage_Catalog_Model_Product $childProduct
     * @return array
     */
    public function getParentProducts($childProduct) {
        $parentProducts = array();
        foreach (array('configurable', 'grouped') as $pType) {
            foreach (Mage::getModel('catalog/product_type_' . $pType)->getParentIdsByChild($childProduct->getId()) as $parentId) {
                $parentProducts[] = Mage::getModel('catalog/product')->load($parentId);
            }
        }
        return $parentProducts;
    }


    /**
     * get a collection of all related products
     *
     * @param Mage_Catalog_Model_Product $product
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function getRelatedProductsCollection(Mage_Catalog_Model_Product $product) {
        /** @var Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection $productCollection */
        $parentProductsCollection = Mage::getResourceModel('catalog/product_collection');
        $parentProductsCollection->addAttributeToSelect('url_key');
        $parentProductsCollection->joinField('relation',
        'catalog/product_relation',
        'parent_id',
        'parent_id=entity_id',
        '{{table}}.child_id=' . $product->getId(),
        'inner');
        $parentProductsCollection->load();
        $parentProductsCollection->addItem($product);
        return $parentProductsCollection;
    }
}
