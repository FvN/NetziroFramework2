<?php
if( NFCore::$database_links[ "master" ]->IsLinked() ){
	 
	echo "<div class=\"container\">";
		echo "<h1>Socket opened</h1>";
      
		// ------------------------------------- | START Simple DataModel test
		/*$sql = "SELECT `test` FROM `test` WHERE `test` = :param1";
		$params = array( ':param1' => "d'alessio" );
		$results = NFCore::$database_links[ "master" ]->Query( $sql, $params );
		NFCore::PrintPre( $results );*/
		/*$object = new NFDataModelSimple( "alessio_test" );
		$object->SetCache( true );
		
		echo $object->Get( "chiave9" );
		$object->Add( "chiave9" , "valore9" );*/
		// ------------------------------------- | END
		
		// ------------------------------------- | START Extended data model test
		
		$array = array();
		
		$array[ "field1" ][ "name" ] = "field1";
		$array[ "field1" ][ "type" ] = "varchar";
		$array[ "field1" ][ "length" ] = 100;
		$array[ "field1" ][ "default_value" ] = "default";
		$array[ "field1" ][ "validation_type" ] = "";
		$array[ "field1" ][ "mandatory" ] = false;
		$array[ "field1" ][ "manipulation" ] = 0;
		$array[ "field1" ][ "index" ] = "";
		
		$array[ "field2" ][ "name" ] = "field2";
		$array[ "field2" ][ "type" ] = "varchar";
		$array[ "field2" ][ "length" ] = 100;
		$array[ "field2" ][ "default_value" ] = "default";
		$array[ "field2" ][ "validation_type" ] = "";
		$array[ "field2" ][ "mandatory" ] = false;
		$array[ "field2" ][ "manipulation" ] = 0;
		$array[ "field2" ][ "index" ] = "";
		
		$array[ "field3" ][ "name" ] = "field3";
		$array[ "field3" ][ "type" ] = "varchar";
		$array[ "field3" ][ "length" ] = 100;
		$array[ "field3" ][ "default_value" ] = "default";
		$array[ "field3" ][ "validation_type" ] = "";
		$array[ "field3" ][ "mandatory" ] = false;
		$array[ "field3" ][ "manipulation" ] = 0;
		$array[ "field3" ][ "index" ] = "";
		
		
		$object = new NFDataModel( "tabella_prova", $array );
		
		$object->SetCache( true );
		$object->SetValue( "field1" , "i love you" );
		$object->SetValue( "field2" , "i love you too" );
		$object->SetValue( "field3" , "i'm alessio" );
		$object->Insert();
		
		// ------------------------------------- | END
		
		
		
    	NFModule::Init();
    	
    echo "</div>";
	
	
}