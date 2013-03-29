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
* FILE RELATIVE LOCATION:	framework/NFDatabase.class.php
* CREATOR:					Alessio Nobile
* ----------------------------------------------------------------------
* CLASS DESCRIPTION:		METHODS WITHIN CLASS USED FOR COMMUNICATION WITH DATABASE.
* 							STRINGS CONNECTION WILL SET AS GLOBAL CLASS VARIABLES.
* 							THIS CLASS SHOULD BE REQUIRED AS FIRST OBJECT EVERY API.
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
 * @package		NFDatabase
 *
 * @desc
 * METHODS WITHIN CLASS USED FOR COMMUNICATION WITH DATABASE.
 * STRINGS CONNECTION WILL SET AS GLOBAL CLASS VARIABLES.
 * THIS CLASS SHOULD BE REQUIRED AS FIRST OBJECT.
 */
class NFDatabase {
	 
	protected $hostname; 	// Database Hostname 		| Use IP as possible. We will save time on dns resolution.
	protected $username; 	// Database MySQL User		| 
	protected $password; 	// Database MySQL Password	|
	protected $timezone;	// Timezone to use on database link
	protected $ssl;			// SSL Link
	protected $database_type;
	protected $encoding;
	public $database; 		// Database Name			|
	public $link;			// Database Link ID			| This variable will contain the ID of MySQL connection you started
	public $query;			// Query String				| This variable will contain the last MySQL string you sent
	public $result;			// Result Variable			| This variable will contain results returned by the last query string
	public $rows;			// Number of rows found		| This variable will contain the number of rows found by SELECT queries
	public $id;
	public $errors = array();
	

	/**
	 * @desc
	 * Loading the class you will set variables needed for MySQL link
	 * Remember to call openLinkDB(), for database link start, after the new class statement.
	 *
	 * @param string $hostname	- You will pass Hostname String Value
	 * @param string $database	- You will pass Database String Value
	 * @param string $username	- You will pass Username String Value
	 * @param string $password	- You will pass Password String Value
	 */
	function NFDatabase( $hostname, $database, $username, $password, $timezone = "Europe/Amsterdam", $ssl = true, $database_type = "mysql", $encoding = "utf8" ) {
		
		try{
		
			// ------------------------------------- | START Check core variables existence
			if( !empty( $hostname ) ){ $this->hostname = $hostname; } else { throw new Exception( "You must specify the hostname" ); }
			if( !empty( $database ) ){ $this->database = $database; } else { throw new Exception( "You must specify the database name" ); }
			if( !empty( $username ) ){ $this->username = $username; } else { throw new Exception( "You must specify an username" ); }
			if( !empty( $password ) ){ $this->password = $password; } else { throw new Exception( "You must specify a password" ); }
			// ------------------------------------- | END
			
			// ------------------------------------- | START Set secondary importance database variables
			$this->timezone = $timezone;
			$this->ssl = $ssl;
			$this->database_type = $database_type;
			$this->encoding = $encoding;
			// ------------------------------------- | END
			
		} catch( Exception $e ){ $e->getMessage(); return false; }
		
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
	 **** ------------------
	 **** $PDO = new PDO( "mssql:host=$host;dbname=$dbname", $user, $pass );  
	 **** $PDO = new PDO( "sybase:host=$host;dbname=$dbname", $user, $pass );
	 **** $PDO = new PDO( "mysql:host=$host;dbname=$dbname", $user, $pass );  
	 **** $PDO = new PDO( "sqlite:my/database/path/database.db" );   
	 * 
	 */
	public function OpenLink(){
		
		try{
			
			// ------------------------------------- | START PDO Instance
			$this->link = new PDO( "$this->database_type:host=$this->hostname;dbname=$this->database", $this->username, $this->password );
			// ------------------------------------- | END  
			
			// ------------------------------------- | START Define instance settings
			$this->link->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			$this->link->query( "SET CHARACTER SET $this->encoding" );
			$this->link->query( "SET NAMES '$this->encoding'" );
			$this->link->query( "SET SESSION time_zone = '$this->timezone'" );
			// ------------------------------------- | END
			
			// ------------------------------------- | START Return
			return true;
			// ------------------------------------- | END
			
		} catch( PDOException $e ){ $this->errors[] = 'Line: '.$e->getLine().' '.$e->getMessage(); return false; }
		
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
	 * 
	 * @return resource - Method will return query results
	 */
	public function Query( $query ){
		
		try{
			
			// ------------------------------------- | START Sanityze the query
			$query = trim( $query );
			$this->query = $this->link->quote( $query );
			// ------------------------------------- | END
			
			// ------------------------------------- | START Query executing
			$result = null;
			$result = $this->link->query( $this->query );
			// ------------------------------------- | END
			
			// ------------------------------------- | START Results fetch
			$this->result = $result->fetchAll();
			// ------------------------------------- | END

			// ------------------------------------- | START Define some info
			if( preg_match( "/^SELECT/", $this->query ) OR preg_match( "/^SHOW/", $this->query ) ){ $this->rows = count( $this->result );	}
			if( preg_match( "/^INSERT/", $this->query ) ){ $this->id = $this->link->lastInsertId(); }
			// ------------------------------------- | END
				
			// ------------------------------------- | START Variables cleaning up
			unset( $query );
			unset( $result );
			// ------------------------------------- | END
			
			// ------------------------------------- | START Return
			return $this->result;
			// ------------------------------------- | END
			
		} catch( PDOException $e ){ $this->errors[] = 'Line: '.$e->getLine().' '.$e->getMessage(); return false; }
		
	}
	
}