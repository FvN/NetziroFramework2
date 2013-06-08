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
*                 NETZIRO FRAMEWORK - DATABASE CLASS
* ----------------------------------------------------------------------
* SOFTWARE UNDER GPL LICENSE
* AUTHOR Alessio Nobile >> www.netziro.it >> netziro@gmail.com
* ----------------------------------------------------------------------
* CLASS NAME:				NFDatabase
* FILE RELATIVE LOCATION:	core/database/NFDatabase.class.php
* CREATOR:					Alessio Nobile
* ----------------------------------------------------------------------
* CLASS DESCRIPTION:		METHODS WITHIN CLASS USED FOR COMMUNICATION WITH DATABASE.
* 							STRINGS CONNECTION WILL SET AS GLOBAL CLASS VARIABLES.
* 							THIS CLASS SHOULD BE REQUIRED AS FIRST OBJECT EVERY API.
* ----------------------------------------------------------------------
*/

namespace Netziro\Database;

use Netziro;
use PDO;
use PDOException;


/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFDatabase
 *
 * @desc
 * METHODS WITHIN CLASS USED FOR COMMUNICATION WITH DATABASE.
 * STRINGS CONNECTION WILL SET AS GLOBAL CLASS VARIABLES.
 * THIS CLASS SHOULD BE REQUIRED AS FIRST OBJECT.
 * 
 * ERROR CODES 1000-2000
 */
class NFDatabase {
	 
	/**
	 * Database Hostname Use IP as possible. You will save time on dns resolution.
	 * 
	 * @var string
	 * 
	 */
	protected $hostname;
	
	/**
	 * Database Name
	 * 
	 * @var string
	 * 
	 */
	protected $database;
	
	/**
	 * Database server user
	 * 
	 * @var string
	 *  
	 */
	protected $username;
	 
	/**
	 * Database server password
	 * 
	 * @var string
	 *
	 */
	protected $password;
	
	/**
	 * Database session timezone
	 * 
	 * @var string
	 * 
	 */
	protected $timezone;
	
	/**
	 * SSL mode value
	 * 
	 * @var string
	 * 
	 */
	protected $ssl;
	
	/**
	 * Database Type
	 * 
	 * @var string
	 * @example MySQL, MSSQL, Sybase
	 * 
	 */
	protected $database_type;
	
	/**
	 * Database session encoding type
	 * 
	 * @var string
	 * @example UTF8
	 * 
	 */
	protected $encoding;
	
	/**
	 * Lock of the class
	 * 
	 * @var boolean
	 * 
	 */
	protected $lock = false;
		
	/**
	 * Link status
	 * 
	 * @var boolean
	 * 
	 */
	protected $linked = false;
	
	/**
	 * Database Link ID | This variable will contain the ID of MySQL connection you started
	 * 
	 * @var string
	 */
	public $link;
	
	/**
	 * Query String | This variable will contain the last MySQL string you sent
	 * 
	 * @var string
	 * 
	 */
	public $query;
	 
	/**
	 * Result Variable | This variable will contain results returned by the last query string
	 * 
	 * @var string
	 * 
	 */
	public $result;
	 
	/**
	 * Number of rows found	| This variable will contain the number of rows found by SELECT queries
	 * 
	 * @var integer
	 * 
	 */
	public $rows;

	
	/**
	 * Last selected record id
	 * 
	 * @var integer
	 * 
	 */
	public $id;
	
	
	/**
	 * Array containing errors
	 * 
	 * @var array
	 * 
	 */
	public $errors = array();
	
	/**
	 * @desc
	 * Loading the class you will set variables needed for MySQL link
	 * Remember to call openLinkDB(), for database link to start, after the new class statement.
	 * 
	 * **** CREDENTIALS ARRAY EXAMPLE:
	 * 
	 * ****	$credentials[ "profile" ] = "ProfileName"; If Profile is set, it will be load the specified profile file overriding the array keys below.
	 * 
	 * ****	$credentials[ "hostname" ] = "mysql.database.com";
	 * ****	$credentials[ "database" ] = "MyDatabaseName";
	 * ****	$credentials[ "username" ] = "root";
	 * ****	$credentials[ "password" ] = "MyPasswords";
	 *
	 * @param array 	$credentials	You will pass an array containing all database credentials
	 * @param string 	$timezone		TimeZone string - Default : Europe/Amsterdam
	 * @param boolean	$ssl			Do you want instanciate a ssl link? - Default : false
	 * @param string	$mysql			Define the database type - Default : mysql
	 * @param string	$encoding		Define the session's encoding - Default : utf8
	 * 	 
	 */
	public function __construct( $credentials = array(), $timezone = "Europe/Amsterdam", $ssl = false, $database_type = "mysql", $encoding = "utf8" ) {

		try{
		
			// ------------------------------------- | START Check the DB Profile existence
			if( isset( $credentials[ "profile" ] ) ){
				if( !empty( $credentials[ "profile" ] ) ){
					
					$profile_file = __DIR__ . "/profiles/" . $credentials[ "profile" ] . ".profile.php";
					
					if( file_exists( $profile_file ) ){ 
						require_once( $profile_file );
					} else { throw new \Exception( "You have specified a db profile, but the file has been not found", 1010 ); }
					
				}
			}
			// ------------------------------------- | END
			
			// ------------------------------------- | START Check core variables existence
			if( !empty( $credentials[ "hostname" ] ) ){ $this->hostname = $credentials[ "hostname" ]; } else { throw new \Exception( "You must specify the hostname", 1001  ); }
			if( !empty( $credentials[ "database" ] ) ){ $this->database = $credentials[ "database" ]; } else { throw new \Exception( "You must specify the database name", 1002 ); }
			if( !empty( $credentials[ "username" ] ) ){ $this->username = $credentials[ "username" ]; } else { throw new \Exception( "You must specify an username", 1003 ); }
			if( !empty( $credentials[ "password" ] ) ){ $this->password = $credentials[ "password" ]; } else { throw new \Exception( "You must specify a password", 1004 ); }
			// ------------------------------------- | END
			
			// ------------------------------------- | START Set secondary importance database variables
			$this->timezone = $timezone;
			$this->ssl = $ssl;
			$this->database_type = $database_type;
			$this->encoding = $encoding;
			// ------------------------------------- | END
			
		} catch( \Exception $e ){
			 
			// ------------------------------------- | START Store the error and return false
			$this->errors[ ] = $e->getMessage(); 
			$this->lock = true;
			Netziro\Core\Logger\NFLogger::LogWrite( 0, $e->getMessage(), __CLASS__ . __METHOD__, $e->getCode() );
			return false; 
			// ------------------------------------- | END
			
		}
		
	}
	
	/**
	 * @author 
	 * Alessio Nobile
	 * 
	 * @desc
	 * Calling this method you will start a new link with the Database
	 * 
	 * @return boolean
	 * TRUE if link will success 
	 * FALSE if link will be unsuccessful
	 * 
	 **** PDO Instance example
	 **** -------------------------------------------------------------------
	 **** $PDO = new PDO( "mssql:host=$host;dbname=$dbname", $user, $pass );  
	 **** $PDO = new PDO( "sybase:host=$host;dbname=$dbname", $user, $pass );
	 **** $PDO = new PDO( "mysql:host=$host;dbname=$dbname", $user, $pass );  
	 **** $PDO = new PDO( "sqlite:my/database/path/database.db" );   
	 * 
	 */
	public function OpenLink(){
		
		try{
			
			if( !$this->lock ){
				
				// ------------------------------------- | START PDO Instance
				$this->link = new PDO( "$this->database_type:host=$this->hostname;dbname=$this->database", $this->username, $this->password );
				// ------------------------------------- | END  
				
				// ------------------------------------- | START Define instance settings
				$this->link->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );
				$this->link->query( "SET CHARACTER SET $this->encoding" );
				$this->link->query( "SET NAMES '$this->encoding'" );
				$this->link->query( "SET SESSION time_zone = '$this->timezone'" );
				// ------------------------------------- | END
				
				// ------------------------------------- | START Return
				$this->linked = true;
				return true;
				// ------------------------------------- | END
				
			} else { throw new PDOException( "The database class is locked", 1020 ); return false; }
			
		} catch( PDOException $e ){ 
			
			// ------------------------------------- | START Store the error and return false
			$this->errors[ ] = 'Line: ' . $e->getLine() . ' ' . $e->getMessage(); 
			Netziro\Core\Logger\NFLogger::LogWrite( 0, $e->getMessage(), __CLASS__ . __METHOD__ , $e->getCode() );
			$this->linked = false;
			return false; 
			// ------------------------------------- | END
		
		}
		
	} 
	
	/**
	 * @desc
	 * Calling this method you will close the Database link
	 * 
	 */
	public function CloseLink(){ $this->link = null; }

	/**
	 * @desc
	 * Calling this method you will send a query string to MySQL Database
	 * 
	 * @param string $query	- You will pass the MySQL string
	 * @param array $params	- Array containing params list that needs to be binded on the query by PDO
	 * 
	 * @return resource - Method will return query results
	 */
	public function Query( $query, $params = array( ) ){
		
		try{
			
			// ------------------------------------- | START Sanityze the query
			$query = trim( $query );
			$this->query = $this->link->prepare( $query );
			// ------------------------------------- | END
			
			// ------------------------------------- | START Results fetch
			if( $this->query->execute( $params ) ){ 
				
				// ------------------------------------- | START Fetch results
				$this->result = $this->query->fetchAll();
				// ------------------------------------- | END
				
				// ------------------------------------- | START Define some info
				if( preg_match( "/^SELECT/", $query ) OR preg_match( "/^SHOW/", $query ) ){ $this->rows = count( $this->result );	}
				if( preg_match( "/^INSERT/", $query ) ){ $this->id = $this->link->lastInsertId( ); }
				if( preg_match( "/^DELETE/", $query ) ){ $this->result = true; }
				// ------------------------------------- | END
				
			} else { throw new PDOException( "Something wrong on the query", 1030 ); $this->query->closeCursor(); }
			// ------------------------------------- | END

			// ------------------------------------- | START Variables cleaning up
			unset( $query );
			$this->query->closeCursor();
			// ------------------------------------- | END
			
			// ------------------------------------- | START Return
			return $this->result;
			// ------------------------------------- | END
			
		} catch( PDOException $e ){ 
			
			// ------------------------------------- | START Store the error and return false
			$this->errors[ ] = 'Line: ' . $e->getLine() . ' ' . $e->getMessage(); 
			Netziro\Core\Logger\NFLogger::LogWrite( 1, $e->getMessage() . $query, __CLASS__ . __METHOD__, $e->getCode() );
			return false; 
			// ------------------------------------- | END
		
		}
		
	}
	
	/**
	 * @desc
	 * Calling this method you will return the the number of records fetch from the last query
	 * 
	 * @return integer
	 */
	public function GetRows( ){ return $this->rows; }
	
	/**
	 * @desc
	 * Calling this method you will return the hostname
	 * 
	 * @return string
	 */
	public function GetHostname( ){ return $this->hostname; }
	
	/**
	 * @desc
	 * Calling this method you will return the database name
	 * 
	 * @return string
	 */
	public function GetDatabaseName( ){ return $this->database; }
	
	/**
	 * @desc
	 * Calling this method you will return the username
	 * 
	 * @return string
	 */
	public function GetUsername( ){ return $this->username; }
	
	
	/**
	 * @desc
	 * Calling this method you will return the the current TimeZone
	 * 
	 * @return string
	 */
	public function GetTimezone( ){ return $this->timezone; }
	
	/**
	 * @desc
	 * Calling this method you will return the database type
	 * 
	 * @return string
	 */
	public function GetDatabaseType( ){ return $this->database_type; }
	
	/**
	 * @desc
	 * Calling this method you will return the errors array
	 * 
	 * @return array
	 */
	public function GetErrors( ){ if( !empty( $this->errors ) ){ return $this->errors; } else { return false; } }
	
	/**
	 * @desc
	 * Calling this method you will print the errors array
	 * 
	 * @return array
	 */
	public function PrintErrors( ){ if( !empty( $this->errors ) ){ print_r ( $this->errors ); } else { return false; } }
	
	/**
	 * @desc
	 * Return the link's status
	 * 
	 * @return bool
	 */
	public function IsLinked( ){ return $this->linked; }
	
}