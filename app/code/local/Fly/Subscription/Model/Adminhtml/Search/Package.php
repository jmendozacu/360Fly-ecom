<?php
/**
 * Fly_Subscription extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Fly
 * @package        Fly_Subscription
 * @copyright      Copyright (c) 2017
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Admin search model
 *
 * @category    Fly
 * @package     Fly_Subscription
 * @author      Ultimate Module Creator
 */
class Fly_Subscription_Model_Adminhtml_Search_Package extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return Fly_Subscription_Model_Adminhtml_Search_Package
     * @author Ultimate Module Creator
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('fly_subscription/package_collection')
            ->addFieldToFilter('customer_id', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $package) {
            $arr[] = array(
                'id'          => 'package/1/'.$package->getId(),
                'type'        => Mage::helper('fly_subscription')->__('Subscription'),
                'name'        => $package->getCustomerId(),
                'description' => $package->getCustomerId(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/subscription_package/edit',
                    array('id'=>$package->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
