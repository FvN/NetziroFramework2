<?php
ob_start();
session_start();
error_reporting( E_ALL ); ini_set( "display_errors", 1 );

define( "NF_INSTANCE", "application" );

require_once( "includes/core/NFBootstrap.core.php" );

echo NF_INSTANCE_ROOT_RELATIVE . "<br />";
echo NF_INSTANCE_TIMEZONE . "<br />";
echo NF_INSTANCE_LOCALE . "<br />";

echo NFIntl::NumberFormatCurrency( 545454645.54655 );

echo _( "Test" );

/*if( NFCore::$database_links[ "Profile1" ]->IsLinked() ){

	echo "Socket opened";
	
	$sql = "SELECT * FROM `test` WHERE `test` = :param1";
	$params = array( ':param1' => "d'alessio" );
	$results = NFCore::$database_links[ "Profile1" ]->Query( $sql, $params );
		
	print_r( $results );
		
	NFCore::$database_links[ "Profile1" ]->PrintErrors();
	
}*/

ob_end_flush( );