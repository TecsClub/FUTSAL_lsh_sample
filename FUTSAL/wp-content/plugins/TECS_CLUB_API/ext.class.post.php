<?php

class ext_class_post {
	
	var $o_POST_UTIL = NULL;
	
    public function DO_JOB($argsPARAM) {
    	$args = clone $argsPARAM;
//    	if (!isset($args->PHONE_NO))			return;
//    	if (!isset($args->PHONE_ID))			return;
	  	if (!isset($args->SVC_CATEGORY))		return;
//    	if ($args->PHONE_NO == 'NOT_GRANTED')	return;
    	
		$PHP_POST_UTIL = dirname( __FILE__ ) . "/POST_UTIL.php";
		if (file_exists($PHP_POST_UTIL)) {
			require_once $PHP_POST_UTIL;
			$this->o_POST_UTIL = new POST_UTIL();
		}
    	
		if ($args->REQ == "DUMMY") {
		} else if ($args->REQ == "post_GET_ROOT_INFO") {
			$this->post_GET_ROOT_INFO($args);
		} else if ($args->REQ == "post_PUT_ROOT_INFO") {
			$this->post_PUT_ROOT_INFO($args);
		} else if ($args->REQ == "post_UPDATE_ROOT_INFO") {
			$this->post_PUT_ROOT_INFO($args);
		} else if ($args->REQ == "post_GET_ALL_ROOT_ATTRIBUTE") {
			$this->post_GET_ALL_ROOT_ATTRIBUTE($args);
		} else if ($args->REQ == "post_LOG") {
			$this->post_LOG($args);
		} else if ($args->REQ == "post_GET_LOG_LIST") {
			$this->post_GET_LOG_LIST($args);
		} else if ($args->REQ == "post_FilterContacts") {
			$this->post_FilterContacts($args);
		} else if ($args->REQ == "post_FIND_ALL_GCM_REGIST_ID_AND_SEND_GCM_MESSAGE") {
			$this->post_FIND_ALL_GCM_REGIST_ID_AND_SEND_GCM_MESSAGE($args);
		}
    }


    function post_GET_ROOT_INFO($args) {
		header("Content-Type: text/html; charset=UTF-8");
    	echo $this->o_POST_UTIL->GET_POST_ROOT($args);
    }

    function post_PUT_ROOT_INFO($args) {
		if (isset($args->BASE64_STR_JSON_UPDATE)) {
	    	$args->OBJ_UPDATE = json_decode(base64_decode($args->BASE64_STR_JSON_UPDATE));
	    	unset($args->OBJ_UPDATE->BASE64);
		} else if (isset($args->STR_JSON_UPDATE)) {
			if (is_string($args->STR_JSON_UPDATE)) {
		    	$args->OBJ_UPDATE = json_decode(stripslashes($args->STR_JSON_UPDATE));
			} else {
		    	$args->OBJ_UPDATE = $args->STR_JSON_UPDATE;
			}
		} else if (isset($args->JSON_UPDATE)) {
	    	$args->OBJ_UPDATE = $args->JSON_UPDATE;
		} else {
			return;
		}
		header("Content-Type: text/html; charset=UTF-8");
    	echo $this->o_POST_UTIL->UPDATE_POST_ROOT($args);
    }

    function post_GET_ALL_ROOT_ATTRIBUTE($args) {
		header("Content-Type: text/html; charset=UTF-8");
    	echo $this->o_POST_UTIL->GET_ALL_ROOT_ATTRIBUTE($args);
    }

	function GET_LOG_OBJECT($args) {
		$result = clone $args;
		unset($result->APP_VERSION);
		unset($result->PHONE_ID);
		unset($result->PHONE_NO);
		unset($result->SVC_CATEGORY);
		unset($result->JSON_LOG_BASE64);
		return $result;
	}

    function post_LOG($args) {
    	$args->OBJ_LEAF		= $this->GET_LOG_OBJECT($args);
		$args->OBJ_UPDATE	= new stdClass();
		$this->o_POST_UTIL->UPDATE_POST_ROOT($args);
		header("Content-Type: text/html; charset=UTF-8");    	
		echo json_encode($args->OBJ_LEAF);
    }
    
    function post_GET_LOG_LIST($args) {
		header("Content-Type: text/html; charset=UTF-8");
    	echo $this->o_POST_UTIL->GET_LOG_LIST($args);
    }

    function post_FilterContacts($args) {
		header("Content-Type: text/html; charset=UTF-8");
    	echo $this->o_POST_UTIL->FILTER_CONTACTS($args);
    }

    function post_FIND_ALL_GCM_REGIST_ID_AND_SEND_GCM_MESSAGE($args) {
		header("Content-Type: text/html; charset=UTF-8");
    	echo $this->o_POST_UTIL->FIND_ALL_GCM_REGIST_ID_AND_SEND_GCM_MESSAGE($args);
    }
    
}
    
?>

