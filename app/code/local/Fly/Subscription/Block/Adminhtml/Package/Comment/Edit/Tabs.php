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
 * Subscription comment admin edit tabs
 *
 * @category    Fly
 * @package     Fly_Subscription
 * @author      Ultimate Module Creator
 */
class Fly_Subscription_Block_Adminhtml_Package_Comment_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
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
        $this->setId('package_comment_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('fly_subscription')->__('Subscription Comment'));
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
            'form_package_comment',
            array(
                'label'   => Mage::helper('fly_subscription')->__('Subscription comment'),
                'title'   => Mage::helper('fly_subscription')->__('Subscription comment'),
                'content' => $this->getLayout()->createBlock(
                    'fly_subscription/adminhtml_package_comment_edit_tab_form'
                )
                ->toHtml(),
            )
        );
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addTab(
                'form_store_package_comment',
                array(
                    'label'   => Mage::helper('fly_subscription')->__('Store views'),
                    'title'   => Mage::helper('fly_subscription')->__('Store views'),
                    'content' => $this->getLayout()->createBlock(
                        'fly_subscription/adminhtml_package_comment_edit_tab_stores'
                    )
                    ->toHtml(),
                )
            );
        }
        return parent::_beforeToHtml();
    }

    /**
     * Retrieve comment
     *
     * @access public
     * @return Fly_Subscription_Model_Package_Comment
     * @author Ultimate Module Creator
     */
    public function getComment()
    {
        return Mage::registry('current_comment');
    }
}
