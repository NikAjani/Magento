<?php
class Ccc_Process_Block_Adminhtml_Process_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
         
        $this->setDefaultSort('id');
        $this->setId('process_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);

    }
     
    protected function _getCollectionClass()
    {
        return 'process/process_collection';
    }
     
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
         
        return parent::_prepareCollection();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('process_id');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('process')->__('Delete'),
            'url'  => $this->getUrl('*/*/Delete', array('' => '')),    
            'confirm' => Mage::helper('process')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('clean data', array(
            'label'=> Mage::helper('process')->__('Clean Data'),
            'url'  => $this->getUrl('*/*/cleanData', array('' => '')),    
            'confirm' => Mage::helper('process')->__('Are you sure?')
        ));

        return $this;
    }
     
    protected function _prepareColumns()
    {

        $this->addColumn('id',
            array(
                'header'=> $this->__('Id'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'processId'
            )
        );

        $this->addColumn('name',
            array(
                'header'=> $this->__('Name'),
                'index' => 'name'
            )
        );

        $this->addColumn('model',
            array(
                'header'=> $this->__('Model'),
                'index' => 'model'
            )
        );

        $this->addColumn('processType',
            array(
                'header'=> $this->__('Process Type'),
                'index' => 'processType',
                'width' => '50px',
                'type' => 'options',
                'options' => $this->_getProcessTypeOptions()
            )
        );

        $this->addColumn('processGroupId',
            array(
                'header'=> $this->__('Process Group'),
                'index' => 'processGroupId',
                 'width' => '50px',
                'type' => 'options',
                'options' => $this->_getGroupArray()
            )
        );

        $this->addColumn('filename',
            array(
                'header'=> $this->__('File Name'),
                'index' => 'filename',
            )
        );

        $this->addColumn('row_per_request)',
            array(
                'header'=> $this->__('Row Per Request'),
                'index' => 'row_per_request',
            )
        );

        $this->addColumn('upload',
        array(
            'header'    =>  Mage::helper('process')->__('Upload'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'width' => '50px',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('process')->__('Upload'),
                    'url'     => array('base' =>  '*/*/uploadFile'),
                    'field'   => 'id'
                )
            ),
        ));

        $this->addColumn('read',
        array(
            'header'    =>  Mage::helper('process')->__('Read'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'width' => '50px',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('process')->__('Read'),
                    'url'     => array('base' =>  '*/*/readFile'),
                    'field'   => 'id'
                )
            ),
        ));

        $this->addColumn('import',
        array(
            'header'    =>  Mage::helper('process')->__('Import'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'width' => '50px',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('process')->__('Import'),
                    'url'     => array('base' =>  '*/*/import'),
                    'field'   => 'id'
                )
            ),
        ));

        $this->addColumn('action',
        array(
            'header'    =>  Mage::helper('process')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('process')->__('Delete'),
                    'url'     => array('base' =>  '*/*/delete'),
                    'confirm' => Mage::helper('process')->__('Are you sure?'),
                    'field'   => 'id'
                )
            ),
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('process')->__('CSV'));
        
        $this->addExportType('*/*/exportXml', Mage::helper('process')->__('XML')); 
        
        return parent::_prepareColumns();
    }
     
   protected function _getProcessTypeOptions()
   {
       return Mage::getModel('process/process')->getProcessTypeOptions();
   }

   protected function _getGroupArray()
   {
       return Mage::getModel('process/process')->getGroupArray();
   }

    public function getRowUrl($row)
    {
         return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}