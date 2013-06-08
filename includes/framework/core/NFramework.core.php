<?php
/*
* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - NFramework
* ----------------------------------------------------------------------
* FILE RELATIVE LOCATION:	core/NFramework.core.php
* CREATOR:					Alessio Nobile
* CREATING DATA:			02/01/12
* ----------------------------------------------------------------------
* FILE DESCRIPTION:			NFCore class will contain core methods used overall the application
* ----------------------------------------------------------------------
*/

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFramework
 *
 * @desc
 * NFramework class will contain core methods used overall the application
 * 
 */
class NFramework{
	
	/**
	 * @var $configurations_path
	 */
	public static $configurations_path = "config/NFConfig.core.php";
	
	/**
	 * @var $credentials
	 */
	protected static $credentials = array();
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * 
	 *
	 */
	public static function InitConf(){
		
		if( file_exists( self::$configurations_path ) ){
	
			require_once( self::$configurations_path );
			
			if( isset( $credentials ) ){
				
				self::$credentials = $credentials;
				unset( $credentials );
				
			} else { throw new Exception( "NFAutoloader - You tried to load the DB credentials configurations, but it doesn't exist" , 11 ); }
			
		} else { throw new Exception( "NFAutoloader - You tried to load the configuration file, but the file doesn't exist" , 10 ); }
		
	}
	
}
