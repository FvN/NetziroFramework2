<?php
/*
* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - NFDependencies
* ----------------------------------------------------------------------
* FILE RELATIVE LOCATION:	core/NFDependencies.core.php
* CREATOR:					Alessio Nobile
* CREATING DATA:			02/01/12
* ----------------------------------------------------------------------
* FILE DESCRIPTION:			NFCore class will contain core methods used overall the application
* ----------------------------------------------------------------------
*/

namespace Netziro\Core\Dependencies;

use Netziro;


/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFDependencies
 *
 * @desc
 * NFCore class will contain core methods used overall the application
 * 
 */
class Dependencies{

	/**
	 * @var string | Core tables name prefix
	 */
	private static $tables_prefix = "nfcore_";
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * This is the Init method which will be run the first time you load/install the application
	 * It will generate all core tables populating it by core settings
	 * 
	 */
	public static function Init(){
		
		self::GenerateTables();
		self::PopulateCoreSettings();
		
	}
	
	/**
	 * @desc
	 * It will generate all tables the framework needs
	 * 
	 */
	public static function GenerateTables(){
		
		self::GenerateTablesSettings();
		self::GenerateTablesModules();
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * It populates the master database with core framework settings
	 *
	 */
	public static function PopulateCoreSettings(){
		
		self::InsertCoreKey( "template" , "default" );
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Get on the fly the settings table name
	 *
	 * @return string
	 */
	public static function GetCoreSettingsTableName(){
		return self::$tables_prefix . "settings";
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Get on the fly the settings table name
	 *
	 * @return string
	 */
	public static function GetCoreModulesTableName(){
		return self::$tables_prefix . "modules";
	}
	
	/**
	 * @desc
	 * Core settings table generator
	 * 
	 * @return boolean
	 */
	private static function GenerateTablesSettings(){
		
		// ------------------------------------- | START Define table name
		$table = self::GetCoreSettingsTableName();
		// ------------------------------------- | END
		
		// ------------------------------------- | START Query building
		$sql = 	"
			CREATE TABLE IF NOT EXISTS `$table` (
				`id`  INT(11) NOT NULL AUTO_INCREMENT ,
				`key` VARCHAR(50) NOT NULL ,
				`value` TEXT NOT NULL ,
				PRIMARY KEY (`id`),
				UNIQUE INDEX `key` USING BTREE (`key`) 
		)
		ENGINE=InnoDB
		DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
		AUTO_INCREMENT=1
		ROW_FORMAT=COMPACT;
		";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Query executing
		$created = Netziro\Framework::$database_links[ "master" ]->Query( $sql );
		// ------------------------------------- | END
		
		// ------------------------------------- | START Return
		if( $created !== false ){ return true; } else { return false; }
		// ------------------------------------- | END
		
	}
	
/**
	 * @desc
	 * Core settings table generator
	 * 
	 * @return boolean
	 */
	private static function GenerateTablesModules(){
		
		// ------------------------------------- | START Define table name
		$table = self::GetCoreModulesTableName();
		// ------------------------------------- | END
		
		// ------------------------------------- | START Query building
		$sql = 	"
			CREATE TABLE IF NOT EXISTS `$table` (
				`id`  INT(11) NOT NULL AUTO_INCREMENT ,
				`key` VARCHAR(50) NOT NULL ,
				PRIMARY KEY (`id`),
				UNIQUE INDEX `key` USING BTREE (`key`) 
		)
		ENGINE=InnoDB
		DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
		AUTO_INCREMENT=1
		ROW_FORMAT=COMPACT;
		";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Query executing
		$created = Netziro\Framework::$database_links[ "master" ]->Query( $sql );
		// ------------------------------------- | END
		
		// ------------------------------------- | START Return
		if( $created !== false ){ return true; } else { return false; }
		// ------------------------------------- | END
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Insert a key into the core settings table 
	 *
	 * @param string $key
	 * @param string $value
	 * 
	 * @return boolean
	 */
	public static function InsertCoreKey( $key, $value ){

		if( !empty( $key ) AND !empty( $value ) ){
			
			// ------------------------------------- | START Define table name
			$table = self::GetCoreSettingsTableName();
			// ------------------------------------- | END
			
			// ------------------------------------- | START Define query params array
			$param = array( ":key" => $key, ":value" => $value );
			// ------------------------------------- | END
			
			// ------------------------------------- | START SQL
			$sql = "INSERT INTO `$table` SET `key` = :key, `value` = :value";
			// ------------------------------------- | END
			
			// ------------------------------------- | START Query executing
			$created = Netziro\Framework::$database_links[ "master" ]->Query( $sql );
			// ------------------------------------- | END
			
			// ------------------------------------- | START Return
			if( $created !== false ){ return true; } else { return false; }
			// ------------------------------------- | END
						
		} else { return false; } 
		
	}
	
}