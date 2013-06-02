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

class NFCache extends NFDatabase{
	
	/**
	 * Class shared redis socket object
	 * 
	 * @var object
	 */
	private static $redis_socket;
	
	/**
	 * Redis server hostname
	 * 
	 * @var string
	 * @example localhost
	 */
	private static $redis_host = "localhost";
	
	/**
	 * Redis server port
	 * 
	 * @var number
	 * @example 6379
	 */
	private static $redis_port = 6379;
	
	
	/**
	 * Redis keys prefix
	 * 
	 * @var string
	 * @example mykeysets.
	 */
	private static $key_prefix;
	
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Redis Init
	 *
	 */
	static public function Init(){
		
		try{

			// ------------------------------------- | START Predis class including and registering
			require_once( "includes/ext/Predis/Autoloader.php" );
			Predis\Autoloader::register();
			self::$redis_socket = new Predis\Client( array( "host" => self::$redis_host, "port" => self::$redis_port ) );
			// ------------------------------------- | END
			
		} catch ( Exception $e ) { echo $e->getMessage();return false;  }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * 
	 *
	 */
	static public function SetKeyPrefix( $prefix ){
		
		if( !empty( $prefix ) ){

			self::$key_prefix = "$prefix.";
			
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
			
			try{
				
				// ------------------------------------- | START Set key value attempt
				self::$redis_socket->set( self::$key_prefix.$key, $value );
				if( $exptime !== 0 ){ self::$redis_socket->expire( self::$key_prefix.$key, $exptime ); }
				// ------------------------------------- | END
				
			} catch ( Exception $e ) { 

				// ------------------------------------- | START Pass the error to the global logger
				NFLogger::LogWrite( 1, $e->getMessage(), __CLASS__ . __METHOD__, 1100 );
				return false; 
				// ------------------------------------- | END
				
			}
			
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
			
			try{
				
				// ------------------------------------- | START Get value attempt
				return self::$redis_socket->get( self::$key_prefix.$key );
				// ------------------------------------- | END
				
			} catch ( Exception $e ) { 

				// ------------------------------------- | START Pass the error to the global logger
				NFLogger::LogWrite( 1, $e->getMessage(), __CLASS__ . __METHOD__, 1101 );
				return false; 
				// ------------------------------------- | END
				
			}
			
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
			
			try{
				
				// ------------------------------------- | START Key deleting attempt
				return self::$redis_socket->del( self::$key_prefix.$key );
				// ------------------------------------- | END
				
			} catch ( Exception $e ) { 

				// ------------------------------------- | START Pass the error to the global logger
				NFLogger::LogWrite( 1, $e->getMessage(), __CLASS__ . __METHOD__, 1102 );
				return false; 
				// ------------------------------------- | END
				
			}
			
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
	static public function SetHash( $key, $array, $exptime = 3600 ){
		
		if( !empty( $key ) AND !empty( $array ) ){
			
			try{
				
				// ------------------------------------- | START Set hash attempt
				self::$redis_socket->hmset( self::$key_prefix.$key, $array );
				if( $exptime !== 0 ){ self::$redis_socket->expire( self::$key_prefix.$key, $exptime ); }
				// ------------------------------------- | END
				
			} catch ( Exception $e ) { 

				// ------------------------------------- | START Pass the error to the global logger
				NFLogger::LogWrite( 1, $e->getMessage(), __CLASS__ . __METHOD__, 1103 );
				return false; 
				// ------------------------------------- | END
				
			}
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Set a sub key-value for an existing hash
	 *
	 * @param string 	$key - Hash name
	 * @param string 	$field - Field name
	 * @param string	$value - Subkey value
	 * 
	 * 
	 * @return boolean
	 */
	static public function SetHashField( $key, $field, $value ){
		
		if( !empty( $key ) AND !empty( $field ) AND !empty( $value ) ){
			
			try{ 

				// ------------------------------------- | START Set value for the given field in hash
				self::$redis_socket->hset( self::$key_prefix.$key, $field, $value );
				// ------------------------------------- | END
			
			} catch ( Exception $e ) { 

				// ------------------------------------- | START Pass the error to the global logger
				NFLogger::LogWrite( 1, $e->getMessage(), __CLASS__ . __METHOD__, 1104 );
				return false; 
				// ------------------------------------- | END
				
			}
			
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
	static public function GetHash( $key ){
		
		if( !empty( $key ) ){
			
			try{ 
			
				// ------------------------------------- | START Get array
				return self::$redis_socket->hgetall( self::$key_prefix.$key );
				// ------------------------------------- | END
				
			} catch ( Exception $e ) { 

				// ------------------------------------- | START Pass the error to the global logger
				NFLogger::LogWrite( 1, $e->getMessage(), __CLASS__ . __METHOD__, 1105 );
				return false; 
				// ------------------------------------- | END
				
			}
			
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
	static public function GetHashField( $key, $field ){
		
		if( !empty( $key ) AND !empty( $field ) ){
			
			try{
				
				// ------------------------------------- | START Get field from hash attempt
				return self::$redis_socket->hget( self::$key_prefix.$key, $field );
				// ------------------------------------- | END
								
			} catch ( Exception $e ) { 

				// ------------------------------------- | START Pass the error to the global logger
				NFLogger::LogWrite( 1, $e->getMessage(), __CLASS__ . __METHOD__, 1106 );
				return false; 
				// ------------------------------------- | END
				
			}
			
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
	static public function DelHashField( $key, $field ){
		
		if( !empty( $key ) AND !empty( $field ) ){
			
			try{
			
				// ------------------------------------- | START Del field from the hash attempt
				return self::$redis_socket->hdel( self::$key_prefix.$key, $field );
				// ------------------------------------- | END
				
			} catch ( Exception $e ) { 

				// ------------------------------------- | START Pass the error to the global logger
				NFLogger::LogWrite( 1, $e->getMessage(), __CLASS__ . __METHOD__, 1107 );
				return false; 
				// ------------------------------------- | END
				
			}
			
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
			
			try{ 
				
				// ------------------------------------- | START Get TTL from a given key
				return self::$redis_socket->ttl( self::$key_prefix.$key );
				// ------------------------------------- | END
				
			} catch ( Exception $e ) { 

				// ------------------------------------- | START Pass the error to the global logger
				NFLogger::LogWrite( 1, $e->getMessage(), __CLASS__ . __METHOD__, 1108 );
				return false; 
				// ------------------------------------- | END
				
			}
			
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




