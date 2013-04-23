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

try{
	
	// ------------------------------------- | START Including Netziro Framework Core files
	require_once( "includes/core/NFramework.core.php" );
	NFramework::InitConf();
	NFramework::InitAutoloader();
	// ------------------------------------- | END
	
	// ------------------------------------- | START Instance&Security checks
	NFCore::CheckInstance();
	NFCore::CheckSession();
	NFCore::CheckPHPEnvironment();
	// ------------------------------------- | END
	
	// ------------------------------------- | START Executing bootstrap functions
	NFCore::DefineDebugSettings();
	NFCore::DefinePHPSettings();
	NFCore::DefineApplicationPath();
	NFCore::DefineLocaleSettings();
	NFCore::DefineTimeZoneSettings();
	NFCore::LoadDatabaseLinks();
	NFCore::FetchRequest();
	NFCore::RouteInstance();
	// ------------------------------------- | END	
	
} catch( Exception $e ){ NFLogger::LogWrite( 0, $e->getMessage(), "General.NFBootstrap", $e->getCode() ); exit(0); }