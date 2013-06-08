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
			NFramework::InitConf();
			// ------------------------------------- | END
			
			// ------------------------------------- | START Debug settings init
			NFCore::InitDebugSettings();
			// ------------------------------------- | END
			
			// ------------------------------------- | START Instance&Security checks
			NFCore::CheckInstance();
			NFCore::CheckSession();
			NFCore::CheckPHPEnvironment();
			// ------------------------------------- | END
			
			// ------------------------------------- | START Executing bootstrap functions
			NFCore::DefinePHPSettings();
			NFCore::DefineApplicationPath();
			NFCore::DefineLocaleSettings();
			NFCore::DefineTimeZoneSettings();
			NFCore::LoadDatabaseLinks();
			NFCore::LoadCache();
			NFCore::FetchRequest();
			NFCore::RouteInstance();
			// ------------------------------------- | END	
			
		} catch( Exception $e ){ NFLogger::LogWrite( 0, $e->getMessage(), "General.NFBootstrap", $e->getCode() ); exit(0); }
		
	}
	
}


