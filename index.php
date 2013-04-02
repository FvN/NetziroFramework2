<?php
ob_start();
session_start();

define( "NF_INSTANCE", "application" );

require_once( "includes/core/NFBootstrap.core.php" );

echo "Formatted currency<br />";
echo NFIntl::NumberFormatCurrency( 545454645.54655 );


echo "<br />Translated label<br />";
echo _( "Test" );

NFCore::PrintPre( NFIntl::GetLocalesSupported() );

/*if( NFCore::$database_links[ "Profile1" ]->IsLinked() ){

	echo "Socket opened";
	
	$sql = "SELECT * FROM `test` WHERE `test` = :param1";
	$params = array( ':param1' => "d'alessio" );
	$results = NFCore::$database_links[ "Profile1" ]->Query( $sql, $params );
		
	print_r( $results );
		
	NFCore::$database_links[ "Profile1" ]->PrintErrors();
	
}*/

ob_end_flush( );