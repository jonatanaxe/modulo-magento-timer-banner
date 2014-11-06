<?php

class LeonamBernini_TimerBanner_Block_Adminhtml_Timerbanner_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('timerbanner_form', array('legend'=>Mage::helper('timerbanner')->__('Item information')));

        $fieldset->addField('id_show', 'text', array(
            'label'     => Mage::helper('timerbanner')->__('ID Show'),
            'class'     => 'validate-code required-entry',
            'maxlength' => '20',
            'required'  => true,
            'name'      => 'id_show',
        ));

        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('timerbanner')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('stores', 'multiselect', array(
                'name'      => 'stores[]',
                'label'     => Mage::helper('timerbanner')->__('Select Store'),
                'title'     => Mage::helper('timerbanner')->__('Select Store'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        }
        else {
            $fieldset->addField('stores', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
        }
        
        $fieldset->addField('filename', 'image', array(
            'label'     => Mage::helper('timerbanner')->__('Image File'),
            'name'      => 'filename',
        ));

        $fieldset->addField('background_image', 'image', array(
            'label'     => Mage::helper('timerbanner')->__('Background Imagem'),
            'name'      => 'background_image',
        ));   

        $fieldset->addField('background_color', 'text', array(
            'label'     => Mage::helper('timerbanner')->__('Background Color'),
            'name'      => 'background_color',
        ));

        $fieldset->addField('product_id', 'text', array(
            'label'     => Mage::helper('timerbanner')->__('Product ID'),
            'required'  => true,
            'name'      => 'product_id',
        ));

        $fieldset->addField('product_name', 'text', array(
            'label'     => Mage::helper('timerbanner')->__('Product Name'),
            'title'     => Mage::helper('timerbanner')->__('If not given, will be shown the name of the registered product'),
            'name'      => 'product_name',
        ));
        
        $fieldset->addField('template', 'select', array(
            'name'      => 'template',
            'label'     => Mage::helper('timerbanner')->__('Template'),
            'required'  => true,
            'note'      => Mage::helper('timerbanner')->getExemplesTemplates(),
            'values'    => Mage::helper('timerbanner')->getTemplates(),
        ));

        $fieldset->addField('width', 'text', array(
            'label'     => Mage::helper('timerbanner')->__('Width'),
            'required'  => true,
            'name'      => 'width',
        ));

        $fieldset->addField('height', 'text', array(
            'label'     => Mage::helper('timerbanner')->__('Height'),
            'required'  => true,
            'name'      => 'height',
        ));

        $image_calendar = Mage::getBaseUrl('skin') . 'adminhtml/default/default/images/grid-cal.gif';
        
        $fieldset->addField('end_time_promotion', 'date', array(
            'label' => Mage::helper('timerbanner')->__('End date promotion'),
            'format' => 'yyyy-MM-dd',
            'required' => true,
            'image' => $image_calendar,
            'name' => 'end_time_promotion',
            'time' => true
        ));
            
        $fieldset->addField('text_time_end', 'text', array(
            'label'     => Mage::helper('timerbanner')->__('Text time end'),
            'required'  => false,
            'name'      => 'text_time_end',
        ));
            
        $fieldset->addField('url', 'text', array(
            'label'     => Mage::helper('timerbanner')->__('Url'),
            'required'  => false,
            'name'      => 'url',
        ));

        $fieldset->addField('target', 'select', array(
            'label'     => Mage::helper('timerbanner')->__('Target'),
            'name'      => 'target',
            'values'    => array(
                array(
                    'value' => '_blank',
                    'label' => Mage::helper('timerbanner')->__('Blank'),
                ),
                array(
                    'value' => '_new',
                    'label' => Mage::helper('timerbanner')->__('New'),
                ),
                array(
                    'value' => '_parent',
                    'label' => Mage::helper('timerbanner')->__('Parent'),
                ),
                array(
                    'value' => '_self',
                    'label' => Mage::helper('timerbanner')->__('Self'),
                ),
                array(
                    'value' => '_top',
                    'label' => Mage::helper('timerbanner')->__('Top'),
                ),
            ),
        ));	   

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('timerbanner')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('timerbanner')->__('Active'),
                ),

                array(
                    'value' => 0,
                    'label' => Mage::helper('timerbanner')->__('Inactive'),
                ),
            ),
        ));
        
        $fieldset->addField('start_time', 'date', array(
            'label' => Mage::helper('timerbanner')->__('Start date'),
            'format' => 'yyyy-MM-dd',
            'required' => false,
            'image' => $image_calendar,
            'name' => 'start_time',
            'time' => true
        ));

        $fieldset->addField('end_time', 'date', array(
            'label' => Mage::helper('timerbanner')->__('End date'),
            'format' =>'yyyy-MM-dd',
            'required' => false,
            'image' => $image_calendar,
            'name' => 'end_time',
            'time' => true
        ));

        if ( Mage::getSingleton('adminhtml/session')->getSlideshowData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getTimerbannerData());
            Mage::getSingleton('adminhtml/session')->setTimerbannerData(null);
        } elseif ( Mage::registry('timerbanner_data') ) {
            $form->setValues(Mage::registry('timerbanner_data')->getData());
        }
        return parent::_prepareForm();
    }
}