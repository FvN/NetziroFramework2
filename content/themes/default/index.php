<?php
if( NFCore::$database_links[ "master" ]->IsLinked() ){
	 
	echo "<div class=\"container\">";
		echo "<h1>Socket opened</h1>";
      
		/*$sql = "SELECT `test` FROM `test` WHERE `test` = :param1";
		$params = array( ':param1' => "d'alessio" );
		$results = NFCore::$database_links[ "master" ]->Query( $sql, $params );
		NFCore::PrintPre( $results );*/
		$object = new NFDataModelSimple( "alessio_test" );
		
		
		echo $object->Delete( "chiave3" );
		echo $object->Get( "chiave3" );
		
		$object->Add( "chiave5" , "valore5" );
		
    	NFModule::Init();
    	
    echo "</div>";
	
	
}