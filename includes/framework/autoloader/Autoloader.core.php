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

use Netziro\UI;

class Autoloader{
	
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
		spl_autoload_register( array( "Netziro\\Core\\Autoloader\\Autoloader", "Load" ) );
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
			case "Theme\\Theme":
				
				$template_init = UI\UserInterface::GetTemplateInit();
				
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
		
		self::$autoloader_array[ "Netziro\\Framework" ] = "includes/framework/core/Framework.core.php";
				
		self::$autoloader_array[ "Netziro\\Database" ] = "includes/framework/database/Database.class.php";
		
		self::$autoloader_array[ "Netziro\\Data\\DataTypes" ] = "includes/framework/core/DataTypes.core.php";
		
		self::$autoloader_array[ "Netziro\\Core\\Bootstrap" ] = "includes/framework/core/Bootstrap.core.php";
		self::$autoloader_array[ "Netziro\\Core\\Settings" ] = "includes/framework/core/Settings.core.php";
		self::$autoloader_array[ "Netziro\\Core\\Logger" ] = "includes/framework/core/Logger.core.php";
		self::$autoloader_array[ "Netziro\\Core\\Dependencies\\Dependencies" ] = "includes/framework/dependencies/Dependencies.core.php";
		self::$autoloader_array[ "Netziro\\Core\\Autoloader\\Autoloader" ] = "includes/framework/autoloader/Autoloader.core.php";
		
		
		self::$autoloader_array[ "Netziro\\UI\\UserInterface" ] = "includes/framework/ui/UserInterface.ui.php";
		
		
		self::$autoloader_array[ "Netziro\\Util\\Crypto" ] = "includes/framework/util/Crypto.util.php";
		self::$autoloader_array[ "Netziro\\Util\\Cache" ] = "includes/framework/util/Cache.util.php";
		self::$autoloader_array[ "Netziro\\Util\\Locale\\Intl" ] = "includes/framework/util/Intl.util.php";
		
		self::$autoloader_array[ "Netziro\\Install\\Install" ] = "includes/framework/install/Install.core.php";
		
		self::$autoloader_array[ "Netziro\\Modules\\Module" ] = "includes/framework/core/Module.core.php";
		
		self::$autoloader_array[ "Netziro\\Models\\TemplateModel" ] = "includes/framework/interfaces/Template.interface.php";
		self::$autoloader_array[ "Netziro\\Models\\ModuleModel" ] = "includes/framework/interfaces/Module.interface.php";
		self::$autoloader_array[ "Netziro\\Models\\ModuleView" ] = "includes/framework/interfaces/Module.interface.php";
		
		self::$autoloader_array[ "Netziro\\Data\\Models\\DataModelSimple" ] = "includes/framework/datamodels/DataModelSimple.class.php";
		self::$autoloader_array[ "Netziro\\Data\\Models\\DataModel" ] = "includes/framework/datamodels/DataModel.class.php";
		
		self::$autoloader_array[ "Predis\\Autoloader" ] = "includes/ext/Predis/Autoloader.php";
			
		
	}
	
		
}

