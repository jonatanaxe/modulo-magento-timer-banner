<?php

class LeonamBernini_TimerBanner_Block_Adminhtml_Reports_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('reportGrid');
        // This is the primary key of the database
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('timerbanner/reports')->getCollection();
        $collection->getSelect()->joinLeft(array('table_timerbanner' => $collection->getTable('timerbanner/timerbanner')), 'main_table.timerbanner_id = table_timerbanner.id', array('title' => 'table_timerbanner.title', 'filename' => 'table_timerbanner.filename'));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('timerbanner')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'id',
            'filter_index' => 'main_table.id',
        ));

        $this->addColumn('filename', array(
            'header' => Mage::helper('timerbanner')->__('Banner Image'),
            'align' => 'left',
            'index' => 'filename',
            'renderer' => 'timerbanner/adminhtml_grid_renderer_image',
            'align'	=> 'center',
            'escape'    => true,
            'sortable'  => false,
            'filter'    => false,
        )); 

        $this->addColumn('title', array(
            'header'    => Mage::helper('timerbanner')->__('Title'),
            'align'     =>'left',
            'filter_index' => 'table_timerbanner.title',
            'index'     => 'title',
        ));
        
        $this->addColumn('ip', array(
            'header'    => Mage::helper('timerbanner')->__('IP'),
            'align'     =>'left',
            'filter_index' => 'table_timerbanner.ip',
            'index'     => 'ip',
        ));
        
        $this->addColumn('date', array(
            'header'    => Mage::helper('timerbanner')->__('Date of click'),
            'align'     => 'center',
            'width'     => '80px',
            'index'     => 'date',
            'filter_index' => 'main_table.date',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return '';
    }

}