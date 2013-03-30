<?php
/*
* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - NFCore
* ----------------------------------------------------------------------
* FILE RELATIVE LOCATION:	core/NFCore.core.php
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

	/**
	 * @desc
	 * This function will define application's URL and real path
	 * 
	 */

	function nfDefineApplicationPath(){
		
		// ------------------------------------- | START Fetch instance informations
		$script_filename = $_SERVER[ "SCRIPT_FILENAME" ];
		$script_name = $_SERVER[ "SCRIPT_NAME" ];
		$request_uri = $_SERVER[ "REQUEST_URI" ];
		$server_name = $_SERVER[ "SERVER_NAME" ];
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define Application URL
		$script_name_exploded = explode( "/", $script_name );
		$last_index = count( $script_name_exploded );
		unset( $script_name_exploded[ $last_index -1 ] );
		$relative_directory = implode( "/", $script_name_exploded );
		$application_url = "http://$server_name$relative_directory/";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define Application Real directory
		$script_filename_exploded = explode( "/", $script_filename );
		$last_index = count( $script_filename_exploded );
		unset( $script_filename_exploded[ $last_index -1 ] );
		$real_directory = implode( "/", $script_filename_exploded ) . "/";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define relative path
		$relative_directory = substr( $relative_directory, 1 ) . "/";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define Constants
		define( "NF_INSTANCE_URL", $application_url );
		define( "NF_INSTANCE_ROOT_DIRECTORY", $real_directory );
		define( "NF_INSTANCE_ROOT_RELATIVE", $relative_directory );
		// ------------------------------------- | END
		
		
	}