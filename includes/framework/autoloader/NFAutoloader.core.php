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
		spl_autoload_register( array( "NFAutoloader", "Load" ) );
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
			case "NFTheme":
				
				$template_init = NFUserInterface::GetTemplateInit();
				
				if( file_exists( $template_init ) ){
					
					require_once( $template_init );
					unset( $template_init );
						
				} else { throw new Exception( "NFAutoloader - You tried to load the template $class, but the file doesn't exist" , 9 ); }
				
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
		
		self::$autoloader_array[ "NFAutoloader" ] = "includes/framework/autoloader/NFAutoloader.core.php";
		self::$autoloader_array[ "NFramework" ] = "includes/framework/core/NFramework.core.php";
		self::$autoloader_array[ "NFBootstrap" ] = "includes/framework/core/NFBootstrap.core.php";
		self::$autoloader_array[ "NFDatabase" ] = "includes/framework/database/NFDatabase.class.php";
		self::$autoloader_array[ "NFCore" ] = "includes/framework/core/NFCore.core.php";
		self::$autoloader_array[ "NFData" ] = "includes/framework/core/NFData.core.php";
		self::$autoloader_array[ "NFSettings" ] = "includes/framework/core/NFSettings.core.php";
		self::$autoloader_array[ "NFDependencies" ] = "includes/framework/dependencies/NFDependencies.core.php";
		self::$autoloader_array[ "NFUserInterface" ] = "includes/framework/ui/NFUserInterface.ui.php";
		self::$autoloader_array[ "NFLogger" ] = "includes/framework/core/NFLogger.core.php";
		self::$autoloader_array[ "NFCrypto" ] = "includes/framework/util/NFCrypto.util.php";
		self::$autoloader_array[ "NFCache" ] = "includes/framework/util/NFCache.util.php";
		self::$autoloader_array[ "NFIntl" ] = "includes/framework/util/NFIntl.util.php";
		self::$autoloader_array[ "NFInstall" ] = "includes/framework/install/NFInstall.core.php";
		self::$autoloader_array[ "NFTemplateModel" ] = "includes/framework/interfaces/NFTemplate.interface.php";
		self::$autoloader_array[ "NFModule" ] = "includes/framework/core/NFModule.core.php";
		self::$autoloader_array[ "NFModuleModel" ] = "includes/framework/interfaces/NFModule.interface.php";
		self::$autoloader_array[ "NFModuleView" ] = "includes/framework/interfaces/NFModule.interface.php";
		self::$autoloader_array[ "NFDataModelSimple" ] = "includes/framework/datamodels/NFDataModelSimple.class.php";
		self::$autoloader_array[ "NFDataModel" ] = "includes/framework/datamodels/NFDataModel.class.php";	
		
	}
	
		
}

