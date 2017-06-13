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
 * Recurring admin edit form
 *
 * @category    Fly
 * @package     Fly_CustomPayment
 * @author      Ultimate Module Creator
 */
class Fly_CustomPayment_Block_Adminhtml_Order_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container {
    /**
     * constructor
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct(){
        parent::__construct();
        $this->_blockGroup = 'custompayment';
        $this->_controller = 'adminhtml_order';
        $this->_updateButton('save', 'label', Mage::helper('custompayment')->__('Save Recurring'));
        $this->_updateButton('delete', 'label', Mage::helper('custompayment')->__('Delete Recurring'));
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('custompayment')->__('Save And Continue Edit'),
            'onclick'    => 'saveAndContinueEdit()',
            'class'        => 'save',
        ), -100);
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    /**
     * get the edit form header
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText(){
        if( Mage::registry('current_order') && Mage::registry('current_order')->getId() ) {
            return Mage::helper('custompayment')->__("Edit Recurring '%s'", $this->escapeHtml(Mage::registry('current_order')->getRecurringId()));
        }
        else {
            return Mage::helper('custompayment')->__('Add Recurring');
        }
    }
}
