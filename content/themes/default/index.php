<?php
if( NFCore::$database_links[ "master" ]->IsLinked() ){
	 
	echo "<div class=\"container\">";
		echo "<h1>Socket opened</h1>";
      
    	NFModule::Init();
    	
    echo "</div>";
	
	
}