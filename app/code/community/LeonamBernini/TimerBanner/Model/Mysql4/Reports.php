<?php

class LeonamBernini_TimerBanner_Model_Mysql4_Reports extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        $this->_init('timerbanner/reports', 'id');
    }
}