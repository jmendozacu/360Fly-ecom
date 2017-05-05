<?php
/**
* Extended OAuth Authorize Controller
*/
require_once Mage::getModuleDir('controllers', 'Mage_Oauth') . DS . 'AuthorizeController.php';
class ES_CoreExtended_AuthorizeController extends Mage_Oauth_AuthorizeController 
{

    protected function _initForm($simple = false) 
    {
        $server = Mage::getModel('oauth/server');
        $session = Mage::getSingleton($this->_sessionName);
        $isException = false;
        try {
            $server->checkAuthorizeRequest();
        } catch (Mage_Core_Exception $e) {
            $session->addError($e->getMessage());
        } catch (Mage_Oauth_Exception $e) {
            $isException = true;
            $session->addException($e, $this->__('An error occurred. Your authorization request is invalid.'));
        } catch (Exception $e) {
            $isException = true;
            $session->addException($e, $this->__('An error occurred.'));
        }
        /* check user credentials*/
        
        Mage::app('default');
        umask(0);
        Mage::getSingleton('core/session', array('name' => 'frontend'));

        $session = Mage::getSingleton('customer/session');

        $session->start();
        $email = $_GET['username'];
        $password = $_GET['password'];
		
		//$email = 'kiran.kayat@lntinfotech.com';
        //$password = '123456';
		
		//exit;

            try {
                $session->login($email, $password);
            } catch (Mage_Core_Exception $e) {
                switch ($e->getCode()) {
                    case Mage_Customer_Model_Customer::EXCEPTION_EMAIL_NOT_CONFIRMED:
                        $value = Mage::helper('customer')->getEmailConfirmationUrl($email);
                        $message = Mage::helper('customer')->__('This account is not confirmed. <a href="%s">Click here</a> to resend confirmation email.', $value);
                        break;
                    case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD:
                        $message = $e->getMessage();
                        break;
                    default:
                        $message = $e->getMessage();
                }
                $session->addError($message);
                
            } catch (Exception $e) {
                
                 Mage::logException($e); 
            }

        $logged = $session->isLoggedIn();
        if ($logged) 
        {
		//echo "test";
            $helper = Mage::helper('oauth');
            $session = Mage::getSingleton($this->_sessionName);
            
            try {
                $server = Mage::getModel('oauth/server');
				
                $token = $server->authorizeToken($session->getCustomerId(), Mage_Oauth_Model_Token::USER_TYPE_CUSTOMER);
				
                if (($callback = $helper->getFullCallbackUrl($token))) 
                {
                    $this->_redirectUrl($callback . ($simple ? '&simple=1' : ''));
                    return $this;
                } else {
                    $block->setVerifier($token->getVerifier());
                    $session->addSuccess($this->__('Authorization confirmed.'));
                }
            } catch (Mage_Core_Exception $e) {
                $session->addError($e->getMessage());
            } catch (Mage_Oauth_Exception $e) {
                $session->addException($e, $this->__('An error occurred. Your authorization request is invalid.'));
            } catch (Exception $e) {
                $session->addException($e, $this->__('An error occurred on confirm authorize.'));
            }
			
            $this->_initLayoutMessages($this->_sessionName);
            $this->renderLayout();

            return $this;
        } else {
            $token = $server->checkAuthorizeRequest();
            $helper = Mage::helper('oauth');
            $callback = $helper->getFullCallbackUrl($token, true);
            $this->_redirectUrl($callback . '&siteCredError=1' );
            return $this;
            
        }

    }
/*
    override base index function
 *  */
    public function indexAction() 
    {
		$this->_initForm();
        $this->_initLayoutMessages($this->_sessionName);
        $this->renderLayout();
    }

}
