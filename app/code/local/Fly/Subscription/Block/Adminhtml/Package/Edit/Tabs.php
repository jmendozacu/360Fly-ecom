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
 * Subscription admin edit tabs
 *
 * @category    Fly
 * @package     Fly_Subscription
 * @author      Ultimate Module Creator
 */
class Fly_Subscription_Block_Adminhtml_Package_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Initialize Tabs
     *
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('package_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('fly_subscription')->__('Subscription'));
    }

    /**
     * before render html
     *
     * @access protected
     * @return Fly_Subscription_Block_Adminhtml_Package_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'form_package',
            array(
                'label'   => Mage::helper('fly_subscription')->__('Subscription'),
                'title'   => Mage::helper('fly_subscription')->__('Subscription'),
                'content' => $this->getLayout()->createBlock(
                    'fly_subscription/adminhtml_package_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        $this->addTab(
            'form_meta_package',
            array(
                'label'   => Mage::helper('fly_subscription')->__('Meta'),
                'title'   => Mage::helper('fly_subscription')->__('Meta'),
                'content' => $this->getLayout()->createBlock(
                    'fly_subscription/adminhtml_package_edit_tab_meta'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_package',
                array(
                    'label'   => Mage::helper('fly_subscription')->__('Store views'),
                    'title'   => Mage::helper('fly_subscription')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'fly_subscription/adminhtml_package_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve subscription entity
     *
     * @access public
     * @return Fly_Subscription_Model_Package
     * @author Ultimate Module Creator
     */
    public function getPackage()
    {
        return Mage::registry('current_package');
    }
}
