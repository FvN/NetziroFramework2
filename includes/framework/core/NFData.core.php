<?php
/*
* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - NFData
* ----------------------------------------------------------------------
* FILE RELATIVE LOCATION:	includes/framework/core/NFCore.core.php
* CREATOR:					Alessio Nobile
* CREATING DATA:			02/01/12
* ----------------------------------------------------------------------
* FILE DESCRIPTION:			NFData
* ----------------------------------------------------------------------
*/

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFData
 *
 * @desc
 *  
 * ERROR CODES 0-1000
 * 
 */
class NFData extends NFramework{
	
	/**
	 * Supported datatypes
	 * @var array
	 */
	protected static $dataset_field_types = array(	"tinyint", "smallint", "mediumint", "int", "bigint", "decimal", "float", 
											"varchar", "char", "tinytext", "mediumtext", "longtext", "text",
											"timestamp", "datetime", "year", "time", "date" );
	
	/**
	 * Supported data validation types
	 * @var array
	 */
	protected static $data_validation_types = array( "email", "date", "datetime", "financial_value" );
	
	/**
	 * Supported indexes
	 * @var string
	 */
	protected static $indexes = array( "unique", "normal" );
	
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Check if the data type is supported
	 *
	 */
	public static function IsSupportedDataType( $type ){
		
		if( !empty( $type ) ){
			
			if( in_array( $type , self::$dataset_field_types ) ){
				
				return true;
				
			} else { return false; }
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Check if the data validation type is supported
	 *
	 */
	public static function IsSupportedDataValidationType( $type ){
		
		if( !empty( $type ) ){
			
			if( in_array( $type , self::$data_validation_types ) ){
				
				return true;
				
			} else { return false; }
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Check if the data validation type is supported
	 *
	 */
	public static function IsSupportedIndexType( $type ){
		
		if( !empty( $type ) ){
			
			if( in_array( $type , self::$indexes ) ){
				
				return true;
				
			} else { return false; }
			
		} else { return false; }
		
	}
	
	
}