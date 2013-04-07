<?php
/*
    This file is part of Netziro Framework.

    Netziro Framework is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Netziro Framework is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Netziro Framework.  If not, see <http://www.gnu.org/licenses/>.

* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - USER INTERFACE CLASS
* ----------------------------------------------------------------------
* SOFTWARE UNDER GPL LICENSE
* AUTHOR Alessio Nobile >> www.netziro.it >> netziro@gmail.com
* ----------------------------------------------------------------------
* CLASS NAME:				NFUserInterface
* FILE RELATIVE LOCATION:	core/ui/NFUserInterface.class.php
* CREATOR:					Alessio Nobile
* ----------------------------------------------------------------------
* CLASS DESCRIPTION:		Class used to renderize your user interface and handle the responsiveness of your application
* ----------------------------------------------------------------------
*/

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFUserInterface
 *
 * @desc
 * Class used to renderize your user interface and handle the responsiveness of your application
 * 
 * ERROR CODES 4000-5000
 * 
 */

class NFUserInterface extends NFramework{
	
	protected static $template = "default";
	protected static $template_directory = "content/themes/default";
	protected static $template_index = "content/themes/default/index.php";
	protected static $template_init = "content/themes/default/init.php";
	
	
	public static function GetTemplate(){ return self::$template; }
	public static function GetTemplateDirectory(){ return self::$template_directory; }
	public static function GetTemplateIndex(){ return self::$template_index; }
	public static function GetTemplateInit(){ return self::$template_init; }
	
	/**
	 * @desc
	 * Constructor
	 *  
	 */
	public static function Init(){
		
		// ------------------------------------- | START Load template settings
		self::LoadTemplateSettings();
		self::LoadTemplate();
		// ------------------------------------- | END
		
	}
	
	/**
	 * @desc
	 * Template settings loader
	 *  
	 */
	private static function LoadTemplateSettings(){
		
		$template = NFSettings::FetchByKey( "template" );
		if( $template !== false ){ 
			self::$template = $template;
			self::$template_directory = "content/themes/$template";
			self::$template_index = "content/themes/$template/index.php";
			self::$template_init = "content/themes/$template/init.php";
			 
		}
		
	}
	
	/**
	 * @desc
	 * Templates loader
	 *  
	 */
	private static function LoadTemplate(){
		
		if( file_exists( self::$template_directory ) AND file_exists( self::$template_index ) AND file_exists( self::$template_init ) ){
			
			NFTheme::Init();
			
		} else { throw new Exception( "The template " . self::$template . " directory or index doesn't exist", 4000 ); }
		
	}
	
	/**
	 * @desc
	 * RenderMenu will render the menu object
	 *  
	 */
	private static function RenderMenu(){

		$html = "
		<ul class=\"nav\">
     		<li class=\"dropdown\">
				<a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"icon-globe\"></i> TEAM <b class=\"caret\"></b></a>
				<ul class=\"dropdown-menu\">
					
					<li class=\"nav-header\">ISSUE TRACKER</li>
					<li><a href=\"#\"><i class=\"icon-fire\"></i> Your issues</a></li>
					<li><a href=\"#\"><i class=\"icon-tasks\"></i> Issues List</a></li>
					
					<li class=\"divider\"></li>
					
					<li class=\"nav-header\">INFO CENTER</li>
					<li><a href=\"#\"><i class=\"icon-book\"></i> CGAPP Manual</a></li>
					<li><a href=\"#\"><i class=\"icon-retweet\"></i> API Documentation</a></li>
					<li><a href=\"#\"><i class=\"icon-info-sign\"></i> Error Codes</a></li>
					<li><a href=\"#\"><i class=\"icon-thumbs-up\"></i> Best Practice</a></li>
					<li><a href=\"#\"><i class=\"icon-magic\"></i> Tech resource</a></li>
				</ul>
			</li>
              
              <li class=\"dropdown\">
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"icon-cogs\"></i> SETTINGS <b class=\"caret\"></b></a>
                <ul class=\"dropdown-menu\">
                  <li><a href=\"\"><i class=\"icon-wrench\"></i> General Settings</a></li>
                  <li><a href=\"\"><i class=\"icon-group\"></i> Divisions</a></li>
                  <li><a href=\"\"><i class=\"icon-reorder\"></i> Menu</a></li>
                  <li><a href=\"\"><i class=\"icon-flag\"></i> Languages</a></li>
                  <li><a href=\"\"><i class=\"icon-filter\"></i> Filters</a></li>
                  <li><a href=\"\"><i class=\"icon-download-alt\"></i> Import</a></li>
                  <li><a href=\"\"><i class=\"icon-upload-alt\"></i> Export</a></li>
                  <li><a href=\"\"><i class=\"icon-share-alt\"></i> Escalation emails</a></li>
                  <li><a href=\"\"><i class=\"icon-user-md\"></i> Customer Details</a></li>
                  <li><a href=\"\"><i class=\"icon-sort\"></i> Categorising</a></li>
                  <li><a href=\"\"><i class=\"icon-sort\"></i> Task Details</a></li>
                </ul>
              </li>
              
              <li class=\"dropdown\">
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"icon-picture\"></i> TEMPLATES <b class=\"caret\"></b></a>
                <ul class=\"dropdown-menu\">
                  <li><a href=\"\"><i class=\"icon-comments\"></i> Surveys</a></li>
                  <li><a href=\"\"><i class=\"icon-envelope-alt\"></i> Emails</a></li>
                </ul>
              </li>
              
              <li class=\"dropdown\">
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"icon-legal\"></i> <b></b> <b class=\"caret\"></b></a>
                <ul class=\"dropdown-menu\">
                  <li class=\"nav-header\">NEW</li>
                  <li><a href=\"\"><i class=\"icon-plus\"></i> New Client</a></li>
                  <li class=\"divider\"></li>
                  <li class=\"nav-header\">Choose</li>
                  <li>
                      <ul class=\"customer-menu\">
                        
                      </ul>
                  </li>
                </ul>
              </li>
              
              <li class=\"dropdown\">
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><i class=\"icon-home\"></i> <b>Alessio Nobile</b> <b class=\"caret\"></b></a>
                <ul class=\"dropdown-menu\">
                  	<li><a href=\"\"><i class=\"icon-user\"></i> My Profile</a></li>
                	<li><a href=\"#\"><i class=\"icon-comment\"></i> Messages Box</a></li>
                	<li><a href=\"admin_logout.php\"><i class=\"icon-off\"></i> Logout</a></li>
                </ul>
              </li>
              
            </ul>
		";

		return $html;
		
	}
	
	/**
	 * @desc
	 * RequireJS rendering
	 * Will render the html string in order to include the requirejs module
	 *  
	 * @param string $module
	 * @param string $action
	 *  
	 */
	private static function RequireJS( $module = "", $action = ""){
	
		// ------------------------------------- | START Define the module name depending on action
		if( !empty( $module ) AND !empty( $action ) ){
			$module_name = "$module.$action";
		} elseif( !empty( $module ) ){
			$module_name = $module;
		}
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define the module file
        $module_file = "js/modules/$module_name.js";
        // ------------------------------------- | END
        
        // ------------------------------------- | START return the html string if the module file exists
	    if( file_exists( $module_file ) ){ 
	    	return "<script data-main=\"js/main\"  src=\"js/require.js\"></script><script> define('global', { module: '$module_name' }) </script>"; 
	    }
	    // ------------------------------------- | END
	       
	}
	
}