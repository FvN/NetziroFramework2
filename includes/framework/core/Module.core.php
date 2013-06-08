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
*                 NETZIRO FRAMEWORK - MODULE CORE CLASS
* ----------------------------------------------------------------------
* SOFTWARE UNDER GPL LICENSE
* AUTHOR Alessio Nobile >> www.netziro.it >> netziro@gmail.com
* ----------------------------------------------------------------------
* CLASS NAME:				NFModule
* FILE RELATIVE LOCATION:	includes/framework/core/NFModule.core.php
* CREATOR:					Alessio Nobile
* ----------------------------------------------------------------------
* CLASS DESCRIPTION:		Module base
* ----------------------------------------------------------------------
*/

namespace Netziro\Modules;

use Netziro;

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFModule
 *
 * @desc
 * Module Class
 * 
 * ERROR CODES 6000-8000
 * 
 */

class Module{
	
	private static $ui = false;
	private static $permissions_checking = false;
	
	private static $module_directory;
	private static $module_index;
	private static $module_init;
	
	private static $nf_module_directory = "modules/";
	private static $nf_module_index = "index.php";
	private static $nf_module_init = "init.php";
	
	
	public static function SetUI( $value = true ){ self::$ui = $value; }
	public static function SetPermissionsChecking( $value = true ){ self::$permissions_checking = $value; }
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * 
	 *
	 */
	public static function Init(){
		
		// ------------------------------------- | START Get the module from the request
		$module = Netziro\Framework::GetValueFromRequest( "m" );
		// ------------------------------------- | END
		
		// ------------------------------------- | START Initialize template settings
		self::$module_directory = self::$nf_module_directory . $module;
		self::$module_index = self::$nf_module_directory . $module . "/" . self::$nf_module_index;
		self::$module_init = self::$nf_module_directory . $module . "/" . self::$nf_module_init;
		// ------------------------------------- | END

		// ------------------------------------- | START Route
		if( !empty( $module ) ){ self::Router( $module ); }
		// ------------------------------------- | END
		
		// ------------------------------------- | START Unsets
		unset( $module );
		// ------------------------------------- | END
		
	}
	
	
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Route your request into the module
	 *
	 */
	private static function Router( $module ){
			
		if( !empty( $module ) ){
			
			if( self::Exist( $module ) ){
				
				call_user_func( array( $module, 'AutoLoad' ) );
				call_user_func( array( $module, 'ModuleRouter' ) );
				
			}
			
		}
				
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Register the given module
	 *
	 * @param string $module
	 * 
	 */
	public static function Register( $module ){
		
		if( !empty( $module ) AND ctype_alnum( $module ) ){
			
			if( !self::Exist( $module ) ){
				
				// ------------------------------------- | START Define query params array
				$table_name = Netziro\Core\Dependencies\NFDependencies::GetCoreModulesTableName();
				$param = array( ":key" => $module );
				// ------------------------------------- | END
				
				// ------------------------------------- | START SQL
				$sql = "INSERT INTO `$table_name` SET `key` = :key";
				// ------------------------------------- | END
				
				// ------------------------------------- | START Query executing
				$created = Netziro\Framework::$database_links[ "master" ]->Query( $sql );
				// ------------------------------------- | END
				
				// ------------------------------------- | START Return
				if( $created !== false ){ return true; } else { return false; }
				// ------------------------------------- | END
				
			} else { return true; }
			
		} else { return false; }
		
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Check if the module exist and has been registered
	 *
	 * @param string $module
	 */
	public static function Exist( $module ){
		
		// ------------------------------------- | START Process the request if $key is a sane value
		if( !empty( $module ) AND ctype_alnum( $module ) ){
			
			// ------------------------------------- | START Query executing
			$table_name = Netziro\Core\Dependencies\NFDependencies::GetCoreModulesTableName();
			$sql = "SELECT `key` FROM `$table_name` WHERE `key` = :string_value";
			$params = array( ":string_value" => $module );
			$results = Netziro\Framework::$database_links[ "master" ]->Query( $sql, $params );
			$rows = Netziro\Framework::$database_links[ "master" ]->GetRows();
			// ------------------------------------- | END
			
			// ------------------------------------- | START Return true if the module is already registered
			if( $rows == 1 ){
				
				if( file_exists( self::$module_directory ) AND file_exists( self::$module_init ) ){
					
					Netziro\Core\Autoloader\Autoloader::AddKey( $module, self::$module_init );
					return true;
						
				} else { throw new \Exception( "NFModule - The module is registered, but the directory doesn't exist", 6003 ); return false; }
				
			} else { throw new \Exception( "NFModule - Module not registered", 6001 ); return false; }
			// ------------------------------------- | END
			
		} else { throw new \Exception( "NFModule - The router couldn't find the module on your request", 6000 ); return false; }
		// ------------------------------------- | END
		
		
	}
	
	
	
	
}

