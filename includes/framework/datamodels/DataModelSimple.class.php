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
*                 NETZIRO FRAMEWORK - SIMPLE DATA MODEL
* ----------------------------------------------------------------------
* SOFTWARE UNDER GPL LICENSE
* AUTHOR Alessio Nobile >> www.netziro.it >> netziro@gmail.com
* ----------------------------------------------------------------------
* CLASS NAME:				NFDataModelSimple
* FILE RELATIVE LOCATION:	includes/framework/datamodels/NFDataModelSimple.class.php
* CREATOR:					Alessio Nobile
* ----------------------------------------------------------------------
* CLASS DESCRIPTION:		
* Simple data model for key-value storaging and built-in caching method using NFCache class
* ----------------------------------------------------------------------
*/

namespace Netziro\Data\Models;

use Netziro;

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFDataModelSimple
 *
 * @desc
 * Simple data model for key-value storaging and built-in caching method using NFCache class
 * 
 */
class DataModelSimple{
	
	/**
	 * Source table name
	 * @var string
	 */
	protected $table;
	
	/**
	 * Key's fieldname
	 * @var string
	 */
	protected $field_key;
	
	/**
	 * Value's fieldname
	 * @var string
	 */
	protected $field_value;
		
	/**
	 * Array containing the data which has been manipulated
	 * @var array
	 */
	protected $data_array = array();
	
	/**
	 * Caching system
	 * @var boolean
	 */
	protected $cache = false;
	
	/**
	 * Cache expiring time
	 * @var boolean
	 */
	protected $cache_expire = 3600;
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Contructor
	 * 
	 * @param $table the source key-value table name
	 * @param $field_key the key fieldname
	 * @param $field_value the value fieldname
	 *
	 */
	public function __construct( $table, $field_key = "key", $field_value = "value" ){
		
		if( !empty( $table ) ){
			
			$this->table = $table;
			$this->field_key = $field_key;
			$this->field_value = $field_value;
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Set/Get Cache option for the given model
	 *
	 */
	public function GetCache(){ return $this->cache; }
	public function SetCache( $option = false ){ $this->cache = $option; }
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Set/Get Cache expiring time
	 *
	 */
	public function GetCacheExpire(){ return $this->cache_expire; }
	public function SetCacheExpire( $time = 3600 ){ $this->cache_expire = $time; }
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Check if the given key exists in array 
	 *
	 * @param $key
	 */
	protected function ExistInArray( $key ){
		
		if( key_exists( $key, $this->data_array ) ){
			
			return true;
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Check if the given key exists in cache
	 *
	 * @param $key
	 * 
	 */
	protected function ExistInCache( $key ){
		
		if( $this->cache ){
		
			// ------------------------------------- | START Get the key from the cache
			$cache_result = Netziro\Util\Cache::GetKeyValue( "$this->table.$key" );
			// ------------------------------------- | END
			
			// ------------------------------------- | START Chek the result
			if( $cache_result === false OR empty( $cache_result ) ){			
				
				unset( $cache_result );
				return false;
				
			} else { 
				
				$this->data_array[ $key ] = $cache_result;
				unset( $cache_result );
				return true;
				
			}
			// ------------------------------------- | END
			
		} else{ return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Check if the given key exists on the database
	 *
	 * @param $key
	 *
	 */
	protected function ExistInDB( $key ){
		
		// ------------------------------------- | START Exec query
		$sql = "SELECT `$this->field_value` FROM `$this->table` WHERE `$this->field_key` = :tofetch";
		$params = array( ':tofetch' => $key );
		$results = Netziro\Framework::$database_links[ "master" ]->Query( $sql, $params );
		// ------------------------------------- | END
		
		// ------------------------------------- | START Unset strings
		unset( $sql );
		unset( $params );
		// ------------------------------------- | END
		
		// ------------------------------------- | START check the result
		if( empty( $results ) ){
			
			unset( $results );
			return false;
			
		} else { 
			
			$value = $results[ 0 ][ $this->field_value ];
			if( $this->cache ){ Netziro\Util\Cache::SetKeyValue( "$this->table.$key", $value, $this->cache_expire ); }
			$this->data_array[ $key ] = $value;
			unset( $results );
			unset( $value );
			return true; 
		
		}
		// ------------------------------------- | END
		
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Check a if a key exists into all layers
	 * 
	 * @param $key
	 *
	 */
	public function Exist( $key ){
		
		if( !empty( $key ) ){
			
			if( !$this->ExistInArray( $key ) ){
				
				if( !$this->ExistInCache( $key ) ){
					
					if( !$this->ExistInDB( $key ) ){
						
						return false;
						
					} else { return true; }
					
				} else { return true; }
				
			} else { return true; } 
			
		} else { return false; }
		
	}
	
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * DB Inserting
	 * 
	 * @param $key
	 * @param $value
	 *
	 */
	protected function InsertDB( $key, $value ){
		
		if( !empty( $key ) AND !empty( $value ) ){
			
			// ------------------------------------- | START Exec query
			$sql = "INSERT INTO `$this->table` ( `$this->field_key`, `$this->field_value` ) VALUES ( :toadd, :value );";
			$params = array( ':toadd' => $key, ':value' => $value );
			Netziro\Framework::$database_links[ "master" ]->Query( $sql, $params );
			// ------------------------------------- | END
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Delete a key from the table
	 * 
	 * @param $key
	 * @param $value
	 *
	 */
	protected function DeleteDB( $key ){
		
		if( !empty( $key ) ){
			
			// ------------------------------------- | START Exec query
			$sql = "DELETE FROM `$this->table` WHERE ( `$this->field_key` = :toremove );";
			$params = array( ':toremove' => $key );
			return Netziro\Framework::$database_links[ "master" ]->Query( $sql, $params );
			// ------------------------------------- | END
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Add a key-value on the source table. Only if the key doesn't exist
	 *
	 * @param $key
	 * @param $value
	 * 
	 */
	public function Add( $key, $value ){
		
		if( !empty( $key ) AND !empty( $value ) ){
			
			if( !$this->Exist( $key ) ){
				
				$this->InsertDB( $key, $value );
				if( $this->cache ){ Netziro\Util\Cache::SetKeyValue( "$this->table.$key", $value, $this->cache_expire ); }
				$this->data_array[ $key ] = $value;
				
			} else { return false; }
			
		} else { return false; }				
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Get a value from a given key
	 *
	 * @param $key
	 * 
	 */
	public function Get( $key ){
		
		if( $this->Exist( $key ) ){
			
			return $this->data_array[ $key ];
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * 
	 *
	 */
	public function Delete( $key ){
		
		if( $this->Exist( $key ) ){
			
			if( $this->DeleteDB( $key ) ){
				
				if( $this->cache ){ Netziro\Util\Cache::DelKey( "$this->table.$key" ); }
				unset( $this->data_array[ $key ] );
				return true;
				
			} else { return false; }
			
		} else { return false; }
		
	}
	
}