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
*                 NETZIRO FRAMEWORK - NFCache
* ----------------------------------------------------------------------
* SOFTWARE UNDER GPL LICENSE
* AUTHOR Alessio Nobile >> www.netziro.it >> netziro@gmail.com
* ----------------------------------------------------------------------
* CLASS NAME:				NFDate
* FILE RELATIVE LOCATION:	includes/framework/util/NFCache.util.php
* CREATOR:					Alessio Nobile
* ----------------------------------------------------------------------
* CLASS DESCRIPTION:		This is a static class which will be included overall projects and it will fetch all logs from your platform
* 							in order to store it somewhere you will like
* ----------------------------------------------------------------------
*/

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFCache
 *
 * @desc

 * 
 */

class NFCache{
	
	private static $redis = true;
	private static $redis_socket;
	private static $redis_host = "localhost";
	private static $redis_port = 6379;
	private static $referer;
	
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Redis Init
	 *
	 */
	static public function Init(){
		
		try{
			
			if( self::$redis ){
				
				require_once( "ext/Predis/Autoloader.php" );
				Predis\Autoloader::register();
				self::$redis_socket = new Predis\Client( array( "host" => self::$redis_host, "port" => self::$redis_port ) );
				
			} else { throw new Exception( "Redis option not activated" ); }
			
		} catch ( Exception $e ) { return false;  }
		
	}
	
	static public function SetReferer( $referer ){
		
		if( !empty( $referer ) ){

			self::$referer = $referer;
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Set the value and expiration time for a given key
	 *
	 * @param string 	$key
	 * @param string 	$value
	 * @param number 	$exptime | 3600 = 1hour
	 * 
	 * @return boolean
	 */
	static public function SetKeyValue( $key, $value, $exptime = 3600 ){
		
		if( !empty( $key ) AND !empty( $value ) ){
			
			self::$redis_socket->set( self::$referer.".".$key, $value );
			if( $exptime !== 0 ){ self::$redis_socket->expire( self::$referer.".".$key, $exptime ); }
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Get value from a given key
	 *
	 * @param unknown $key
	 * @return boolean
	 */
	static public function GetKeyValue( $key ){
		
		if( !empty( $key ) ){
			
			return self::$redis_socket->get( self::$referer.".".$key );
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Delete key
	 *
	 * @param unknown $key
	 * @return boolean
	 */
	static public function DelKey( $key ){
		
		if( !empty( $key ) ){
			
			return self::$redis_socket->del( self::$referer.".".$key );
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Set the value and expiration time for a given key
	 *
	 * @param string 	$key
	 * @param string 	$value
	 * @param number 	$exptime | 3600 = 1hour
	 * 
	 * @return boolean
	 */
	static public function SetArrayValue( $key, $array, $exptime = 3600 ){
		
		if( !empty( $key ) AND !empty( $array ) ){
			
			self::$redis_socket->hmset( self::$referer.".".$key, $array );
			if( $exptime !== 0 ){ self::$redis_socket->expire( self::$referer.".".$key, $exptime ); }
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Get value from a given key
	 *
	 * @param unknown $key
	 * @return boolean
	 */
	static public function GetArrayValue( $key ){
		
		if( !empty( $key ) ){
			
			return self::$redis_socket->hgetall( self::$referer.".".$key );
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Delete Array
	 *
	 * @param unknown $key
	 * @return boolean
	 */
	static public function DelArrayKey( $key, $array_key ){
		
		if( !empty( $key ) AND !empty( $array_key ) ){
			
			return self::$redis_socket->hdel( self::$referer.".".$key, $array_key );
			
		} else { return false; }
		
	}
	

	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Get the TTL for a given key
	 *
	 * @param unknown $key
	 * @return boolean
	 */
	static public function GetKeyTTL( $key ){
		
		if( !empty( $key ) ){
			
			return self::$redis_socket->ttl( self::$referer.".".$key );
			
		} else { return false; }
		
	}
	
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Set redis host and port
	 *
	 * @param string $host
	 * @param number $port
	 */
	static public function SetRedisHost( $host = "localhost", $port = 6379 ){
		
		self::$redis_host = $host;
		self::$redis_port = $port;
	
	}
		
	
}




