<?php

class LeonamBernini_TimerBanner_Block_Adminhtml_Reports_Banner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('reportBannerGrid');
        // This is the primary key of the database
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('timerbanner/reports')->getCollection();
        $collection->getSelect()
                ->reset(Zend_Db_Select::COLUMNS)
                ->joinLeft(array('table_timerbanner' => $collection->getTable('timerbanner/timerbanner')), 'main_table.timerbanner_id = table_timerbanner.id', array('title' => 'table_timerbanner.title', 'url' => 'table_timerbanner.url', 'filename' => 'table_timerbanner.filename'))
                ->columns('table_timerbanner.title AS title')
                ->columns('COUNT(main_table.timerbanner_id) AS total')
                ->group('table_timerbanner.title')
                ->group('table_timerbanner.url')
                ->group('table_timerbanner.filename');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('filename', array(
            'header' => Mage::helper('timerbanner')->__('Banner Image'),
            'align' => 'left',
            'index' => 'filename',
            'renderer' => 'timerbanner/adminhtml_grid_renderer_image',
            'width'     => '170px',
            'align'	=> 'center',
            'escape'    => true,
            'sortable'  => false,
            'filter'    => false,
        ));
        
        $this->addColumn('title', array(
            'header'    => Mage::helper('timerbanner')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
            'filter_index' => 'table_timerbanner.title',
        ));
        
        $this->addColumn('url', array(
            'header'    => Mage::helper('timerbanner')->__('URL to click'),
            'align'     =>'left',
            'index'     => 'url',
            'filter_index' => 'table_timerbanner.url',
        ));

        $this->addColumn('total', array(
            'header'    => Mage::helper('timerbanner')->__('Total of Clicks'),
            'align'     =>'center',
            'index'     => 'total',
            'filter'    => false,
        ));
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return '';
    }

}