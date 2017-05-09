<?php
		umask(0);
		require("./app/Mage.php");
		Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

		$customerid = $_REQUEST['uuid'];
		$planid = $_REQUEST['planid'];
		
		
		$header_token = $_REQUEST['token'];
		if($header_token)
		{
			
			$oauthCollection = Mage::getModel('oauth/token')->getCollection()->addFieldToFilter('token',$header_token)->addFieldToFilter('revoked','0')->getFirstItem();
			$customerid = $oauthCollection->getCustomerId(); //For customer type account
		
		}
		else
		{
			$message['error'] = 'Invalid token';
			echo Mage::helper('core')->jsonEncode($message);
			exit;
		}
		
		
		if($customerid && $planid)
			{
			
				$customer = Mage::getModel('customer/customer');
				$customer->load($customerid);
				
								
				$customer = Mage::getModel('customer/customer')->load($customerid);
				$product = Mage::getModel('catalog/product')->setStoreId(1)->load($planid);
				// load quote by customer and store...
				$quote = Mage::getModel('sales/quote')->setStoreId(1)->loadByCustomer($customerid);
				//echo "quote";
				$quote->addProduct($product, 1);
				//echo "product added";
				$quote->setIsActive(1);
				$quote->collectTotals()->save();
				
				$url = Mage::getBaseurl().'restconnet/restapi/placeorder';
				$message['success'] = $url;
				echo Mage::helper('core')->jsonEncode($message);
				//echo 1;
				exit;
				
			}
			else
			{
				$message['error'] = 'Invalid token';
				echo Mage::helper('core')->jsonEncode($message);
				exit;
			}

?>