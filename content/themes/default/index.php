<?php
if( NFCore::$database_links[ "master" ]->IsLinked() ){
	 
	echo "<div class=\"container\">";
		echo "<h1>Socket opened</h1>";
      
    	echo "<p>";
    		$sql = "SELECT * FROM `test` WHERE `test` = :param1";
			$params = array( ':param1' => "d'alessio" );
			$results = NFCore::$database_links[ "master" ]->Query( $sql, $params );
				
			print_r( $results );
				
			NFCore::$database_links[ "master" ]->PrintErrors();	
    	echo "</p>";
    	
    echo "</div>";
	
	
}