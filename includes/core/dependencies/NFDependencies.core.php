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
* TRACKING  LOG - LOG YOUR CHANGES ONLY IF YOU ARE DOING IMPORTANT UPDATES ( CHANGE OF METHOD, ADDING/DELETING LINES OF CODE, BUGFIX)
* ----------------------------------------------------------------------
* UPDATE : 
* MODDER: ALESSIO NOBILE / DATE AND HOUR : 02/11/2011 - 12:45
* ----------------------------------------------------------------------
*/

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFDependencies
 *
 * @desc
 * NFCore class will contain core methods used overall the application
 * 
 */
class NFDependencies extends NFramework{

	private static $tables_prefix = "nfcore_";
	
	/**
	 * @desc
	 * It will generate all tables the framework needs
	 * 
	 */
	public static function GenerateTables(){
		
		self::GenerateTablesSettings();
		
	}
	
	/**
	 * @desc
	 * Settings table Generator
	 * 
	 */
	private static function GenerateTablesSettings(){
		
		// ------------------------------------- | START Define table name
		$table = self::$tables_prefix . "settings";
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
		$created = NFCore::$database_links[ "master" ]->Query( $sql );
		// ------------------------------------- | END
		
		// ------------------------------------- | START Return
		if( $created !== false ){ return true; } else { return false; }
		// ------------------------------------- | END
		
	}
	
	
	
	
}