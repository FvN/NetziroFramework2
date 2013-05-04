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
*                 NETZIRO FRAMEWORK - MODULE MODEL INTERFACE
* ----------------------------------------------------------------------
* SOFTWARE UNDER GPL LICENSE
* AUTHOR Alessio Nobile >> www.netziro.it >> netziro@gmail.com
* ----------------------------------------------------------------------
* CLASS NAME:				NFModule
* FILE RELATIVE LOCATION:	includes/core/models/NFModule.model.php
* CREATOR:					Alessio Nobile
* ----------------------------------------------------------------------
* CLASS DESCRIPTION:		Module model interface
* ----------------------------------------------------------------------
*/

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFModule
 *
 * @desc
 * Module model interface
 * 
 * ERROR CODES 6000-8000
 * 
 */

interface NFModuleModel{
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Module Init Method and request router
	 *
	 */
	static function ModuleRouter();
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Load methods visibility rules 
	 *
	 */
	static function LoadVisibilityRules();
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Load all User Interface requirements for the given module
	 * 
	 */
	static function LoadUI();
	
}


interface NFModuleView{
	
	/**
	 * @author Alessio Nobile
	 * 
	 * @desc
	 * Module Init Method
	 *
	 */
	public function ListView();
	
	public function AddView();
	
	public function SearchView();
	
	public function DelView();
	
		
}

