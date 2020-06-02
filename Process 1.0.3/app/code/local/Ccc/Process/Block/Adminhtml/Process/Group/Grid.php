<?php
class Ccc_Process_Block_Adminhtml_Process_Group_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
         
        $this->setDefaultSort('id');
        $this->setId('process_group_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);

    }
     
    protected function _getCollectionClass()
    {
        return 'process/process_group_collection';
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
        $this->getMassactionBlock()->setFormFieldName('group_id');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('process')->__('Delete'),
            'url'  => $this->getUrl('*/*/Delete', array('' => '')),    
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
                'index' => 'groupId'
            )
        );

        $this->addColumn('name',
            array(
                'header'=> $this->__('Name'),
                'index' => 'name'
            )
        );


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
                    'field'   => 'id'
                )
            ),
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('process')->__('CSV'));
        
        $this->addExportType('*/*/exportXml', Mage::helper('process')->__('XML')); 
        
        return parent::_prepareColumns();
    }
     
   

    public function getRowUrl($row)
    {
         return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}