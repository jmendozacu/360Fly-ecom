<?php

		umask(0);
		require("../app/Mage.php");
		Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

		$customerid = $_REQUEST['uuid'];
		
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
		$flag = 1;
		$updated = 0;
		if($profileid){
		
		
		$profile = Mage::getModel('sales/recurring_profile')->load($profileid);
		
		if(count($profile)<=0 || $customerid != $profile->getCustomerId())
		{
			$profile = Mage::getModel('custompayment/order')->load($profileid);
			
			$flag = 2;
		}
		//Mage::register('current_customer', $customer);
		//Mage::register('current_recurring_profile', $profile);
		
		if($profile->getCustomerId())
		{
		
			if($customerid == $profile->getCustomerId())
			{
				switch ($action) {
					case 'cancel':						
					case 'suspend':
						//$profile->suspend();
						
						if($flag != 2)
						{
						$collection = Mage::getModel('sales/recurring_profile')->getCollection()
						->addFieldToFilter('customer_id', array('eq' => $customerid))
						->addFieldToFilter('state', array('eq' => 'active'))
						->setOrder('created_at', 'DESC');
						
						foreach ($collection as $profiledata) {
							//$profiledata = Mage::getModel('sales/recurring_profile')->load($profileid);
							$profiledata->suspend();
							$updated = 1;
						}
						}
						if($flag == 2)
						{
							$profiles = Mage::getModel('custompayment/order')->getCollection()
							->addFieldToFilter('customer_id',$customerid)->addFieldToFilter('profile_id',$profileid)->addFieldToFilter('state','active')->setOrder('created_at', 'DESC')->setPageSize(1);
							foreach($profiles as $profile)
							{
								$id = $profile->getProfileId();
								$updateprofile = Mage::getModel('custompayment/order')->load($id);
								$updateprofile->setState('suspended');
								$updateprofile->save();
								$updated = 1;
							}
						}
						if($updated == 1)
							$message['success'] = 'Subscription Profile has been suspended.';
						else
							$message['error'] = 'Profile not found.';
						break;
					case 'activate':
						if($flag != 2)
						{
						$collection = Mage::getModel('sales/recurring_profile')->getCollection()
						->addFieldToFilter('customer_id', array('eq' => $customerid))
						->addFieldToFilter('state', array('eq' => 'suspended'))
						->setOrder('created_at', 'DESC');
						
						foreach ($collection as $profiledata) {
							//$profiledata = Mage::getModel('sales/recurring_profile')->load($profileid);
							$profiledata->activate();
							$updated = 1;
						}
						}
						if($flag == 2)
						{
							$profiles = Mage::getModel('custompayment/order')->getCollection()
							->addFieldToFilter('customer_id',$customerid)->addFieldToFilter('profile_id',$profileid)->addFieldToFilter('state','suspended')->setOrder('created_at', 'DESC')->setPageSize(1);
							foreach($profiles as $profile)
							{
								$id = $profile->getProfileId();
								$updateprofile = Mage::getModel('custompayment/order')->load($id);
								$updateprofile->setState('active');
								$updateprofile->save();
								$updated = 1;
							}
						}
						if($updated == 1)
							$message['success'] = 'Subscription Profile has been activated.';
						else
							$message['error'] = 'Profile not found.';
						break;
					default:
						$message['error'] = 'Invalid action.';
						break;
				}
				
				echo Mage::helper('core')->jsonEncode($message);
				exit;
			}
		}
		}

?>