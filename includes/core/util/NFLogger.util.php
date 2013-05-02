<?php
/*
    This file is part of Netziro Framework.

    Netziro Framework is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Netziro Framework is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Netziro Framework.  If not, see <http://www.gnu.org/licenses/>.

* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - LOGGER CLASS
* ----------------------------------------------------------------------
* SOFTWARE UNDER GPL LICENSE
* AUTHOR Alessio Nobile >> www.netziro.it >> netziro@gmail.com
* ----------------------------------------------------------------------
* CLASS NAME:				NFLogger
* FILE RELATIVE LOCATION:	core/util/NFLogger.util.php
* CREATOR:					Alessio Nobile
* ----------------------------------------------------------------------
* CLASS DESCRIPTION:		This is a static class which will be included overall projects and it will fetch all logs from your platform
* 							in order to store it somewhere you will like
* ----------------------------------------------------------------------
*/

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFLogger
 *
 * @desc
 * This is a static class which will be included overall projects and it will fetch all logs from your platform
 * in order to store it somewhere you will like
 * 
 * LOG/ERRORS LEVELS
 * 
 * 0 - Critical Error which is affecting the application behavior
 * 1 - Medium importance error which is affecting single classes on the application
 * 3 - Notices ( DEFAULT ) 
 * 
 */

class NFLogger extends NFramework{
	
	private static $array_errors_code = array();
	
	private static $array_log = array();
	
	/**
	 * @desc
	 * Static method which will write the given log into an array
	 *  
	 * @param intege $level		| Log importance level
	 * @param string $log		| Log text
	 * @param string $class		| Class where the log come from
	 * @param intege $code		| Log/Error code
	 *  
	 */
	public static function LogWrite( $level = 3, $log, $class = "General", $code = 0 ){
		
		if( !empty( $log ) ){
				
			self::$array_log[ $level ][ $class ][ ][ "message" ] = "$class - ( $code ) $log";
			self::$array_log[ $level ][ $class ][ ][ "code" ] = $code;
			self::$array_log[ $level ][ $class ][ ][ "log" ] = $log;
			
			if( defined( "NF_INSTANCE_LOG_OUTPUT" ) AND NF_INSTANCE_LOG_OUTPUT ){ echo "$class - ( $code ) $log"; }
			
		}
		
	}
	
	/**
	 * @desc
	 * Static method which will read logs from the given class
	 *  
	 */
	public static function LogRead(){
		
	}
	
	/**
	 * @desc
	 * Error code inint
	 *  
	 */
	public static function ErrorCodeInit(){
		
	}
	
	/**
	 * @desc
	 * Errors code list
	 *  
	 */ 
	public static function ErrorCodeList(){
		
		// ------------------------------------- | START Netziro Framework Core errors
		self::$array_errors_code[ 1 ] = "Netziro Framework - Instance not defined yet";
		self::$array_errors_code[ 2 ] = "Netziro Framework - Session has been not started yet";	
		self::$array_errors_code[ 3 ] = "Netziro Framework - Tried to init the instance but we couldn't recognize the instance type";
		self::$array_errors_code[ 4 ] = "Netziro Framework - Requires PHP 5.4>. You got " . PHP_MAJOR_VERSION . "." . PHP_MINOR_VERSION;
		self::$array_errors_code[ 5 ] = "Netziro Framework - Requires the PHP {{details}} module";
		// ------------------------------------- | END
		
		// ------------------------------------- | START NFAutoloader errors
		self::$array_errors_code[ 6 ] = "NFAutoloader - You tried to load the class {{details}}, but cannot be associated";
		self::$array_errors_code[ 7 ] = "NFAutoloader - You tried to load the class {{details}}, but the file doesn't exist";
		self::$array_errors_code[ 8 ] = "NFAutoloader - You tried to load the module {{details}}, but the file doesn't exist";
		self::$array_errors_code[ 9 ] = "NFAutoloader - You tried to load the template {{details}}, but the file doesn't exist";
		self::$array_errors_code[ 10 ] = "NFAutoloader - You tried to load the configuration file, but the file doesn't exist";
		self::$array_errors_code[ 11 ] = "NFAutoloader - You tried to load the DB credentials configurations, but it doesn't exist";
		// ------------------------------------- | END
		
		// ------------------------------------- | START NFIntl errors
		self::$array_errors_code[ 15 ] = "NFIntl - SetLocale failed. Empty locale value";
		self::$array_errors_code[ 20 ] = "NFIntl - {{details}} timezone not supported";
		self::$array_errors_code[ 21 ] = "NFIntl - {{details}} locale format not correct";
		self::$array_errors_code[ 22 ] = "NFIntl - {{details}} locale is not supported";
		// ------------------------------------- | END
		
		// ------------------------------------- | START NFDatabase errors
		self::$array_errors_code[ 1000 ] = "NFDatabase - Database credentials array has been not instanciated yet. Check your NFConfig file";
		self::$array_errors_code[ 1001 ] = "NFDatabase - You must specify the hostname";
		self::$array_errors_code[ 1002 ] = "NFDatabase - You must specify the database name";
		self::$array_errors_code[ 1003 ] = "NFDatabase - You must specify an username";
		self::$array_errors_code[ 1004 ] = "NFDatabase - You must specify a password";
		self::$array_errors_code[ 1010 ] = "NFDatabase - You have specified a db profile, but the file has been not found";
		self::$array_errors_code[ 1020 ] = "NFDatabase - The database class is locked";
		self::$array_errors_code[ 1030 ] = "NFDatabase - Something wrong on the query";
		// ------------------------------------- | END
		
		// ------------------------------------- | START NFUserInterface errors
		self::$array_errors_code[ 4000 ] = "NFUserInterface - The template {{details}} directory or index doesn't exist";
		// ------------------------------------- | END
		
		
	}
	
	/**
	 * @desc
	 * Print out the TraceBack
	 *  
	 */
	public static function BackTracePrint(){
		
		// ------------------------------------- | START Request info
		echo "<hr />";
		echo "<h5>Request informations:</h5>";
		echo "<div class=\"debug-div\">";
			echo "<strong>Server:</strong> " . $_SERVER[ "SERVER_ADDR" ] . "<br />";
			echo "<strong>Server Name:</strong> " . $_SERVER[ "SERVER_NAME" ] . "<br />";
			echo "<strong>Request method:</strong> " . $_SERVER[ "REQUEST_METHOD" ] . "<br />";
			echo "<strong>Request URI:</strong> " . $_SERVER[ "REQUEST_URI" ] . "<br />";
			echo "<strong>Request Script:</strong> " . $_SERVER[ "PHP_SELF" ] . "<br />";
			echo "<strong>Request ScriptName:</strong> " . $_SERVER[ "SCRIPT_NAME" ] . "<br />";
			echo "<strong>Remote IP:</strong> " . $_SERVER[ "REMOTE_ADDR" ] . "<br />";
			echo "<strong>NF_INSTANCE_URL:</strong> " . NF_INSTANCE_URL . "<br />";
			echo "<strong>NF_INSTANCE_ROOT_DIRECTORY:</strong> " . NF_INSTANCE_ROOT_DIRECTORY . "<br />";
			echo "<strong>NF_INSTANCE_ROOT_RELATIVE:</strong> " . NF_INSTANCE_ROOT_RELATIVE . "<br />";
		echo "</div>";
		echo "<hr />";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Logs printing
		echo "<h5>Netziro Framework logs:</h5>";
		echo "<div class=\"debug-div\">";
			NFCore::PrintPre( self::$array_log );
		echo "</div>";
		echo "<hr />";
		// ------------------------------------- | END
		
		// ------------------------------------- | START print out the list of included files
		echo "<h5>File Included:</h5>";
		echo "<div class=\"debug-div\">";
			NFCore::PrintPre( get_included_files() );
		echo "</div>";
		echo "<hr />";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Request vars
		echo "<h5>Request Vars:</h5>";
		echo "<div class=\"debug-div\">";
			NFCore::PrintPre( $_REQUEST );
		echo "</div>";
		echo "<hr />";
		
		// ------------------------------------- | END
		
		// ------------------------------------- | START Request headers
		if( function_exists( "apache_request_headers" ) AND function_exists( "apache_response_headers" ) ){
			echo "<h5>Apache headers:</h5>";
			echo "<div class=\"debug-div\">";
				if( !isset( $argv ) ){ $headers = apache_request_headers(); }
				echo "<strong>Request headers:</strong> <br/ >" . NFCore::PrintPre( $headers );
				if( !isset( $argv ) ){ $headers = apache_response_headers(); }
				echo "<strong>Response headers:</strong> <br/ >" . NFCore::PrintPre( $headers );
			echo "</div>";
			echo "<hr />";
		}
		// ------------------------------------- | END
		
		// ------------------------------------- | START Get memory usage
		echo "<h5>Memory usage info:</h5>";
		echo "<div class=\"debug-div\">";
			echo "<strong> Memory Used: " . NFCore::FormatBytes( memory_get_usage() ) . "</strong><br />";
			echo "<strong> Memory Peak Used: " . NFCore::FormatBytes( memory_get_peak_usage() ) . "</strong><br />";
		echo "</div>";
		echo "<hr />";
		// ------------------------------------- | END
		
	}
	
	
}




