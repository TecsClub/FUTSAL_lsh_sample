<?php

class MyCrypt {

//    private $iv  = '0123456789ABCDEF'; #Same as in JAVA
    private $iv  = '2360236023602360'; #Same as in JAVA
    private $key = '2360236023602360'; #Same as in JAVA

    function __construct() {

    }

    function encrypt($str, $argKey = null) {
//      return base64_encode($str);
    	return $str;
    }
    
    function encrypt_ORG($str, $argKey = null) {
        $iv = $this->iv;

        $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
		$argKey = $argKey != null ? $argKey : $this->key;
        mcrypt_generic_init($td, $argKey, $iv);
        $str = $this->padString(base64_encode($str));
        $encrypted = mcrypt_generic($td, $str);

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        
//		$decrypted = $this->decrypt(base64_encode($encrypted), $argKey);
//		error_log("DECRYPTED : BEFORE : " . print_r($decrypted, true));

        return base64_encode($encrypted);
//      return str_replace("+","_",base64_encode($encrypted));
    }
    
    function decrypt($code, $argKey = null) {
//        return base64_decode($code);
        return $code;
    }

    function decrypt_ORG($code, $argKey = null) {
//    	if (strlen($code) < 1) return $code;
//      $code = $code != '' ? base64_decode(str_replace("_","+",$code)) : 'DUMMY';
        $code = $code != '' ? base64_decode($code) : 'DUMMY';
        $iv = $this->iv;

        $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
		$argKey = $argKey != null ? $argKey : $this->key;
        mcrypt_generic_init($td, $argKey, $iv);
        $decrypted = base64_decode(mdecrypt_generic($td, $code));

        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);

        return trim($decrypted);
    }

    protected function hex2bin($hexdata) {
        $bindata = '';

        for ($i = 0; $i < strlen($hexdata); $i += 2) {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }

        return $bindata;
    }

    private function padString($source) {
        $paddingChar = ' ';
        $size = 16;
        $x = strlen($source) % $size;
        $padLength = $size - $x;

        for ($i = 0; $i < $padLength; $i++) {
            $source .= $paddingChar;
        }

        return $source;
    }

}
    
?>

