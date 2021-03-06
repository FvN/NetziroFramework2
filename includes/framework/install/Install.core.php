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

namespace Netziro\Install;

use Netziro;

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

class Install implements Netziro\Models\TemplateModel{
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Template Init Method
	 *
	 */
	public static function Init(){ 
		
		Netziro\UI\UserInterface::IncludeCSSInline( " body { padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */ }" );
		Netziro\UI\UserInterface::IncludeCSS( "bootstrap.css" );
		Netziro\UI\UserInterface::IncludeCSS( "bootstrap-responsive.css" );
		Netziro\UI\UserInterface::IncludeCSS( "install/install.css" );
		Netziro\UI\UserInterface::IncludeJS( "jquery.js" );
		Netziro\UI\UserInterface::IncludeJS( "bootstrap.min.js" );
		Netziro\UI\UserInterface::RenderHTMLHead();
		//require_once( parent::$template_index );
		self::Welcome();
		Netziro\UI\UserInterface::RenderJS(); 
		Netziro\UI\UserInterface::RenderHTMLFooter();
	
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * 
	 *
	 */
	protected static function Welcome(){
		
		echo "<div class=\"tabbable tabs-left\">";
			
			echo "<ul class=\"nav nav-tabs\">";
				echo "<li class=\"active\"><a href=\"#tab1\" data-toggle=\"tab\">Welcome</a></li>";
				echo "<li><a href=\"#tab2\" data-toggle=\"tab\">Install</a></li>";
			echo "</ul>";
			
			echo "<div class=\"tab-content\">";
			
				echo "<div class=\"tab-pane active\" id=\"tab1\">";
					echo "<p>Welcome to the Netziro Framework</p>";
				echo "</div>";
			
				echo "<div class=\"tab-pane\" id=\"tab2\">";
					echo "<p>Installation start</p>";
				echo "</div>";
				
			echo "</div>";
			
		echo "</div>";

	}
	
	
}