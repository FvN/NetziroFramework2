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
*                 NETZIRO FRAMEWORK - TABLE DATA MODEL
* ----------------------------------------------------------------------
* SOFTWARE UNDER GPL LICENSE
* AUTHOR Alessio Nobile >> www.netziro.it >> netziro@gmail.com
* ----------------------------------------------------------------------
* CLASS NAME:				NFDataModel
* FILE RELATIVE LOCATION:	includes/framework/datamodels/NFDataModel.class.php
* CREATOR:					Alessio Nobile
* ----------------------------------------------------------------------
* CLASS DESCRIPTION:		
* 
* ----------------------------------------------------------------------
*/

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFDataModel
 *
 * @desc
 *
 *
 *
 */
class NFDataModel{
	
	/**
	 * Source table name
	 * @var string
	 */
	protected $table;
	
	/**
	 * Array containing the dataset
	 * @var array
	 */
	protected $dataset = array();
	
	/**
	 * Array containing mandatory fields
	 * @var array
	 */
	protected $mandatory_fields = array();
	
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
	 * 
	 *
	 */
	public function __construct( $table, $dataset = array() ){
		
		if( !empty( $table ) ){
			
			$this->table = $table;
			
			if( !empty( $dataset ) ){

				foreach( $dataset as $field ){
					
					$this->RegisterField(
							
							$field[ "name" ],
							$field[ "type" ],
							$field[ "length" ],
							$field[ "default_value" ],
							$field[ "validation_type" ],
							$field[ "mandatory" ],
							$field[ "manipulation" ],
							$field[ "index" ]
							
					);
					
				}
					
			}
			
			
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Register a field in the class dataset
	 * 
	 */
	public function RegisterField( $name, $type = "varchar", $length = 100, $default_value = "", $validation_type = "", $mandatory = false, $manipulation = 0, $index = "" ){
		
		if( !empty( $name ) AND ctype_alnum( $name ) ){ 
			
			if( NFData::IsSupportedDataType( $type ) ){ 
				
				if( empty( $validation_type ) OR NFData::IsSupportedDataValidationType( $validation_type ) ){
					 
					if( empty( $index ) OR NFData::IsSupportedIndexType( $index ) ){
		
						$this->dataset[ $name ][ "name" ] = $name;
						$this->dataset[ $name ][ "type" ] = $type; 
						$this->dataset[ $name ][ "length" ] = $length;
						$this->dataset[ $name ][ "value" ] = $default_value;
						$this->dataset[ $name ][ "validation_type" ] = $validation_type;
						$this->dataset[ $name ][ "mandatory" ] = $mandatory;
						$this->dataset[ $name ][ "index" ] = $index;
						
						if( $mandatory ){ array_push( $this->mandatory_fields , $name); }
						
					} else { throw new Exception( "You must specify a supported index", 7004 ); }	
					
				} else { throw new Exception( "You must specify a supported data validation type", 7003 ); }
				
			} else { throw new Exception( "You must specify a supported field type", 7002 ); }
			
		} else { throw new Exception( "You must specify a field name", 7001 ); }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Set a value for a given field 
	 *
	 */
	public function SetValue( $field, $value ){
		
		if( !empty( $field ) AND key_exists( $field , $this->dataset ) AND !empty( $value )  ){
			
			$this->dataset[ $field ][ "value" ] = $value;  
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Get a value for a given field 
	 *
	 */
	public function GetValue( $field, $value ){
		
		if( !empty( $field ) AND key_exists( $field , $this->dataset ) AND !empty( $value )  ){
			
			return $this->dataset[ $field ][ "value" ];  
			
		} else { return false; }
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Insert the record in the table
	 *
	 */
	public function Insert( ){
		
		// ------------------------------------- | START Arrays init
		$fields = array();
		$values = array();
		$placeholders = array();
		if( $this->cache ){ $values_cache = array(); }
		// ------------------------------------- | END
		
		// ------------------------------------- | START Arrays populating
		foreach( $this->dataset as $field => $content ){
			
			array_push( $fields , $field );
			array_push( $placeholders , ":$field" );
			$values[ ":$field" ] = $content[ "value" ];
			if( $this->cache ){ $values_cache[ $field ] = $content[ "value" ]; }
			
		}
		// ------------------------------------- | END
		
		// ------------------------------------- | START Query generating
		$fields = implode( ",", $fields );
		$placeholders = implode( ",", $placeholders );
		$sql = "INSERT INTO `$this->table` ( $fields ) VALUES ( $placeholders );";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Query executing
		$result = NFCore::$database_links[ "master" ]->Query( $sql, $values );
		$id = NFCore::$database_links[ "master" ]->id;
		// ------------------------------------- | END
		
		// ------------------------------------- | START Cache
		if( $this->cache ){ NFCache::SetHash( "$this->table.id.$id", $values_cache, $this->cache_expire ); }
		// ------------------------------------- | END
		
		// ------------------------------------- | START Unsets
		unset( $sql );
		unset( $fields );
		unset( $values );
		unset( $placeholders );
		if( $this->cache ){ unset( $values_cache ); }
		// ------------------------------------- | END
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Delete
	 *
	 */
	public function Delete( $id = 0 ){
		
		if( $id != 0 ){
			
			$params = array( ':todelete' => $id );
			$sql = "DELETE FROM `$this->table` WHERE id = :todelete;";
			NFCore::$database_links[ "master" ]->Query( $sql, $params );
			if( $this->cache ){ NFCache::DelKey( "$this->table.id.$id" ); }
			
		}
		
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
	
}