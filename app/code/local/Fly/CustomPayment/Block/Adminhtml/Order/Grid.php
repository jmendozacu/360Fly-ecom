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
 * Recurring admin grid block
 *
 * @category    Fly
 * @package     Fly_CustomPayment
 * @author      Ultimate Module Creator
 */
class Fly_CustomPayment_Block_Adminhtml_Order_Grid
    extends Mage_Adminhtml_Block_Widget_Grid {
    /**
     * constructor
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct(){
        parent::__construct();
        $this->setId('orderGrid');
        $this->setDefaultSort('profile_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    /**
     * prepare collection
     * @access protected
     * @return Fly_CustomPayment_Block_Adminhtml_Order_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareCollection(){
        $collection = Mage::getModel('custompayment/order')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    /**
     * prepare grid collection
     * @access protected
     * @return Fly_CustomPayment_Block_Adminhtml_Order_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareColumns(){
        $this->addColumn('profile_id', array(
            'header'    => Mage::helper('custompayment')->__('Id'),
            'index'        => 'profile_id',
            'type'        => 'number'
        ));
        $this->addColumn('customer_email', array(
            'header'    => Mage::helper('custompayment')->__('Customer Email'),
            'align'     => 'left',
            'index'     => 'customer_email',
        ));
        $this->addColumn('state', array(
            'header'    => Mage::helper('custompayment')->__('State'),
            'index'        => 'state',
            
        ));
        $this->addColumn('created_at', array(
            'header'    => Mage::helper('custompayment')->__('Created at'),
            'index'     => 'created_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('custompayment')->__('Updated at'),
            'index'     => 'updated_at',
            'width'     => '120px',
            'type'      => 'datetime',
        ));
        /*$this->addColumn('action',
            array(
                'header'=>  Mage::helper('custompayment')->__('Action'),
                'width' => '100',
                'type'  => 'action',
                'getter'=> 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('custompayment')->__('Edit'),
                        
                        'field' => 'id'
                    )
                ),
                'filter'=> false,
                'is_system'    => true,
                'sortable'  => false,
        ));*/
        $this->addExportType('*/*/exportCsv', Mage::helper('custompayment')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('custompayment')->__('Excel'));
        $this->addExportType('*/*/exportXml', Mage::helper('custompayment')->__('XML'));
        return parent::_prepareColumns();
    }
    /**
     * prepare mass action
     * @access protected
     * @return Fly_CustomPayment_Block_Adminhtml_Order_Grid
     * @author Ultimate Module Creator
     */
    protected function _prepareMassaction(){
        $this->setMassactionIdField('profile_id');
        $this->getMassactionBlock()->setFormFieldName('order');
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('custompayment')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('custompayment')->__('Are you sure?')
        ));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('custompayment')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'status' => array(
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => Mage::helper('custompayment')->__('Status'),
                        'values' => array(
                                '1' => Mage::helper('custompayment')->__('Enabled'),
                                '0' => Mage::helper('custompayment')->__('Disabled'),
                        )
                )
            )
        ));
        return $this;
    }
    /**
     * get the row url
     * @access public
     * @param Fly_CustomPayment_Model_Order
     * @return string
     * @author Ultimate Module Creator
     */
    public function getRowUrl($row){
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    /**
     * get the grid url
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getGridUrl(){
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
    /**
     * after collection load
     * @access protected
     * @return Fly_CustomPayment_Block_Adminhtml_Order_Grid
     * @author Ultimate Module Creator
     */
    protected function _afterLoadCollection(){
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }
}
