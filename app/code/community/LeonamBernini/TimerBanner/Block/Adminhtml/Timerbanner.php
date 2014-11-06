<?php
class LeonamBernini_TimerBanner_Block_Adminhtml_Timerbanner extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_timerbanner';
        $this->_blockGroup = 'timerbanner';
        $this->_headerText = Mage::helper('timerbanner')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('timerbanner')->__('Add Item');
        parent::__construct();
    }
}
