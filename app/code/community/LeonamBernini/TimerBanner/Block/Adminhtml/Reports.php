<?php
class LeonamBernini_TimerBanner_Block_Adminhtml_Reports extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_reports';
        $this->_blockGroup = 'timerbanner';
        $this->_headerText = Mage::helper('timerbanner')->__('Report');
        parent::__construct();
        $this->removeButton('add');
    }
}
