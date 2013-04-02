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

	public static $database_links = array();
	public static $database_links_counter = 0;
	
	/**
	 * @desc
	 * Load Database links
	 * 
	 */
	public static function LoadDatabaseLinks(){
		
		global $credentials;
		
		if( is_array( $credentials ) ){
				
			foreach( $credentials as $profile_name => $credential ){
				
				if( empty( $profile_name ) ){ $profile_name = self::$database_links_counter; }
				self::$database_links[ $profile_name ] = new NFDatabase( $credential );
				self::$database_links[ $profile_name ]->OpenLink();
				self::$database_links_counter++;
				
			}
			
		} else { throw new Exception( "Database credentials array has been not instanciated yet. Check your NFConfig file", 1000 ); } 
		
	}
	
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
	public static function DefineDebugSettings(){
		
		// ------------------------------------- | START Check if debug mode is on
		if( defined( "NF_INSTANCE_DEBUG" ) AND NF_INSTANCE_DEBUG ){ error_reporting( E_ALL ); ini_set( "display_errors", 1 ); }
		// ------------------------------------- | END
		
		// ------------------------------------- | START Check if backtrace needs to be printed out at the end of the execution
		if( defined( "NF_INSTANCE_LOG_BACKTRACE" ) AND NF_INSTANCE_LOG_BACKTRACE ){
			register_shutdown_function( array( "NFLogger", "BackTracePrint" ) );
		}
		// ------------------------------------- | END
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
	 * language_COUNTRY
	 * 
	 */
	public static function DefineLocaleSettings(){
		
		$locales = array( 'af_ZA',
                    'am_ET',
                    'ar_AE',
                    'ar_BH',
                    'ar_DZ',
                    'ar_EG',
                    'ar_IQ',
                    'ar_JO',
                    'ar_KW',
                    'ar_LB',
                    'ar_LY',
                    'ar_MA',
                    'arn_CL',
                    'ar_OM',
                    'ar_QA',
                    'ar_SA',
                    'ar_SY',
                    'ar_TN',
                    'ar_YE',
                    'as_IN',
                    'az_Cyrl_AZ',
                    'az_Latn_AZ',
                    'ba_RU',
                    'be_BY',
                    'bg_BG',
                    'bn_BD',
                    'bn_IN',
                    'bo_CN',
                    'br_FR',
                    'bs_Cyrl_BA',
                    'bs_Latn_BA',
                    'ca_ES',
                    'co_FR',
                    'cs_CZ',
                    'cy_GB',
                    'da_DK',
                    'de_AT',
                    'de_CH',
                    'de_DE',
                    'de_LI',
                    'de_LU',
                    'dsb_DE',
                    'dv_MV',
                    'el_GR',
                    'en_029',
                    'en_AU',
                    'en_BZ',
                    'en_CA',
                    'en_GB',
                    'en_IE',
                    'en_IN',
                    'en_JM',
                    'en_MY',
                    'en_NZ',
                    'en_PH',
                    'en_SG',
                    'en_TT',
                    'en_US',
                    'en_ZA',
                    'en_ZW',
                    'es_AR',
                    'es_BO',
                    'es_CL',
                    'es_CO',
                    'es_CR',
                    'es_DO',
                    'es_EC',
                    'es_ES',
                    'es_GT',
                    'es_HN',
                    'es_MX',
                    'es_NI',
                    'es_PA',
                    'es_PE',
                    'es_PR',
                    'es_PY',
                    'es_SV',
                    'es_US',
                    'es_UY',
                    'es_VE',
                    'et_EE',
                    'eu_ES',
                    'fa_IR',
                    'fi_FI',
                    'fil_PH',
                    'fo_FO',
                    'fr_BE',
                    'fr_CA',
                    'fr_CH',
                    'fr_FR',
                    'fr_LU',
                    'fr_MC',
                    'fy_NL',
                    'ga_IE',
                    'gd_GB',
                    'gl_ES',
                    'gsw_FR',
                    'gu_IN',
                    'ha_Latn_NG',
                    'he_IL',
                    'hi_IN',
                    'hr_BA',
                    'hr_HR',
                    'hsb_DE',
                    'hu_HU',
                    'hy_AM',
                    'id_ID',
                    'ig_NG',
                    'ii_CN',
                    'is_IS',
                    'it_CH',
                    'it_IT',
                    'iu_Cans_CA',
                    'iu_Latn_CA',
                    'ja_JP',
                    'ka_GE',
                    'kk_KZ',
                    'kl_GL',
                    'km_KH',
                    'kn_IN',
                    'kok_IN',
                    'ko_KR',
                    'ky_KG',
                    'lb_LU',
                    'lo_LA',
                    'lt_LT',
                    'lv_LV',
                    'mi_NZ',
                    'mk_MK',
                    'ml_IN',
                    'mn_MN',
                    'mn_Mong_CN',
                    'moh_CA',
                    'mr_IN',
                    'ms_BN',
                    'ms_MY',
                    'mt_MT',
                    'nb_NO',
                    'ne_NP',
                    'nl_BE',
                    'nl_NL',
                    'nn_NO',
                    'nso_ZA',
                    'oc_FR',
                    'or_IN',
                    'pa_IN',
                    'pl_PL',
                    'prs_AF',
                    'ps_AF',
                    'pt_BR',
                    'pt_PT',
                    'qut_GT',
                    'quz_BO',
                    'quz_EC',
                    'quz_PE',
                    'rm_CH',
                    'ro_RO',
                    'ru_RU',
                    'rw_RW',
                    'sah_RU',
                    'sa_IN',
                    'se_FI',
                    'se_NO',
                    'se_SE',
                    'si_LK',
                    'sk_SK',
                    'sl_SI',
                    'sma_NO',
                    'sma_SE',
                    'smj_NO',
                    'smj_SE',
                    'smn_FI',
                    'sms_FI',
                    'sq_AL',
                    'sr_Cyrl_BA',
                    'sr_Cyrl_CS',
                    'sr_Cyrl_ME',
                    'sr_Cyrl_RS',
                    'sr_Latn_BA',
                    'sr_Latn_CS',
                    'sr_Latn_ME',
                    'sr_Latn_RS',
                    'sv_FI',
                    'sv_SE',
                    'sw_KE',
                    'syr_SY',
                    'ta_IN',
                    'te_IN',
                    'tg_Cyrl_TJ',
                    'th_TH',
                    'tk_TM',
                    'tn_ZA',
                    'tr_TR',
                    'tt_RU',
                    'tzm_Latn_DZ',
                    'ug_CN',
                    'uk_UA',
                    'ur_PK',
                    'uz_Cyrl_UZ',
                    'uz_Latn_UZ',
                    'vi_VN',
                    'wo_SN',
                    'xh_ZA',
                    'yo_NG',
                    'zh_CN',
                    'zh_HK',
                    'zh_MO',
                    'zh_SG',
                    'zh_TW',
                    'zu_ZA');
		
		// ------------------------------------- | START Fetch settings from get/session
		if( isset( $_GET[ "locale" ] ) ){ 
			$locale = $_GET[ "locale" ];
		} elseif ( isset( $_SESSION[ "locale" ] ) ) {
			$locale = $_SESSION[ "locale" ];
		} else {
			$locale = NFIntl::LocaleHttpHeader();
			if( empty( $locale ) ){
				if( defined( "NF_INSTANCE_LOCALE_DEFAULT" ) ){ $locale = NF_INSTANCE_LOCALE_DEFAULT; }	
			}
		}
		// ------------------------------------- | END
		
		// ------------------------------------- | START If $lang layout isn't correct, we set default locale
		if( strlen( $locale ) != 5 AND substr( $locale, 2, 1 ) != "_" ){ throw new Exception( "Netziro Framework $locale locale format not correct", 10 ); }
		if( !in_array( $locale , $locales ) ){ throw new Exception( "Netziro Framework $locale locale is not supported", 11 ); }
		// ------------------------------------- | END
		
		// ------------------------------------- | START Set locale for the instance
		NFIntl::SetLocale( $locale );
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
	
	/**
	 * @desc
	 * This function will print out an array having <pre>$array</pre>
	 * 
	 */
	public static function PrintPre( $array ){
			
		echo "<pre>";
			print_r( $array );
		echo "</pre>";
			
	}
	
}