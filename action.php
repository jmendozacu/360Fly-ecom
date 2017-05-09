<?php

		umask(0);
		require("./app/Mage.php");
		Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

		$customerid = $_REQUEST['uuid'];
		//exit;
		$customer = Mage::getModel('customer/customer');
		$customer->load($customerid);
		
		$profileid = $_REQUEST['profile'];
		$action = $_REQUEST['action'];
		
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
		
		//exit;
		if($profileid){
		
		
		$profile = Mage::getModel('sales/recurring_profile')->load($profileid);
		Mage::register('current_customer', $customer);
		Mage::register('current_recurring_profile', $profile);
		
		if($profile->getCustomerId())
		{
		
			if($customerid == $profile->getCustomerId())
			{
				switch ($action) {
					case 'cancel':
						$profile->cancel();
						$message['success'] = 'Subscription Profile has been cancelled.';
						break;
					case 'suspend':
						$profile->suspend();
						$message['success'] = 'Subscription Profile has been suspended.';
						break;
					case 'activate':
						$profile->activate();
						$message['success'] = 'Subscription Profile has been activated.';
						break;
				}
				//$profile->activate();
				
				//$message['success'] = 'Subscription Profile has been cancelled.';
				echo Mage::helper('core')->jsonEncode($message);
				exit;
			}
		}
		}

?>