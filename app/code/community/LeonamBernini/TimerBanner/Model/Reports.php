<?php

class LeonamBernini_TimerBanner_Model_Reports extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('timerbanner/reports');
    }
}