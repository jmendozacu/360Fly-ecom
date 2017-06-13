<?php

		umask(0);
		require("../app/Mage.php");
		Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

		$customerid = $_REQUEST['uuid'];
		$storeid = 1;
		$storeid = $_REQUEST['storeid'];
		$planid = $_REQUEST['planid'];
		
		$customer = Mage::getModel('customer/customer');
		$customer->load($customerid);
		
				
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
		$customer_email = $customer->getEmail();
		
	
		$product = Mage::getModel('catalog/product')->load($planid);
		 if ($product->getStorage()) {
			$storage        = $product->getStorage();
			$attributes     = Mage::getModel('catalogsearch/advanced')->getAttributes();
			$attributeArray = array();
			foreach ($attributes as $a) {
				if ($a->getAttributeCode() == 'storage') {
					foreach ($a->getSource()->getAllOptions(false) as $option) {
						
						if ($option['value'] == $storage) {
							
							$product->setStorage($option['label']);
							break;
						}
					}
				}
			}
		}
		
		if($product)
		{
			$recurrng_data = $product->getData('recurring_profile');
		}
		
		
		
		try{
			$profiles = Mage::getModel('custompayment/order')->getCollection()->addFieldToFilter('customer_id',$customerid)
			->addFieldToFilter('state','active');
			
			if(count($profiles)>0)
			{
				foreach($profiles as $profile)
				{
					$id = $profile->getProfileId();
					$updateprofile = Mage::getModel('custompayment/order')->load($id);
					$updateprofile->setState('suspended');
					$updateprofile->save();
					$flag = 1;
				}
			}
			
			if($flag != 1)
			{
				$collection = Mage::getModel('sales/recurring_profile')->getCollection()
					->addFieldToFilter('customer_id', $customerid)->addFieldToFilter('state', 'active');
				if(count($collection)>0)
				{
					foreach ($collection as $profile) {
						$profile = Mage::getModel('sales/recurring_profile')->load($profile->getId());
						Mage::register('current_customer', $customer);
						Mage::register('current_recurring_profile', $profile->getId());
						
						$profile->suspend();
					}
				}
			}
			
			// create new profile entry
			$profile = Mage::getModel('custompayment/order');

			
			$profile->setProfileId(null)
            ->setState('active')
            ->setCustomerId($customerid)
			->setCustomerEmail($customer_email)
            ->setStoreId($storeid)
            ->setMethodCode('mobile')
            ->setCreatedAt(Varien_Date::now())
			->setUpdatedAt(Varien_Date::now())
            ->setReferenceId(null)
            ->setSubscriber_name(null)
            ->setStartDatetime(Varien_Date::now())
            ->setInternalReferenceId()
            ->setScheduleDescription()
            ->setSuspensionThreshold()
			
			
            ->setBillFailedLater($recurrng_data['bill_failed_later'])
            ->setPeriodUnit($recurrng_data['period_unit'])
            ->setPeriodFrequency($recurrng_data['period_frequency'])
            ->setPeriodMaxCycles($recurrng_data['period_max_cycles'])
            
			->setBillingAmount($product->getPrice())
            
			->setTrialPeriodUnit($recurrng_data['trial_period_unit'])
            ->setTrialPeriodFrequency($recurrng_data['trial_period_frequency'])
            ->setTrialPeriodMaxCycles($recurrng_data['trial_period_max_cycles'])
            ->setTrialBillingAmount($recurrng_data['trial_billing_amount'])
			
            ->setCurrencyCode('USD')
            ->setShippingAmount(0)
			
            ->setTaxAmount(0)
            ->setInitAmount($recurrng_data['init_amount'])
            ->setInitMayFail($recurrng_data['init_may_fail'])
					
			->setOrderInfo(null)
			->setOrderItemInfo(serialize((array) $product->getData()))
			->setBillingAddressInfo(null)
			->setShippingAddressInfo(null)
			->setProfileVendorInfo(null)
			->setAdditionalInfo(null);
					
			$profile->save();
			$message['success'] = 'Profile order has been created successfully.';
            echo Mage::helper('core')->jsonEncode($message);
            exit;
			}
			catch(Exception $e){
				$message['error'] = 'Invalid arguments, please verify and resend.';
				echo Mage::helper('core')->jsonEncode($message);
				exit;
			}
	
		
		
		

?>