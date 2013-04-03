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
*                 NETZIRO FRAMEWORK - CRYPTO
* ----------------------------------------------------------------------
* SOFTWARE UNDER GPL LICENSE
* AUTHOR Alessio Nobile >> www.netziro.it >> netziro@gmail.com
* ----------------------------------------------------------------------
* CLASS NAME:				NFCrypto
* FILE RELATIVE LOCATION:	core/util/NFCrypto.util.php
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

/**
 * @copyright 	Alessio Nobile <netziro@gmail.com>
 * @author 		Alessio Nobile
 * @package		NFCrypto
 *
 * @desc
 * 
 */

class NFCrypto extends NFramework{
	
	private $key;
	private $auth;
	private $algo = MCRYPT_RIJNDAEL_128;
	private $iv;
	private $session_name;
	private $key_name;
	
	/**
	 * @desc
	 * Static method which will read logs from the given class
	 *  
	 */
	public function __construct(){
		
		// ------------------------------------- | START If constant key is defined then use it
		if( defined( "NF_INSTANCE_CRYPTO_KEY" ) ){ 
			self::SetKey( NF_INSTANCE_CRYPTO_KEY ); 
		} else {
			self::SetKey( self::GenerateRandomKey( ) );
		}
		// ------------------------------------- | END
		
		// ------------------------------------- | START Generate KeyName + IV
		self::SetKeyName( session_name() );
		self::SetIV( mcrypt_get_iv_size( $this->algo, MCRYPT_MODE_CBC ) );
		// ------------------------------------- | END

		// ------------------------------------- | START Saving the keyname on the cookie
		if( empty( $_COOKIE[ $this->key_name ] ) OR strpos( $_COOKIE[ $this->key_name ], ':' ) === false ){
			
			$key_length = mcrypt_get_key_size( $this->algo, MCRYPT_MODE_CBC );
			self::SetKey( self::GenerateRandomKey( $key_length ) );
			self::SetAuth( self::GenerateRandomKey( 32 ) );
			$cookie_param = session_get_cookie_params();
			setcookie(
                $this->key_name,
                base64_encode( $this->key ) . ':' . base64_encode( $this->auth ),
                $cookie_param['lifetime'],
                $cookie_param['path'],
                $cookie_param['domain'],
                $cookie_param['secure'],
                $cookie_param['httponly']
            );
			
		} else {
            list( $this->key, $this->auth ) = explode ( ":", $_COOKIE[ $this->key_name ] );
            $this->key  = base64_decode( $this->key );
            $this->auth = base64_decode( $this->auth );
		}
		// ------------------------------------- | END
		 
		// ------------------------------------- | START Return
		return true;
		// ------------------------------------- | END
		
	}
	
	/**
	 * @desc
	 * Encrypt a given string
	 *  
	 * @param string $string
	 */
	public function Encrypt( $string ){
		
		// ------------------------------------- | START Define IV
		$iv = mcrypt_create_iv( $this->iv, MCRYPT_DEV_URANDOM );
		// ------------------------------------- | END
		
		// ------------------------------------- | START Create encrypted string
        $encrypted = mcrypt_encrypt(
            $this->algo,
            $this->key,
            $string,
            MCRYPT_MODE_CBC,
            $iv
        );
        // ------------------------------------- | END
        
        // ------------------------------------- | START Hashing the encrypted string
        $hmac  = hash_hmac( 'sha256', $iv . $this->algo . $encrypted, $this->auth );
        // ------------------------------------- | END
        
        // ------------------------------------- | START Composing the string in base64
        $string_encrypted = $hmac . ':' . base64_encode( $iv ) . ':' . base64_encode( $encrypted );
        // ------------------------------------- | END
        
        // ------------------------------------- | START Return encrypted string
        return $string_encrypted;  
        // ------------------------------------- | END
		
	}
	
	/**
	 * @desc
	 * Decrypt a given string
	 *  
	 * @param string $string
	 */
	public function Decrypt( $string ){
		
		// ------------------------------------- | START Generate single variables from the array
        list( $hmac, $iv, $encrypted ) = explode( ':', $string );
        // ------------------------------------- | END
        
        // ------------------------------------- | START IV + string decoding
        $iv = base64_decode( $iv );
        $encrypted = base64_decode( $encrypted );
        // ------------------------------------- | END 
        
        // ------------------------------------- | START new hash
        $new_hmac = hash_hmac( 'sha256', $iv . $this->algo . $encrypted, $this->auth );
		if ( $hmac !== $new_hmac ) { return false; }
        // ------------------------------------- | END
        
		// ------------------------------------- | START decrypt the string
  		$decrypt = mcrypt_decrypt(
            $this->algo,
            $this->key,
            $encrypted,
            MCRYPT_MODE_CBC,
            $iv
        );
  		// ------------------------------------- | END
        
  		// ------------------------------------- | START Return decrypted string
  		return rtrim( $decrypt, "\0" ); 
  		// ------------------------------------- | END
		
	}
	
	
	/**
     * Random key generator 
     * fallback to mcrypt_create_iv
     * 
     * @param  int $length
     * 
     * @return string
     */
    private function GenerateRandomKey( $length = 32 ) {
        
    	// ------------------------------------- | START Try to generate a key using SSL
    	if( function_exists( "openssl_random_pseudo_bytes" ) ) {
            $random = openssl_random_pseudo_bytes( $length, $strong );
            if( $strong === true ) { return $random; }    
        }
        
        // ------------------------------------- | START Fallback into mcrypt
        if( defined( MCRYPT_DEV_URANDOM ) ) {
            return mcrypt_create_iv( $length, MCRYPT_DEV_URANDOM );
        } else {
            throw new Exception( "Some errors on the key generator. Please check your OpenSSL + MCRYPT settings" );
        }
        // ------------------------------------- | END
        	
    }
	
	/**
	 * @desc
	 * Set/Get Key method
	 *  
	 */
	public function SetKey( $key ){ if( !empty( $key ) AND ctype_alnum( $key ) ){ $this->key = $key; } }
	public function GetKey( ){ return $this->key; }
	
	/**
	 * @desc
	 * Set/Get Auth method
	 *  
	 */
	public function SetAuth( $auth ){ if( !empty( $auth ) AND ctype_alnum( $auth ) ){ $this->auth = $auth; } }
	public function GetAuth( ){ return $this->auth; }
	
	/**
	 * @desc
	 * Set/Get IV
	 *  
	 */
	public function SetIV( $iv ){ if( !empty( $iv ) AND is_numeric( $iv ) ){ $this->iv = $iv; } }
	public function GetIV( ){ return $this->iv; }
	
	/**
	 * @desc
	 * Set/Get IV
	 *  
	 */
	public function SetKeyName( $session_name ){ 
		if( !empty( $session_name ) AND ctype_alnum( $session_name ) ){
			$this->key_name = "KEY_$session_name";
		} 
	}
	public function GetKeyName( ){ return $this->key_name; }
	
}




