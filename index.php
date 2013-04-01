<?php
ob_start();
session_start();

define( "NF_INSTANCE", "application" );

require_once( "includes/core/NFBootstrap.core.php" );

echo NF_INSTANCE_ROOT_RELATIVE . "<br />";
echo NF_INSTANCE_TIMEZONE . "<br />";
echo NF_INSTANCE_LOCALE . "<br />";

	
echo "Socket opened";

$sql = "SELECT * FROM `test` WHERE `test` = :param1";
$params = array( ':param1' => "d'alessio" );
$results = NFCore::$database_links[ "Profile1" ]->Query( $sql, $params );
	
print_r( $results );
	
NFCore::$database_links[ "Profile1" ]->PrintErrors();

ob_end_flush( );