<?php
/**
 * Fly_CustomPayment extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Fly
 * @package        Fly_CustomPayment
 * @copyright      Copyright (c) 2017
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Recurring admin edit tabs
 *
 * @category    Fly
 * @package     Fly_CustomPayment
 * @author      Ultimate Module Creator
 */
class Fly_CustomPayment_Block_Adminhtml_Order_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs {
    /**
     * Initialize Tabs
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct() {
        parent::__construct();
        $this->setId('order_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('custompayment')->__('Recurring'));
    }
    /**
     * before render html
     * @access protected
     * @return Fly_CustomPayment_Block_Adminhtml_Order_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml(){
        $this->addTab('form_order', array(
            'label'        => Mage::helper('custompayment')->__('Recurring'),
            'title'        => Mage::helper('custompayment')->__('Recurring'),
            'content'     => $this->getLayout()->createBlock('custompayment/adminhtml_order_edit_tab_form')->toHtml(),
        ));
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve recurring entity
     * @access public
     * @return Fly_CustomPayment_Model_Order
     * @author Ultimate Module Creator
     */
    public function getOrder(){
        return Mage::registry('current_order');
    }
}
