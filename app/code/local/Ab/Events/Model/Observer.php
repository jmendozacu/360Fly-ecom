<?php
 
class Ab_Events_Model_Observer
{
    public function logCartAdd() {
 
        $product = Mage::getModel('catalog/product')
                        ->load(Mage::app()->getRequest()->getParam('product', 0));
 
        if (!$product->getId()) {
            return;
        }
 
        $categories = $product->getCategoryIds();
 
        Mage::getModel('core/session')->setProductToShoppingCart(
            new Varien_Object(array(
                'id' => $product->getId(),
                'qty' => Mage::app()->getRequest()->getParam('qty', 1),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'fprice' => Mage::getModel('directory/currency')->format($product->getFinalPrice(), array('display'=>Zend_Currency::NO_SYMBOL),
		false),
                /* 'category_name' => Mage::getModel('catalog/category')->load($categories[0])->getName(), */
                'currency' => Mage::app()->getStore()->getCurrentCurrencyCode()
            ))
        );
    }
	
	public function logCustomerSave(){
		Mage::getModel('core/session')->setCustomerRegistrationFlag(true);
	}
}