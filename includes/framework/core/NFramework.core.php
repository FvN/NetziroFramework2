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
	 * @var $autoloader_array
	 */
	public static $autoloader_array = array();
	
	/**
	 * @var $autoloader_path
	 */
	public static $autoloader_path = "includes/framework/autoloader/NFAutoloader.core.php";
	
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
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Include the Autoloader array
	 *
	 */
	public static function InitAutoloader(){
		
		if( file_exists( self::$autoloader_path ) ){
	
			require_once( self::$autoloader_path );
			
			if( isset( $autoloader ) ){
				
				self::$autoloader_array = $autoloader;
				spl_autoload_register( array( "NFramework", "AutoLoader" ) );
				unset( $autoloader );
				
			} else { throw new Exception( "NFAutoloader - You tried to load the autoloader array, but seems to be empty" , 11 ); }
			
		} else { throw new Exception( "NFAutoloader - You tried to load the autoloader array, but the file doesn't exist" , 10 ); }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Add a new key into the autoloader array 
	 *
	 */
	public static function AddAutoloaderKey( $key, $value ){

		if( !empty( $key ) AND !empty( $value ) ){
			
			self::$autoloader_array[ $key ] = $value;
			
		}
		
	}
		
	/**
	 * @desc
	 * Netziro Framework AutoLoader method
	 * 
	 */
	public static function AutoLoader( $class ){
		
		switch( $class ){
									
			// ------------------------------------- | START NFTheme
			case "NFTheme":
				
				$template_init = NFUserInterface::GetTemplateInit();
				
				if( file_exists( $template_init ) ){
					
					require_once( $template_init );
					unset( $template_init );
						
				} else { throw new Exception( "NFAutoloader - You tried to load the template $class, but the file doesn't exist" , 9 ); }
				
				break;
			// ------------------------------------- | END
			
			// ------------------------------------- | START Default case
			default:
				
				if( key_exists( $class , self::$autoloader_array ) ){
					
					if( file_exists( self::$autoloader_array[ $class ] ) ){
						
						require_once( self::$autoloader_array[ $class ] );
						
					}// else { throw new Exception( "NFAutoloader - You tried to load the class $class, but the file doesn't exist" , 7 ); }
					
				}// else { throw new Exception( "NFAutoloader - You tried to load the class $class, but cannot be associated" , 6 ); }
					
				break;
			// ------------------------------------- | END
			
		}
		
	}
		
	
}
