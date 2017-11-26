<?php

namespace App\Lib;


Trait BulkDataQuery 
{
	/**
	* Build the values statement for Mysql Bulk insert query from Array
	* @param Array
	* @return string
	**/

	public function buildValueStatement(array $data)
	{	
		 $values = [];

		 array_walk($data, function($v) use (&$values){
	        
	        $columns_values = [];
	        array_walk($v, function($v1) use (&$values,&$columns_values){
	            	
	           	$slash_str =  addslashes($v1);

	           	switch (true) {
	           		case is_null($v1):
	           			$column_value = 'null';
	           			break;

	           		case is_numeric($v1):
	           			$column_value  = $v1;
	           			break;

	           		case $this->isAQuery($v1):
	           			$column_value = '('.rtrim($v1,';').')';
	           			break;

	           		default:
	           			$column_value = "'{$slash_str}'";
	           			break;
	           	}

	            $columns_values[] = $column_value;

	        });
	        $columns_values = implode(',', $columns_values);

	        $values[] = $columns_values;          
	    });

		return '('.implode('),(', $values).')';
	}

	/**
	* Function is checking the string is in mysql query format or not.
	* @param String
	* @return Bool
	**/

	function isAQuery($str)
	{
		return preg_match("/^(\s*?)select\s*?.*?\s*?from([\s]|[^;]|(['\"].*;.*['\"]))*?;\s*?$/i", $str);
	}

	/**
	 * Function builds the Insert and ignore statement.
	 * @param Array - Bulk data 
	 * @param String - $table - Table name.
	 * @return String
	 **/

	function insertIgnoreQuery(array $data,$table){

		if(!isset($data[0]) || !is_array($data[0])){
			return false;
		}

		$keys = array_keys($data[0]);
	    $keys = '`'.implode('`,`', $keys).'`';

	    $values = $this->buildValueStatement($data);

	    $query = "INSERT IGNORE INTO `{$table}` ({$keys}) values {$values}";
	    return  $query;
	}

	/**
	 * Function builds the Insert and Update statement.
	 * @param Array - Bulk data 
	 * @param String - $table - Table name.
	 * @param Array - Column name , which do you want to update.
	 * @return String
	 **/

	function insertUpdateQuery(array $data,$table, array $updateColumn){

		if(!isset($data[0]) || !is_array($data[0])){
			return false;
		}

		$keys = array_keys($data[0]);
	    $keys = '`'.implode('`,`', $keys).'`';

	    $values = $this->buildValueStatement($data);
	    
	    $updateColumns  =[];
        array_walk($updateColumn, function($v) use(&$updateColumns){

        	$updateColumns[] = '`'.$v.'`=  values(`'.$v.'`)';
        });

        $updateColumnsStr = implode(',', $updateColumns);


	    $query = "INSERT INTO `{$table}` ({$keys}) values {$values} ON DUPLICATE KEY UPDATE {$updateColumnsStr}";
	    return  $query;
	}

	/**
	 * Function executes the Insert the Update query.
	 * @param Array - Bulk data - $data
	 * @param Array - Column name , which do you want to update.
	 * @return Array
	 **/

	public static function bulkInsertUpdate(array $data,array $updateColumn,$size=10000)
	{	
		$totalData = count($data);
		if(!$totalData)
			return NULL;

		$inst = new static;

		$tableName = $inst->getTable();
		
		$nextId = $inst->getConnection()->select("SHOW TABLE STATUS LIKE '{$tableName}'");
		$nextId = isset($nextId[0]->Auto_increment)?$nextId[0]->Auto_increment:1;

		$chunkData = array_chunk($data, $size);

		foreach($chunkData as $rowData){

			$query = $inst->insertUpdateQuery($rowData,$tableName,$updateColumn);
			$inst->getConnection()->statement($query);			
		}
		
		$newMaxId = $inst->max($inst->getKeyName());
		$maxId = ($newMaxId+1);
		$inst->getConnection()->statement('ALTER TABLE '.$tableName.' AUTO_INCREMENT='.$maxId);

		$inserted = (($newMaxId-$nextId)+1);
		$inserted = ($inserted > $totalData)?$totalData:$inserted;
		$updated = ($totalData-$inserted);

		return ['total'=>$totalData,'updated'=>$updated,'inserted'=>$inserted];

	}

	/**
	 * Function executes the Insert the Ingore query.
	 * @param Array - Bulk data - $data
	 * @param Array - Column name , which do you want to update.
	 * @return Array
	 **/

	public static function bulkInsertIgnore(array $data,$size=10000)
	{		

		$totalData = count($data);
		if(!$totalData)
			return NULL;

		$inst = new static;
		$tableName = $inst->getTable();

		$nextId = $inst->getConnection()->select("SHOW TABLE STATUS LIKE '{$tableName}'");
		$nextId = isset($nextId[0]->Auto_increment)?$nextId[0]->Auto_increment:1;

		$chunkData = array_chunk($data, $size);

		foreach($chunkData as $rowData){

			$query = $inst->insertIgnoreQuery($rowData,$tableName);
			$inst->getConnection()->statement($query);			
		}		

		$newMaxId = $inst->max($inst->getKeyName());
		$maxId = ($newMaxId+1);
		$inst->getConnection()->statement('ALTER TABLE '.$tableName.' AUTO_INCREMENT='.$maxId);

		$inserted = (($newMaxId-$nextId)+1);
		$inserted = ($inserted > $totalData)?$totalData:$inserted;
		$ignored = ($totalData-$inserted);
		return ['total'=>$totalData,'ignored'=>$ignored,'inserted'=>$inserted];

	}
}	

