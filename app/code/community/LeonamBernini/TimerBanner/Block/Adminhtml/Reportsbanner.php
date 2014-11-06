<?php
class LeonamBernini_TimerBanner_Block_Adminhtml_Reportsbanner extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_reports_banner';
        $this->_blockGroup = 'timerbanner';
        $this->_headerText = Mage::helper('timerbanner')->__('Report - Totals');
        parent::__construct();
        $this->removeButton('add');
    }
}
