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
 * Subscription admin controller
 *
 * @category    Fly
 * @package     Fly_Subscription
 * @author      Ultimate Module Creator
 */
class Fly_Subscription_Adminhtml_Subscription_PackageController extends Fly_Subscription_Controller_Adminhtml_Subscription
{
    /**
     * init the subscription
     *
     * @access protected
     * @return Fly_Subscription_Model_Package
     */
    protected function _initPackage()
    {
        $packageId  = (int) $this->getRequest()->getParam('id');
        $package    = Mage::getModel('fly_subscription/package');
        if ($packageId) {
            $package->load($packageId);
        }
        Mage::register('current_package', $package);
        return $package;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('fly_subscription')->__('Subscribers'))
             ->_title(Mage::helper('fly_subscription')->__('Subscriptions'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit subscription - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $packageId    = $this->getRequest()->getParam('id');
        $package      = $this->_initPackage();
        if ($packageId && !$package->getId()) {
            $this->_getSession()->addError(
                Mage::helper('fly_subscription')->__('This subscription no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getPackageData(true);
        if (!empty($data)) {
            $package->setData($data);
        }
        Mage::register('package_data', $package);
        $this->loadLayout();
        $this->_title(Mage::helper('fly_subscription')->__('Subscribers'))
             ->_title(Mage::helper('fly_subscription')->__('Subscriptions'));
        if ($package->getId()) {
            $this->_title($package->getCustomerId());
        } else {
            $this->_title(Mage::helper('fly_subscription')->__('Add subscription'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new subscription action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save subscription - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('package')) {
            try {
                $package = $this->_initPackage();
                $package->addData($data);
                $package->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('fly_subscription')->__('Subscription was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $package->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setPackageData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('fly_subscription')->__('There was a problem saving the subscription.')
                );
                Mage::getSingleton('adminhtml/session')->setPackageData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('fly_subscription')->__('Unable to find subscription to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete subscription - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $package = Mage::getModel('fly_subscription/package');
                $package->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('fly_subscription')->__('Subscription was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('fly_subscription')->__('There was an error deleting subscription.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('fly_subscription')->__('Could not find subscription to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete subscription - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $packageIds = $this->getRequest()->getParam('package');
        if (!is_array($packageIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('fly_subscription')->__('Please select subscriptions to delete.')
            );
        } else {
            try {
                foreach ($packageIds as $packageId) {
                    $package = Mage::getModel('fly_subscription/package');
                    $package->setId($packageId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('fly_subscription')->__('Total of %d subscriptions were successfully deleted.', count($packageIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('fly_subscription')->__('There was an error deleting subscriptions.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massStatusAction()
    {
        $packageIds = $this->getRequest()->getParam('package');
        if (!is_array($packageIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('fly_subscription')->__('Please select subscriptions.')
            );
        } else {
            try {
                foreach ($packageIds as $packageId) {
                $package = Mage::getSingleton('fly_subscription/package')->load($packageId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d subscriptions were successfully updated.', count($packageIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('fly_subscription')->__('There was an error updating subscriptions.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportCsvAction()
    {
        $fileName   = 'package.csv';
        $content    = $this->getLayout()->createBlock('fly_subscription/adminhtml_package_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction()
    {
        $fileName   = 'package.xls';
        $content    = $this->getLayout()->createBlock('fly_subscription/adminhtml_package_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction()
    {
        $fileName   = 'package.xml';
        $content    = $this->getLayout()->createBlock('fly_subscription/adminhtml_package_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('customer/fly_subscription/package');
    }
}
