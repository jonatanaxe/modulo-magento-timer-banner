<?php

class LeonamBernini_TimerBanner_Model_Mysql4_Reports_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        //parent::_construct();
        $this->_init('timerbanner/reports');
    }
}