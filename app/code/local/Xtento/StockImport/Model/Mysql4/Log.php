<?php

/**
 * Product:       Xtento_StockImport (2.3.4)
 * ID:            pdPxsRjlYe/jzWvrh39yYtb/LukbtTgwOebmpEnEWD0=
 * Packaged:      2016-09-28T05:01:00+00:00
 * Last Modified: 2013-06-26T17:57:44+02:00
 * File:          app/code/local/Xtento/StockImport/Model/Mysql4/Log.php
 * Copyright:     Copyright (c) 2016 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_StockImport_Model_Mysql4_Log extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('xtento_stockimport/log', 'log_id');
    }
}