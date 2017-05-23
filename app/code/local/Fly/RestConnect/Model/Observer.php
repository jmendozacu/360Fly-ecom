<?php

class Fly_RestConnect_Model_Observer extends Varien_Object
{
    /*public function salesQuoteItemSetCustomAttribute($observer)
    {
        $quoteItem = $observer->getQuoteItem();
        $product = $observer->getProduct();
        $quoteItem->setCustomAttribute($product->getStorage());
		return $this;
    }*/
	public function salesAttribute($observer)
    {
	
		$profileIds = Mage::getSingleton('checkout/session')->getLastRecurringProfileIds();

		if ($profileIds && is_array($profileIds)) {
        $collection = Mage::getModel('sales/recurring_profile')->getCollection()
            ->addFieldToFilter('profile_id', array('in' => $profileIds));
        $profiles = array();
        foreach ($collection as $profile) {

			$profiles[]= $profile;
			//$profiledata = Mage::getModel('sales/recurring_profile')->load($profile->getId());
			
			$profiledata = Mage::getModel('sales/recurring_profile')->load($profile->getId());
			
			$productid = $profiledata['order_item_info']['product_id'];
			
			$orderinfo = $profiledata['order_item_info'];
			
			// set storage value to profile
				$product = Mage::getModel('catalog/product')->load($productid);
				if($product->getIsTopup())
				{
					$istopup = $product->getIsTopup();
					$orderinfo['topup'] = 'Yes';
				}
				else{
					$orderinfo['topup'] = 'No';
				}
				$orderinfo['storage'] = $product->getAttributeText('storage');
				$profiledata->setOrderItemInfo(serialize($orderinfo));
				$profiledata->save();
			
			
			// Suspend previous subscriptions if any
			if($istopup != 1)
			{
				$collection = Mage::getModel('sales/recurring_profile')->getCollection()
					->addFieldToFilter('customer_id', array('eq' => $profiledata['customer_id']))
					->addFieldToFilter('state', array('eq' => 'active'))
					->addFieldToFilter('profile_id', array('neq' => $profile->getId()));
					if($collection)
					{
						foreach($collection as $profile)
						{
							$profile->setState('suspended');
							$profile->save();
						}
					}
				}
			}
        }
 	
 
    }
}