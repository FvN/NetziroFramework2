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
	
	/**
	 * @desc
	 * Get all supported locales
	 * 
	 * @return array 
	 */
	public static function GetLocalesSupported(){
		
		// ------------------------------------- | START Define arrays
		$locales = array();
		$locales_elements = scandir( NF_INSTANCE_ROOT_DIRECTORY . "/includes/locales/" );
		$locales_all = self::GetLocalesAll();
		// ------------------------------------- | END
		
		// ------------------------------------- | START Process the list of directories
		foreach( $locales_elements as $locale ){
			
			if( $locale == "." OR $locale == ".." ){ continue; }
			$locale_tags = explode( ".", $locale );
			if( !empty( $locale_tags[ 0 ] ) AND in_array( $locale_tags[ 0 ], $locales_all ) ){ $locales[ ] = $locale_tags[ 0 ]; }
			
		}
		// ------------------------------------- | END
		
		// ------------------------------------- | START Unset unused variables
		unset( $locales_elements );
		unset( $locale );
		unset( $locale_tags );
		unset( $locales_all );
		// ------------------------------------- | END
		
		// ------------------------------------- | START Return array
		return $locales;
		// ------------------------------------- | END
		
	}
	
	/**
	 * @desc
	 * Get all possible locales
	 * 
	 * @return array 
	 */
	public static function GetLocalesAll(){
		
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
		
		return $locales;
		
	}	
	
	
}




