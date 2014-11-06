<?php

class LeonamBernini_TimerBanner_Adminhtml_ReportsController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('timerbanner/manage_timerbanner')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        return $this;
    }

    public function indexAction() {
        $this->_initAction();       
        $this->_addContent($this->getLayout()->createBlock('timerbanner/adminhtml_reports'));
        $this->renderLayout();
    }
    
    public function bannerAction() {
        $this->_initAction();       
        $block = $this->getLayout()->createBlock('timerbanner/adminhtml_reportsbanner','reports_banner');
        $block->append( $this->getLayout()->createBlock('timerbanner/adminhtml_reports_banner_grid') );
        $this->_addContent( $block );
        $this->renderLayout();
    }
    
    
    /**
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
                   $this->getLayout()->createBlock('timerbanner/adminhtml_reports_grid')->toHtml()
        );
    }
}
?>