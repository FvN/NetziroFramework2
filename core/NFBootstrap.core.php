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
* TRACKING  LOG - LOG YOUR CHANGES ONLY IF YOU ARE DOING IMPORTANT UPDATES ( CHANGE OF METHOD, ADDING/DELETING LINES OF CODE, BUGFIX)
* ----------------------------------------------------------------------
* UPDATE : 
* MODDER: ALESSIO NOBILE / DATE AND HOUR : 02/11/2011 - 12:45
* ----------------------------------------------------------------------
*/

try{
	
	// ------------------------------------- | START Including Netziro Framework Core files
	require_once( "config/NFConfig.core.php" );
	require_once( "core/NFramework.core.php" );
	// ------------------------------------- | END
	
	// ------------------------------------- | START Instance&Security checks
	NFCore::CheckInstance();
	NFCore::CheckSession();
	// ------------------------------------- | END
	
	// ------------------------------------- | START Executing bootstrap functions
	NFCore::DefineDebugMode();
	NFCore::DefineApplicationPath();
	NFCore::DefineLocaleSettings();
	NFCore::DefineTimeZoneSettings();
	// ------------------------------------- | END
		
	
} catch( Exception $e ){ NFLogger::LogWrite( 0, $e->getMessage(), "General.NFBootstrap", $e->getCode() ); exit(0); }