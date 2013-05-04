<?php
/*
* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - NFSettings
* ----------------------------------------------------------------------
* FILE RELATIVE LOCATION:	core/NFSettings.core.php
* CREATOR:					Alessio Nobile
* CREATING DATA:			02/01/12
* ----------------------------------------------------------------------
* FILE DESCRIPTION:			NFSettings class will contain core methods to handle framework settings
* ----------------------------------------------------------------------
*/

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFSettings
 *
 * @desc
 * NFSettings class will contain core methods to handle framework settings
 * 
 */
class NFSettings extends NFramework{
	
	
	/**
	 * @desc
	 * Check if the settings table exists
	 * 
	 * @return array
	 */
	public static function IsTableExisting(){
		
		// ------------------------------------- | START Query executing
		$sql = "SELECT COUNT(*) AS `check` FROM `information_schema`.`tables` WHERE `table_schema` = :database_name AND `table_name` = :table_name;";
		$params = array( ':table_name' => NFDependencies::GetCoreSettingsTableName(), ':database_name' => NFCore::$database_links[ "master" ]->GetDatabaseName() );
		$results = NFCore::$database_links[ "master" ]->Query( $sql, $params );
		$rows = NFCore::$database_links[ "master" ]->GetRows();
		// ------------------------------------- | END
			
		// ------------------------------------- | START Return results if there are, false otherwise
		if( $rows == 1 ){
			
			return $results[ 0 ][ "check" ];
				
		} else { return false; }
		// ------------------------------------- | END
		
	}
	
	/**
	 * @desc
	 * Fetch All settings putting them into an array key value
	 * 
	 * @return array
	 */
	public static function FetchAll(){
		
		// ------------------------------------- | START Query executing
		$table_name = NFDependencies::GetCoreSettingsTableName();
		$sql = "SELECT `value` FROM $table_name";
		$results = NFCore::$database_links[ "master" ]->Query( $sql );
		$rows = NFCore::$database_links[ "master" ]->GetRows();
		// ------------------------------------- | END
			
		// ------------------------------------- | START Return results if there are, false otherwise
		if( $rows != 0 ){
			
			return $results;
				
		} else { return false; }
		// ------------------------------------- | END
		
	}
	
	/**
	 * @desc
	 * Fetch the value by a given $key
	 * 
	 * @param string $key
	 * 
	 * @return string
	 */
	public static function FetchByKey( $key ){
		
		// ------------------------------------- | START Process the request if $key is a sane value
		if( !empty( $key ) AND ctype_alnum( $key ) ){
			
			// ------------------------------------- | START Query executing
			$table_name = NFDependencies::GetCoreSettingsTableName();
			$sql = "SELECT `value` FROM `$table_name` WHERE `key` = :string_value";
			$params = array( ":string_value" => $key );
			$results = NFCore::$database_links[ "master" ]->Query( $sql, $params );
			$rows = NFCore::$database_links[ "master" ]->GetRows();
			// ------------------------------------- | END
			
			// ------------------------------------- | START Data Processing if there is a single result
			if( $rows == 1 ){
				
				return $results[ 0 ][ "value" ];
				
			} else { return false; }
			// ------------------------------------- | END
			
		} else { return false; }
		// ------------------------------------- | END
		
	}
	
}