<?php

class LeonamBernini_TimerBanner_IndexController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('timerbanner/manage_timerbanner')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        return $this;
    }
    
    public function preDispatch() {}

    public function clickAction() {
        $cookie = Mage::getSingleton('core/cookie');
        $id = $this->getRequest()->getParam('id_banner');
        $userCode = $this->getUserCode($id);
        $date_click = now();
        $report = Mage::getModel('timerbanner/reports');
        if ( $id ) {
            if ( !$cookie->get('timerbanner_user_code_click' . $id ) ) {
                $cookie->set( 'timerbanner_user_code_click' . $id, $userCode );
                $report->setData( 'timerbanner_id', $id )
                       ->setData( 'ip', $this->getIP() )
                       ->setData( 'date', $date_click );
                try {
                    $report->save();
                } catch (Exception $e) { }
            }
        }
    }
    
    private function getIP(){
        $ipAddress = null;
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ipAddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ipAddress = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["REMOTE_ADDR"])) {
            $ipAddress = $_SERVER["REMOTE_ADDR"];
        }
        return $ipAddress;
    }


    private function getUserCode($id) {
        $cookiefrontend = $_COOKIE['frontend'];
        $usercode = $this->getIP() . $cookiefrontend . $id;
        return md5($usercode);
    }
}
?>