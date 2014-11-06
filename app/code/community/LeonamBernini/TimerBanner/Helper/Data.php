<?php

class LeonamBernini_TimerBanner_Helper_Data extends Mage_Core_Helper_Abstract
{
    
    private $bannerPath;
    private $bannerThumbsPath;
    
    public function __construct() {
        $this->bannerPath       = '/leonam_bernini/timerbanner/';
        $this->bannerThumbsPath = '/leonam_bernini/timerbanner/thumbs/';
    }
    
    public function getBannerPath()
    {
        return $this->bannerPath;
    }
    public function getThumbsPath($path = null)
    {
        if( $path == null ){
            return $this->bannerThumbsPath;
        }else{
            return str_replace( '/timerbanner/', '/timerbanner/thumbs/', $path);
        }
    }

    public function resizeImg($fileName, $width, $height = '')
    {
        //$fileName = "slideshow\slides\\".$fileName;
        $folderURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
        $imageURL = $folderURL . $fileName;

        $basePath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $this->bannerPath. $fileName;

        $newPath = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $this->bannerThumbsPath . $fileName;
        //if width empty then return original size image's URL
        if ($width != '') {
            //if image has already resized then just return URL
            if (file_exists($basePath) && is_file($basePath) && !file_exists($newPath)) {
                $imageObj = new Varien_Image($basePath);
                $imageObj->constrainOnly(TRUE);
                $imageObj->keepAspectRatio(FALSE);
                $imageObj->keepFrame(FALSE);
                $imageObj->resize($width, $height);
                $imageObj->save($newPath);
            }
            $resizedURL = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . "resized" . DS . $fileName;
         } else {
            $resizedURL = $imageURL;
         }
         return $resizedURL;
    }
    
    
    public function getTemplates()
    {
        return array(
            '1' => $this->__('model') . ' 1',
            '2' => $this->__('model') . ' 2',
            '3' => $this->__('model') . ' 3',
            '4' => $this->__('model') . ' 4',
            '5' => $this->__('model') . ' 5',
        );
    }
    
    public function getExemplesTemplates()
    {
        $exemples = '<img src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) . 'frontend/base/default/leonam_bernini/timerbanner/images/models.jpg' . '" title="' . $this->__('models exemples') . '" alt="' . $this->__('models exemples') . '" style="margin-top: 10px;">';
        return $exemples;
    }
    
}