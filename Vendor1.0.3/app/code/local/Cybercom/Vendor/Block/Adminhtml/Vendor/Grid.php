<?php

class Cybercom_Vendor_Block_Adminhtml_Vendor_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
         
        // Set some defaults for our grid
        $this->setDefaultSort('id');
        $this->setId('vendor_vendor_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);

    }
     
    protected function _getCollectionClass()
    {
        // This is the model we are using for the grid
        return 'vendor/vendor_collection';
    }
     
    protected function _prepareCollection()
    {
        // Get and set our collection for the grid
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
         
        return parent::_prepareCollection();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('vendor_id');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('vendor')->__('Delete'),
            'url'  => $this->getUrl('*/*/Delete', array('' => '')),    
            'confirm' => Mage::helper('vendor')->__('Are you sure?')
        ));

        return $this;
    }

    protected function _prepareColumns()
    {

        // Add the columns that should appear in the grid
        $this->addColumn('id',
            array(
                'header'=> $this->__('Id'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'id'
            )
        );

        $this->addColumn('name',
            array(
                'header'=> $this->__('Name'),
                'index' => 'name'
            )
        );

        $this->addColumn('email',
            array(
                'header'=> $this->__('Email'),
                'index' => 'email'
            )
        );

        $this->addColumn('status',
            array(
                'header'=> $this->__('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => $this->_getStatusOptions()
            )
        );

        $this->addColumn('createdDate',
            array(
                'header'=> $this->__('Created Date'),
                'index' => 'createdDate'
            )
        );

        $this->addColumn('action',
        array(
            'header'    =>  Mage::helper('vendor')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('vendor')->__('Delete'),
                    'url'     => array('base' =>  '*/*/delete'),
                    'field'   => 'id'
                )
            ),
        ));

        
        return parent::_prepareColumns();
    }
     
    protected function _getStatusOptions()
    {
        return Mage::getModel('vendor/vendor')->getStatusOptions();
    }   

    public function getRowUrl($row)
    {
         return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}