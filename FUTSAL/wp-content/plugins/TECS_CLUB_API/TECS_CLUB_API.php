<?php
/*
* Plugin Name: TECS_CLUB API
* Plugin URI: http://api.tecs.club/
* Description: TECS_CLUB API
* Version: 0.1
* Text Domain: api.tecs.club
* Domain Path: /languages/
* Author: Lee SangYun
* Author URI: http://api.tecs.club/
* License: PRIVATE
* License URI: NONE
* Slug: TECS_CLUB API
*/

date_default_timezone_set("Asia/Seoul");

set_include_path(get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . '/phpseclib');
// error_log("LSY -> " . get_include_path());

class TECS_CLUB_UTILS {
	
	public static function xml2js($xmlnode) {
	    $root = (func_num_args() > 1 ? false : true);
	    $jsnode = array();

	    if (!$root) {
	        if (count($xmlnode->attributes()) > 0){
	            $jsnode["$"] = array();
	            foreach($xmlnode->attributes() as $key => $value)
	                $jsnode["$"][$key] = (string)$value;
	        }

	        $textcontent = trim((string)$xmlnode);
	        if (count($textcontent) > 0)
	            $jsnode["_"] = $textcontent;

	        foreach ($xmlnode->children() as $childxmlnode) {
	            $childname = $childxmlnode->getName();
	            if (!array_key_exists($childname, $jsnode))
	                $jsnode[$childname] = array();
	            array_push($jsnode[$childname], TECS_CLUB_UTILS::xml2js($childxmlnode, true));
	        }
	        return $jsnode;
	    } else {
	        $nodename = $xmlnode->getName();
	        $jsnode[$nodename] = array();
	        array_push($jsnode[$nodename], TECS_CLUB_UTILS::xml2js($xmlnode, true));
	        return json_encode($jsnode);
	    }
	}   
	
	public static function remove_unicode_escape_sequence($string) {
		return preg_replace_callback(
			'/\\\\u([0-9a-f]{4})/i', 
/*
			create_function(
	             // 여기에서 홑따옴표가 중요합니다. 혹은 모든 $를 \$로 회피해야 합니다.
	             '$matches',
	             'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
	        ),
*/
			function($matches){
    			return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");
			},
	        $string
        );
	}

	public static function startsWith($haystack, $needle) {
	    // search backwards starting from haystack length characters from the end
	    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}
	
	public static function endsWith($haystack, $needle) {
	    // search forward starting from end minus needle length characters
	    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
	}

	public function extract_between_two_substring($string, $start, $end) {
		$result = "";
		$startpos = strpos($string, $start) + strlen($start);
		if (strpos($string, $start) !== false) {
		    $endpos = strpos($string, $end, $startpos);
		    if (strpos($string, $end, $startpos) !== false) {
		        $result = substr($string, $startpos, $endpos - $startpos);
		    }
		}
		return $result;
	}
	
	public static function STRIP_SLASHES_FOR_OBJ($OBJ_PARAMS) {
		$mObjVars = get_object_vars($OBJ_PARAMS);
		foreach($mObjVars as $Key => $Value) {
//			error_log(sprintf("STRIP_SLASHES_FOR_OBJ BEFORE : %s => %s", $Key, remove_unicode_escape_sequence(json_encode($Value, JSON_PRETTY_PRINT))));
			if (is_string($Value)) {
				$OBJ_PARAMS->$Key = stripslashes($Value);
			} else if (is_object($Value)) {
				$OBJ_PARAMS->$Key = STRIP_SLASHES_FOR_OBJ($Value);
			} else if (is_array($Value)) {
				$Value_AS_OBJECT = (object) $Value;
				$OBJ_PARAMS->$Key = STRIP_SLASHES_FOR_OBJ($Value_AS_OBJECT);
			}
//			error_log(sprintf("STRIP_SLASHES_FOR_OBJ AFTER  : %s => %s", $Key, remove_unicode_escape_sequence(json_encode($OBJ_PARAMS->$Key, JSON_PRETTY_PRINT))));
		}
		return $OBJ_PARAMS;
	}

	public static function GET_STR_JSON_TO_JSON($STR_JSON) {
		if (is_object($STR_JSON)) {
//error_log("GET_STR_JSON_TO_JSON : STR_JSON : " . print_r($STR_JSON,true ) . " : is_object");
			$OBJ_RESULT = clone($STR_JSON);
//error_log("GET_STR_JSON_TO_JSON : OBJ_RESULT : " . print_r($OBJ_RESULT,true ));
			$ALL_KEYS = get_object_vars($OBJ_RESULT);
//error_log("GET_STR_JSON_TO_JSON : ALL_KEYS : " . print_r($ALL_KEYS,true ));
			foreach($ALL_KEYS as $ONE_KEY => $ONE_ITEM) {
//error_log(sprintf("GET_STR_JSON_TO_JSON : %s => %s", $ONE_KEY, print_r($ONE_ITEM, true)));
				$OBJ_RESULT->$ONE_KEY = TECS_CLUB_UTILS::GET_STR_JSON_TO_JSON($ONE_ITEM);
			}
			return $OBJ_RESULT;
		} else if (is_array($STR_JSON)) {
//error_log("GET_STR_JSON_TO_JSON : STR_JSON : " . print_r($STR_JSON,true ) . " : is_array");
			$ARR_RESULT = array();
			foreach($STR_JSON as $ONE_ITEM) {
				array_push($ARR_RESULT, TECS_CLUB_UTILS::GET_STR_JSON_TO_JSON($ONE_ITEM));
			}
			return $ARR_RESULT;
		} else if (is_string($STR_JSON)) {
//error_log("GET_STR_JSON_TO_JSON : STR_JSON : " . print_r($STR_JSON,true ) . " : is_string");
			$TEMP_OBJECT = json_decode(stripslashes($STR_JSON));
			if (is_object($TEMP_OBJECT)) {
				return TECS_CLUB_UTILS::GET_STR_JSON_TO_JSON($TEMP_OBJECT);
			} else if (is_array($TEMP_OBJECT)) {
				return TECS_CLUB_UTILS::GET_STR_JSON_TO_JSON($TEMP_OBJECT);
			} else {
				return $STR_JSON;
			}
		} else {
			return $STR_JSON;
		}
	}
	
}

/*
function TECS_CLUB_API_POST_FILTER($STR_POST_CONTENT) {
	require_once 'MyCrypt.php';
	$oMyCrypt = new MyCrypt();
	$content = $STR_POST_CONTENT;
	$content_decoded = json_decode($oMyCrypt->decrypt($content));
	if (is_object($content_decoded)) {
		$content = json_encode($content_decoded, JSON_PRETTY_PRINT);
	}
  	return $content;
}
add_filter( 'MyDecrypt', 'TECS_CLUB_API_POST_FILTER' );

function TECS_CLUB_API_CONTENT_FILTER() {
	require_once 'MyCrypt.php';
	$oMyCrypt = new MyCrypt();
	$content = get_the_content( null, true );
// error_log(print_r($content, true));
	$content_decoded = json_decode($oMyCrypt->decrypt($content));
	if (is_object($content_decoded)) {
		$content = json_encode($content_decoded, JSON_PRETTY_PRINT);
	}
  	return $content;
}
add_filter( 'the_content', 'TECS_CLUB_API_CONTENT_FILTER' );

function TECS_CLUB_API_EDITOR_FILTER($STR_EDITOR_CONTENT) {
	require_once 'MyCrypt.php';
	$oMyCrypt = new MyCrypt();
	$content = $STR_EDITOR_CONTENT;
	$content_decoded = json_decode($oMyCrypt->decrypt($content));
	if (is_object($content_decoded)) {
//		$content = '<xmp>' . json_encode($content_decoded, JSON_PRETTY_PRINT) . '</xmp>';
		$content = TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($content_decoded, JSON_PRETTY_PRINT));
	}
  	return $content;
}
add_filter( 'the_editor_content', 'TECS_CLUB_API_EDITOR_FILTER' );


function TECS_CLUB_API_COMMENT_FILTER($comment_data) {
	require_once 'MyCrypt.php';
	$oMyCrypt = new MyCrypt();
	$comment_decoded = json_decode($oMyCrypt->decrypt($comment_data));
//	error_log("LSY => " . print_r($comment_decoded, true));
	if (is_object($comment_decoded)) {
		$comment_data = '<xmp>' . TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($comment_decoded, JSON_PRETTY_PRINT)) . '</xmp>';
	}
//	error_log($comment_data);
  	return $comment_data;
}
// remove_filter( 'comment_text', 'wpautobr' );
add_filter( 'comment_text', 'TECS_CLUB_API_COMMENT_FILTER' );

//*/

function TECS_CLUB_API() {
	$STR_RAW_POST = file_get_contents("php://input");
// error_log('STR_RAW_POST : ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence(print_r($STR_RAW_POST, TRUE)));
//	$args = json_decode(stripslashes($STR_RAW_POST));
	$args = json_decode($STR_RAW_POST);
	if (!is_object($args)) {
//error_log("!is_object() => " . print_r($_REQUEST, true));
		$args = json_decode(json_encode($_REQUEST), FALSE);
	}

	if (isset($args->JSON)) $args = json_decode(stripslashes($args->JSON));
	if (is_array($args)) $args = (object) $args;

	if (isset($args->CATEGORY)) {
		if (!isset($args->SVC_CATEGORY)) {
			$args->SVC_CATEGORY = $args->CATEGORY;
		}
	}

	$args = TECS_CLUB_UTILS::GET_STR_JSON_TO_JSON($args);

	
	if (strlen($STR_RAW_POST) > 0) {
		$XML = simplexml_load_string( $STR_RAW_POST );
		if (is_object($XML)) {
			$args->STR_XML = $STR_RAW_POST;
			$args->XML = json_encode($XML);
		}
	}

//	$args->_SERVER	= $_SERVER;
//	$args->_FILES	= $_FILES;
	$args->REMOTE_ADDR	= $_SERVER['REMOTE_ADDR'];
	if (isset($_SERVER['HTTP_USER_AGENT']))
		$args->HTTP_USER_AGENT	= $_SERVER['HTTP_USER_AGENT'];
	
	

if (isset($args->STR_BASE64_JSON)) {
	error_log('ARGS STR_BASE64_JSON => ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence(base64_decode ($args->STR_BASE64_JSON)));
} else 	if (count($_FILES) > 0)	{
		$args->ATTACH = $_FILES;
		error_log('ARGS WITH ATTACH => ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($args, JSON_PRETTY_PRINT)));
} else {
	error_log('ARGS => ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($args, JSON_PRETTY_PRINT)));
}


// error_log(TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($args, JSON_PRETTY_PRINT)));

	if (isset($args->REQ)) {
		$cmd_explode = explode("_", $args->REQ);
		if ($cmd_explode[0] != '') {
			$ext_func_php = dirname( __FILE__ ) . "/ext.class." . $cmd_explode[0] . ".php";
			if (file_exists($ext_func_php)) {
				require_once $ext_func_php;
		
				if ($cmd_explode[0] == 'dummy') {
				} else if ($cmd_explode[0] == 'api') {
					$m_ext_class = new ext_class_api();  $m_ext_class->DO_JOB($args);
				} else if ($cmd_explode[0] == 'post') {
					$m_ext_class = new ext_class_post(); $m_ext_class->DO_JOB($args);
				}
				exit();
			}
		}
	}
}
add_action( 'init', 'TECS_CLUB_API' );

?>

