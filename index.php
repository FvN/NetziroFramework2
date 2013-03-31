<?php
ob_start();
session_start();

define( "NF_INSTANCE", "application" );

require_once( "core/NFBootstrap.core.php" );

echo NF_INSTANCE_ROOT_RELATIVE . "<br />";
echo NF_INSTANCE_TIMEZONE . "<br />";
echo NF_INSTANCE_LOCALE . "<br />";


$credentials[ "profile" ] = "Profile1";
/*$credentials[ "database" ] = "test";
$credentials[ "username" ] = "root";
$credentials[ "password" ] = "ph03nix";*/

$NFDatabase = new NFDatabase( $credentials );
$linkopened = $NFDatabase->OpenLink();

if( $linkopened === true ){
	
	echo "Socket opened";

	$sql = "SELECT * FROM `test` WHERE `test` = :param1";
	$params = array( ':param1' => "d'alessio" );
	$results = $NFDatabase->Query( $sql, $params );
	
	print_r( $results );
	
	$NFDatabase->PrintErrors();
	
} else {
	
	echo "Socket not opened";
	
	$NFDatabase->PrintErrors();
	
}

print_r( get_included_files() );

ob_end_flush( );