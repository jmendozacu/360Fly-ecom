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
 * Subscription abstract REST API handler model
 *
 * @category    Fly
 * @package     Fly_Subscription
 * @author      Ultimate Module Creator
 */
abstract class Fly_Subscription_Model_Api2_Package_Rest extends Fly_Subscription_Model_Api2_Package
{
    /**
     * current subscription
     */
    protected $_package;

    /**
     * retrieve entity
     *
     * @access protected
     * @return array|mixed
     * @author Ultimate Module Creator
     */
    protected function _retrieve() {
        $package = $this->_getPackage();
        $this->_preparePackageForResponse($package);
        return $package->getData();
    }

    /**
     * get collection
     *
     * @access protected
     * @return array
     * @author Ultimate Module Creator
     */
    protected function _retrieveCollection() {
        $collection = Mage::getResourceModel('fly_subscription/package_collection');
        $entityOnlyAttributes = $this->getEntityOnlyAttributes(
            $this->getUserType(),
            Mage_Api2_Model_Resource::OPERATION_ATTRIBUTE_READ
        );
        $availableAttributes = array_keys($this->getAvailableAttributes(
            $this->getUserType(),
            Mage_Api2_Model_Resource::OPERATION_ATTRIBUTE_READ)
        );
        $collection->addFieldToFilter('status', array('eq' => 1));
        $store = $this->_getStore();
        $collection->addStoreFilter($store->getId());
        $this->_applyCollectionModifiers($collection);
        $packages = $collection->load();
        $packages->walk('afterLoad');
        foreach ($packages as $package) {
            $this->_setPackage($package);
            $this->_preparePackageForResponse($package);
        }
        $packagesArray = $packages->toArray();
        $packagesArray = $packagesArray['items'];

        return $packagesArray;
    }

    /**
     * prepare subscription for response
     *
     * @access protected
     * @param Fly_Subscription_Model_Package $package
     * @author Ultimate Module Creator
     */
    protected function _preparePackageForResponse(Fly_Subscription_Model_Package $package) {
        $packageData = $package->getData();
        if ($this->getActionType() == self::ACTION_TYPE_ENTITY) {
            $packageData['url'] = $package->getPackageUrl();
        }
    }

    /**
     * create subscription
     *
     * @access protected
     * @param array $data
     * @return string|void
     * @author Ultimate Module Creator
     */
    protected function _create(array $data) {
        $this->_critical(self::RESOURCE_METHOD_NOT_ALLOWED);
    }

    /**
     * update subscription
     *
     * @access protected
     * @param array $data
     * @author Ultimate Module Creator
     */
    protected function _update(array $data) {
        $this->_critical(self::RESOURCE_METHOD_NOT_ALLOWED);
    }

    /**
     * delete subscription
     *
     * @access protected
     * @author Ultimate Module Creator
     */
    protected function _delete() {
        $this->_critical(self::RESOURCE_METHOD_NOT_ALLOWED);
    }

    /**
     * delete current subscription
     *
     * @access protected
     * @param Fly_Subscription_Model_Package $package
     * @author Ultimate Module Creator
     */
    protected function _setPackage(Fly_Subscription_Model_Package $package) {
        $this->_package = $package;
    }

    /**
     * get current subscription
     *
     * @access protected
     * @return Fly_Subscription_Model_Package
     * @author Ultimate Module Creator
     */
    protected function _getPackage() {
        if (is_null($this->_package)) {
            $packageId = $this->getRequest()->getParam('id');
            $package = Mage::getModel('fly_subscription/package');
            $package->load($packageId);
            if (!($package->getId())) {
                $this->_critical(self::RESOURCE_NOT_FOUND);
            }
            if ($this->_getStore()->getId()) {
                $isValidStore = count(array_intersect(array(0, $this->_getStore()->getId()), $package->getStoreId()));
                if (!$isValidStore) {
                    $this->_critical(self::RESOURCE_NOT_FOUND);
                }
            }
            $this->_package = $package;
        }
        return $this->_package;
    }
}
