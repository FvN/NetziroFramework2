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
	
	// ------------------------------------- | START Debugging options
	if( defined( "CG_INSTANCE_DEBUG" ) AND CG_INSTANCE_DEBUG ){ error_reporting( E_ALL ); ini_set( "display_errors", 1 ); }
	// ------------------------------------- | END
	
	// ------------------------------------- | START Including Netziro Framework Core files
	require_once( "config/NFConfig.core.php" );
	require_once( "core/util/NFLogger.util.php" );
	require_once( "core/NFCore.core.php" );
	require_once( "core/database/NFDatabase.class.php" );
	// ------------------------------------- | END
	
	// ------------------------------------- | START Instance&Security checks
	if( !defined( "NF_INSTANCE" ) ){ throw new Exception( "Netziro Framework instance not defined yet", 1 ); }
	if( session_status() != PHP_SESSION_ACTIVE ){ throw new Exception( "Netziro Framework session has been not started yet", 2 ); }
	// ------------------------------------- | END
	
	// ------------------------------------- | START Executing bootstrap functions
	NFCore::DefineApplicationPath();
	// ------------------------------------- | END
		
	
} catch( Exception $e ){ NFLogger::LogWrite( 0, $e->getMessage(), "General.NFBootstrap", $e->getCode() ); exit(0); }