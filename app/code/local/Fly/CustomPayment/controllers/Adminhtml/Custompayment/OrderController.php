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
 * Recurring admin controller
 *
 * @category    Fly
 * @package     Fly_CustomPayment
 * @author      Ultimate Module Creator
 */
class Fly_CustomPayment_Adminhtml_Custompayment_OrderController
    extends Fly_CustomPayment_Controller_Adminhtml_CustomPayment {
    /**
     * init the order
     * @access protected
     * @return Fly_CustomPayment_Model_Order
     */
    protected function _initOrder(){
        $orderId  = (int) $this->getRequest()->getParam('id');
        $order    = Mage::getModel('custompayment/order');
        if ($orderId) {
            $order->load($orderId);
        }
        Mage::register('current_order', $order);
        return $order;
    }
     /**
     * default action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction() {
        $this->loadLayout();
        $this->_title(Mage::helper('custompayment')->__('Recurring Orders'))
             ->_title(Mage::helper('custompayment')->__('Recurrings'));
        $this->renderLayout();
    }
    /**
     * grid action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction() {
        $this->loadLayout()->renderLayout();
    }
    /**
     * edit recurring - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction() {
        $orderId    = $this->getRequest()->getParam('id');
        $order      = $this->_initOrder();
        if ($orderId && !$order->getId()) {
            $this->_getSession()->addError(Mage::helper('custompayment')->__('This recurring no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getOrderData(true);
        if (!empty($data)) {
            $order->setData($data);
        }
        Mage::register('order_data', $order);
        $this->loadLayout();
        $this->_title(Mage::helper('custompayment')->__('Recurring Orders'))
             ->_title(Mage::helper('custompayment')->__('Recurrings'));
        if ($order->getId()){
            $this->_title($order->getRecurringId());
        }
        else{
            $this->_title(Mage::helper('custompayment')->__('Add recurring'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    /**
     * new recurring action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save recurring - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('order')) {
            try {
                $order = $this->_initOrder();
                $order->addData($data);
                $order->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('custompayment')->__('Recurring was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $order->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setOrderData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custompayment')->__('There was a problem saving the recurring.'));
                Mage::getSingleton('adminhtml/session')->setOrderData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custompayment')->__('Unable to find recurring to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * delete recurring - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $order = Mage::getModel('custompayment/order');
                $order->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('custompayment')->__('Recurring was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custompayment')->__('There was an error deleteing recurring.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custompayment')->__('Could not find recurring to delete.'));
        $this->_redirect('*/*/');
    }
    /**
     * mass delete recurring - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction() {
        $orderIds = $this->getRequest()->getParam('order');
        if(!is_array($orderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custompayment')->__('Please select recurrings to delete.'));
        }
        else {
            try {
                foreach ($orderIds as $orderId) {
                    $order = Mage::getModel('custompayment/order');
                    $order->setId($orderId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('custompayment')->__('Total of %d recurrings were successfully deleted.', count($orderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custompayment')->__('There was an error deleting recurrings.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass status change - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massStatusAction(){
        $orderIds = $this->getRequest()->getParam('order');
        if(!is_array($orderIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custompayment')->__('Please select recurrings.'));
        }
        else {
            try {
                foreach ($orderIds as $orderId) {
                $order = Mage::getSingleton('custompayment/order')->load($orderId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d recurrings were successfully updated.', count($orderIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('custompayment')->__('There was an error updating recurrings.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * export as csv - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportCsvAction(){
        $fileName   = 'order.csv';
        $content    = $this->getLayout()->createBlock('custompayment/adminhtml_order_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction(){
        $fileName   = 'order.xls';
        $content    = $this->getLayout()->createBlock('custompayment/adminhtml_order_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction(){
        $fileName   = 'order.xml';
        $content    = $this->getLayout()->createBlock('custompayment/adminhtml_order_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
}
