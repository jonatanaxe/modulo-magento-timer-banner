<?php
class LeonamBernini_TimerBanner_Block_Timerbanner extends Mage_Core_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('leonambernini/timerbanner/timerbanner.phtml');
    }
    
    public function getDataBanner()
    {
        try{
            $today = date("Y-m-d");
            $banners = Mage::getModel('timerbanner/timerbanner')
                                ->getCollection()
                                ->addFieldToFilter(
                                        array('stores', 'stores'),
                                        array(
                                                array('finset'=>Mage::app()->getStore()->getId()), 
                                                array('eq'=>'0'))
                                )
                                ->addFieldToFilter('start_time', array( array('lteq' => $today), array('null' => true)))
                                ->addFieldToFilter('end_time', array(array('gteq' => $today), array('null' => true)))
                                ->addFieldToFilter('status', array('eq' => '1'))
                                ->addFieldToFilter('id_show', array('eq' => $this->getTimerId()) )
                                ->setOrder("id","ASC");
            
            foreach ( $banners as $banner ){
                $product = Mage::getModel('catalog/product')->load( $banner->getProductId() );
                
                if( $product ){
                    $res = array(
                        'id'        => $banner->getId(),
                        'title'     => $banner->getTitle(),
                        'time'      => $banner->getEndTimePromotion(),
                        'textTime'  => ( ( $banner->getTextTimeEnd() != '' ) ? $banner->getTextTimeEnd() : Mage::helper('timerbanner')->__('FINISHED')),
                        'target'    => $product->getTarget(),
                        'product'   => array(
                            'id'    => $product->getId(),
                            'name'  => ( ( $banner->getProductName() != null && $banner->getProductName() != '' ) ? $banner->getProductName() : $product->getName() ),
                            'price' => Mage::helper('core')->currency( $product->getPrice(), true, false ),
                            'sPrice'=> Mage::helper('core')->currency( $product->getFinalPrice(), true, false),
                            'image' => ( ( $banner->getFilename() != '' ) ? Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $banner->getFilename() : Mage::helper('catalog/image')->init($product, 'image') ),
                            'url'   => ( ( strpos( $product->getProductUrl(), 'http://' ) > -1 || strpos( $product->getProductUrl(), 'https://' )  > -1 ) ? $product->getProductUrl() : 'http://' . $product->getProductUrl() ),
                        ),
                        'layout'    => array(
                            'template'        => $banner->getTemplate(),
                            'backgroundImage' => ( ( $banner->getBackgroundImage() != '' ) ? "background-image: url('" . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $banner->getBackgroundImage() . "');" : '' ),
                            'backgroundColor' => ( ( $banner->getBackgroundColor() != '' ) ? 'background-color: ' . $banner->getBackgroundColor() . ';' : '' ),
                            'width'           => ( ( $banner->getWidth() > 0 ) ? 'width: ' . $banner->getWidth() .'px;' : '' ),
                            'height'          => ( ( $banner->getHeight() > 0 ) ? 'height: ' . $banner->getHeight() .'px;' : '' ),
                        ),
                    );
                    break;
                }else{
                    $res = Mage::helper('timerbanner')->__('Product not found');
                }
            }
            return $res;
            
        } catch (Exception $ex) {
            return Mage::helper('timerbanner')->__('The TimerBanner not configured.');
        }
    }
}