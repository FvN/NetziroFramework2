<?php
/*
* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - NFAutoloader
* ----------------------------------------------------------------------
* FILE RELATIVE LOCATION:	core/autoloader/NFAutoloader.core.php
* CREATOR:					Alessio Nobile
* CREATING DATA:			02/01/12
* ----------------------------------------------------------------------
* FILE DESCRIPTION:			Array containing all classes requirements
* ----------------------------------------------------------------------
*/
namespace Netziro\Core\Autoloader; 

use Netziro;


class NFAutoloader{
	
	/**
	 * @var $autoloader_array
	 */
	public static $autoloader_array = array();
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Include the Autoloader array
	 *
	 */
	public static function Init(){

		// ------------------------------------- | START Init the autoloader array
		self::InitArray();		
		// ------------------------------------- | END
		
		// ------------------------------------- | START Register
		spl_autoload_register( array( "Netziro\\Core\\Autoloader\\NFAutoloader", "Load" ) );
		// ------------------------------------- | END
		
	}
	
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Add a new key into the autoloader array 
	 *
	 */
	public static function AddKey( $key, $value ){

		if( !empty( $key ) AND !empty( $value ) ){
			
			self::$autoloader_array[ $key ] = $value;
			
		}
		
	}
	
	/**
	 * @desc
	 * Netziro Framework AutoLoader method
	 * 
	 */
	public static function Load( $class ){
		
		switch( $class ){
									
			// ------------------------------------- | START NFTheme
			case "Theme\\NFTheme":
				
				$template_init = Netziro\UI\NFUserInterface::GetTemplateInit();
				
				if( file_exists( $template_init ) ){
					
					require_once( $template_init );
					unset( $template_init );
						
				} else { throw new \Exception( "NFAutoloader - You tried to load the template $class, but the file doesn't exist" , 9 ); }
				
				break;
			// ------------------------------------- | END
			
			// ------------------------------------- | START Default case
			default:
				
				if( key_exists( $class , self::$autoloader_array ) ){
					
					if( file_exists( self::$autoloader_array[ $class ] ) ){
						
						require_once( self::$autoloader_array[ $class ] );
						
					}// else { throw new Exception( "NFAutoloader - You tried to load the class $class, but the file doesn't exist" , 7 ); }
					
				}// else { throw new Exception( "NFAutoloader - You tried to load the class $class, but cannot be associated" , 6 ); }
					
				break;
			// ------------------------------------- | END
			
		}
		
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Init the array
	 *
	 */
	protected static function InitArray(){
		
		self::$autoloader_array[ "Netziro\\Core\\Autoloader\\NFAutoloader" ] = "includes/framework/autoloader/NFAutoloader.core.php";
		self::$autoloader_array[ "Netziro\\NFramework" ] = "includes/framework/core/NFramework.core.php";
		self::$autoloader_array[ "Netziro\\Core\\Bootstrap\\NFBootstrap" ] = "includes/framework/core/NFBootstrap.core.php";
		self::$autoloader_array[ "Netziro\\Database\\NFDatabase" ] = "includes/framework/database/NFDatabase.class.php";
		self::$autoloader_array[ "Netziro\\Core\\NFCore" ] = "includes/framework/core/NFCore.core.php";
		self::$autoloader_array[ "Netziro\\Data\\NFData" ] = "includes/framework/core/NFData.core.php";
		self::$autoloader_array[ "Netziro\\Core\\NFSettings" ] = "includes/framework/core/NFSettings.core.php";
		self::$autoloader_array[ "Netziro\\Core\\Dependencies\\NFDependencies" ] = "includes/framework/dependencies/NFDependencies.core.php";
		self::$autoloader_array[ "Netziro\\UI\\NFUserInterface" ] = "includes/framework/ui/NFUserInterface.ui.php";
		self::$autoloader_array[ "Netziro\\Core\\Logger\\NFLogger" ] = "includes/framework/core/NFLogger.core.php";
		self::$autoloader_array[ "Netziro\\Util\\NFCrypto" ] = "includes/framework/util/NFCrypto.util.php";
		self::$autoloader_array[ "Netziro\\Util\\NFCache" ] = "includes/framework/util/NFCache.util.php";
		self::$autoloader_array[ "Netziro\\Util\\Locale\\NFIntl" ] = "includes/framework/util/NFIntl.util.php";
		self::$autoloader_array[ "Netziro\\Install\\NFInstall" ] = "includes/framework/install/NFInstall.core.php";
		self::$autoloader_array[ "Netziro\\Models\\NFTemplateModel" ] = "includes/framework/interfaces/NFTemplate.interface.php";
		self::$autoloader_array[ "Netziro\\Modules\\NFModule" ] = "includes/framework/core/NFModule.core.php";
		self::$autoloader_array[ "Netziro\\Models\\NFModuleModel" ] = "includes/framework/interfaces/NFModule.interface.php";
		self::$autoloader_array[ "Netziro\\Models\\NFModuleView" ] = "includes/framework/interfaces/NFModule.interface.php";
		self::$autoloader_array[ "Netziro\\Data\\Models\\NFDataModelSimple" ] = "includes/framework/datamodels/NFDataModelSimple.class.php";
		self::$autoloader_array[ "Netziro\\Data\\Models\\NFDataModel" ] = "includes/framework/datamodels/NFDataModel.class.php";	
		
	}
	
		
}

