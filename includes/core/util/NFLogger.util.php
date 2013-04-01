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
* TRACKING  LOG - LOG YOUR CHANGES ONLY IF YOU ARE DOING IMPORTANT UPDATES ( CHANGE OF METHOD, ADDING/DELETING LINES OF CODE, BUGFIX)
* ----------------------------------------------------------------------
* UPDATE : 
* MODDER: ALESSIO NOBILE / DATE AND HOUR : 02/11/2011 - 12:45
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
		
	}
	
	/**
	 * @desc
	 * Print out the TraceBack
	 *  
	 */
	public static function BackTracePrint(){
		
		if( defined( "NF_INSTANCE_LOG_BACKTRACE" ) AND NF_INSTANCE_LOG_BACKTRACE ){
			print_r( self::$array_log );
		}
		
	}
	
	
}




