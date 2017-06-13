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
 * Recurring model
 *
 * @category    Fly
 * @package     Fly_CustomPayment
 * @author      Ultimate Module Creator
 */
class Fly_CustomPayment_Model_Order
    extends Mage_Core_Model_Abstract {
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'custompayment_order';
    const CACHE_TAG = 'custompayment_order';
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'custompayment_order';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'order';
    /**
     * constructor
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function _construct(){
        parent::_construct();
        $this->_init('custompayment/order');
    }
    /**
     * before save recurring
     * @access protected
     * @return Fly_CustomPayment_Model_Order
     * @author Ultimate Module Creator
     */
    protected function _beforeSave(){
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()){
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }
    /**
     * save order relation
     * @access public
     * @return Fly_CustomPayment_Model_Order
     * @author Ultimate Module Creator
     */
    protected function _afterSave() {
        return parent::_afterSave();
    }
    /**
     * get default values
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getDefaultValues() {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
}
