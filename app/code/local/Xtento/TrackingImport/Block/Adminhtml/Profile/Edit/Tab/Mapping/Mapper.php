<?php

/**
 * Product:       Xtento_TrackingImport (2.2.1)
 * ID:            UkPw/HNCTGTNeNACl67A1tsc5/yF+olcWhzGXPJ/t28=
 * Packaged:      2016-09-21T14:35:43+00:00
 * Last Modified: 2014-07-22T19:08:43+02:00
 * File:          app/code/local/Xtento/TrackingImport/Block/Adminhtml/Profile/Edit/Tab/Mapping/Mapper.php
 * Copyright:     Copyright (c) 2016 XTENTO GmbH & Co. KG <info@xtento.com> / All rights reserved.
 */

class Xtento_TrackingImport_Block_Adminhtml_Profile_Edit_Tab_Mapping_Mapper extends Xtento_TrackingImport_Block_Adminhtml_Profile_Edit_Tab_Mapping_Abstract
{
    protected $MAPPING_ID = 'mapping';
    protected $MAPPING_MODEL = 'xtento_trackingimport/processor_mapping_fields';
    protected $FIELD_LABEL = 'Magento Field';
    protected $VALUE_FIELD_LABEL = 'File Field Name / Index';
    protected $HAS_DEFAULT_VALUE_COLUMN = true;
    protected $HAS_VALUE_COLUMN = true;
    protected $DEFAULT_VALUE_FIELD_LABEL = 'Default Value';
    protected $ADD_FIELD_LABEL = 'Add field to mapping';
    protected $ADD_ALL_FIELD_LABEL = 'Add all fields';
    protected $SELECT_LABEL = '--- Select field ---';
}
