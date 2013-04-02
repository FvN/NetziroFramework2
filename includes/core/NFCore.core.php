<?php
/*
* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - NFCore
* ----------------------------------------------------------------------
* FILE RELATIVE LOCATION:	core/NFCore.core.php
* CREATOR:					Alessio Nobile
* CREATING DATA:			02/01/12
* ----------------------------------------------------------------------
* FILE DESCRIPTION:			NFCore class will contain core methods used overall the application
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
 * @package		NFCore
 *
 * @desc
 * NFCore class will contain core methods used overall the application
 * 
 */
class NFCore extends NFramework{

	public static $database_links = array();
	public static $database_links_counter = 0;
	
	/**
	 * @desc
	 * Load Database links
	 * 
	 */
	public static function LoadDatabaseLinks(){
		
		global $credentials;
		
		if( is_array( $credentials ) ){
				
			foreach( $credentials as $profile_name => $credential ){
				
				if( empty( $profile_name ) ){ $profile_name = self::$database_links_counter; }
				self::$database_links[ $profile_name ] = new NFDatabase( $credential );
				self::$database_links[ $profile_name ]->OpenLink();
				self::$database_links_counter++;
				
			}
			
		} else { throw new Exception( "Database credentials array has been not instanciated yet. Check your NFConfig file", 1000 ); } 
		
	}
	
	/**
	 * @desc
	 * Define PHP Settings
	 * 
	 */
	public static function DefinePHPSettings(){
		
		// ------------------------------------- | START Define the maximum upload file size
		if( defined( "NF_INSTANCE_UPLOAD_MAXFILESIZE" ) AND ctype_alnum( NF_INSTANCE_UPLOAD_MAXFILESIZE ) ){ ini_set( "upload_max_filesize", NF_INSTANCE_UPLOAD_MAXFILESIZE ); }
		ini_set( "auto_detect_line_endings", TRUE );
		// ------------------------------------- | END
		
	}
	
	/**
	 * @desc
	 * Check if the session has been started
	 * 
	 */
	public static function CheckSession(){
		if( session_status() != PHP_SESSION_ACTIVE ){ throw new Exception( "Netziro Framework session has been not started yet", 2 ); }
	}
	
	/**
	 * @desc
	 * Check if the Netziro Framework has been defined
	 * 
	 */
	public static function CheckInstance(){
		
		if( !defined( "NF_INSTANCE" ) ){ throw new Exception( "Netziro Framework instance not defined yet", 1 ); }
	}
	
	/**
	 * @desc
	 * Check if the session has been started
	 * 
	 */
	public static function DefineDebugSettings(){
		
		// ------------------------------------- | START Check if debug mode is on
		if( defined( "NF_INSTANCE_DEBUG" ) AND NF_INSTANCE_DEBUG ){ error_reporting( E_ALL ); ini_set( "display_errors", 1 ); }
		// ------------------------------------- | END
		
		// ------------------------------------- | START Check if backtrace needs to be printed out at the end of the execution
		if( defined( "NF_INSTANCE_LOG_BACKTRACE" ) AND NF_INSTANCE_LOG_BACKTRACE ){
			register_shutdown_function( array( "NFLogger", "BackTracePrint" ) );
		}
		// ------------------------------------- | END
	}
	
	/**
	 * @desc
	 * Defining timezone settings
	 * 
	 */
	public static function DefineTimeZoneSettings(){
	
		// ------------------------------------- | START Fetch settings from get/session
		if( isset( $_GET[ "timezone" ] ) ){ 
			$timezone = $_GET[ "timezone" ];
		} elseif ( isset( $_SESSION[ "timezone" ] ) ) {
			$timezone = $_SESSION[ "timezone" ];
		} else {
			if( defined( "NF_INSTANCE_TIMEZONE_DEFAULT" ) ){ $timezone = NF_INSTANCE_TIMEZONE_DEFAULT; }
		}
		// ------------------------------------- | END
		
		// ------------------------------------- | START Check if the timezone is supported
		$zones = timezone_identifiers_list();
		if( !in_array( $timezone , $zones ) ){ throw new Exception( "Netziro Framework $timezone timezone not supported", 20 ); }
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define Timezone
		define( 'NF_INSTANCE_TIMEZONE', $timezone );
		date_default_timezone_set( NF_INSTANCE_TIMEZONE );
		// ------------------------------------- | END
		
		// ------------------------------------- | START Unset Variables
		unset( $timezone );
		unset( $zones );
		// ------------------------------------- | END
		
	}
	
	/**
	 * @desc
	 * Defining Locale settings format based on RFC 5646
	 * Ex. en-EN
	 * 
	 * language_COUNTRY
	 * 
	 */
	public static function DefineLocaleSettings(){
		
		// ------------------------------------- | START Fetch settings from get/session
		if( isset( $_GET[ "locale" ] ) ){ 
			$locale = $_GET[ "locale" ];
		} elseif ( isset( $_SESSION[ "locale" ] ) ) {
			$locale = $_SESSION[ "locale" ];
		} else {
			$locale = NFIntl::LocaleHttpHeader();
			if( empty( $locale ) ){
				if( defined( "NF_INSTANCE_LOCALE_DEFAULT" ) ){ $locale = NF_INSTANCE_LOCALE_DEFAULT; }	
			}
		}
		// ------------------------------------- | END
		
		// ------------------------------------- | START If $lang layout isn't correct, we set default locale
		$locales = NFIntl::GetLocalesSupported( );
		if( strlen( $locale ) != 5 AND substr( $locale, 2, 1 ) != "_" ){ throw new Exception( "Netziro Framework $locale locale format not correct", 10 ); }
		if( !in_array( $locale , $locales ) ){ throw new Exception( "Netziro Framework $locale locale is not supported", 11 ); }
		// ------------------------------------- | END
		
		// ------------------------------------- | START Set locale for the instance
		NFIntl::SetLocale( $locale );
		// ------------------------------------- | END
		
		// ------------------------------------- | START Unset variables
		unset( $locales );
		unset( $locale );
		unset( $locale_file );
		// ------------------------------------- | END
		
	}
		
	/**
	 * @desc
	 * This function will define application's URL and real path
	 * 
	 */
	public static function DefineApplicationPath(){
		
		// ------------------------------------- | START Fetch instance informations
		$script_filename = $_SERVER[ "SCRIPT_FILENAME" ];
		$script_name = $_SERVER[ "SCRIPT_NAME" ];
		$request_uri = $_SERVER[ "REQUEST_URI" ];
		$server_name = $_SERVER[ "SERVER_NAME" ];
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define Application URL
		$script_name_exploded = explode( "/", $script_name );
		$last_index = count( $script_name_exploded );
		unset( $script_name_exploded[ $last_index -1 ] );
		$relative_directory = implode( "/", $script_name_exploded );
		$application_url = "http://$server_name$relative_directory/";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define Application Real directory
		$script_filename_exploded = explode( "/", $script_filename );
		$last_index = count( $script_filename_exploded );
		unset( $script_filename_exploded[ $last_index -1 ] );
		$real_directory = implode( "/", $script_filename_exploded ) . "/";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define relative path
		$relative_directory = substr( $relative_directory, 1 ) . "/";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define Constants
		define( "NF_INSTANCE_URL", $application_url );
		define( "NF_INSTANCE_ROOT_DIRECTORY", $real_directory );
		define( "NF_INSTANCE_ROOT_RELATIVE", $relative_directory );
		// ------------------------------------- | END
		
		// ------------------------------------- | START Unset variables
		unset( $application_url );
		unset( $real_directory );
		unset( $relative_directory );
		unset( $script_filename );
		unset( $script_name );
		unset( $request_uri );
		unset( $server_name );
		unset( $script_name_exploded );
		unset( $last_index );
		// ------------------------------------- | END
		
		
	}
	
	/**
	 * @desc
	 * This function will print out an array having <pre>$array</pre>
	 * 
	 */
	public static function PrintPre( $array ){
			
		echo "<pre>";
			print_r( $array );
		echo "</pre>";
			
	}
	
}