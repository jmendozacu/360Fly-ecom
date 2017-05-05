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
 * Subscription widget block
 *
 * @category    Fly
 * @package     Fly_Subscription
 * @author      Ultimate Module Creator
 */
class Fly_Subscription_Block_Package_Widget_View extends Mage_Core_Block_Template implements
    Mage_Widget_Block_Interface
{
    protected $_htmlTemplate = 'fly_subscription/package/widget/view.phtml';

    /**
     * Prepare a for widget
     *
     * @access protected
     * @return Fly_Subscription_Block_Package_Widget_View
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $packageId = $this->getData('package_id');
        if ($packageId) {
            $package = Mage::getModel('fly_subscription/package')
                ->setStoreId(Mage::app()->getStore()->getId())
                ->load($packageId);
            if ($package->getStatus()) {
                $this->setCurrentPackage($package);
                $this->setTemplate($this->_htmlTemplate);
            }
        }
        return $this;
    }
}
