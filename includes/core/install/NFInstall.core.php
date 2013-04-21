<?php
/*
* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - NFInstall
* ----------------------------------------------------------------------
* FILE RELATIVE LOCATION:	includes/core/install/NFInstall.core.php
* CREATOR:					Alessio Nobile
* CREATING DATA:			02/01/12
* ----------------------------------------------------------------------
* FILE DESCRIPTION:			NFInstall
* ----------------------------------------------------------------------
*/

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFInstall
 *
 * @desc
 * NFInstall
 * 
 * ERROR CODES 0-1000
 * 
 */

class NFInstall extends NFUserInterface{
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Template Init Method
	 *
	 */
	public static function Init(){ 
		
		parent::IncludeCSSInline( " body { padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */ }" );
		parent::IncludeCSS( "includes/css/bootstrap.css" );
		parent::IncludeCSS( "includes/css/bootstrap-responsive.css" );
		parent::IncludeJS( "includes/js/jquery.js" );
		parent::IncludeJS( "includes/js/bootstrap.min.js" );
		parent::RenderHTMLHead();
		//require_once( parent::$template_index );
		self::Welcome();
		parent::RenderJS(); 
		parent::RenderHTMLFooter();
	
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * 
	 *
	 */
	protected static function Welcome(){
		
		echo "<div class=\"navbar navbar-inverse navbar-fixed-top\">";
			echo "<div class=\"navbar-inner\">";
				echo "<div class=\"container\">";
					echo "<button type=\"button\" class=\"btn btn-navbar\" data-toggle=\"collapse\" data-target=\".nav-collapse\">";
						echo "<span class=\"icon-bar\"></span>";
						echo "<span class=\"icon-bar\"></span>";
						echo "<span class=\"icon-bar\"></span>";
					echo "</button>";
					echo "<a class=\"brand\" href=\"#\">Project name</a>";
					
					echo "<div class=\"nav-collapse collapse\">";
						echo "<ul class=\"nav\">";
							echo "<li class=\"active\"><a href=\"#\">Home</a></li>";
							echo "<li><a href=\"#about\">About</a></li>";
							echo "<li><a href=\"#contact\">Contact</a></li>";
						echo "</ul>";
					echo "</div><!--/.nav-collapse -->";
				echo "</div>";
			echo "</div>";
		echo "</div>";

		echo "<div class=\"container\">";

			echo "<h1>Netziro Framework 2</h1>";
			echo "<p>Start message</p>";

		echo "</div> <!-- /container -->";
		
	}
	
	
}