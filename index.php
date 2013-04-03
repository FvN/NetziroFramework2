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

$NFCrypto = new NFCrypto();

$string = "Ciao Alessio";
$encrypted = $NFCrypto->Encrypt( $string );

echo "Original string: $string<br />";
echo "Encrypted string: $encrypted<br />";

$decrypt = $NFCrypto->Decrypt( $encrypted );
echo "Decrypted string: $decrypt<br />";

$decrypt = $NFCrypto->Decrypt( "e7358f116d75d2def5870ba70ace2e82da49fc6eefebd10fdff90c35ba9e1db8:DG5ZJtdCdEk6D0SnrnwJOw==:ky57wrWRe9czV81Ao0eXEQ==" );
echo "Decrypted string: $decrypt<br />";
/*
if( NFCore::$database_links[ "master" ]->IsLinked() ){

	echo "Socket opened";
	
	$sql = "SELECT * FROM `test` WHERE `test` = :param1";
	$params = array( ':param1' => "d'alessio" );
	$results = NFCore::$database_links[ "master" ]->Query( $sql, $params );
		
	print_r( $results );
		
	NFCore::$database_links[ "master" ]->PrintErrors();
	
}*/

ob_end_flush( );