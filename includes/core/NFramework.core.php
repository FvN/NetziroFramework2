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
	
	/**
	 * @desc
	 * Netziro Framework AutoLoader method
	 * 
	 */
	public static function AutoLoader( $class ){
		
		switch( $class ){
			
			// ------------------------------------- | START Module Including logic
			case strstr( $class, "NFMod" ) != FALSE:
				require_once( "modules/$class.module.php" );
				break;
			// ------------------------------------- | END
			 
			// ------------------------------------- | START NFDatabase logic 
			case "NFDatabase":
				require_once( "includes/core/database/NFDatabase.class.php" );
				break;
			// ------------------------------------- | END
				
			// ------------------------------------- | START NFCore Logic
			case "NFCore":
				require_once( "includes/core/NFCore.core.php" );
				break;
			// ------------------------------------- | END
				
			// ------------------------------------- | START NFLogger
			case "NFLogger":
				require_once( "includes/core/util/NFLogger.util.php" );
				break;
			// ------------------------------------- | END
			
			// ------------------------------------- | START NFIntl
			case "NFIntl":
				require_once( "includes/core/util/NFIntl.util.php" );
				break;
			// ------------------------------------- | END
			
		}
		
	}
		
	
}

spl_autoload_register( array( "NFramework", "AutoLoader" ) );