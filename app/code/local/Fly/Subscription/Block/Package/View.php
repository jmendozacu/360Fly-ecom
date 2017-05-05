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
 * Subscription view block
 *
 * @category    Fly
 * @package     Fly_Subscription
 * @author      Ultimate Module Creator
 */
class Fly_Subscription_Block_Package_View extends Mage_Core_Block_Template
{
    /**
     * get the current subscription
     *
     * @access public
     * @return mixed (Fly_Subscription_Model_Package|null)
     * @author Ultimate Module Creator
     */
    public function getCurrentPackage()
    {
        return Mage::registry('current_package');
    }
}
