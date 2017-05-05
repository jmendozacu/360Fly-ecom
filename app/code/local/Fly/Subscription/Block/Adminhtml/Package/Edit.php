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
 * Subscription admin edit form
 *
 * @category    Fly
 * @package     Fly_Subscription
 * @author      Ultimate Module Creator
 */
class Fly_Subscription_Block_Adminhtml_Package_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * constructor
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct()
    {
        parent::__construct();
        $this->_blockGroup = 'fly_subscription';
        $this->_controller = 'adminhtml_package';
        $this->_updateButton(
            'save',
            'label',
            Mage::helper('fly_subscription')->__('Save Subscription')
        );
        $this->_updateButton(
            'delete',
            'label',
            Mage::helper('fly_subscription')->__('Delete Subscription')
        );
        $this->_addButton(
            'saveandcontinue',
            array(
                'label'   => Mage::helper('fly_subscription')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class'   => 'save',
            ),
            -100
        );
        $this->_formScripts[] = "
            function saveAndContinueEdit() {
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * get the edit form header
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText()
    {
        if (Mage::registry('current_package') && Mage::registry('current_package')->getId()) {
            return Mage::helper('fly_subscription')->__(
                "Edit Subscription '%s'",
                $this->escapeHtml(Mage::registry('current_package')->getCustomerId())
            );
        } else {
            return Mage::helper('fly_subscription')->__('Add Subscription');
        }
    }
}
