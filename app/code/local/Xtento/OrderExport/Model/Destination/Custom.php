<?php

/**
 * Product:       Xtento_OrderExport (1.9.6)
 * ID:            UkPw/HNCTGTNeNACl67A1tsc5/yF+olcWhzGXPJ/t28=
 * Packaged:      2016-09-21T14:35:40+00:00
 * Last Modified: 2013-02-11T16:34:56+01:00
 * File:          app/code/local/Xtento/OrderExport/Model/Destination/Custom.php
 * Copyright:     Copyright (c) 2016 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_Destination_Custom extends Xtento_OrderExport_Model_Destination_Abstract
{
    public function testConnection()
    {
        $this->initConnection();
        if (!$this->getDestination()->getBackupDestination()) {
            $this->getDestination()->setLastResult($this->getTestResult()->getSuccess())->setLastResultMessage($this->getTestResult()->getMessage())->save();
        }
        return $this->getTestResult();
    }

    public function initConnection()
    {
        $this->setDestination(Mage::getModel('xtento_orderexport/destination')->load($this->getDestination()->getId()));
        $testResult = new Varien_Object();
        $this->setTestResult($testResult);
        if (!@Mage::getModel($this->getDestination()->getCustomClass())) {
            $this->getTestResult()->setSuccess(false)->setMessage(Mage::helper('xtento_orderexport')->__('Custom class NOT found.'));
        } else {
            $this->getTestResult()->setSuccess(true)->setMessage(Mage::helper('xtento_orderexport')->__('Custom class found and ready to use.'));
        }
        return true;
    }

    public function saveFiles($fileArray)
    {
        if (empty($fileArray)) {
            return array();
        }
        // Init connection
        $this->initConnection();
        // Call custom class
        @Mage::getModel($this->getDestination()->getCustomClass())->saveFiles($fileArray);
        return array_keys($fileArray);
    }
}