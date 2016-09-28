<?php

/**
 * Product:       Xtento_StockImport (2.3.4)
 * ID:            pdPxsRjlYe/jzWvrh39yYtb/LukbtTgwOebmpEnEWD0=
 * Packaged:      2016-09-28T05:01:00+00:00
 * Last Modified: 2013-08-07T16:53:10+02:00
 * File:          app/code/local/Xtento/StockImport/Model/Source/Interface.php
 * Copyright:     Copyright (c) 2016 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

interface Xtento_StockImport_Model_Source_Interface
{
    public function testConnection();
    public function loadFiles();
    public function archiveFiles($filesToProcess, $forceDelete = false);
}