<?php

class LeonamBernini_TimerBanner_Block_Adminhtml_Timerbanner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId   = 'id';
        $this->_blockGroup = 'timerbanner';
        $this->_controller = 'adminhtml_timerbanner';

        $this->_updateButton('save',   'label', Mage::helper('timerbanner')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('timerbanner')->__('Delete Item'));
    }

    public function getHeaderText()
    {
        if( Mage::registry('timerbanner_data') && Mage::registry('timerbanner_data')->getId() ) {
            return Mage::helper('timerbanner')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('timerbanner_data')->getTitle()));
        } else {
            return Mage::helper('timerbanner')->__('Add Item');
        }
    }
}