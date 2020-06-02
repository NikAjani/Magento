<?php
class Ccc_Process_Model_Process extends Mage_Core_Model_Abstract
{

	const IMPORT = 0;
	const EXPORT = 1;
	const EXECUTE = 2;
	const IMPORT_LABEL = "Import";
	const EXPORT_LABEL = "Export";
	const EXECUTE_LABEL = "Execute";

	protected $_filePath = null;

	protected $_header = [];

	protected $_requireColumns = ['sku'];

	protected $_identifier = 'sku';
	
	protected $_readData = [];

	protected $_finalData = [];
	
	protected $_products = null;

	protected $reportedData = [];
	
	protected $_attributes = null;

    protected function _construct()
    {  
        $this->_init('process/process');
        $this->setFilePath();
    }

    public function setFilePath($filePath = null)
    {
    	if($filePath == null)
    		$filePath = (Mage::getBaseDir('media') . DS .('process') . DS . ('import'));

    	$this->_filePath = $filePath;
    	return $this;
    }

    public function getFilePath()
    {
    	return $this->_filePath;
    }
  
	public function getFile()
	{
		if(!$this->getId())
		{
			return null;
		}
		return $this->getFilePath().DS.$this->filename;
	}

	public function setHeader($header)
	{
		$this->_header = $header;
			
		return $this;
	}

	public function getHeader()
	{
		return $this->_header;
	}

	public function setReadData($rows)
	{
		if(!is_array($rows))
			throw new Exception('Data must be in arrray');
			
		$this->_readData = $rows;
		return $this;
	}

	public function addReadData($key, $value)
	{
		if(!is_array($value))
			throw new Exception('Data must be in arrray');
			
		$this->_readData[$key] = $value;
		return $this;
	}

	public function removeReadData($key = null)
	{
		if($key == null) {
			unset($this->_readData);
			return $this;
		}
		unset($this->_readData[$key]);
		return $this;
	}

	public function setRequireColumns($requireColumns)
	{
		$this->_requireColumns = $requireColumns;
		return $this;
	}

	public function getRequireColumns()
	{
		return $this->_requireColumns;
	}

	public function setIdentifier($identifier)
	{
		$this->_identifier = $identifier;
		return $this;
	}

	public function getIdentifier()
	{
		return $this->_identifier;
	}

	public function getReadData()
	{
		return $this->_readData;
	}

	public function setFinalData($finalData)
	{
		if(!is_array($finalData))
			throw new Exception('Final data must be in array');
		
		$this->_finalData = $finalData;
		return $this;
	}

	public function getFinalData()
	{
		return $this->_finalData;
	}

	public function setReportedData($reportedData)
    {
        if (!is_array($reportedData)) {
            throw new Exception('data must be in array');
        }
        $this->reportedData = $reportedData;
        return $this;
    }

    public function addReportedData($key, $value)
    {
        $this->reportedData[$key] = $value;
        return $this;
    }

    public function getReportedData($key = null)
    {
        if ($key === null) {
            return $this->reportedData;
        }
        return $this->reportedData[$key] ?? null;
    }

    public function removeReportedData($key = null)
    {
        if ($key === null) {
            unset($this->reportedData);
            return $this;
        }
        unset($this->reportedData[$key]);
        return $this;
    }

    public function getProcessTypeOptions()
	{
	  	return [
	        self::IMPORT => self::IMPORT_LABEL,
	        self::EXPORT => self::EXPORT_LABEL,
	        self::EXECUTE => self::EXECUTE_LABEL
	    ];
	}

	public function getGroupArray()
	 {
	 	$collection = $this->getCollection()
	 					->getSelect()
	 					->getAdapter()
	 					->fetchPairs("SELECT groupId,name FROM `{$this->getResource()->getTable('process/process_group')}`");

	 	return $collection;
	 }

	 public function loadProducts()
	 {
	 	$productsPairs = $this->getCollection()
	 					->getSelect()
	 					->getAdapter()
	 					->fetchPairs("SELECT sku, entity_id FROM `{$this->getResource()->getTable('catalog/product')}`");

	 	$this->_products = $productsPairs;
	 	return $this;
	 }

	 public function getProducts()
	 {
	 	return $this->_products;
	 }

	 public function loadAttributes()
	 {
	 	$attributePairs = $this->getCollection()
	 					->getSelect()
	 					->getAdapter()
	 					->fetchPairs("SELECT attribute_code,attribute_id FROM `{$this->getResource()->getTable('eav/attribute')}` WHERE entity_type_id = 4");

	 	$this->_attributes = $attributePairs;
	 	return $this;
	 }

	 public function getAttributes()
	 {
	 	return $this->_attributes;
	 }

	public function fileUpload($file)
	{

		$fileName = $this->name.'.csv';
		

        if(file_exists($this->getFile())){
            unlink($this->getFile());
        }

		$uploader = new Varien_File_Uploader($file);
		$uploader->setAllowRenameFiles(false);
		$uploader->setAllowedExtensions(array('csv'));
		$uploader->setFilesDispersion(false);

		if(!$uploader->save($this->getFilePath(), $fileName))
			throw new Exception('Error in file upload');
		
		$this->filename = $fileName;
		
		$this->save();

		return true;
	}

	public function readFile()
	 {

 		$csvObject = new Varien_File_Csv();
    	$rows = $csvObject->getData($this->getFile());

    	$cnt = true;

    	$this->setHeader(array_shift($rows));

    	if (array_diff($this->getRequireColumns(), $this->getHeader())) {
            throw new Exception('Please insert require fields. ');
        }

    	foreach ($rows as $key => $row) {
    		
			$rows[$key] = array_combine($this->getHeader(), $row);
    	}
		
		$this->setReadData($rows);
    	unset($rows);
    	$this->verifyData();
    	$this->errorReportExport();

    	if(!$this->getFinalData())
    		throw new Exception('Check error report');

    	$this->insertData();
    	return $this;
	 } 

	 public function verifyData()
	 {
	 	$readData = $this->getReadData();
	 	if(!$readData)
			throw new Exception("No data found.");

		$this->loadProducts();
		$this->loadAttributes();
		$products = $this->getProducts();
        $attributes = $this->getAttributes();


		$rowTmp = [
			'entity_type_id' => 4,
			'entity_id' => null,
			'attribute_id' => null,
			'value' => null,
			'store_id' => 0
		];

		$finalData = [];

		foreach ($readData as $key => $row) {
			
			try {
				
				if(!array_key_exists($row[$this->getIdentifier()], $products))
					throw new Exception("Missing SKU.");

				if(array_key_exists($row[$this->getIdentifier()], $finalData))
					throw new Exception('record is not unique.');


				$oneRecord = array();
                foreach ($row as $attributeCode => $value) {

                	if (in_array($attributeCode, $this->getRequireColumns())) {
						continue;
					}
                    
                    $attributeId = $attributes[$attributeCode] ?? null;

                    if ($attributeId == null) 
                        continue;
                    
                    $entityId = $products[$row[$this->getIdentifier()]] ?? null;
                    
                    if ($entityId == null) 
                        throw new Exception('record identification failed');
                    
                    $record = $rowTmp;
                    $record['entity_id'] = $entityId;
                    $record['attribute_id'] = $attributeId;
                    $record['value'] = $value;
                    $oneRecord[] = $record;
                }

                $finalData[$row[$this->getIdentifier()]] = $oneRecord;

			} catch (Exception $e) {
                $this->addReportedData($key, array_merge($row, array('status' => 'failure', 'message' => $e->getMessage())));
                $this->removeReadData($key);
            }
 
		}

		$this->setFinalData($finalData);
		unset($finalData);
		unset($rowTmp);		
		return $this;
	 }

	public function errorReportExport()
    {
        if(!$rows = $this->getReportedData())
        	return false;

        $header = array_merge($this->getHeader(), array('status', 'message'));
       
        $data = array($header);

        foreach ($rows as $row) {
            $record = array();
            foreach ($header as $key) {
                $record[] = $row[$key];
            }
            $data[] = $record;
        }
        $csv = new Varien_File_Csv();

        $filename = $this->name.'_report.csv';

        $filename = $this->getFilePath() . DS . $filename;

        $csv->saveData($filename, $data);
    }

    public function insertData()
    {

    	if(!$rows = $this->getFinalData())
    		throw new Exception('No data found check error report');

		$dataModel = Mage::getModel('process/process_data');
    	
    	foreach ($rows as $key => $row) {
    		$dataModel->setData([
    			'processId' => $this->getId(),
    			'identifier' => $key,
    			'data' => json_encode($row)
    		])->save();
    	}
    		
    }

    public function cleanData()
    {
        $processData = Mage::getModel('process/process_data');
        $processData->_getResource()->beginTransaction();
        try {
            $records = $processData->getCollection()
                ->addFieldToFilter('processId', $this->getId());
            foreach ($records as $record) {
                $record->delete()->save();
            }
            $processData->_getResource()->commit();
        } catch (Exception $e) {
            $processData->_getResource()->rollBack();
            throw $e;
        }
        return $this;
    }

    public function getModel()
    {
    	return Mage::getModel($this->model);
    }

    public function getDataCollection()
    {
    	$processData = Mage::getModel('process/process_data');
    	$records = $processData->getCollection()
                ->addFieldToFilter('processId', $this->getId())
                ->addFieldToFilter('startTime', '')
                ->addFieldToFilter('endTime', '');

        $records->getSelect()->limit($this->row_per_request);

        return $records;
    }

    public function importData()
    {

    	echo '<pre>';

    	$collection = $this->getDataCollection();

    	if(!$collection->getData())
    		throw new Exception('No records found to process.');
    		

    	date_default_timezone_set('Asia/Kolkata');

    	while ($collection->getData()) {

    		$write = Mage::getSingleton("core/resource")->getConnection("core_write");
    		
    		foreach ($collection as $row) {
    			
    			$row['startTime'] = date("Y-m-d H:i:s",time());

    			$rowData = (array) json_decode($row->getData('data'), true);

    			foreach ($rowData as $key => $value) {

    				$attribute = Mage::getModel('eav/entity_attribute');

    				$attribute->load($value['attribute_id']);


					$query = "DELETE FROM `{$attribute->getBackendTable()}` WHERE `attribute_id`=:attribute_id AND `store_id`=:store_id AND `entity_id`=:entity_id";

					$bind = array(
					'attribute_id' => $value['attribute_id'],
					'store_id' => $value['store_id'],
					'entity_id' => $value['entity_id'],
					);

					$write->query($query, $bind);

					$query = "INSERT INTO `{$attribute->getBackendTable()}` (entity_type_id, attribute_id, store_id, entity_id, value) VALUES (:entity_type_id, :attribute_id, :store_id, :entity_id, :value)";

					$write->query($query, $value);
    			}

    			$row['endTime'] = date("Y-m-d H:i:s",time());
    			print_r($row);
    			$row->save();
    			
    		}

    		$collection = $this->getDataCollection();
    	}
       
       return true;
    }

}