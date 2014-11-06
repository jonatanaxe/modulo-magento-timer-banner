<?php

class LeonamBernini_TimerBanner_Block_Adminhtml_Timerbanner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('TimerBannerGrid');
        // This is the primary key of the database
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('timerbanner/timerbanner')->getCollection();
        foreach($collection as $link){
            if($link->getStores() && $link->getStores() != 0 ){
                $link->setStores(explode(',',$link->getStores()));
            }
            else{
                $link->setStores(array('0'));
            }
        }
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
        ));

        $this->addColumn('id_show', array(
            'header'    => Mage::helper('timerbanner')->__('ID Show'),
            'align'     =>'center',
            'width'     => '100px',
            'index'     => 'id_show',
        ));

        $this->addColumn('filename', array(
            'header' => Mage::helper('timerbanner')->__('Image'),
            'align' => 'left',
            'index' => 'filename',
            'renderer' => 'timerbanner/adminhtml_grid_renderer_image',
            'width'	=> '130px',
            'align'	=> 'center',
            'escape'    => true,
            'sortable'  => false,
            'filter'    => false,
        )); 
        
        $this->addColumn('title', array(
            'header'    => Mage::helper('timerbanner')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));
        
        $this->addColumn('name', array(
            'header'    => Mage::helper('timerbanner')->__('Name'),
            'align'     =>'left',
            'index'     => 'name',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('stores', array(
                'header'        => Mage::helper('timerbanner')->__('Store'),
                'index'         => 'stores',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback'
                                => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('start_time', array(
            'header'    => Mage::helper('timerbanner')->__('Start Time'),
            'align'     => 'center',
            'width'     => '80px',
            'index'     => 'start_time',
        ));

        $this->addColumn('end_time', array(
            'header'    => Mage::helper('timerbanner')->__('End Time'),
            'align'     => 'center',
            'width'     => '80px',
            'index'     => 'end_time',
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('timerbanner')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => Mage::helper('timerbanner')->__('Active'),
                0 => Mage::helper('timerbanner')->__('Inactive'),
            ),
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getGridUrl()
    {
      return $this->getUrl('*/*/grid', array('_current'=>true));
    }

}