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
*                 NETZIRO FRAMEWORK - Module Init
* ----------------------------------------------------------------------
* SOFTWARE UNDER GPL LICENSE
* AUTHOR Alessio Nobile >> www.netziro.it >> netziro@gmail.com
* ----------------------------------------------------------------------
* CLASS NAME:				NFTheme
* FILE RELATIVE LOCATION:	modules/$module/init.php
* CREATOR:					Alessio Nobile
* ----------------------------------------------------------------------
* CLASS DESCRIPTION:		Class used to init the theme
* ----------------------------------------------------------------------
*/

namespace app;

use Netziro\Modules;
use Netziro\Models;

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFapp
 *
 * @desc
 * Theme init class
 * 
 * ERROR CODES 4000-5000
 * 
 */

class app extends Modules\Module implements Models\ModuleModel{
	
	protected $module_name;
	
	protected $dataset = array();
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Template Init Method
	 *
	 */
	public static function AutoLoad(){ 
		
		
		//echo "ciao";
		
	
	
	}
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Template Init Method
	 *
	 */
	public static function ModuleRouter(){ 
		
		
		echo "ciao";
		
	
	
	}
	

	/* (non-PHPdoc)
	 * @see NFModuleModel::LoadUI()
	 */
	public static function LoadUI(){
		
		//NFUserInterface::IncludeCSS( "bootstrap.css" );
		//NFUserInterface::IncludeCSS( "bootstrap-responsive.css" );
		//NFUserInterface::IncludeJS( "jquery.js" );
		//NFUserInterface::IncludeJS( "bootstrap.min.js" );
		
	}
	
	public static function LoadVisibilityRules(){}
	
}