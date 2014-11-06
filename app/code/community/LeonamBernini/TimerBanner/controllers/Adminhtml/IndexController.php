<?php

class LeonamBernini_TimerBanner_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
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
        $this->_addContent($this->getLayout()->createBlock('timerbanner/adminhtml_timerbanner'));
        $this->renderLayout();
    }
    
    public function newAction(){
        $this->_forward('edit');
    }
    
    public function editAction(){
        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('timerbanner/timerbanner')->load($id);

        if ( $model->getId() || $id == 0 ) {

            Mage::register('timerbanner_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('timerbanner/manage_timerbanner');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('timerbanner/adminhtml_timerbanner_edit'))
                 ->_addLeft($this->getLayout()->createBlock('timerbanner/adminhtml_timerbanner_edit_tabs'));

            $this->renderLayout();
        } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('timerbanner')->__('Item does not exist'));
                $this->_redirect('*/*/');
        }
    }
    
    public function uploadImage($file, $name)
    {
        try {	
            $bannerPath = Mage::helper('timerbanner')->getBannerPath();
            
            /* Starting upload */	
            $uploader = new Varien_File_Uploader($name);

            // Any extention would work
            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
            $uploader->setAllowRenameFiles(true);

            // Set the file upload mode 
            // false -> get the file directly in the specified folder
            // true -> get the file in the product like folders 
            //	(file.jpg will go in something like /media/f/i/file.jpg)
            $uploader->setFilesDispersion(false);

            // We set media as the upload dir
            $path = Mage::getBaseDir('media') . DS . $bannerPath ;

            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $result = $uploader->save($path, md5( $imageName . date('d.m.Y_H.m.i') ) . '.' . $extension );

            //For thumb
            Mage::helper('timerbanner')->resizeImg($result['file'], 100, 75);
            //For thumb ends

            $test = $bannerPath.$result['file'];

            
            return $test;

        } catch (Exception $e) {
            return $file['name'];
        }
    }
    
    public function saveAction()
    {
        if ( $this->getRequest()->getPost() ) {
            try {
                $postData = $this->getRequest()->getPost();
                $timerbannerModel = Mage::getModel('timerbanner/timerbanner');

                if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
                    $postData['filename'] = $this->uploadImage($_FILES['filename'], 'filename');
                    if(isset($postData['filename']['delete']) && $postData['filename']['delete'] == 1)
                    {
                        unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['filename']['value']);
                        unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS . Mage::helper('timerbanner')->getThumbsPath($postData['filename']['value']));
                    }
                }else {       
                    if(isset($postData['filename']['delete']) && $postData['filename']['delete'] == 1){
                        unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['filename']['value']);
                        unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .Mage::helper('timerbanner')->getThumbsPath($postData['filename']['value']));
                        $postData['filename'] = '';
                    }else{
                        unset($postData['filename']);
                    }
                }

                if(isset($_FILES['background_image']['name']) && $_FILES['background_image']['name'] != '') {
                    $postData['background_image'] = $this->uploadImage($_FILES['background_image'], 'background_image');
                    if(isset($postData['background_image']['delete']) && $postData['background_image']['delete'] == 1)
                    {
                        unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['background_image']['value']);
                        unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS . Mage::helper('timerbanner')->getThumbsPath($postData['background_image']['value']));
                    }
                }else {       
                    if(isset($postData['background_image']['delete']) && $postData['background_image']['delete'] == 1){
                        unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .$postData['background_image']['value']);
                        unlink(Mage_Core_Model_Store::URL_TYPE_MEDIA. DS .Mage::helper('timerbanner')->getThumbsPath($postData['background_image']['value']));
                        $postData['background_image'] = '';
                    }else{
                        unset($postData['background_image']);
                    }
                }
                
                if(isset($postData['stores'])) {
                    if(in_array('0',$postData['stores'])){
                        $postData['stores'] = '0';
                    }else{
                        $postData['stores'] = implode(",", $postData['stores']);
                    }
                }

                if($postData['stores'] == "")
                {
                    $postData['stores'] = '0';
                }
                
                $times = explode(" ", now());
                if ( $postData['start_time'] ) {
                    $postData['start_time'] = $postData['start_time']. " " . $times[1];
                }else{
                    $postData['start_time'] = null;
                }
                if ( $postData['end_time'] ) {
                    $postData['end_time']   = $postData['end_time'] . " " . $times[1];
                }else{
                    $postData['end_time'] = null;
                }

                $timerbannerModel->setId($this->getRequest()->getParam('id'))
                        ->setIdShow($postData['id_show'])
                        ->setTitle($postData['title'])
                        ->setFilename($postData['filename'])
                        ->setBackgroundImage($postData['background_image'])
                        ->setBackgroundColor($postData['background_color'])
                        ->setProductId($postData['product_id'])
                        ->setProductName($postData['product_name'])
                        ->setTemplate($postData['template'])
                        ->setWidth($postData['width'])
                        ->setHeight($postData['height'])
                        ->setEndTimePromotion($postData['end_time_promotion'])
                        ->setTextTimeEnd($postData['text_time_end'])
                        ->setUrl($postData['url'])
                        ->setTarget($postData['target'])
                        ->setStatus($postData['status'])
                        ->setStores($postData['stores'])
                        ->setStartTime($postData['start_time'])
                        ->setEndTime($postData['end_time'])
                        ->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setSlideshowData(false);

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSlideshowData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
    
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if( $id > 0 ) {
            try {
                $model = Mage::getModel('timerbanner/timerbanner')->load($id);
                $image = $model->getFilename();
                $background = $model->getBackgroundImage();
                $model->delete();
                
                if( $image != '' && $image != null && file_exists( Mage_Core_Model_Store::URL_TYPE_MEDIA .$image ) ){
                    unlink( Mage_Core_Model_Store::URL_TYPE_MEDIA .$image );
                
                    if( file_exists( Mage_Core_Model_Store::URL_TYPE_MEDIA . Mage::helper('timerbanner')->getThumbsPath( $image ) ) ){
                        unlink( Mage_Core_Model_Store::URL_TYPE_MEDIA . Mage::helper('timerbanner')->getThumbsPath( $image ) );
                    }
                }
                if( $background != '' && $background != null && file_exists( Mage_Core_Model_Store::URL_TYPE_MEDIA .$background ) ){
                    unlink( Mage_Core_Model_Store::URL_TYPE_MEDIA .$background );
                
                    if( file_exists( Mage_Core_Model_Store::URL_TYPE_MEDIA . Mage::helper('timerbanner')->getThumbsPath( $background ) ) ){
                        unlink( Mage_Core_Model_Store::URL_TYPE_MEDIA . Mage::helper('timerbanner')->getThumbsPath( $background ) );
                    }
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
    
    /**
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
                   $this->getLayout()->createBlock('timerbanner/adminhtml_timerbanner_grid')->toHtml()
        );
    }
}
?>