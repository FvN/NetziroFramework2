<?php
/*
* ----------------------------------------------------------------------
*                 NETZIRO FRAMEWORK - NFCore
* ----------------------------------------------------------------------
* FILE RELATIVE LOCATION:	core/NFCore.core.php
* CREATOR:					Alessio Nobile
* CREATING DATA:			02/01/12
* ----------------------------------------------------------------------
* FILE DESCRIPTION:			NFCore class will contain core methods used overall the application
* ----------------------------------------------------------------------
* TRACKING  LOG - LOG YOUR CHANGES ONLY IF YOU ARE DOING IMPORTANT UPDATES ( CHANGE OF METHOD, ADDING/DELETING LINES OF CODE, BUGFIX)
* ----------------------------------------------------------------------
* UPDATE : 
* MODDER: ALESSIO NOBILE / DATE AND HOUR : 02/11/2011 - 12:45
* ----------------------------------------------------------------------
*/

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFCore
 *
 * @desc
 * NFCore class will contain core methods used overall the application
 * 
 */
class NFCore extends NFramework{

	/**
	 * @desc
	 * Define PHP Settings
	 * 
	 */
	public static function DefinePHPSettings(){
		
		// ------------------------------------- | START Define the maximum upload file size
		if( defined( "NF_INSTANCE_UPLOAD_MAXFILESIZE" ) AND ctype_alnum( NF_INSTANCE_UPLOAD_MAXFILESIZE ) ){ ini_set( "upload_max_filesize", NF_INSTANCE_UPLOAD_MAXFILESIZE ); }
		ini_set( "auto_detect_line_endings", TRUE );
		// ------------------------------------- | END
		
	}
	
	/**
	 * @desc
	 * Check if the session has been started
	 * 
	 */
	public static function CheckSession(){
		if( session_status() != PHP_SESSION_ACTIVE ){ throw new Exception( "Netziro Framework session has been not started yet", 2 ); }
	}
	
	/**
	 * @desc
	 * Check if the Netziro Framework has been defined
	 * 
	 */
	public static function CheckInstance(){
		if( !defined( "NF_INSTANCE" ) ){ throw new Exception( "Netziro Framework instance not defined yet", 1 ); }
	}
	
	/**
	 * @desc
	 * Check if the session has been started
	 * 
	 */
	public static function DefineDebugMode(){
		if( defined( "NF_INSTANCE_DEBUG" ) AND NF_INSTANCE_DEBUG ){ error_reporting( E_ALL ); ini_set( "display_errors", 1 ); }
	}
	
	/**
	 * @desc
	 * Defining timezone settings
	 * 
	 */
	public static function DefineTimeZoneSettings(){
	
		// ------------------------------------- | START Fetch settings from get/session
		if( isset( $_GET[ "timezone" ] ) ){ 
			$timezone = $_GET[ "timezone" ];
		} elseif ( isset( $_SESSION[ "timezone" ] ) ) {
			$timezone = $_SESSION[ "timezone" ];
		} else {
			if( defined( "NF_INSTANCE_TIMEZONE_DEFAULT" ) ){ $timezone = NF_INSTANCE_TIMEZONE_DEFAULT; }
		}
		// ------------------------------------- | END
		
		// ------------------------------------- | START Check if the timezone is supported
		$zones = timezone_identifiers_list();
		if( !in_array( $timezone , $zones ) ){ throw new Exception( "Netziro Framework $timezone timezone not supported", 20 ); }
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define Timezone
		define( 'NF_INSTANCE_TIMEZONE', $timezone );
		date_default_timezone_set( NF_INSTANCE_TIMEZONE );
		// ------------------------------------- | END
		
		// ------------------------------------- | START Unset Variables
		unset( $timezone );
		unset( $zones );
		// ------------------------------------- | END
		
	}
	
	/**
	 * @desc
	 * Defining Locale settings format based on RFC 5646
	 * Ex. en-EN
	 * 
	 * language-COUNTRY
	 * 
	 */
	public static function DefineLocaleSettings(){
		
		$locales = array( 'af-ZA',
                    'am-ET',
                    'ar-AE',
                    'ar-BH',
                    'ar-DZ',
                    'ar-EG',
                    'ar-IQ',
                    'ar-JO',
                    'ar-KW',
                    'ar-LB',
                    'ar-LY',
                    'ar-MA',
                    'arn-CL',
                    'ar-OM',
                    'ar-QA',
                    'ar-SA',
                    'ar-SY',
                    'ar-TN',
                    'ar-YE',
                    'as-IN',
                    'az-Cyrl-AZ',
                    'az-Latn-AZ',
                    'ba-RU',
                    'be-BY',
                    'bg-BG',
                    'bn-BD',
                    'bn-IN',
                    'bo-CN',
                    'br-FR',
                    'bs-Cyrl-BA',
                    'bs-Latn-BA',
                    'ca-ES',
                    'co-FR',
                    'cs-CZ',
                    'cy-GB',
                    'da-DK',
                    'de-AT',
                    'de-CH',
                    'de-DE',
                    'de-LI',
                    'de-LU',
                    'dsb-DE',
                    'dv-MV',
                    'el-GR',
                    'en-029',
                    'en-AU',
                    'en-BZ',
                    'en-CA',
                    'en-GB',
                    'en-IE',
                    'en-IN',
                    'en-JM',
                    'en-MY',
                    'en-NZ',
                    'en-PH',
                    'en-SG',
                    'en-TT',
                    'en-US',
                    'en-ZA',
                    'en-ZW',
                    'es-AR',
                    'es-BO',
                    'es-CL',
                    'es-CO',
                    'es-CR',
                    'es-DO',
                    'es-EC',
                    'es-ES',
                    'es-GT',
                    'es-HN',
                    'es-MX',
                    'es-NI',
                    'es-PA',
                    'es-PE',
                    'es-PR',
                    'es-PY',
                    'es-SV',
                    'es-US',
                    'es-UY',
                    'es-VE',
                    'et-EE',
                    'eu-ES',
                    'fa-IR',
                    'fi-FI',
                    'fil-PH',
                    'fo-FO',
                    'fr-BE',
                    'fr-CA',
                    'fr-CH',
                    'fr-FR',
                    'fr-LU',
                    'fr-MC',
                    'fy-NL',
                    'ga-IE',
                    'gd-GB',
                    'gl-ES',
                    'gsw-FR',
                    'gu-IN',
                    'ha-Latn-NG',
                    'he-IL',
                    'hi-IN',
                    'hr-BA',
                    'hr-HR',
                    'hsb-DE',
                    'hu-HU',
                    'hy-AM',
                    'id-ID',
                    'ig-NG',
                    'ii-CN',
                    'is-IS',
                    'it-CH',
                    'it-IT',
                    'iu-Cans-CA',
                    'iu-Latn-CA',
                    'ja-JP',
                    'ka-GE',
                    'kk-KZ',
                    'kl-GL',
                    'km-KH',
                    'kn-IN',
                    'kok-IN',
                    'ko-KR',
                    'ky-KG',
                    'lb-LU',
                    'lo-LA',
                    'lt-LT',
                    'lv-LV',
                    'mi-NZ',
                    'mk-MK',
                    'ml-IN',
                    'mn-MN',
                    'mn-Mong-CN',
                    'moh-CA',
                    'mr-IN',
                    'ms-BN',
                    'ms-MY',
                    'mt-MT',
                    'nb-NO',
                    'ne-NP',
                    'nl-BE',
                    'nl-NL',
                    'nn-NO',
                    'nso-ZA',
                    'oc-FR',
                    'or-IN',
                    'pa-IN',
                    'pl-PL',
                    'prs-AF',
                    'ps-AF',
                    'pt-BR',
                    'pt-PT',
                    'qut-GT',
                    'quz-BO',
                    'quz-EC',
                    'quz-PE',
                    'rm-CH',
                    'ro-RO',
                    'ru-RU',
                    'rw-RW',
                    'sah-RU',
                    'sa-IN',
                    'se-FI',
                    'se-NO',
                    'se-SE',
                    'si-LK',
                    'sk-SK',
                    'sl-SI',
                    'sma-NO',
                    'sma-SE',
                    'smj-NO',
                    'smj-SE',
                    'smn-FI',
                    'sms-FI',
                    'sq-AL',
                    'sr-Cyrl-BA',
                    'sr-Cyrl-CS',
                    'sr-Cyrl-ME',
                    'sr-Cyrl-RS',
                    'sr-Latn-BA',
                    'sr-Latn-CS',
                    'sr-Latn-ME',
                    'sr-Latn-RS',
                    'sv-FI',
                    'sv-SE',
                    'sw-KE',
                    'syr-SY',
                    'ta-IN',
                    'te-IN',
                    'tg-Cyrl-TJ',
                    'th-TH',
                    'tk-TM',
                    'tn-ZA',
                    'tr-TR',
                    'tt-RU',
                    'tzm-Latn-DZ',
                    'ug-CN',
                    'uk-UA',
                    'ur-PK',
                    'uz-Cyrl-UZ',
                    'uz-Latn-UZ',
                    'vi-VN',
                    'wo-SN',
                    'xh-ZA',
                    'yo-NG',
                    'zh-CN',
                    'zh-HK',
                    'zh-MO',
                    'zh-SG',
                    'zh-TW',
                    'zu-ZA');
		
		// ------------------------------------- | START Fetch settings from get/session
		if( isset( $_GET[ "locale" ] ) ){ 
			$locale = $_GET[ "locale" ];
		} elseif ( isset( $_SESSION[ "locale" ] ) ) {
			$locale = $_SESSION[ "locale" ];
		} else {
			if( defined( "NF_INSTANCE_LOCALE_DEFAULT" ) ){ $locale = NF_INSTANCE_LOCALE_DEFAULT; }
		}
		// ------------------------------------- | END
		
		// ------------------------------------- | START If $lang layout isn't correct, we set default locale
		if( strlen( $locale ) != 5 AND substr( $locale, 2, 1 ) != "-" ){ throw new Exception( "Netziro Framework $locale locale format not correct", 10 ); }
		if( !in_array( $locale , $locales ) ){ throw new Exception( "Netziro Framework $locale locale is not supported", 11 ); }
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define locales files
		$locale_file = "includes/locales/$locale.php";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Always include the default template 
		if( file_exists( $locale_file ) ){ require_once( $locale_file ); } else { throw new Exception( "Netziro Framework $locale locale file not found", 12 ); }
		// ------------------------------------- | END
		
		// ------------------------------------- | START Override variables in case you are requesting another locale
		$_SESSION[ "locale" ] = $locale;
		define( 'NF_INSTANCE_LOCALE', $locale );
		define( 'NF_INSTANCE_LANGUAGE', strtoupper( substr( $locale, 0, 2 ) ) );
		// ------------------------------------- | END
		
		// ------------------------------------- | START Unset variables
		unset( $locales );
		unset( $locale );
		unset( $locale_file );
		// ------------------------------------- | END
		
	}
		
	/**
	 * @desc
	 * This function will define application's URL and real path
	 * 
	 */
	public static function DefineApplicationPath(){
		
		// ------------------------------------- | START Fetch instance informations
		$script_filename = $_SERVER[ "SCRIPT_FILENAME" ];
		$script_name = $_SERVER[ "SCRIPT_NAME" ];
		$request_uri = $_SERVER[ "REQUEST_URI" ];
		$server_name = $_SERVER[ "SERVER_NAME" ];
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define Application URL
		$script_name_exploded = explode( "/", $script_name );
		$last_index = count( $script_name_exploded );
		unset( $script_name_exploded[ $last_index -1 ] );
		$relative_directory = implode( "/", $script_name_exploded );
		$application_url = "http://$server_name$relative_directory/";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define Application Real directory
		$script_filename_exploded = explode( "/", $script_filename );
		$last_index = count( $script_filename_exploded );
		unset( $script_filename_exploded[ $last_index -1 ] );
		$real_directory = implode( "/", $script_filename_exploded ) . "/";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define relative path
		$relative_directory = substr( $relative_directory, 1 ) . "/";
		// ------------------------------------- | END
		
		// ------------------------------------- | START Define Constants
		define( "NF_INSTANCE_URL", $application_url );
		define( "NF_INSTANCE_ROOT_DIRECTORY", $real_directory );
		define( "NF_INSTANCE_ROOT_RELATIVE", $relative_directory );
		// ------------------------------------- | END
		
		// ------------------------------------- | START Unset variables
		unset( $application_url );
		unset( $real_directory );
		unset( $relative_directory );
		unset( $script_filename );
		unset( $script_name );
		unset( $request_uri );
		unset( $server_name );
		unset( $script_name_exploded );
		unset( $last_index );
		// ------------------------------------- | END
		
		
	}
	
}