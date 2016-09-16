<?php
/**
 *
 * Webshopapps Shipping Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * Shipper HQ Shipping
 *
 * @category ShipperHQ
 * @package ShipperHQ_Shipping_Carrier
 * @copyright Copyright (c) 2014 Zowta LLC (http://www.ShipperHQ.com)
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @author ShipperHQ Team sales@shipperhq.com
 */

/**
 * Shipper shipping model
 *
 * @category ShipperHQ
 * @package ShipperHQ_Shipper
 */
class Shipperhq_Freight_Adminhtml_Order_FreightController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @var Mage_Sales_Model_Quote
     */
    protected $_quote = null;

    protected $_checkoutSession;


//    protected function _ajaxRedirectResponse()
//    {
//        $this->getResponse()
//            ->setHeader('HTTP/1.1', '403 Session Expired')
//            ->setHeader('Login-Required', 'true')
//            ->sendResponse();
//        return $this;
//    }

    /**
     * Validate ajax request and redirect on failure
     *
     * @return bool
     */
//    protected function _expireAjax()
//    {
//        if (!$this->_getQuote()->hasItems()
//            || $this->_getQuote()->getHasError() //|| $this->_getOnepage()->getQuote()->getIsMultiShipping()
//        ) {
//            $this->_ajaxRedirectResponse();
//            return true;
//        }
//        $action = $this->getRequest()->getActionName();
//
//        if ($this->_getCheckout()->getCartWasUpdated(true)
//            && !in_array($action, array('index', 'progress', 'getAccessorialRates'))) {
//            $this->_ajaxRedirectResponse();
//            return true;
//        }
//
//        return false;
//    }

    public function getAccessorialRatesAction()
    {
        if ($this->getRequest()->isGet()) {
            $response = Mage::getSingleton('shipperhq_freight/service_accessorials')->getAccessorialRates(
                $this->_getQuote(), $this->getRequest()->getParams()
            );
            $response = Mage::helper('core')->jsonEncode($response);

            $this->getResponse()->setBody($response);
        } else {
            // If someone sends post?
            $this->getResponse()->setBody('{}');
        }

    }

//    protected function _getShippingMethodsHtml()
//    {
//        $layout = $this->getLayout();
//        $update = $layout->getUpdate();
//        $update->load('onestepcheckout_ajax_save_billing');
//        $layout->generateXml();
//        $layout->generateBlocks();
//        $output = $layout->getOutput();
//
//        return $output;
//    }


    /**
     * Get frontend checkout session object
     *
     * @return Mage_Checkout_Model_Session
     */
//    protected function _getCheckout()
//    {
//        if ($this->_quote === null) {
//            $this->_checkoutSession = Mage::getSingleton('checkout/session');
//        }
//        return $this->_checkoutSession;
//    }
//
//    protected function _getQuote()
//    {
//        if ($this->_quote === null) {
//            return $this->_getCheckout()->getQuote();
//        }
//        return $this->_quote;
//    }

    /**
     * Retrieve quote object
     *
     * @return Mage_Sales_Model_Quote
     */
    protected function _getQuote()
    {
        return Mage::getSingleton('adminhtml/session_quote')->getQuote();
    }

}