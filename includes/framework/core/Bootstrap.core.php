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

namespace Netziro\Core;

use Netziro;
/**
 * @author alessio
 *
 */
class Bootstrap{

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
			Netziro\Framework::InitConf();
			// ------------------------------------- | END
			
			// ------------------------------------- | START Debug settings init
			Netziro\Framework::InitDebugSettings();
			// ------------------------------------- | END
			
			// ------------------------------------- | START Instance&Security checks
			Netziro\Framework::CheckInstance();
			Netziro\Framework::CheckSession();
			Netziro\Framework::CheckPHPEnvironment();
			// ------------------------------------- | END
			
			// ------------------------------------- | START Executing bootstrap functions
			Netziro\Framework::DefinePHPSettings();
			Netziro\Framework::DefineApplicationPath();
			Netziro\Framework::FetchRequest();
			Netziro\Framework::DefineLocaleSettings();
			Netziro\Framework::DefineTimeZoneSettings();
			Netziro\Framework::LoadDatabaseLinks();
			Netziro\Framework::LoadCache();
			Netziro\Framework::RouteInstance();
			// ------------------------------------- | END	
			
		} catch( \Exception $e ){ Netziro\Core\Logger::LogWrite( 0, $e->getMessage(), "General.Bootstrap", $e->getCode() ); exit(0); }
		
	}
	
}


