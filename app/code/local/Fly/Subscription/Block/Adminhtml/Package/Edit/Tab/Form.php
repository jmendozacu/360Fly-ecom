<?php
/**
 * Fly_Subscription extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Fly
 * @package        Fly_Subscription
 * @copyright      Copyright (c) 2017
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Subscription edit form tab
 *
 * @category    Fly
 * @package     Fly_Subscription
 * @author      Ultimate Module Creator
 */
class Fly_Subscription_Block_Adminhtml_Package_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Fly_Subscription_Block_Adminhtml_Package_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('package_');
        $form->setFieldNameSuffix('package');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'package_form',
            array('legend' => Mage::helper('fly_subscription')->__('Subscription'))
        );

        $fieldset->addField(
            'customer_id',
            'text',
            array(
                'label' => Mage::helper('fly_subscription')->__('Created At'),
                'name'  => 'customer_id',
                'required'  => true,
                'class' => 'required-entry',

           )
        );
        $fieldset->addField(
            'url_key',
            'text',
            array(
                'label' => Mage::helper('fly_subscription')->__('Url key'),
                'name'  => 'url_key',
                'note'  => Mage::helper('fly_subscription')->__('Relative to Website Base URL')
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('fly_subscription')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('fly_subscription')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('fly_subscription')->__('Disabled'),
                    ),
                ),
            )
        );
        $fieldset->addField(
            'in_rss',
            'select',
            array(
                'label'  => Mage::helper('fly_subscription')->__('Show in rss'),
                'name'   => 'in_rss',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('fly_subscription')->__('Yes'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('fly_subscription')->__('No'),
                    ),
                ),
            )
        );
        if (Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                )
            );
            Mage::registry('current_package')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $fieldset->addField(
            'allow_comment',
            'select',
            array(
                'label' => Mage::helper('fly_subscription')->__('Allow Comments'),
                'name'  => 'allow_comment',
                'values'=> Mage::getModel('fly_subscription/adminhtml_source_yesnodefault')->toOptionArray()
            )
        );
        $formValues = Mage::registry('current_package')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getPackageData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getPackageData());
            Mage::getSingleton('adminhtml/session')->setPackageData(null);
        } elseif (Mage::registry('current_package')) {
            $formValues = array_merge($formValues, Mage::registry('current_package')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
