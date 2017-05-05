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
 * Subscription front contrller
 *
 * @category    Fly
 * @package     Fly_Subscription
 * @author      Ultimate Module Creator
 */
class Fly_Subscription_PackageController extends Mage_Core_Controller_Front_Action
{

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
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if (Mage::helper('fly_subscription/package')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('fly_subscription')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'packages',
                    array(
                        'label' => Mage::helper('fly_subscription')->__('Subscriptions'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('fly_subscription/package')->getPackagesUrl());
        }
        if ($headBlock) {
            $headBlock->setTitle(Mage::getStoreConfig('fly_subscription/package/meta_title'));
            $headBlock->setKeywords(Mage::getStoreConfig('fly_subscription/package/meta_keywords'));
            $headBlock->setDescription(Mage::getStoreConfig('fly_subscription/package/meta_description'));
        }
        $this->renderLayout();
    }

    /**
     * init Subscription
     *
     * @access protected
     * @return Fly_Subscription_Model_Package
     * @author Ultimate Module Creator
     */
    protected function _initPackage()
    {
        $packageId   = $this->getRequest()->getParam('id', 0);
        $package     = Mage::getModel('fly_subscription/package')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($packageId);
        if (!$package->getId()) {
            return false;
        } elseif (!$package->getStatus()) {
            return false;
        }
        return $package;
    }

    /**
     * view subscription action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function viewAction()
    {
        $package = $this->_initPackage();
        if (!$package) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_package', $package);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('subscription-package subscription-package' . $package->getId());
        }
        if (Mage::helper('fly_subscription/package')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label'    => Mage::helper('fly_subscription')->__('Home'),
                        'link'     => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'packages',
                    array(
                        'label' => Mage::helper('fly_subscription')->__('Subscriptions'),
                        'link'  => Mage::helper('fly_subscription/package')->getPackagesUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'package',
                    array(
                        'label' => $package->getCustomerId(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $package->getPackageUrl());
        }
        if ($headBlock) {
            if ($package->getMetaTitle()) {
                $headBlock->setTitle($package->getMetaTitle());
            } else {
                $headBlock->setTitle($package->getCustomerId());
            }
            $headBlock->setKeywords($package->getMetaKeywords());
            $headBlock->setDescription($package->getMetaDescription());
        }
        $this->renderLayout();
    }

    /**
     * subscriptions rss list action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function rssAction()
    {
        if (Mage::helper('fly_subscription/package')->isRssEnabled()) {
            $this->getResponse()->setHeader('Content-type', 'text/xml; charset=UTF-8');
            $this->loadLayout(false);
            $this->renderLayout();
        } else {
            $this->getResponse()->setHeader('HTTP/1.1', '404 Not Found');
            $this->getResponse()->setHeader('Status', '404 File not found');
            $this->_forward('nofeed', 'index', 'rss');
        }
    }

    /**
     * Submit new comment action
     * @access public
     * @author Ultimate Module Creator
     */
    public function commentpostAction()
    {
        $data   = $this->getRequest()->getPost();
        $package = $this->_initPackage();
        $session    = Mage::getSingleton('core/session');
        if ($package) {
            if ($package->getAllowComments()) {
                if ((Mage::getSingleton('customer/session')->isLoggedIn() ||
                    Mage::getStoreConfigFlag('fly_subscription/package/allow_guest_comment'))) {
                    $comment  = Mage::getModel('fly_subscription/package_comment')->setData($data);
                    $validate = $comment->validate();
                    if ($validate === true) {
                        try {
                            $comment->setPackageId($package->getId())
                                ->setStatus(Fly_Subscription_Model_Package_Comment::STATUS_PENDING)
                                ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                                ->setStores(array(Mage::app()->getStore()->getId()))
                                ->save();
                            $session->addSuccess($this->__('Your comment has been accepted for moderation.'));
                        } catch (Exception $e) {
                            $session->setPackageCommentData($data);
                            $session->addError($this->__('Unable to post the comment.'));
                        }
                    } else {
                        $session->setPackageCommentData($data);
                        if (is_array($validate)) {
                            foreach ($validate as $errorMessage) {
                                $session->addError($errorMessage);
                            }
                        } else {
                            $session->addError($this->__('Unable to post the comment.'));
                        }
                    }
                } else {
                    $session->addError($this->__('Guest comments are not allowed'));
                }
            } else {
                $session->addError($this->__('This subscription does not allow comments'));
            }
        }
        $this->_redirectReferer();
    }
}
