<?php

/**
 * Product:       Xtento_OrderExport (1.9.6)
 * ID:            UkPw/HNCTGTNeNACl67A1tsc5/yF+olcWhzGXPJ/t28=
 * Packaged:      2016-09-21T14:35:40+00:00
 * Last Modified: 2013-02-07T23:24:31+01:00
 * File:          app/code/local/Xtento/OrderExport/Model/Export/Condition/Item.php
 * Copyright:     Copyright (c) 2016 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_Export_Condition_Item extends Mage_SalesRule_Model_Rule_Condition_Address
{
    public function loadAttributeOptions()
    {
        $attributes = array();
        $attributes = array_merge($attributes, Mage::getSingleton('xtento_orderexport/export_condition_custom')->getCustomNotMappedAttributes('_item'));
        $this->setAttributeOption($attributes);
        return $this;
    }

    public function getInputType()
    {
        switch ($this->getAttribute()) {
            case 'stock_id':
                return 'numeric';
        }
        // Get type for custom
        return 'string';
    }

    public function getValueElementType()
    {
        /*switch ($this->getAttribute()) {
            case 'shipping_method':
            case 'payment_method':
            case 'country_id':
            case 'region_id':
                return 'select';
        }*/
        return 'text';
    }

    public function getValueSelectOptions()
    {
        if (!$this->hasData('value_select_options')) {
            $this->setData('value_select_options', array());
        }
        return $this->getData('value_select_options');
    }

    /**
     * Validate Address Rule Condition
     *
     * @param Varien_Object $object
     * @return bool
     */
    public function validate(Varien_Object $object)
    {
        #var_dump($this->validateAttribute($object->getData($this->getAttribute())), $object->getData($this->getAttribute()), $this->getAttribute(), $this->getValueParsed()); die();
        return $this->validateAttribute($object->getData($this->getAttribute()));
    }
}
