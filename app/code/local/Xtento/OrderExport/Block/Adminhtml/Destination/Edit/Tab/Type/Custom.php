<?php

/**
 * Product:       Xtento_OrderExport (1.9.6)
 * ID:            UkPw/HNCTGTNeNACl67A1tsc5/yF+olcWhzGXPJ/t28=
 * Packaged:      2016-09-21T14:35:40+00:00
 * Last Modified: 2013-07-01T23:20:39+02:00
 * File:          app/code/local/Xtento/OrderExport/Block/Adminhtml/Destination/Edit/Tab/Type/Custom.php
 * Copyright:     Copyright (c) 2016 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Block_Adminhtml_Destination_Edit_Tab_Type_Custom
{
    // Custom Type Configuration
    public function getFields($form)
    {
        $fieldset = $form->addFieldset('config_fieldset', array(
            'legend' => Mage::helper('xtento_orderexport')->__('Custom Type Configuration'),
            'class' => 'fieldset-wide'
        ));

        $fieldset->addField('custom_class', 'text', array(
            'label' => Mage::helper('xtento_orderexport')->__('Custom Class Identifier'),
            'name' => 'custom_class',
            'note' => Mage::helper('xtento_orderexport')->__('You can set up an own class in our (or another) module which gets called when exporting. The saveFiles($fileArray ($filename => $contents)) function would be called in your class. If your class was called Xtento_OrderExport_Model_Destination_Myclass then the identifier to enter here would be xtento_orderexport/destination_myclass'),
            'required' => true
        ));
    }
}