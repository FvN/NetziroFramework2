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
* TRACKING  LOG - LOG YOUR CHANGES ONLY IF YOU ARE DOING IMPORTANT UPDATES ( CHANGE OF METHOD, ADDING/DELETING LINES OF CODE, BUGFIX)
* ----------------------------------------------------------------------
* UPDATE : 
* MODDER: ALESSIO NOBILE / DATE AND HOUR : 02/11/2011 - 12:45
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
	 * Fetch All settings putting them into an array key value
	 * 
	 * @return array
	 */
	public static function FetchAll(){
		
		// ------------------------------------- | START Query executing
		$sql = "SELECT `value` FROM `nf_settings`";
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
			$sql = "SELECT `value` FROM `nf_settings` WHERE `key` = :key";
			$params = array( ':key' => $key );
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