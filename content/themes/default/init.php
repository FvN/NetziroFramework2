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
*                 NETZIRO FRAMEWORK - THEME CLASS
* ----------------------------------------------------------------------
* SOFTWARE UNDER GPL LICENSE
* AUTHOR Alessio Nobile >> www.netziro.it >> netziro@gmail.com
* ----------------------------------------------------------------------
* CLASS NAME:				NFTheme
* FILE RELATIVE LOCATION:	content/themes/$template/init.php
* CREATOR:					Alessio Nobile
* ----------------------------------------------------------------------
* CLASS DESCRIPTION:		Class used to init the theme
* ----------------------------------------------------------------------
*/

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFTheme
 *
 * @desc
 * Theme init class
 * 
 * ERROR CODES 4000-5000
 * 
 */

class NFTheme extends NFUserInterface{
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Template Init Method
	 *
	 */
	public static function Init(){ 
		
		parent::IncludeCSS( "bootstrap.css" );
		parent::IncludeCSS( "bootstrap-responsive.css" );
		parent::IncludeJS( "jquery.js" );
		parent::IncludeJS( "bootstrap.min.js" );
		parent::RenderHTMLHead();
		require_once( parent::$template_index );
		parent::RenderJS(); 
		parent::RenderHTMLFooter();
	
	
	}
	
}