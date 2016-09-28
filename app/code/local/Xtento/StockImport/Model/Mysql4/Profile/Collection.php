<?php

/**
 * Product:       Xtento_StockImport (2.3.4)
 * ID:            pdPxsRjlYe/jzWvrh39yYtb/LukbtTgwOebmpEnEWD0=
 * Packaged:      2016-09-28T05:01:00+00:00
 * Last Modified: 2013-07-13T13:04:04+02:00
 * File:          app/code/local/Xtento/StockImport/Model/Mysql4/Profile/Collection.php
 * Copyright:     Copyright (c) 2016 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_StockImport_Model_Mysql4_Profile_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('xtento_stockimport/profile');
    }

    protected function _afterLoad()
    {
        parent::_afterLoad();
        foreach ($this->getItems() as $item) {
            $item->setData('configuration', unserialize($item->getData('configuration')));
            $item->setDataChanges(false);
        }
        return $this;
    }
}