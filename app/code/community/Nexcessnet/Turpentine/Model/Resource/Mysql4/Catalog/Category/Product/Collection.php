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

class Nexcessnet_Turpentine_Model_Resource_Mysql4_Catalog_Category_Product_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract {


    /**
     * Initialize resource model and define main table
     */
    protected function _construct()
    {
        $this->_init('turpentine/catalog_category_product');
    }

    /**
     * Filter by product ids
     *
     * @param array $productIds
     * @return Nexcessnet_Turpentine_Model_Resource_Mysql4_Catalog_Category_Product_Collection
     */
    public function filterAllByProductIds(array $productIds)
    {
        $this->getSelect()
            ->where('product_id in (?)', $productIds)
            ->group('category_id');
        return $this;
    }

    /**
     * get all category ids
     *
     * @return array
     */
    public function getAllCategoryIds()
    {
        if(!$this->isLoaded()){
            $this->load();
        }
        $categoryIds = array();
        foreach($this->getItems() as $item){
            $categoryIds[] = $item->getCategoryId();
        }
        return $categoryIds;
    }

}