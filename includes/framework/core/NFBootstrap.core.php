<?php
/*
* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - NFBootstrap
* ----------------------------------------------------------------------
* FILE RELATIVE LOCATION:	core/NFBootstrap.core.php
* CREATOR:					Alessio Nobile
* CREATING DATA:			02/01/12
* ----------------------------------------------------------------------
* FILE DESCRIPTION:			
* ----------------------------------------------------------------------
*/

namespace Netziro\Core\Bootstrap;

use Netziro;
/**
 * @author alessio
 *
 */
class NFBootstrap{

	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Bootstrap method
	 *
	 */
	public static function Init(){

		try{
			
			// ------------------------------------- | START Including Netziro Framework Core files
			Netziro\NFramework::InitConf();
			// ------------------------------------- | END
			
			// ------------------------------------- | START Debug settings init
			Netziro\Core\NFCore::InitDebugSettings();
			// ------------------------------------- | END
			
			// ------------------------------------- | START Instance&Security checks
			Netziro\Core\NFCore::CheckInstance();
			Netziro\Core\NFCore::CheckSession();
			Netziro\Core\NFCore::CheckPHPEnvironment();
			// ------------------------------------- | END
			
			// ------------------------------------- | START Executing bootstrap functions
			Netziro\Core\NFCore::DefinePHPSettings();
			Netziro\Core\NFCore::DefineApplicationPath();
			Netziro\Core\NFCore::DefineLocaleSettings();
			Netziro\Core\NFCore::DefineTimeZoneSettings();
			Netziro\Core\NFCore::LoadDatabaseLinks();
			Netziro\Core\NFCore::LoadCache();
			Netziro\Core\NFCore::FetchRequest();
			Netziro\Core\NFCore::RouteInstance();
			// ------------------------------------- | END	
			
		} catch( \Exception $e ){ Netziro\Core\Logger\NFLogger::LogWrite( 0, $e->getMessage(), "General.NFBootstrap", $e->getCode() ); exit(0); }
		
	}
	
}


