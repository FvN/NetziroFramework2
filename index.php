<?php


require_once( "core/database/NFDatabase.class.php" );

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

