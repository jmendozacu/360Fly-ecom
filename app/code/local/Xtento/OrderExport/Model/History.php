<?php

/**
 * Product:       Xtento_OrderExport (1.9.6)
 * ID:            UkPw/HNCTGTNeNACl67A1tsc5/yF+olcWhzGXPJ/t28=
 * Packaged:      2016-09-21T14:35:40+00:00
 * Last Modified: 2012-12-02T17:55:57+01:00
 * File:          app/code/local/Xtento/OrderExport/Model/History.php
 * Copyright:     Copyright (c) 2016 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_OrderExport_Model_History extends Mage_Core_Model_Abstract
{
    /*
     * History model. Keeps track of which objects have been exported and which haven't
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('xtento_orderexport/history');
    }
}