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
*                 NETZIRO FRAMEWORK - Internationalization class
* ----------------------------------------------------------------------
* SOFTWARE UNDER GPL LICENSE
* AUTHOR Alessio Nobile >> www.netziro.it >> netziro@gmail.com
* ----------------------------------------------------------------------
* CLASS NAME:				NFDatabase
* FILE RELATIVE LOCATION:	core/util/NFIntl.util.php
* CREATOR:					Alessio Nobile
* ----------------------------------------------------------------------
* CLASS DESCRIPTION:		
* ----------------------------------------------------------------------
* TRACKING  LOG - LOG YOUR CHANGES ONLY IF YOU ARE DOING IMPORTANT UPDATES ( CHANGE OF METHOD, ADDING/DELETING LINES OF CODE, BUGFIX)
* ----------------------------------------------------------------------
* UPDATE : 
* MODDER: ALESSIO NOBILE / DATE AND HOUR : 02/11/2011 - 12:45
* ----------------------------------------------------------------------
*/

class NFIntl extends NFramework{
	
	private static $locale_instance;
	private static $NumberFormatter;
	private static $IntlDateFormatter;

	
	/**
	 * @desc
	 * Set the locale for the instance
	 * 
	 * $param $locale | language_COUNTRY
	 */
	public static function SetLocale( $locale ){
		
		if( !empty( $locale ) ){
			
			// ------------------------------------- | START Set Locales and languages informations for the instance
			setlocale( LC_MESSAGES, "$locale.utf8" );
			bindtextdomain( NF_INSTANCE_APPLICATION_NAME, NF_INSTANCE_ROOT_DIRECTORY . "includes/locales/" );
			textdomain( NF_INSTANCE_APPLICATION_NAME );
			bind_textdomain_codeset( NF_INSTANCE_APPLICATION_NAME, "UTF-8" );
			self::$locale_instance = $locale;
			$_SESSION[ "locale" ] = $locale;
			define( 'NF_INSTANCE_LOCALE', $locale );
			define( 'NF_INSTANCE_LANGUAGE', strtoupper( substr( $locale, 0, 2 ) ) );
			// ------------------------------------- | END
			
		} else { throw new Exception( "NFIntl SetLocale failed. Empty locale value", 15 ); }
		
	}
	
	/**
	 * @desc
	 * Try to get the locale setting from the HTTP Headers
	 * 
	 * language_COUNTRY
	 * 
	 * @return the locale string 
	 */
	public static function LocaleHttpHeader(){
		
		$locale = Locale::acceptFromHttp( $_SERVER[ "HTTP_ACCEPT_LANGUAGE" ] );
		return $locale;
		
	}	
	
	
	/**
	 * @desc
	 * Format a decimal number by the instance locale settings
	 * 
	 * @param $value | decimal number 
	 * @return the formatted value
	 */
	public static function NumberFormatDecimal( $value = 0 ){
		
		if( is_float( $value ) ){
			
			$a = new NumberFormatter( self::$locale_instance, NumberFormatter::DECIMAL ); 
			return $a->format( $value ); 
			
		} else { return "Your value is not a decimal number."; }
		
	}	
	
	/**
	 * @desc
	 * Format a currency by the instance locale settings
	 * 
	 * @param $value | currency 
	 * 
	 * @return the formatted value
	 */
	public static function NumberFormatCurrency( $value = 0 ){
		
		if( is_float( $value ) ){
			
			$a = new NumberFormatter( self::$locale_instance, NumberFormatter::CURRENCY ); 
			return $a->format( $value ); 
			
		} else { return "Your value is not a decimal number."; }
		
	}	
	
	
}




