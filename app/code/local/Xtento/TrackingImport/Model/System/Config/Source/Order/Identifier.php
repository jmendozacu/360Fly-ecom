<?php

/**
 * Product:       Xtento_TrackingImport (2.2.1)
 * ID:            UkPw/HNCTGTNeNACl67A1tsc5/yF+olcWhzGXPJ/t28=
 * Packaged:      2016-09-21T14:35:43+00:00
 * Last Modified: 2014-06-24T22:08:35+02:00
 * File:          app/code/local/Xtento/TrackingImport/Model/System/Config/Source/Order/Identifier.php
 * Copyright:     Copyright (c) 2016 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TrackingImport_Model_System_Config_Source_Order_Identifier
{

    public function toOptionArray()
    {
        $identifiers[] = array('value' => 'order_increment_id', 'label' => Mage::helper('xtento_trackingimport')->__('Order Increment ID'));
        $identifiers[] = array('value' => 'order_entity_id', 'label' => Mage::helper('xtento_trackingimport')->__('Order Entity ID (entity_id, internal Magento ID)'));
        $identifiers[] = array('value' => 'invoice_increment_id', 'label' => Mage::helper('xtento_trackingimport')->__('Invoice Increment ID'));
        $identifiers[] = array('value' => 'shipment_increment_id', 'label' => Mage::helper('xtento_trackingimport')->__('Shipment Increment ID'));
        $identifiers[] = array('value' => 'creditmemo_increment_id', 'label' => Mage::helper('xtento_trackingimport')->__('Credit Memo Increment ID'));
        return $identifiers;
    }

}
