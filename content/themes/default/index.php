<?php
if( NFCore::$database_links[ "master" ]->IsLinked() ){

	echo "Socket opened";
	
	$sql = "SELECT * FROM `test` WHERE `test` = :param1";
	$params = array( ':param1' => "d'alessio" );
	$results = NFCore::$database_links[ "master" ]->Query( $sql, $params );
		
	print_r( $results );
		
	NFCore::$database_links[ "master" ]->PrintErrors();
	
}