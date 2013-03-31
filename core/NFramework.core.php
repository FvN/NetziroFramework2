<?php
/*
* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - NFramework
* ----------------------------------------------------------------------
* FILE RELATIVE LOCATION:	core/NFramework.core.php
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
 * @package		NFramework
 *
 * @desc
 * NFramework class will contain core methods used overall the application
 * 
 */
class NFramework{
	
	public static function AutoLoader( $class ){
		
		if( $class == "NFDatabase.class.php" ){
			require_once( "core/database/NFDatabase.class.php" );
		} elseif( $class == "NFCore" ){
			require_once( "core/NFCore.core.php" );
		} elseif( $class == "NFLogger" ){
			require_once( "core/util/NFLogger.util.php" );
		}
		
		
	}
		
	
}

spl_autoload_register( array( "NFramework", "AutoLoader" ) );