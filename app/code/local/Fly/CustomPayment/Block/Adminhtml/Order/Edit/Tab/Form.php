<?php
/**
 * Fly_CustomPayment extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Fly
 * @package        Fly_CustomPayment
 * @copyright      Copyright (c) 2017
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Recurring edit form tab
 *
 * @category    Fly
 * @package     Fly_CustomPayment
 * @author      Ultimate Module Creator
 */
class Fly_CustomPayment_Block_Adminhtml_Order_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare the form
     * @access protected
     * @return CustomPayment_Order_Block_Adminhtml_Order_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('order_');
        $form->setFieldNameSuffix('order');
        $this->setForm($form);
        $fieldset = $form->addFieldset('order_form', array('legend'=>Mage::helper('custompayment')->__('Recurring')));

        $fieldset->addField('recurring_id', 'text', array(
            'label' => Mage::helper('custompayment')->__('Recurring Id'),
            'name'  => 'recurring_id',
            'required'  => true,
            'class' => 'required-entry',

        ));
        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('custompayment')->__('Status'),
            'name'  => 'status',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('custompayment')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('custompayment')->__('Disabled'),
                ),
            ),
        ));
        $formValues = Mage::registry('current_order')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getOrderData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getOrderData());
            Mage::getSingleton('adminhtml/session')->setOrderData(null);
        }
        elseif (Mage::registry('current_order')){
            $formValues = array_merge($formValues, Mage::registry('current_order')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
