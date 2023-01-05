<?php

class ext_class_api {
    public function DO_JOB($argsPARAM) {
    	$args = clone $argsPARAM;
		if ($args->REQ == "api_ECHO") {
			$this->api_ECHO($args);
		} else if ($args->REQ == "api_GreenLine") {
			$this->api_GreenLine($args);
		} else if ($args->REQ == "api_CISCO") {
			$this->api_CISCO($args);
		} else if ($args->REQ == "api_TTS_VW") {
			$this->api_TTS_VW($args);
		} else if ($args->REQ == "api_HTTP_ACCESS") {
			$this->api_HTTP_ACCESS($args);
		} else if ($args->REQ == "api_HTTP_DOWNLOAD") {
			$this->api_URL_DOWNLOAD($args);
		} else if ($args->REQ == "api_URL_DOWNLOAD") {
			$this->api_URL_DOWNLOAD($args);
		} else if ($args->REQ == "api_GET_WP_ROOT") {
			$this->api_GET_WP_ROOT($args);
		} else if ($args->REQ == "api_WP_ACCESS") {
			$this->api_WP_ACCESS($args);
		} else if ($args->REQ == "api_WP_USER_ADD") {
			$this->api_WP_USER_ADD($args);
		} else if ($args->REQ == "api_WP_USER_DEL") {
			$this->api_WP_USER_DEL($args);
		} else if ($args->REQ == "api_WP_ENCODE") {
			$this->api_WP_ENCODE($args);
		} else if ($args->REQ == "api_WP_AUTHENTICATE") {
			$this->api_WP_AUTHENTICATE($args);
		} else if ($args->REQ == "api_WP_CHPWD") {
			$this->api_WP_CHPWD($args);
		} else if ($args->REQ == "api_DB_ACCESS") {
			$this->api_DB_ACCESS($args);
		} else if ($args->REQ == "api_API_ACCESS") {
			$this->api_API_ACCESS($args);
		} else if ($args->REQ == "api_APIS_ACCESS") {
			$this->api_APIS_ACCESS($args);
		} else if ($args->REQ == "api_YOUTUBE_SEARCH") {
			require_once 'youtube_search.php';
			$this->api_YOUTUBE_SEARCH($args);
		} else if ($args->REQ == "api_YOUTUBE_MP3") {
			require_once 'youtube_search.php';
			$this->api_YOUTUBE_MP3($args);
		} else if ($args->REQ == "api_SIMILARITY") {
			$this->api_SIMILARITY($args);
		} else if ($args->REQ == "api_GET_TTS_WAV_VOICEWARE") {
			$this->api_GET_TTS_WAV_VOICEWARE($args);
		} else if ($args->REQ == "api_GET_PAGE") {
			$this->api_GET_PAGE($args);
		} else if ($args->REQ == "api_GET_FILE") {
			$this->api_GET_FILE($args);
		} else if ($args->REQ == "api_PUT_FILE") {
			$this->api_PUT_FILE($args);
		} else if ($args->REQ == "api_EXEC") {
			$this->api_EXEC($args);
		} else if ($args->REQ == "api_SEND_EMAIL") {
			$this->api_SEND_EMAIL($args);
		} else if ($args->REQ == "api_LOGIN") {
			$this->api_LOGIN($args);
		} else if ($args->REQ == "api_GET_WORK_CONDITION") {
			$this->api_GET_WORK_CONDITION($args);
		} else if ($args->REQ == "api_POST_LOG_STRING") {
			$this->api_POST_LOG_STRING($args);
		} else if ($args->REQ == "api_GET_CALL_GROUP_NUMBERS") {
			$this->api_GET_CALL_GROUP_NUMBERS($args);
		} else if ($args->REQ == "api_get_daum_keywords") {
			require_once 'simple_html_dom.php';
			$this->api_get_daum_keywords($args);
		} else if ($args->REQ == "api_srch_images") {
			require_once 'simple_html_dom.php';
			$this->api_srch_images($args);
		} else if ($args->REQ == "api_SET_LED_LAMP") {
			$this->api_SET_LED_LAMP($args);
		}
    }

	public function JSON_NULL_2_BLANK($JSON_ARGS) {
		$KEY_ARRAY = get_object_vars($JSON_ARGS);
		foreach($KEY_ARRAY as $KEY => $VAL) {
			if ($VAL == NULL) {
				$JSON_ARGS->$KEY = '';
			}
		}
		return $JSON_ARGS;
	}
	
	public function IS_VALID_JSON($string) {
	   json_decode($string);
	   return json_last_error() === JSON_ERROR_NONE;
	}

	public function UDP_COMMUNICATION($HOST, $PORT, $PARAMS, $BASE64_SPLIT = false, $SEND_ONLY = false) {

		$UDP_RESULT = new stdClass();
		$UDP_RESULT->HISTORY = array();
		$FLAG_ERROR = false;
		if(!($UDP_SOCK = socket_create(AF_INET, SOCK_DGRAM, 0))) {
			array_push(
				$UDP_RESULT->HISTORY, 
				sprintf("ERROR ON UDP_SOCKET socket_create()")
			);
			$UDP_RESULT->ERROR_CODE = socket_last_error();
			$UDP_RESULT->ERROR_MSG = socket_strerror($UDP_RESULT->ERROR_CODE);
			$FLAG_ERROR = true;
		}
		if (!$FLAG_ERROR) {
			if(!socket_set_option($UDP_SOCK,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>5, "usec"=>0))) {
				array_push(
					$UDP_RESULT->HISTORY, 
					sprintf("ERROR ON UDP_SOCKET socket_set_option()")
				);
				$UDP_RESULT->ERROR_CODE = socket_last_error();
				$UDP_RESULT->ERROR_MSG = socket_strerror($UDP_RESULT->ERROR_CODE);
				$FLAG_ERROR = true;
			}
		}
		if (!$FLAG_ERROR) {
			array_push(
				$UDP_RESULT->HISTORY, 
				sprintf("UDP_SOCKET CREATED FOR %s:%d", $HOST, $PORT)
			);
		}

//		error_log(sprintf("UDP_COMMUNICATION : STEP_1 : %s", TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($UDP_RESULT))));

		//Communication step
	    //Send the message to the server
		if (!$FLAG_ERROR) {
			if ($this->IS_VALID_JSON($PARAMS)) {
				$STR_MESSAGE_SEND = TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($this->JSON_NULL_2_BLANK($PARAMS)));
			} else {
				$STR_MESSAGE_SEND = $PARAMS;
			}
			
			if ($BASE64_SPLIT) {
				$STR_MESSAGE_SEND_BASE64 = base64_encode($STR_MESSAGE_SEND);
				$ARRAY_MESSAGE = str_split($STR_MESSAGE_SEND_BASE64, 1024);
			    foreach($ARRAY_MESSAGE as $INDEX => $ONE_MESSAGE) {
			    	if (($INDEX) < count($ARRAY_MESSAGE) -1) {
				    	$MSG_FOR_SEND = sprintf("%s", $ONE_MESSAGE);
			    	} else {
				    	$MSG_FOR_SEND = sprintf("%s%c", $ONE_MESSAGE, 0x00);
			    	}
				    $MESSAGE_LENGTH = strlen($MSG_FOR_SEND);
				    if( ! socket_sendto($UDP_SOCK, $MSG_FOR_SEND, $MESSAGE_LENGTH, 0, $HOST , $PORT)) {
						array_push(
							$UDP_RESULT->HISTORY, 
							sprintf("ERROR ON UDP_SOCKET socket_sendto()")
						);
						$UDP_RESULT->ERROR_CODE = socket_last_error();
						$UDP_RESULT->ERROR_MSG = socket_strerror($UDP_RESULT->ERROR_CODE);
						$FLAG_ERROR = true;
						break;
				    }
			    }
			} else {
			    if( ! socket_sendto($UDP_SOCK, $STR_MESSAGE_SEND , strlen($STR_MESSAGE_SEND) , 0 , $HOST , $PORT)) {
					array_push(
						$UDP_RESULT->HISTORY, 
						sprintf("ERROR ON UDP_SOCKET socket_sendto()")
					);
					$UDP_RESULT->ERROR_CODE = socket_last_error();
					$UDP_RESULT->ERROR_MSG = socket_strerror($UDP_RESULT->ERROR_CODE);
					$FLAG_ERROR = true;
			    }
			}
		}

//		error_log(sprintf("UDP_COMMUNICATION : STEP_2 : %s", TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($UDP_RESULT))));
	         
		$STR_MESSAGE_REPLY = "";
	    //Now receive reply from server and print it
		if (!$FLAG_ERROR) {
			if (!$SEND_ONLY) {
			    if(socket_recv ( $UDP_SOCK , $STR_MESSAGE_REPLY , 65536 , MSG_WAITALL) === FALSE) {
					array_push(
						$UDP_RESULT->HISTORY, 
						sprintf("ERROR ON UDP_SOCKET socket_recv()")
					);
					$UDP_RESULT->ERROR_CODE = socket_last_error();
					$UDP_RESULT->ERROR_MSG = socket_strerror($UDP_RESULT->ERROR_CODE);
					$FLAG_ERROR = true;
			    }
			    socket_close($UDP_SOCK);
			}
		}

//		error_log(sprintf("UDP_COMMUNICATION : STEP_3 : %s", TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($UDP_RESULT))));
		
		$JSON_RESULT = json_decode($STR_MESSAGE_REPLY);
		if (is_object($JSON_RESULT)) {
			$JSON_RESULT->UDP_RESULT = $UDP_RESULT;
		} else {
			$JSON_RESULT = new \stdClass();
			$JSON_RESULT->STR_MESSAGE_REPLY = $STR_MESSAGE_REPLY;
			$JSON_RESULT->UDP_RESULT = $UDP_RESULT;
		}

//		error_log(sprintf("UDP_COMMUNICATION : STEP_4 : %s", TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($JSON_RESULT))));

		return $JSON_RESULT;
	}
	
	public function SEND_IP_SMS($argsPARAM) {
		$args = clone $argsPARAM;
		
		if (isset($args->SMS_FROM) && isset($args->SMS_TO) && isset($args->SMS_TEXT)) {

			$MESSAGE_ID = sprintf('%s%s', $args->SMS_FROM, date('YmdHis'));
			
			$STR_UDP_PACKET  = sprintf('|type:outbound');
			$STR_UDP_PACKET .= sprintf('|messageid:%s', $MESSAGE_ID);
			$STR_UDP_PACKET .= sprintf('|userid:%s', $args->SMS_FROM);
			$STR_UDP_PACKET .= sprintf('|priority:1');
			
			$STR_SMS_TEXT_EUCKR = iconv('UTF-8', 'EUC-KR', $args->SMS_TEXT);
			
			$STR_UDP_PACKET .= sprintf('|context:%s', base64_encode($STR_SMS_TEXT_EUCKR));

			if (is_array($args->SMS_TO)) {
				$STR_LIST_SMS_TO = '';
				foreach($args->SMS_TO as $ONE_SMS_TO) {
					$STR_LIST_SMS_TO .= $ONE_SMS_TO . ' ';
				}
				$STR_UDP_PACKET .= sprintf('|phonenum:%s', $STR_LIST_SMS_TO);
			} else {
				$STR_UDP_PACKET .= sprintf('|phonenum:%s', $args->SMS_TO);
			}
			$STR_UDP_PACKET .= sprintf('|');

			error_log('SEND_IP_SMS : ' . $STR_UDP_PACKET);
			
			$this->UDP_COMMUNICATION('127.0.0.1', 6071, $STR_UDP_PACKET, false, true);

		} else {
			
		}
	}

	public function GET_ECHO_STRING($argsPARAM) {
		$args = clone $argsPARAM;
		$args->HANGUL = "동해물과 백두산이...";
		$args->HANGUL .= "동해물과 백두산이...";
		$args->HANGUL .= "동해물과 백두산이...";
		$args->HANGUL .= "동해물과 백두산이...";
		$args->HANGUL .= "동해물과 백두산이...";
		$args->HANGUL .= "동해물과 백두산이...";
		return TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($args, JSON_PRETTY_PRINT));
	}

    function CREATE_TABLES_FOR_LED_INFO() {
		global $wpdb;
		$WP_TABLE = "LED_INFO";
		$TABLE_NAME			= $wpdb->prefix . $WP_TABLE;
		if (!$this->IS_TABLE_EXIST($WP_TABLE)) {
			$CHARSET_COLLATE	= $wpdb->get_charset_collate();

			$query = "
				CREATE TABLE $TABLE_NAME (
					SET_LED_ID			VARCHAR(64) NOT NULL,
					PRIMARY KEY 		(SET_LED_ID),
					SET_DATE			VARCHAR(8),
					SET_TIME			VARCHAR(8),
					SET_ADDR			VARCHAR(256),
					SET_PLACE_COMMENT	VARCHAR(256),
					SET_LNG				VARCHAR(32),
					SET_LAT				VARCHAR(32),
					SET_LED_PHOTO_URL	TEXT,
					SET_LED_SETTINGS	INT(8) UNSIGNED
				) $CHARSET_COLLATE;
			";
			$result = $wpdb->get_results($query);
			error_log("CREATE_TABLES_FOR_LED_INFO : $WP_TABLE : " . print_r($result,true) );
		}
	}

	function api_SET_LED_LAMP($args) {
		$this->CREATE_TABLES_FOR_LED_INFO();

		$ERROR_STATE = false;
		$args->STATUS = 400;
		$args->STATUS_HELP = 'INVALID PARAMETERS';
		if (!$ERROR_STATE && !isset($args->SET_LED_ID)) {
			$args->STATUS_HELP = 'NO [SET_LED_ID] PARAMETER';
			$ERROR_STATE = true;
		}
		if (!$ERROR_STATE && !isset($args->SET_ADDR)) {
			$args->STATUS_HELP = 'NO [SET_ADDR] PARAMETER';
			$ERROR_STATE = true;
		}
		if (!$ERROR_STATE && !isset($args->SET_PLACE_COMMENT)) {
			$args->STATUS_HELP = 'NO [SET_PLACE_COMMENT] PARAMETER';
			$ERROR_STATE = true;
		}
		if (!$ERROR_STATE && !isset($args->SET_GPS)) {
			$args->STATUS_HELP = 'NO [SET_GPS] PARAMETER';
			$ERROR_STATE = true;
		}
		if (!$ERROR_STATE && !isset($args->ATTACH)) {
			$args->STATUS_HELP = 'NO [ATTACH] PARAMETER';
			$ERROR_STATE = true;
		}
		
		if (!$ERROR_STATE) {
			$ARRAY_SAVE_PATH = [];
			foreach($args->ATTACH as $KEY_NAME => $ONE_ATTACH) {
				if (!$ONE_ATTACH['error']) {
					$SAVE_URL_PATH = sprintf(
						"SET_LED_FILES/%s/%s/%s_%s",
						date("Y", time()),
						date("m", time()),
						basename($ONE_ATTACH['tmp_name']),
						$ONE_ATTACH['name']
					);
					$SAVE_FILE_PATH = sprintf(
						"%s%s",
						ABSPATH,
						$SAVE_URL_PATH
					);
					if (!file_exists(dirname($SAVE_FILE_PATH))) {
						mkdir(dirname($SAVE_FILE_PATH), 0777, true);
					}
					rename($ONE_ATTACH['tmp_name'], $SAVE_FILE_PATH);
					array_push($ARRAY_SAVE_PATH, $SAVE_URL_PATH);
				}
			}

			global $wpdb;
			$WP_TABLE = "LED_INFO";
			$TABLE_NAME	= $wpdb->prefix . $WP_TABLE;

			$query = sprintf("
					INSERT INTO %s
						VALUES (
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
							'%d'
						);
					",
					$TABLE_NAME,
					$args->SET_LED_ID,
					date("Ymd", time()),
					date("His", time()),
					$args->SET_ADDR,
					$args->SET_PLACE_COMMENT,
					$args->SET_GPS->Longitude,
					$args->SET_GPS->Latitude,
					json_encode($ARRAY_SAVE_PATH),
					0
				);
				
	 		$RESULTS = $wpdb->get_results($query);
	 		if ($wpdb->last_error) {
				$args->STATUS_HELP = $wpdb->last_error;
	 		} else {
				$args->STATUS = 200;
				$args->STATUS_HELP = "OK";
	 		}
	 		
		}
		
		header("Content-Type: text/html; charset=UTF-8");    	
//		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($args));
		echo json_encode($args);
	}

	function HTTP_ACCESS($ARGS) {

//error_log(sprintf('HTTP_ACCESS [%s]', print_r($ARGS, true)));
		
		$HTTP_ACCESS_TIMEOUT = 5;
		
		$HTTP_URL	= $ARGS->URL; unset($ARGS->URL);
		if (isset($ARGS->TIMEOUT)) {
			$HTTP_ACCESS_TIMEOUT = intval($ARGS->TIMEOUT); unset($ARGS->TIMEOUT);
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, "IVR_INTERACT FOR DNA_SOFT BY GLOSSMATE");
		curl_setopt($ch, CURLOPT_URL, $HTTP_URL);
		curl_setopt($ch, CURLOPT_TIMEOUT, $HTTP_ACCESS_TIMEOUT); //timeout in seconds 
		if (isset($ARGS->ACCESS_TYPE)) {
			if ($ARGS->ACCESS_TYPE == 'JSON') {
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, remove_unicode_escape_sequence(json_encode($ARGS)));
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Accept: application/json',
					'Content-Type: application/json'
				));
			}
		} else {
			if (isset($ARGS->HTTP_HEADER)) {
				curl_setopt($ch, CURLOPT_HTTPHEADER, $ARGS->HTTPHEADER);
			}
			$fields_string = '';
			if (isset($ARGS->POST_FIELDS)) {
				curl_setopt($ch, CURLOPT_POST, true);
				foreach($ARGS->POST_FIELDS as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
				$fields_string = rtrim($fields_string,'&');
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
			}
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$STR_HTTP_RESULT = curl_exec ($ch);

//error_log(sprintf('HTTP_ACCESS [%s]', print_r($STR_HTTP_RESULT, true)));

		curl_close ($ch);

		if (isset($ARGS->RETURN_TYPE)) {
			if ($ARGS->RETURN_TYPE == 'JSON') {
				$TEMP_RESULT = json_decode($STR_HTTP_RESULT); 
			} else if ($ARGS->RETURN_TYPE == 'XML') {
				$TEMP_RESULT = new SimpleXMLElement($STR_HTTP_RESULT);
	//error_log(sprintf('TEMP_RESULT [%s]', remove_unicode_escape_sequence(json_encode($TEMP_RESULT, true))));
			} else {
				$TEMP_RESULT = $STR_HTTP_RESULT; 
			}
		} else {
			$TEMP_RESULT = $STR_HTTP_RESULT; 
		}

		return $TEMP_RESULT;
	}

	function KEY_COMPARE($KEY, $ASC) {
		return function ($a, $b) use ($KEY, $ASC) {
			$RESULT = 0;
			if (is_string($a->$KEY)) {
				if ($ASC) {
					$RESULT = strcmp($a->$KEY, $b->$KEY);
//					$RESULT = strnatcmp($a->$KEY, $b->$KEY);
				} else {
					$RESULT = strcmp($b->$KEY, $a->$KEY);
//					$RESULT = strnatcmp($b->$KEY, $a->$KEY);
				}
			} else {
				if ($ASC) {
					$RESULT = $a->$KEY > $b->$KEY;
				} else {
					$RESULT = $a->$KEY < $b->$KEY;
				}
			}
// error_log(sprintf('KEY => %s, A => %s, B => %s : %d',$KEY,json_encode($a),json_encode($b),$RESULT));
			return $RESULT;
		}; 
	}
	
	function SORT_BY_OBJ_KEY($ARRAY, $KEY, $ASC=true) {
// error_log(sprintf('SORT_BY_OBJ_KEY BEFORE [%s]', json_encode($ARRAY, JSON_PRETTY_PRINT)));
		usort($ARRAY, $this->KEY_COMPARE($KEY, $ASC));
// error_log(sprintf('SORT_BY_OBJ_KEY AFTER [%s]', json_encode($ARRAY, JSON_PRETTY_PRINT)));
		return $ARRAY;
	}
	
	function api_GET_CALL_GROUP_NUMBERS($argsPARAM) {
		$args = clone $argsPARAM;
		$JSON_RESULT = new \stdClass();
		$JSON_RESULT->CODE = 400;
		$JSON_RESULT->MESSAGE = "BAD REQUEST";

		if (isset($args->CALL_GROUP)) {
			$PHP_POST_UTIL = dirname( __FILE__ ) . "/POST_UTIL.php";
			if (file_exists($PHP_POST_UTIL)) {
				require_once $PHP_POST_UTIL;
				$this->o_POST_UTIL = new POST_UTIL();
				$CALL_LOG = json_decode($this->o_POST_UTIL->GET_LOG_LIST($args));
			}
			$CALL_STATISTICS = new \stdClass();
			foreach($args->CALL_GROUP->CALL_NUMBERS as $ONE_NUMBER) {
				$CALL_STATISTICS->$ONE_NUMBER = new \stdClass();
				$CALL_STATISTICS->$ONE_NUMBER->CALL_COUNT = 0;
				$CALL_STATISTICS->$ONE_NUMBER->CALL_DURATION = 0;
				$CALL_STATISTICS->$ONE_NUMBER->CALL_HANGUP_LAST = '';
			}
			foreach($CALL_LOG as $ONE_CALL_LOG) {
				$STAFF_NO = $ONE_CALL_LOG->OBJ_LOG->STAFF_NO;
				if (in_array($STAFF_NO, $args->CALL_GROUP->CALL_NUMBERS)) {
					if (!isset($CALL_STATISTICS->$STAFF_NO)) {
						$CALL_STATISTICS->$STAFF_NO = new \stdClass();
						$CALL_STATISTICS->$STAFF_NO->CALL_COUNT			= 1;
						$CALL_STATISTICS->$STAFF_NO->CALL_DURATION		= $ONE_CALL_LOG->OBJ_LOG->TIME_STAFF_DURATION;
						$CALL_STATISTICS->$STAFF_NO->CALL_HANGUP_LAST	= $ONE_CALL_LOG->DATE_TIME;
					} else {
						$CALL_STATISTICS->$STAFF_NO->CALL_COUNT		+= 1;
						$CALL_STATISTICS->$STAFF_NO->CALL_DURATION	+= $ONE_CALL_LOG->OBJ_LOG->TIME_STAFF_DURATION;
						if (strcmp($CALL_STATISTICS->$STAFF_NO->CALL_HANGUP_LAST, $ONE_CALL_LOG->DATE_TIME) < 0) {
							$CALL_STATISTICS->$STAFF_NO->CALL_HANGUP_LAST	= $ONE_CALL_LOG->DATE_TIME;
						}
					}
				}
			}
			$ARRAY_CALL_STATISTICS = array();
			$m_ArgsVars = get_object_vars($CALL_STATISTICS);
			foreach($m_ArgsVars as $Key => $Value) {
				$Value->CALL_NUMBER = $Key;
				array_push($ARRAY_CALL_STATISTICS, $Value);
			}
			
			if ($args->CALL_GROUP->CALL_ASSIGN == "DUMMY") {
			} else if ($args->CALL_GROUP->CALL_ASSIGN == "紐⑸줉 ?쒖꽌?濡??곗꽑?좊떦") {
			} else if ($args->CALL_GROUP->CALL_ASSIGN == "理쒖옣 ?듯솕?댁떇 ?곗꽑?좊떦") {
				$ARRAY_CALL_STATISTICS = $this->SORT_BY_OBJ_KEY($ARRAY_CALL_STATISTICS, 'CALL_HANGUP_LAST', true);
			} else if ($args->CALL_GROUP->CALL_ASSIGN == "理쒖냼 ?듯솕?뚯닔 ?곗꽑?좊떦") {
				$ARRAY_CALL_STATISTICS = $this->SORT_BY_OBJ_KEY($ARRAY_CALL_STATISTICS, 'CALL_COUNT', true);
			} else if ($args->CALL_GROUP->CALL_ASSIGN == "理쒖냼 ?듯솕?쒓컙 ?곗꽑?좊떦") {
				$ARRAY_CALL_STATISTICS = $this->SORT_BY_OBJ_KEY($ARRAY_CALL_STATISTICS, 'CALL_DURATION', true);
			}
			
			$CALL_GROUP_NUMBERS = array();
			foreach ($ARRAY_CALL_STATISTICS as $ONE_STAT) {
				array_push($CALL_GROUP_NUMBERS, $ONE_STAT->CALL_NUMBER);
			}

			$JSON_RESULT->CODE = 200;
			$JSON_RESULT->MESSAGE = "OK";
			$JSON_RESULT->CALL_GROUP = $args->CALL_GROUP;
			$JSON_RESULT->CALL_STATISTICS = $ARRAY_CALL_STATISTICS;
			$JSON_RESULT->CALL_GROUP_NUMBERS = $CALL_GROUP_NUMBERS;
		}

// error_log(sprintf('api_GET_CALL_GROUP_NUMBERS [%s]', TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($JSON_RESULT, JSON_PRETTY_PRINT))));

		header("Content-Type: text/html; charset=UTF-8");
    	echo json_encode($JSON_RESULT,JSON_PRETTY_PRINT);
	}
	
	function api_POST_LOG_STRING($argsPARAM) {
		$args = clone $argsPARAM;
		$JSON_RESULT = new \stdClass();
		$JSON_RESULT->CODE = 400;
		$JSON_RESULT->MESSAGE = "BAD REQUEST";
		
		$STR_LOG_STRING = "";
		if (isset($args->LOG_STRING)) {
			$STR_LOG_STRING = TECS_CLUB_UTILS::remove_unicode_escape_sequence($args->LOG_STRING);
		} else if (isset($args->LOG_STRING_BASE64)) {
			$STR_LOG_STRING = TECS_CLUB_UTILS::remove_unicode_escape_sequence(base64_decode($args->LOG_STRING_BASE64));
		}
		
		if (strlen($STR_LOG_STRING) > 0) {
			$LOG_PREFIX = "LOG"; if (isset($args->LOG_PREFIX)) $LOG_PREFIX = $args->LOG_PREFIX;
			$LOG_EXT = "LOG"; if (isset($args->LOG_EXT)) $LOG_EXT = $args->LOG_EXT;
			$WP_ROOT = substr(dirname(__FILE__), 0, strrpos(dirname(__FILE__),"wp-content")-1);
			$DATE_PREV_HOUR = strtotime("-1 hour");
			$LOG_PATH_PREV_HOUR = sprintf("%s/api_LOG/%s/%s_%s.%s", $WP_ROOT, date("Y/m/d", $DATE_PREV_HOUR), $LOG_PREFIX, date("Y-m-d_H", $DATE_PREV_HOUR), $LOG_EXT);
			$LOG_PATH = sprintf("%s/api_LOG/%s/%s_%s.%s", $WP_ROOT, date("Y/m/d"), $LOG_PREFIX, date("Y-m-d_H"), $LOG_EXT);
			if (isset($args->LOG_PATH)) {
				$LOG_PATH = sprintf("%s/%s/%s/%s_%s.%s", $WP_ROOT, $args->LOG_PATH, date("Y/m/d"), $LOG_PREFIX, date("Y-m-d_H"), $LOG_EXT);
				$LOG_PATH_PREV_HOUR = sprintf("%s/%s/%s/%s_%s.%s", $WP_ROOT, $args->LOG_PATH, date("Y/m/d", $DATE_PREV_HOUR), $LOG_PREFIX, date("Y-m-d_H", $DATE_PREV_HOUR), $LOG_EXT);
			}
			if (!file_exists(dirname($LOG_PATH_PREV_HOUR))) {
				mkdir(dirname($LOG_PATH), 0777, true);
			}
			if (!file_exists($LOG_PATH_PREV_HOUR)) {
				file_put_contents($LOG_PATH_PREV_HOUR, "\n", FILE_APPEND | LOCK_EX);
			}

			if (!file_exists(dirname($LOG_PATH))) {
				mkdir(dirname($LOG_PATH), 0777, true);
			}
			if (isset($args->LOG_TIME_STAMP) && $args->LOG_TIME_STAMP) {
				$STR_LOG_STRING = sprintf("%s - %s\n", date("Y-m-d H:i:s"), $STR_LOG_STRING);
			} else {
				$STR_LOG_STRING = sprintf("%s\n", $STR_LOG_STRING);
			}
			$TMP_RESULT = file_put_contents($LOG_PATH, $STR_LOG_STRING, FILE_APPEND | LOCK_EX);
			if ($TMP_RESULT === FALSE) {
				$JSON_RESULT->CODE = 500;
				$JSON_RESULT->MESSAGE = "ERROR ON file_put_contents()";
			} else {
				$JSON_RESULT->CODE = 200;
				$JSON_RESULT->MESSAGE = sprintf("OK %d bytes saved.", $TMP_RESULT);
			}
		}

		header("Content-Type: text/html; charset=UTF-8");
    	echo json_encode($JSON_RESULT,JSON_PRETTY_PRINT);
	}

	function api_GET_WORK_CONDITION($argsPARAM) {
		$args = clone $argsPARAM;

error_log(sprintf('api_GET_WORK_CONDITION args [%s]', json_encode($args,JSON_PRETTY_PRINT)));

		$JSON_RESULT = new \stdClass();
		$JSON_RESULT->TIME_STRING = date('Y-m-d H:i');
		$JSON_RESULT->WORK_CONDITION = 'WORK_OVER';
		$JSON_RESULT->WORK_CONDITION = 'LUNCH_TIME';
	//	$JSON_RESULT->WORK_CONDITION = 'NO_WORK_DAY';
		$JSON_RESULT->WORK_CONDITION = 'WORK_SERVICE';
		$JSON_RESULT->WORK_FLAG = '';
		$JSON_CONFIG = NULL;

		if (isset($args->CONFIG_URL)) {
			$JSON_CONFIG = json_decode(file_get_contents($args->CONFIG_URL));
		} else if (isset($args->JSON_CONFIG)) {
			$JSON_CONFIG = $args->JSON_CONFIG;
		}
		
		if (is_object($JSON_CONFIG)) {

			$JSON_RESULT->WORK_TIMES = new \stdClass();
			$JSON_RESULT->WORK_TIMES->LUNCH_TIME_START	= $JSON_CONFIG->WORK_TIME_INFORMATION->LUNCH_TIME_START;
			$JSON_RESULT->WORK_TIMES->LUNCH_TIME_END	= $JSON_CONFIG->WORK_TIME_INFORMATION->LUNCH_TIME_END;
			$JSON_RESULT->WORK_TIMES->WORK_START		= $JSON_CONFIG->WORK_TIME_INFORMATION->WORK_TIMES[0]->START;
			$JSON_RESULT->WORK_TIMES->WORK_END			= $JSON_CONFIG->WORK_TIME_INFORMATION->WORK_TIMES[0]->END;
			
			$CUSTOM_DAY_TRIGGER = NULL;
			if (isset($JSON_CONFIG->CUSTOM_WORK_INFORMATION)) {
				foreach($JSON_CONFIG->CUSTOM_WORK_INFORMATION as $ONE_CUSTOM_DAY) {
					if ($ONE_CUSTOM_DAY->DATE == date('Y-m-d')) {
						$CUSTOM_DAY_TRIGGER = $ONE_CUSTOM_DAY;
						break;
					}
				}
			}

error_log(sprintf('CUSTOM_DAY_TRIGGER [%s]', json_encode($CUSTOM_DAY_TRIGGER,JSON_PRETTY_PRINT)));
			
			if (is_object($CUSTOM_DAY_TRIGGER)) {

				$JSON_RESULT->WORK_TIMES->LUNCH_TIME_START	= $CUSTOM_DAY_TRIGGER->LUNCH_TIME_START;
				$JSON_RESULT->WORK_TIMES->LUNCH_TIME_END	= $CUSTOM_DAY_TRIGGER->LUNCH_TIME_END;
				$JSON_RESULT->WORK_TIMES->WORK_START		= $CUSTOM_DAY_TRIGGER->WORK_TIMES[0]->START;
				$JSON_RESULT->WORK_TIMES->WORK_END			= $CUSTOM_DAY_TRIGGER->WORK_TIMES[0]->END;

				if ($CUSTOM_DAY_TRIGGER->ITS_WORK_DAY) {
					$CURRENT_TIME = date('H:i');
					if ((strcmp($CUSTOM_DAY_TRIGGER->LUNCH_TIME_START, $CURRENT_TIME) <= 0) &&
						(strcmp($CURRENT_TIME, $CUSTOM_DAY_TRIGGER->LUNCH_TIME_END) <= 0)) {
						$JSON_RESULT->WORK_CONDITION = 'LUNCH_TIME';
					} else {
						$JSON_RESULT->WORK_CONDITION = 'WORK_OVER';
						foreach($CUSTOM_DAY_TRIGGER->WORK_TIMES as $ONE_CUSTOM_WORK_TIME) {
							if ((strcmp($ONE_CUSTOM_WORK_TIME->START, $CURRENT_TIME) < 0) &&
							   (strcmp($CURRENT_TIME, $ONE_CUSTOM_WORK_TIME->END) < 0)) {
							   	$JSON_RESULT->WORK_CONDITION = 'WORK_SERVICE';
							}
						}
					}
				} else {
					$JSON_RESULT->WORK_CONDITION = 'CUSTOM_NO_WORK_DAY';
				}
			} else {
				$WEEK_NUMBER = date('w');
				if (($WEEK_NUMBER == 0) || ($WEEK_NUMBER == 6)) {
					$JSON_RESULT->WORK_CONDITION = 'NO_WORK_DAY';
				} else {
					$HTTP_ARGS = new stdClass();
					$HTTP_ARGS->RETURN_TYPE = 'XML';
					$HTTP_ARGS->URL = 'http://apis.data.go.kr/B090041/openapi/service/SpcdeInfoService/getRestDeInfo';

					$POST_FIELDS = array(
						'ServiceKey' => 'GzNji2eADLsDRBLVhDX2JrKRVv2C1JVGlilJBSFpfu4nv0YBwG85NYq02YaMDSFuRSjRgEbdQLUFs9GvMA4bFA%3D%3D',
						'solYear' => date('Y'),
						'solMonth' => date('m')
					);

					$fields_string = '';
					foreach($POST_FIELDS as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
					$fields_string = rtrim($fields_string,'&');
					
					$HTTP_ARGS->URL .= '?' . $fields_string;
					
					
					$HTTP_RESULT = $this->HTTP_ACCESS($HTTP_ARGS);
					if ($HTTP_RESULT->header->resultCode == '00') {
error_log(sprintf('api_GET_WORK_CONDITION HOLIDAYS : [%s]', TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($HTTP_RESULT->body->items->item))));
						foreach($HTTP_RESULT->body->items->item as $ONE_HOLIDAY) {
							if ($ONE_HOLIDAY->isHoliday) {
								if ($ONE_HOLIDAY->locdate == date('Ymd')) {
	//							if ($ONE_HOLIDAY->locdate == '20180217') {
									$JSON_RESULT->WORK_CONDITION = 'NO_WORK_DAY';
								}
							}
						}
					}
				}
				if ($JSON_RESULT->WORK_CONDITION != 'NO_WORK_DAY') {
					$CURRENT_TIME = date('H:i');
					if ((strcmp($JSON_CONFIG->WORK_TIME_INFORMATION->LUNCH_TIME_START, $CURRENT_TIME) <= 0) &&
						(strcmp($CURRENT_TIME, $JSON_CONFIG->WORK_TIME_INFORMATION->LUNCH_TIME_END) <= 0)) {
						$JSON_RESULT->WORK_CONDITION = 'LUNCH_TIME';
					} else {
						$JSON_RESULT->WORK_CONDITION = 'WORK_OVER';
						foreach($JSON_CONFIG->WORK_TIME_INFORMATION->WORK_TIMES as $ONE_WORK_TIME) {
							if ((strcmp($ONE_WORK_TIME->START, $CURRENT_TIME) < 0) &&
							   (strcmp($CURRENT_TIME, $ONE_WORK_TIME->END) < 0)) {
							   	$JSON_RESULT->WORK_CONDITION = 'WORK_SERVICE';
							}
						}
					}
				}
			}
		}
		
		if (count($JSON_CONFIG->WORK_TIME_INFORMATION->WORK_TIMES) == 1) {
			foreach($JSON_CONFIG->WORK_TIME_INFORMATION->WORK_TIMES as $ONE_WORK_TIME) {
				if (strcmp($CURRENT_TIME, $ONE_WORK_TIME->START) < 0) {
				   	$JSON_RESULT->WORK_FLAG = 'WORK_BEFORE';
				} else if (strcmp($CURRENT_TIME, $ONE_WORK_TIME->END) > 0) {
				   	$JSON_RESULT->WORK_FLAG = 'WORK_AFTER';
				} else {
				   	$JSON_RESULT->WORK_FLAG = 'WORK_IN_DOING';
				}
			}
		}

error_log(sprintf('api_GET_WORK_CONDITION RESULT : [%s]', TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($JSON_RESULT))));

		header("Content-Type: text/html; charset=UTF-8");
    	echo json_encode($JSON_RESULT,JSON_PRETTY_PRINT);
	}

	function api_LOGIN($args) {
		$credentials = array(
			"user_login" => $args->USER_ID,
			"user_password" => $args->USER_PW,
			"remember" => false
		);
		$LOGIN_RESULT = wp_signon($credentials);
		
		header("Content-Type: text/html; charset=UTF-8");
//    	echo '<xmp>' . json_encode($LOGIN_RESULT,JSON_PRETTY_PRINT) . '</xmp>';
    	echo json_encode($LOGIN_RESULT,JSON_PRETTY_PRINT);
	}

    public function api_ECHO($args) {
//    	echo '<xmp>' . print_r($args, true) . '</xmp>';
		header("Content-Type: text/html; charset=UTF-8");
    	echo '<xmp>' . $this->GET_ECHO_STRING($args) . '</xmp>';
    }

    public function api_GreenLine($args) {
    	$JSON_RESULT = new stdClass();
    	if (isset($args->WHAT)) {
    		if ($args->WHAT == 'DUMMY') {
    		} else if ($args->WHAT == 'LIST_VIDEO_FILES') {
				$JSON_RESULT->VIDEO_FILES = array();
	    		if (isset($args->TITLE)) {
					$_WP_ROOT = substr(dirname(__FILE__), 0, strrpos(dirname(__FILE__),"wp-content")-1);
					$LS_FILE_COMMAND = sprintf('ls %s/WEBAPPS/APPS/Green-Line/CAM/%s* | sort -r ', $_WP_ROOT, $args->TITLE);
					$SHELL_RESULT  = exec($LS_FILE_COMMAND, $arr_output_lines);
					$EXEC_OUTPUT_TEXTS = implode("\n", $arr_output_lines);
					foreach($arr_output_lines as $ONE_FILE) {
						$STR_FILE_PART = strstr($ONE_FILE, $args->TITLE);
						array_push($JSON_RESULT->VIDEO_FILES, $STR_FILE_PART);
					}
	    		}
    		}
    	} else {
	    	$args->DATE_TIME = date('Y-m-d H:i:s');
			$JSON_RESULT = $args;
	    	
	    	if (isset($args->ALERT_SMS_TO) && isset($args->ALERT_SMS_MSG)) {
		    	$ARGS_SMS = new stdClass();
		    	$ARGS_SMS->SMS_FROM = '07045193590';
		    	$ARGS_SMS->SMS_TO = '01089555198 01024667516 01077743438';
//		    	$ARGS_SMS->SMS_TO = $args->ALERT_SMS_TO;
		    	$ARGS_SMS->SMS_TEXT = $args->ALERT_SMS_MSG;
		    	$this->SEND_IP_SMS($ARGS_SMS);
	    	}
    	}
    	
		header("Content-Type: text/html; charset=UTF-8");
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($JSON_RESULT, JSON_PRETTY_PRINT));
    }

    public function api_CISCO($args) {
//    	echo '<xmp>' . print_r($args, true) . '</xmp>';
		header("Content-Type: text/html; charset=UTF-8");
		echo '<CiscoIPPhoneText>';
		echo '<Title>Title text goes here</Title>';
		echo '<Prompt>The prompt text goes here</Prompt>';
		echo '<Text>The text to be displayed as the message body goes here</Text>';
		echo '</CiscoIPPhoneText>';
    }

	public function api_HTTP_ACCESS($args) {
		$result = '';
		if (isset($args->CURLOPT_URL) || isset($args->URL)) {
			$m_CURL_SETOPT_ARRAY = array();
			$m_ArgsVars = get_object_vars($args);
			foreach($m_ArgsVars as $Key => $Value) {
				if (TECS_CLUB_UTILS::startsWith($Key, 'CURLOPT_')) {
					if (TECS_CLUB_UTILS::startsWith($Key, 'CURLOPT_POSTFIELDS')) {
//error_log('api_HTTP_ACCESS : ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence(print_r($Key, TRUE)));
//error_log('api_HTTP_ACCESS : ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence(print_r($Value, TRUE)));
						if (is_object($Value)) {
//							$m_CURL_SETOPT_ARRAY[constant($Key)] = http_build_query((array) $Value);
							$m_CURL_SETOPT_ARRAY[constant($Key)] = json_encode($Value);
						} else if (is_array($Value)) {
							$m_CURL_SETOPT_ARRAY[constant($Key)] = http_build_query($Value);
						} else {
							$m_CURL_SETOPT_ARRAY[constant($Key)] = $Value;
						}
					} else {
						$m_CURL_SETOPT_ARRAY[constant($Key)] = $Value;
					}
				} else if (TECS_CLUB_UTILS::startsWith($Key, 'URL')) {
					$m_CURL_SETOPT_ARRAY[constant('CURLOPT_' . $Key)] = $Value;
				}
			}
			if (!isset($args->CURLOPT_POST))			$m_CURL_SETOPT_ARRAY[constant('CURLOPT_POST')]		 		= true;
			if (!isset($args->CURLOPT_RETURNTRANSFER))	$m_CURL_SETOPT_ARRAY[constant('CURLOPT_RETURNTRANSFER')]	= true;

//error_log('api_HTTP_ACCESS : ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($m_CURL_SETOPT_ARRAY, JSON_PRETTY_PRINT)));
//error_log('api_HTTP_ACCESS : ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence(print_r($m_CURL_SETOPT_ARRAY, TRUE)));

	        // Open connection
	        $ch = curl_init();
	        // Set Options
	        curl_setopt_array($ch, $m_CURL_SETOPT_ARRAY);
	        // Execute post
	        $result = curl_exec($ch);

//error_log('api_HTTP_ACCESS : ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($result, JSON_PRETTY_PRINT)));
//error_log('api_HTTP_ACCESS : curl_error : ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence(curl_error($ch)));
	 
	        // Close connection
	        curl_close($ch);
		}
		if (isset($args->RESULT_FORMAT)) {

// error_log('api_HTTP_ACCESS : ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence(print_r($result, TRUE)));
			return $result;
		} else {
			header("Content-Type: text/html; charset=UTF-8");    	
			echo $result;
		}
	}

	public function api_URL_DOWNLOAD($args) {
		$result = '';
		if (isset($args->URL_DOWNLOAD)) {
			$FILE_NAME = sprintf("DOWNLOAD_%s", md5(time()));
			if (isset($args->FILE_NAME)) $FILE_NAME = $args->FILE_NAME;
			$TMP_PATH = sprintf("/tmp/%s", $FILE_NAME);
			file_put_contents(
				$TMP_PATH,
				file_get_contents($args->URL_DOWNLOAD)
			);
			
			$filesize = filesize($TMP_PATH);
			$path_parts = pathinfo($TMP_PATH);
			$filename = $path_parts['basename'];
//			$extension = $path_parts['extension'];
			 
			header("Pragma: public");
			header("Expires: 0");
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: $filesize");
			 
			ob_clean();
			flush();
			readfile($TMP_PATH);
			unlink($TMP_PATH);
		} else {
			header("Content-Type: text/html; charset=UTF-8");    	
			echo $result;
		}
	}
	
	public function api_GET_WP_ROOT($args) {
		$result = new stdClass();
		$result->_WP_ROOT = substr(dirname(__FILE__), 0, strrpos(dirname(__FILE__),"wp-content")-1);
		header("Content-Type: text/html; charset=UTF-8");    	
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($result, JSON_PRETTY_PRINT));
	}

    function api_DB_ACCESS($args) {
		global $wpdb;

    	$OBJ_RESULT = new stdClass();
		$STR_QUERY = "";
		if (isset($args->STR_SQL)) {
			$STR_QUERY = $args->STR_SQL;
		} else if (isset($args->STR_SQL_BASE64)) {
			$STR_QUERY = base64_decode($args->STR_SQL_BASE64);
		}
error_log('STR_QUERY => ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence($STR_QUERY));

		if (strlen($STR_QUERY) > 0) {
			$OBJ_RESULT = $wpdb->get_results($STR_QUERY);
/*
			if (isset($args->ARRAY_PREPARE)) {
				if (count($args->ARRAY_PREPARE) > 0) {
					$OBJ_RESULT = $wpdb->query(
						$wpdb->prepare(
							$STR_QUERY,
							$args->ARRAY_PREPARE
						)
					);
				} else {
					$OBJ_RESULT = $wpdb->get_results($STR_QUERY);
				}
			} else {
				$OBJ_RESULT = $wpdb->get_results($STR_QUERY);
			}
*/
		}
		if ($wpdb->last_error) {
		  $OBJ_RESULT = new stdClass();
		  $OBJ_RESULT->STATUS = 500;
		  $OBJ_RESULT->STATUS_HELP = $wpdb->last_error;
		}		

		header("Content-Type: text/html; charset=UTF-8");    	
//		echo "<xmp>";
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($OBJ_RESULT, JSON_PRETTY_PRINT));
//		echo "</xmp>";
    }
    
    function api_TTS_VW($args) {
    	$ACCESS_API_ARGS = new stdClass();
    	$ACCESS_API_ARGS->API_REQUEST = new stdClass();
//    	$ACCESS_API_ARGS->API_REQUEST->URL = 'http://pbx.1key.kr:8080/API/';
    	$ACCESS_API_ARGS->API_REQUEST->REQUEST = 'TTS_VW';
    	$ACCESS_API_ARGS->API_REQUEST->TTS_SPEED = 100;
    	$ACCESS_API_ARGS->API_REQUEST->TTS_TEXT = '안녕하세요? 음성합성 테스트 입니다.';
    	if (isset($args->TTS_URL))		$ACCESS_API_ARGS->API_REQUEST->URL			= $args->TTS_URL;
    	if (isset($args->TTS_SPEED))	$ACCESS_API_ARGS->API_REQUEST->TTS_SPEED	= $args->TTS_SPEED;
    	if (isset($args->TTS_TEXT))		$ACCESS_API_ARGS->API_REQUEST->TTS_TEXT		= $args->TTS_TEXT;
    	if (isset($args->TTS_LANG))		$ACCESS_API_ARGS->API_REQUEST->TTS_LANG		= $args->TTS_LANG;

//		error_log(TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($ACCESS_API_ARGS, JSON_PRETTY_PRINT)));

    	$this->api_API_ACCESS($ACCESS_API_ARGS);
    }
    
    function api_API_ACCESS($args) {
    	$OBJ_RESULT = new stdClass();
    	$OBJ_RESULT->CODE = 200;
    	$OBJ_RESULT->MESSAGE = "OK";

		error_log('api_API_ACCESS => ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($args, JSON_PRETTY_PRINT)));
    	
    	if (isset($args->API_REQUEST)) {
   			$OBJ_RESULT->API_REQUEST = $args->API_REQUEST;
    		if (is_object($args->API_REQUEST)) {
		    	$ACCESS_API_ARGS = new stdClass();
		    	$ACCESS_API_ARGS->URL = "http://pbx.1key.kr:8080/API/";
		    	if (isset($args->API_REQUEST->URL)) {
		    		$ACCESS_API_ARGS->URL = $args->API_REQUEST->URL;
		    		unset($args->API_REQUEST->URL);
		    	}
		    	$ACCESS_API_ARGS->RESULT_FORMAT = 1;
/*
		    	$ACCESS_API_ARGS->CURLOPT_HTTPHEADER = array(
							'Accept: application/json',
							'Content-Type: application/json'
						);
*/
		    	$ACCESS_API_ARGS->CURLOPT_POSTFIELDS = $args->API_REQUEST;
		    	$TEMP_STR_RESULT = $this->api_HTTP_ACCESS($ACCESS_API_ARGS);
		    	$TEMP_JSON_RESULT = json_decode($TEMP_STR_RESULT);
		    	if (is_object($TEMP_JSON_RESULT)) {
		    		if (!isset($TEMP_JSON_RESULT->RESULT->RESULT_CONTENTS)) {
				    	$OBJ_RESULT->CODE = 400;
				    	$OBJ_RESULT->MESSAGE = "BAD API_REQUEST PROBLEM";
		    		} else {
			    		$OBJ_RESULT->API_RESULT = $TEMP_JSON_RESULT->RESULT->RESULT_CONTENTS;
		    		}
		    	} else {
			    	$OBJ_RESULT->CODE = 400;
			    	$OBJ_RESULT->MESSAGE = "WE CANNOT PROCESS YOUR API_REQUEST!";
		    	}
    		} else {
		    	$OBJ_RESULT->CODE = 400;
		    	$OBJ_RESULT->MESSAGE = "API_REQUEST IS NOT A VALID JSON STRING";
		    	$OBJ_RESULT->API_REQUEST = stripslashes($args->API_REQUEST);
    		}
    	} else {
	    	$OBJ_RESULT->CODE = 400;
	    	$OBJ_RESULT->MESSAGE = "NO API_REQUEST PARAMS";
    	}
    	
    	if (isset($args->API_REQUEST->REQUEST) && ($args->API_REQUEST->REQUEST == "TTS_VW")) {
			header("Pragma: public");
			header("Expires: 0");
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"TTS_VW.WAV\"");
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ". strlen($TEMP_STR_RESULT));
			 
			ob_clean();
			flush();
			echo $TEMP_STR_RESULT; // readfile($filepath);
    	} else {
			header("Content-Type: text/html; charset=UTF-8");    	
//			echo "<pre>";
			echo TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($OBJ_RESULT, JSON_PRETTY_PRINT));
//			echo "</pre>";
    	}
    }

    function api_APIS_ACCESS($args) {
    	$OBJ_RESULT = new stdClass();
    	$OBJ_RESULT->CODE = 200;
    	$OBJ_RESULT->MESSAGE = "OK";
    	
    	if (isset($args->APIS_REQUEST)) {
   			$OBJ_RESULT->APIS_REQUEST = $args->APIS_REQUEST;
    		if (is_object($args->APIS_REQUEST)) {
		    	$ACCESS_APIS_ARGS = new stdClass();
		    	$ACCESS_APIS_ARGS->URL = "http://127.0.0.1:8080/APIS/";
		    	$ACCESS_APIS_ARGS->RESULT_FORMAT = 1;
/*
		    	$ACCESS_APIS_ARGS->CURLOPT_HTTPHEADER = array(
							'Accept: application/json',
							'Content-Type: application/json'
						);
*/
		    	$ACCESS_APIS_ARGS->CURLOPT_POSTFIELDS = $args->APIS_REQUEST;
		    	$TEMP_STR_RESULT = $this->api_HTTP_ACCESS($ACCESS_APIS_ARGS);
		    	$TEMP_JSON_RESULT = json_decode($TEMP_STR_RESULT);
		    	if (is_object($TEMP_JSON_RESULT)) {
		    		if (!isset($TEMP_JSON_RESULT->RESULT->RESULT_CONTENTS)) {
				    	$OBJ_RESULT->CODE = 400;
				    	$OBJ_RESULT->MESSAGE = "BAD APIS_REQUEST PROBLEM";
		    		} else {
			    		$OBJ_RESULT->APIS_RESULT = $TEMP_JSON_RESULT->RESULT->RESULT_CONTENTS;
		    		}
		    	} else {
			    	$OBJ_RESULT->CODE = 400;
			    	$OBJ_RESULT->MESSAGE = "WE CANNOT PROCESS YOUR APIS_REQUEST!";
		    	}
    		} else {
		    	$OBJ_RESULT->CODE = 400;
		    	$OBJ_RESULT->MESSAGE = "APIS_REQUEST IS NOT A VALID JSON STRING";
		    	$OBJ_RESULT->APIS_REQUEST = stripslashes($args->APIS_REQUEST);
    		}
    	} else {
	    	$OBJ_RESULT->CODE = 400;
	    	$OBJ_RESULT->MESSAGE = "NO APIS_REQUEST PARAMS";
    	}
    	
    	if (isset($args->APIS_REQUEST->REQUEST) && ($args->APIS_REQUEST->REQUEST == "TTS_VW")) {
			header("Pragma: public");
			header("Expires: 0");
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"TTS_VW.WAV\"");
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ". strlen($TEMP_STR_RESULT));
			 
			ob_clean();
			flush();
			echo $TEMP_STR_RESULT; // readfile($filepath);
    	} else {
			header("Content-Type: text/html; charset=UTF-8");    	
//			echo "<pre>";
			echo TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($OBJ_RESULT, JSON_PRETTY_PRINT));
//			echo "</pre>";
    	}
    }

	public function api_WP_ACCESS($args) {
		$result = 'NO RESULT';
		if (isset($args->PHP_CODES)) {
			require( __DIR__ . '../../../index.php' );
			$TEMP_RESULT = eval($args->PHP_CODES);
			if (is_string($TEMP_RESULT)) {
				$result = $TEMP_RESULT;
			} else {
				$result = json_encode($TEMP_RESULT);
			}
		} else if (isset($args->PHP_CODES_BASE64)) {
			require( __DIR__ . '../../../index.php' );
			$PHP_CODES = base64_decode($args->PHP_CODES_BASE64);
//error_log('PHP_CODES => ' . TECS_CLUB_UTILS::remove_unicode_escape_sequence($PHP_CODES));
			$TEMP_RESULT = eval($PHP_CODES);
			if (is_string($TEMP_RESULT)) {
				$result = $TEMP_RESULT;
			} else {
				$result = json_encode($TEMP_RESULT);
			}
		}
//error_log(TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($result, JSON_PRETTY_PRINT)));
		header("Content-Type: text/html; charset=UTF-8");    	
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence($result);
	}

	public function api_WP_USER_ADD($args) {
		$result = 'NO RESULT';
		if (isset($args->USER_ID) && isset($args->USER_PW) && isset($args->USER_EMAIL)) {
			require( __DIR__ . '../../../index.php' );
			$TEMP_RESULT = wp_create_user($args->USER_ID, $args->USER_PW, $args->USER_EMAIL);
			if (is_string($TEMP_RESULT)) {
				$result = $TEMP_RESULT;
			} else {
				$result = json_encode($TEMP_RESULT);
			}
			if (!is_object($TEMP_RESULT)) {
				if (isset($args->USER_NAME)) {
					wp_update_user( array(
					    'ID'            => $TEMP_RESULT,
					    'display_name' => $args->USER_NAME
					) );				
				}
			}
		} else {
			$result = sprintf("API ?몄텧 ?뺤떇???섎せ?섏뿀?듬땲??");
		}
		header("Content-Type: text/html; charset=UTF-8");    	
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence($result);
	}

	public function api_WP_USER_DEL($args) {
		
		$JSON_RESULT = new stdClass();
		$JSON_RESULT->RESULT = '';

		if (isset($args->API_KEY) && isset($args->USER_ID)) {
			if ($args->API_KEY == 'kr_13989badc8f73855bb877c998dr799274qw') {
				require( __DIR__ . '../../../index.php' );
				require( __DIR__ . '/../../../wp-admin/includes/user.php' );
				
				$TEMP_RESULT = get_user_by('login', $args->USER_ID);
				if (isset($TEMP_RESULT->data->ID)) {
					$JSON_RESULT->RESULT = wp_delete_user($TEMP_RESULT->data->ID);
				} else {
					$JSON_RESULT->RESULT = sprintf("INVALID USER %s", $args->USER_ID);
				}
			} else {
				$JSON_RESULT->RESULT = sprintf("API_KEY 媛 ?좏슚?섏? ?딆뒿?덈떎.");
			}
		} else {
			$JSON_RESULT->RESULT = sprintf("API ?몄텧 ?뺤떇???섎せ?섏뿀?듬땲??");
		}
		header("Content-Type: text/html; charset=UTF-8");    	
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($JSON_RESULT));
	}

	
	public function api_WP_ENCODE($args) {
		$result = 'NO RESULT';
		if (isset($args->TXT_PLAIN)) {
			require( __DIR__ . '../../../index.php' );
			$TEMP_RESULT = wp_hash_password($args->TXT_PLAIN);
			if (is_string($TEMP_RESULT)) {
				$result = (wp_check_password($args->TXT_PLAIN, $TEMP_RESULT) ? 'TRUE' : 'FALSE');
//				$result = $TEMP_RESULT;
			} else {
				$result = json_encode($TEMP_RESULT);
			}
		} else {
			$result = sprintf("API ?몄텧 ?뺤떇???섎せ?섏뿀?듬땲??");
		}
		header("Content-Type: text/html; charset=UTF-8");    	
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence($result);
	}
	
	public function api_WP_CHPWD($args) {
		$JSON_RESULT = new stdCLass();
		$JSON_RESULT->MSG_CODE = 200;
		if (isset($args->ID) && isset($args->PW_OLD) && isset($args->PW_NEW)) {
			require( __DIR__ . '../../../index.php' );
			$USER = get_user_by('login', $args->ID);
			if ($USER) {
				if (wp_check_password( $args->PW_OLD, $USER->data->user_pass, $args->ID)) {
					wp_set_password($args->PW_NEW, $USER->ID);
					$JSON_RESULT->MSG_HELP = sprintf("USER ID -> '%s' PW_NEW APPLIED -> '%s'", $args->ID, $args->PW_NEW);
				} else {
					$JSON_RESULT->MSG_CODE = 401 ;
					$JSON_RESULT->MSG_HELP = sprintf("USER ID -> '%s' WRONG PW_OLD -> '%s'", $args->ID, $args->PW_OLD);
				}
			} else {
				$JSON_RESULT->MSG_CODE = 404;
				$JSON_RESULT->MSG_HELP = sprintf("USER ID -> '%s' NOT EXISTS!", $args->ID);
			}
		} else {
			$JSON_RESULT->MSG_CODE = 400;
			$JSON_RESULT->MSG_HELP = sprintf("API ?몄텧 ?뺤떇???섎せ?섏뿀?듬땲??");
		}
		header("Content-Type: text/html; charset=UTF-8");    	
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($JSON_RESULT, JSON_PRETTY_PRINT));
	}

	public function api_WP_AUTHENTICATE($args) {
		$result = 'NO RESULT';
		if (isset($args->PW_PLAIN) && isset($args->PW_HASH)) {
			require( __DIR__ . '../../../index.php' );
			$result = (wp_check_password($args->PW_PLAIN, $args->PW_HASH) ? 'TRUE' : 'FALSE');
		} else {
			$result = sprintf("API ?몄텧 ?뺤떇???섎せ?섏뿀?듬땲??");
		}
		header("Content-Type: text/html; charset=UTF-8");    	
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence($result);
	}
	public function api_YOUTUBE_SEARCH($args) {

		error_log(sprintf("YOUTUBE_SEARCH : %s", print_r($args, true)));

		$result = '[]';
		if ($args->Q) {
			$API_KEY = 'AIzaSyA8vPoDhpJUzx5Ek2psVgCBN83A9H5hgiw';
			$COUNT = 5;
			if (isset($args->COUNT)) $COUNT = $args->COUNT;
			$PG_TOKEN = '';
			if (isset($args->PG_TOKEN)) $PG_TOKEN = $args->PG_TOKEN;
			$YS = new youtube_search($API_KEY, $args->Q, $COUNT, $PG_TOKEN);
			$result = json_encode($YS->get_data());
		}
//		error_log(sprintf("YOUTUBE_SEARCH : %s", print_r($result, true)));
		header("Content-Type: text/html; charset=UTF-8");    	
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence($result);
//		return $result;
	}

    function CREATE_TABLES_FOR_YOUTUBE_MP3() {
		global $wpdb;
		$WP_TABLE = "YOUTUBE_MP3";
		$TABLE_NAME			= $wpdb->prefix . $WP_TABLE;
		if (!$this->IS_TABLE_EXIST($WP_TABLE)) {
			$CHARSET_COLLATE	= $wpdb->get_charset_collate();

			$query = "
				CREATE TABLE $TABLE_NAME (
					YOUTUBE_MEDIA_ID		VARCHAR(64) NOT NULL,
					PRIMARY KEY 			(YOUTUBE_MEDIA_ID),
					YOUTUBE_MEDIA_MP3_PATH	MEDIUMTEXT,
					YOUTUBE_MEDIA_INFO		MEDIUMTEXT
				) $CHARSET_COLLATE;
			";
			$result = $wpdb->get_results($query);
			error_log("CREATE_TABLES_FOR_YOUTUBE_MP3 : $WP_TABLE : " . print_r($result,true) );
			
		}
	}

	function INSERT_YOUTUBE_MP3($args) {
		global $wpdb;
		$WP_TABLE = "YOUTUBE_MP3";
		$TABLE_NAME			= $wpdb->prefix . $WP_TABLE;
		if (!$this->IS_TABLE_EXIST($WP_TABLE)) {
			$OBJ_ERROR = new stdClass();
			$OBJ_ERROR->ERROR = "DB??$TABLE_NAME ?뚯씠釉붿씠 ?놁뒿?덈떎.";
	    	$result = remove_unicode_escape_sequence(json_encode($OBJ_ERROR));
//	    	$result = (json_encode($OBJ_ERROR));
		} else {
			$query = "
				INSERT INTO $TABLE_NAME (
					YOUTUBE_MEDIA_ID,
					YOUTUBE_MEDIA_MP3_PATH,
					YOUTUBE_MEDIA_INFO
					)
				VALUES (
					\"$args->YOUTUBE_MEDIA_ID\",
					\"$args->YOUTUBE_MEDIA_MP3_PATH\",
					\"$args->YOUTUBE_MEDIA_INFO\"
				);
			";
			$result = $wpdb->get_results($query);
		}
	}

    function SELECT_YOUTUBE_MP3($args) {
    	$OBJ_RESULT = new stdClass();
		global $wpdb;
		$WP_TABLE = "YOUTUBE_MP3";
		$TABLE_NAME			= $wpdb->prefix . $WP_TABLE;
		if (!$this->IS_TABLE_EXIST($WP_TABLE)) {
			$OBJ_ERROR = new stdClass();
			$OBJ_ERROR->ERROR = "DB??$TABLE_NAME ?뚯씠釉붿씠 ?놁뒿?덈떎.";
			$OBJ_RESULT = $OBJ_ERROR;
		} else {
			$query = "
		        SELECT		*      
		        FROM        $TABLE_NAME
		        WHERE
		        	YOUTUBE_MEDIA_ID = '$args->YOUTUBE_MEDIA_ID'
			";
			$query_result = $wpdb->get_results($query);
			$OBJ_RESULT = $query_result;
		}
    	return $OBJ_RESULT;
    }

	function api_YOUTUBE_MP3($argsPARAM) {
		$args = clone $argsPARAM;
//error_log(sprintf("YOUTUBE_MP3 : %s", print_r($args, true)));

		$result = '';
    	$args->YOUTUBE_videoId	= isset($args->YOUTUBE_videoId) ? $args->YOUTUBE_videoId : "KSGPcpMnRXE";
		if (isset($args->YOUTUBE_videoId) && strlen($args->YOUTUBE_videoId) > 0) {

			$this->CREATE_TABLES_FOR_YOUTUBE_MP3();

			$ARGS_DB = new stdClass();
			$ARGS_DB->YOUTUBE_MEDIA_ID		= $args->YOUTUBE_videoId;
			$ARGS_DB->YOUTUBE_MEDIA_INFO	= '';
			
			if (isset($args->PHONE_ID) || isset($args->PHONE_NO)) {
				$OBJ_YOUTUBE_MEDIA_INFO				= new stdClass();
				$OBJ_YOUTUBE_MEDIA_INFO->PHONE_ID	= $args->PHONE_ID;
				$OBJ_YOUTUBE_MEDIA_INFO->PHONE_NO	= $args->PHONE_NO;
				$ARGS_DB->YOUTUBE_MEDIA_INFO		= addslashes(json_encode($OBJ_YOUTUBE_MEDIA_INFO));
			}

			$SAVE_FILE_PATH_MP3 = "";
			$SELECT_RESULT = $this->SELECT_YOUTUBE_MP3($ARGS_DB);
//error_log(sprintf("YOUTUBE_MP3 : %s", print_r($SELECT_RESULT, true)));
			foreach($SELECT_RESULT as $KEY => $ONE_RESULT) {
				$SAVE_FILE_PATH_MP3 = $ONE_RESULT->YOUTUBE_MEDIA_MP3_PATH;
				break;
			}
			if (strlen($SAVE_FILE_PATH_MP3) <= 0) { // NOT EXIST FROM DB
				$YOUTUBE_URL = sprintf("https://www.youtube.com/watch?v=%s", $args->YOUTUBE_videoId);
				$TODAY = time();
				$SAVE_FILE_PATH_MP3 = sprintf(
					"%s/../../uploads/YOUTUBE_MP3/%s/%s.mp3",
					__DIR__,
					date("Y/m/d", $TODAY),
					$args->YOUTUBE_videoId
				);
				$SAVE_FILE_PATH_WEBM = sprintf(
					"%s/../../uploads/YOUTUBE_MP3/%s/%s.webm",
					__DIR__,
					date("Y/m/d", $TODAY),
					$args->YOUTUBE_videoId
				);
				if (!file_exists(dirname($SAVE_FILE_PATH_MP3))) {
					mkdir(dirname($SAVE_FILE_PATH_MP3), 0777, true);
				}
// error_log(sprintf("SAVE_FILE_PATH_MP3 : %s", $SAVE_FILE_PATH_MP3));
				
				$STR_SHELL_COMMAND = sprintf("youtube-dl -x --audio-format mp3 -o '%s' '%s' ", $SAVE_FILE_PATH_WEBM, $YOUTUBE_URL);
				error_log(sprintf("YOUTUBE_MP3 : STR_SHELL_COMMAND => %s", $STR_SHELL_COMMAND));
				$EXEC_RESULT = shell_exec($STR_SHELL_COMMAND);
//error_log(sprintf("YOUTUBE_MP3 : %s", $EXEC_RESULT));
				$ARGS_DB->YOUTUBE_MEDIA_MP3_PATH = $SAVE_FILE_PATH_MP3;
				$this->INSERT_YOUTUBE_MP3($ARGS_DB);
			}
			$result = $SAVE_FILE_PATH_MP3;
		}

		$filepath = $result;
		if (isset($args->OUT_TYPE) && ($args->OUT_TYPE == 'PATH')) {
			$JSON_RESULT = new stdClass();
			$JSON_RESULT->YOUTUBE_MP3 = sprintf("/wp-content/%s", strstr($filepath, 'uploads'));
			header("Content-Type: text/html; charset=UTF-8");    	
			echo TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($JSON_RESULT));
		} else {
			$filesize = filesize($filepath);
			$path_parts = pathinfo($filepath);
			$filename = $path_parts['basename'];
			$extension = $path_parts['extension'];
			 
			header("Pragma: public");
			header("Expires: 0");
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: $filesize");
			 
			ob_clean();
			flush();
			readfile($filepath);
		}
	}

    public function erase_unwanted_chars($STR) {
//    	$unwantedChars = array(',', '.', '"', '!', '?', '[', ']', '(', ')', "'", "??, "??, "\t", "&quot;");
    	$unwantedChars = array(',', '.', '"', '!', '?', '[', ']', '(', ')', "'", "‘", "’", "\t", "&quot;");
    	$result = str_replace($unwantedChars, '', $STR);
//error_log("BEFORE : " . print_r($result,true));
//error_log("AFTER  : " . print_r($result,true));
//    	return $result;
		return ($STR);
    }

    function IS_TABLE_EXIST($STR_TABLE_NAME) {
		global $wpdb;
		$TABLE_NAME = $wpdb->prefix . $STR_TABLE_NAME;
		$query = "
			SHOW TABLES;
		";		
		$result = $wpdb->get_results($query);
		foreach($result as $ITEM) {
			foreach($ITEM as $VALUE) {
//				error_log($VALUE);
				if ($TABLE_NAME == $VALUE) return true;
			}
		}
		return false;
    }

    
    public function api_SIMILARITY($args) {
//		error_log("ext_func_API_GET_SIMILARITY  : " . print_r($args,true));    	
    	
    	$STRING_TASK_NO_PUNCT = $this->erase_unwanted_chars($args->MISSION_TASK);
    	$STRING_DONE_NO_PUNCT = $this->erase_unwanted_chars($args->MISSION_DONE);
    	
    	$SAY_TASK = new stdClass();
    	$SAY_TASK->MISSION_TASK = $STRING_TASK_NO_PUNCT;
    	$SAY_TASK->MISSION_DONE = $STRING_DONE_NO_PUNCT;
    	
		similar_text(strtolower($STRING_TASK_NO_PUNCT), strtolower($STRING_DONE_NO_PUNCT), $PERCENT);
    	$SAY_TASK->MISSION_POINTS = sprintf("%5.2f",$PERCENT);

		header("Content-Type: text/html; charset=UTF-8");
		echo json_encode($SAY_TASK);
    }

	public function OBJ_TO_GET_PARMS($PARAMS) {
		$mObjVars = get_object_vars($PARAMS);
		$result = ""; $flag_FIRST = true;
		foreach($mObjVars as $Key => $Value) {
			$result .= ($flag_FIRST ? "?" : "&") . $Key . "=" . $Value;
			if ($flag_FIRST) $flag_FIRST = false;
		}
		return $result;
	}

    public function api_GET_TTS_WAV_VOICEWARE($args) {
    	
    	$VOICE_CODE	= isset($args->VOICE_CODE) ? $args->VOICE_CODE : "TTS";
    	
    	$TTS_TEXT	= "TTS ?앹꽦???꾪븳 ?띿뒪?몃? ?꾨떖?섏? ?딆쑝?⑥뒿?덈떎.";

    	$voice_file_path_wav = sprintf("%s/temp/%s.wav", dirname( __FILE__ ), $VOICE_CODE);
    	
		$URL = "http://127.0.0.1:8080/API/?JSON=";

		$OBJ_REQUEST = new \stdClass();
		$OBJ_REQUEST->REQUEST			= "TTS_VW";
		$OBJ_REQUEST->SERVER_TIMEOUT	= 2500;
		$OBJ_REQUEST->SERVER_IP			= "pbx.q1p.win";
		$OBJ_REQUEST->SERVER_PORT		= 7000;
		$OBJ_REQUEST->TTS_FORMAT		= 1;
		$OBJ_REQUEST->TTS_TEXT_FORMAT	= 0;
		$OBJ_REQUEST->TTS_SPEED			= 100;
		$OBJ_REQUEST->TTS_PITCH			= 100;
		$OBJ_REQUEST->TTS_VOLUME		= 100;
		$OBJ_REQUEST->TTS_VOICE			= 14;
		$OBJ_REQUEST->TTS_TEXT			= $TTS_TEXT;
		
		if (isset($args->TTS_SPEED))  $OBJ_REQUEST->TTS_SPEED  = $args->TTS_SPEED;
		if (isset($args->TTS_PITCH))  $OBJ_REQUEST->TTS_PITCH  = $args->TTS_PITCH;
		if (isset($args->TTS_VOLUME)) $OBJ_REQUEST->TTS_VOLUME = $args->TTS_VOLUME;
		if (isset($args->TTS_VOICE))  $OBJ_REQUEST->TTS_VOICE  = $args->TTS_VOICE;
		
		$URL .= urlencode(remove_unicode_escape_sequence(json_encode($OBJ_REQUEST)));

		file_put_contents($voice_file_path_wav,file_get_contents($URL));
		
    	
		$filepath = $voice_file_path_wav;
		$filesize = filesize($filepath);
		$path_parts = pathinfo($filepath);
		$filename = $path_parts['basename'];
		$extension = $path_parts['extension'];
		 
		header("Pragma: public");
		header("Expires: 0");
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: $filesize");
		 
		ob_clean();
		flush();
		readfile($voice_file_path_wav);

		unlink($voice_file_path_wav);
    }

    public function api_GET_PAGE($args) {
		if (!isset($args->FLDR_TEMPLATE)) $args->FLDR_TEMPLATE = "WEBAPPS";
		if (!isset($args->FILE_TEMPLATE)) $args->FILE_TEMPLATE = "WEBAPPS";
		$args->PATH_TEMPLATE = sprintf("%s/%s", $args->FLDR_TEMPLATE, $args->FILE_TEMPLATE);

//		error_log("LSY -> " . print_r($args, true));
		
		$result = "";
//		error_log("checkcheck -> " . print_r($args->FLDR_TEMPLATE, true));
		if (file_exists($args->PATH_TEMPLATE)) {
			if ((isset($args->XE_COMPILE)) && ($args->XE_COMPILE == 'YES')) {
				$STR_CONTENTS = $this->HTML_TEMPLATE_COMPILE(json_encode($args), $args->PATH_TEMPLATE);
			} else {
				$STR_CONTENTS = file_get_contents($args->PATH_TEMPLATE);
			}
			if (isset($args->JSON_ARGS_BASE64)) {
				$STR_CONTENTS = str_replace(
					"#PAGE_ARGS#",
					sprintf("<script>var JSON_ARGS=JSON.parse(Base64.decode('%s'));</script>", $args->JSON_ARGS_BASE64),
					$STR_CONTENTS
				);
			} else {
				$STR_CONTENTS = str_replace(
					"#PAGE_ARGS#",
					"",
					$STR_CONTENTS
				);
			}
			$result = $STR_CONTENTS;
		} else {
			$result = sprintf("<p>파일 %s가 존재하지 않습니다.</p>", $args->PATH_TEMPLATE);
		}

//		error_log("LSY -> " . print_r($args, true));
//		error_log("LSY -> " . print_r($result, true));

		header("Content-Type: text/html; charset=UTF-8");
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence($result);
    }
    

    public function api_GET_FILE($args) {
    	
    	if (!isset($args->FLDR)) $args->FLDR = ".";
    	if (!isset($args->FILE)) $args->FILE = "CONFIG.JSON";
    	
		$PATH_TEMPLATE = sprintf("%s/%s", $args->FLDR, $args->FILE);

		$args->PATH_TEMPLATE = $PATH_TEMPLATE;
		
//		error_log("LSY -> " . print_r($args, true));
		
		if (file_exists($args->PATH_TEMPLATE)) {
			$STR_FILE_CONTENTS = file_get_contents($PATH_TEMPLATE);
			error_log("GET_FILE_EX -> ". $PATH_TEMPLATE);
		} else {
//			$STR_FILE_CONTENTS = sprintf("?뚯씪 %s 媛 議댁옱?섏? ?딆뒿?덈떎.", $args->PATH_TEMPLATE);
			error_log("GET_FILE_NOT_EX -> ". $PATH_TEMPLATE);
			$STR_FILE_CONTENTS = $args->PATH_TEMPLATE;
		}

		header("Content-Type: text/html; charset=UTF-8");
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence($STR_FILE_CONTENTS);
    }
    
    public function api_PUT_FILE($args) {
    	
    	if (!isset($args->FLDR)) $args->FLDR = ".";
    	if (!isset($args->FILE)) $args->FILE = "CONFIG.JSON";
    	if (!isset($args->CONTENTS)) $args->CONTENTS = "";
    	if (isset($args->CONTENTS_BASE64)) $args->CONTENTS = base64_decode($args->CONTENTS_BASE64);
    	
		$PATH_TEMPLATE = sprintf("%s/%s", $args->FLDR, $args->FILE);

		$args->PATH_TEMPLATE = $PATH_TEMPLATE;

		if(!file_exists($args->PATH_TEMPLATE)) mkdir(dirname($args->PATH_TEMPLATE),0777,true);

//		error_log("LSY -> " . print_r($args, true));

		$args->PUT_RESULT = file_put_contents($PATH_TEMPLATE, $args->CONTENTS);

		header("Content-Type: text/html; charset=UTF-8");
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($args));
    }
    
    public function api_EXEC($args) {
    	if (isset($args->SHELL_COMMAND_BASE64)) $args->SHELL_COMMAND = base64_decode($args->SHELL_COMMAND_BASE64);

		$args->TIME_BEFORE = microtime(true);
		$args->EXEC_RESULT = exec($args->SHELL_COMMAND, $arr_output_lines);
		$args->TIME_AFTER  = microtime(true);
		$args->EXEC_OUTPUT_LINES = $arr_output_lines;
		$args->EXEC_OUTPUT_TEXTS = implode("\n", $arr_output_lines);

		header("Content-Type: text/html; charset=UTF-8");
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($args));
    }

	public function HTML_TEMPLATE_COMPILE($STR_JSON_ARGS, $TEMPLATE_FILE_PATH) {
		$content = "";
		$JSON_ARGS = json_decode($STR_JSON_ARGS);
		if (is_object($JSON_ARGS)) {
			$mShellParam = new stdClass();
			$mShellParam->cmd = 'xe_HTML_TEMPLATE_COMPILE';
			$mShellParam->STR_JSON_ARGS = $STR_JSON_ARGS;
			$mShellParam->TEMPLATE_FILE_PATH = $TEMPLATE_FILE_PATH;

// error_log(sprintf("LSY | HTML_TEMPLATE_COMPILE mShellParam : %s ", print_r($mShellParam, true)));

			$TEMP_FILENAME = sprintf("%s/temp/%s.json", dirname( __FILE__ ), md5(microtime()));
			file_put_contents($TEMP_FILENAME, json_encode($mShellParam));
// error_log(sprintf("LSY | HTML_TEMPLATE_COMPILE FILENAME : %s ", $TEMP_FILENAME));
			
			$mShellCommand = 
					"php " .
//					"/usr/local/bin/php " .
					dirname( __FILE__ ) . "/../../../xe/XE_TEMPLATE.php " .
//					"'" . json_encode($mShellParam) . "'";
					"'" . $TEMP_FILENAME . "'";

// error_log(sprintf("LSY | HTML_TEMPLATE_COMPILE mShellCommand : %s ", $mShellCommand));
		
			$time_brfore	= microtime(true);
			exec($mShellCommand, $arr_output_lines);
			$content		= implode("\n", $arr_output_lines);
			$time_after		= microtime(true);
//			error_log(sprintf("LSY | HTML_TEMPLATE_COMPILE FROM SHELL : %d ", strlen($content)));
//			error_log(sprintf("LSY | HTML_TEMPLATE_COMPILE FROM SHELL : %s ", $content));
			error_log(sprintf("LSY | HTML_TEMPLATE_COMPILE FROM SHELL : %f ", $time_after - $time_brfore));
		}
		return $content;
	}
	
    function api_SEND_EMAIL($args) {

    	$RESULT = new stdClass();
    	$RESULT->RESULT = "SUCCESS";
    	$RESULT->RESULT_MSG = "DEFAULT SUCCESS";

    	if (isset($args->JSON_ARGS_BASE64)) {
    		$OBJ_EMAIL_PARAMS = json_decode(base64_decode($args->JSON_ARGS_BASE64));
    		if (is_object($OBJ_EMAIL_PARAMS)) {
    			if (!isset($OBJ_EMAIL_PARAMS->TO)) {
			    	$RESULT->RESULT = "ERROR";
			    	$RESULT->RESULT_MSG = "NO DESTINATION E-MALI ADDRESS SPECFIED!";
    			} else {
	    			if (!isset($OBJ_EMAIL_PARAMS->SUBJECT)) {
						$OBJ_EMAIL_PARAMS->SUBJECT	= 'NO SUBJECT';
					}
	    			if (!isset($OBJ_EMAIL_PARAMS->FROM)) {
						$OBJ_EMAIL_PARAMS->FROM      = 'nautes_system@nautestech.com';
						$OBJ_EMAIL_PARAMS->FROMNAME  = 'NAUTES_SYSTEM';
					}
	    			if (!isset($OBJ_EMAIL_PARAMS->SUBJECT)) {
						$OBJ_EMAIL_PARAMS->SUBJECT   = 'NAUTES SYSTEM AUTO ALARM';
					}
	    			if (!isset($OBJ_EMAIL_PARAMS->CONTENT)) {
						$OBJ_EMAIL_PARAMS->CONTENT   = 'NO CONTENT';
					}
	    			if (!isset($OBJ_EMAIL_PARAMS->TEMPLATE)) {
						$OBJ_EMAIL_PARAMS->TEMPLATE   = 'EMAIL_CONTENTS';
					}

					require_once 'PHPMailer/class.phpmailer.php';
					
					$mMailer = new PHPMailer();
					
					$mMailer->CharSet	= "EUC-KR"; 
					$mMailer->Encoding	= "Base64"; 
					
					$mMailer->From      = $OBJ_EMAIL_PARAMS->FROM;
//					$mMailer->FromName  = $OBJ_EMAIL_PARAMS->FROM_NAME;
					$mMailer->FromName  = iconv("UTF-8", "EUC-KR", $OBJ_EMAIL_PARAMS->FROM_NAME);
					$mMailer->Subject   = iconv("UTF-8", "EUC-KR", $OBJ_EMAIL_PARAMS->SUBJECT);
					
					$PATH_TEMPLATE = sprintf("%s/TEMPLATES/%s/%s.html", dirname(__FILE__), "COMMON", $OBJ_EMAIL_PARAMS->TEMPLATE);
					
					$mMailer->Body = iconv(
						"UTF-8",
						"EUC-KR",
						$this->HTML_TEMPLATE_COMPILE(json_encode($OBJ_EMAIL_PARAMS), $PATH_TEMPLATE)
					);

					
					$mMailer->IsHTML(true);
					
					if (!is_array($OBJ_EMAIL_PARAMS->TO)) {
						$OBJ_EMAIL_PARAMS->TO = array($OBJ_EMAIL_PARAMS->TO);
					}
//error_log("LSY - SEND_EMAIL : " . print_r($OBJ_EMAIL_PARAMS,true));
					
					foreach ($OBJ_EMAIL_PARAMS->TO as $ONE_EMAIL_ADRESS) {
						$mMailer->AddAddress($ONE_EMAIL_ADRESS);
					}

/*
http://nautes.q0p.win/nau?cmd=nau_EMAIL&JSON={"SUBJECT":"NAUTES SYSTEM AUTO ALARM MAIL","CONTENT":"NO CONTENT","FROM":"nautes_system@nautestech.com","FROMNAME":"NAUTES_SYSTEM","TO":["lsy@nautestech.com"],"ATTACHES":["sftp://lsy:dltkddbs@1key.win:22/DATA/home/lsy/hh.java"]}
*/
					
					if (isset($OBJ_EMAIL_PARAMS->ATTACHES)) {
						$TEMP_DIRECTORY = "/tmp/" . md5(time()) . "/";
						mkdir($TEMP_DIRECTORY);
						foreach($OBJ_EMAIL_PARAMS->ATTACHES as $ONE_ATTACH) {
							$OBJ_PARSE_URL = json_decode(json_encode(parse_url($ONE_ATTACH)));
							
							$REMOTE_FILE_NAME = basename($OBJ_PARSE_URL->path);
							$REMOTE_FILE_CONTENTS = file_get_contents("ssh2." . $ONE_ATTACH);
							
							if ($REMOTE_FILE_CONTENTS === false) {
						    	$RESULT->RESULT = "ERROR";
						    	$RESULT->RESULT_MSG = "REMOTE FILE URL [$ONE_ATTACH] IS INVALID!";
						    	break;
							} else {
								$TEMP_FILE_PATH = $TEMP_DIRECTORY . $REMOTE_FILE_NAME;
								$TEMP_FILE_SAVE_RESULT = file_put_contents($TEMP_FILE_PATH, $REMOTE_FILE_CONTENTS);
								if ($TEMP_FILE_SAVE_RESULT === false) {
							    	$RESULT->RESULT = "ERROR";
							    	$RESULT->RESULT_MSG = "LOCAL FILE [$TEMP_FILE_PATH] CREATION PROBLEM!";
							    	break;
								} else {
									$mMailer->AddAttachment( $TEMP_FILE_PATH , $REMOTE_FILE_NAME );
								}
//								unlink($TEMP_FILE_PATH);
							}
						}
//						rmdir($TEMP_DIRECTORY);
					}

// error_log("LSY - SEND_EMAIL : " . print_r($mMailer,true));
					if ($RESULT->RESULT != "ERROR") {
						if ($mMailer->Send()) {
					    	$RESULT->RESULT = "SUCCESS";
					    	$RESULT->RESULT_MSG = "SENDING JOB OF REQUEST MAIL IS SUCCESSED!";
						} else {
					    	$RESULT->RESULT = "ERROR";
					    	$RESULT->RESULT_MSG = "SENDING JOB OF REQUEST MAIL HAS UNKNOWN ERROR!";
						}
					}
					
					if (isset($OBJ_EMAIL_PARAMS->ATTACHES)) {
						foreach($OBJ_EMAIL_PARAMS->ATTACHES as $ONE_ATTACH) {
							$OBJ_PARSE_URL = json_decode(json_encode(parse_url($ONE_ATTACH)));
							$REMOTE_FILE_NAME = basename($OBJ_PARSE_URL->path);
							$TEMP_FILE_PATH = $TEMP_DIRECTORY . $REMOTE_FILE_NAME;
							unlink($TEMP_FILE_PATH);
						}
						rmdir($TEMP_DIRECTORY);
					}
					
    			}
    		} else {
		    	$RESULT->RESULT = "ERROR";
		    	$RESULT->RESULT_MSG = "INVALID JSON ARGUMENT SUPPLIED!";
    		}
    	} else {
	    	$RESULT->RESULT = "ERROR";
	    	$RESULT->RESULT_MSG = "JSON_ARGS_BASE64 ARGUMENT NOT SUPPLIED!";
    	}
//		error_log("LSY - SEND_EMAIL : " . print_r($RESULT,true));
//		error_log("LSY - SEND_EMAIL : " . print_r($OBJ_EMAIL_PARAMS,true));

//		return json_encode($RESULT);
		header("Content-Type: text/html; charset=UTF-8");
		echo TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($RESULT));
    }

    function api_get_daum_keywords($args) {

    	$result = array();
    	
    	$strHTTP = str_get_html(file_get_contents("http://www.daum.net"));

		foreach($strHTTP->find('div') as $element) {
			if (strncmp($element->class, "rank", 4) != 0) {
				continue;
			}
			if($element->find('a')[0]->tabindex != "") {
				continue;
			}
			$result_keyword = "";

			$flag_strong = false;
			foreach($element->find('strong') as $el_strong) {
				$flag_strong = true;
				$result_keyword = $el_strong->innertext;
			}
			if (!$flag_strong) {
				$result_keyword = $element->find('a')[0]->innertext;
			}
//			echo $result_keyword . '<br>';
			$temp_key = trim($result_keyword);
			if (!in_array($temp_key, $result)) {
		    	array_push($result, trim($temp_key));
			}
		}

// error_log("LSY => api_get_daum_keywords : " . TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($result)));
		header("Content-Type: text/html; charset=UTF-8");
		echo json_encode($result);

    }
    
    function api_srch_images($args) {

		$args->srchKeyword	= isset($args->srchKeyword)	  ? $args->srchKeyword	: "";
		$args->pageNumber	= isset($args->pageNumber)	  ? $args->pageNumber	: "1";
		$args->pageNumber	= $args->pageNumber		> 0	  ? $args->pageNumber	: 1;
		$args->listCount	= isset($args->listCount)	  ? $args->listCount	: "100";
		$args->format		= isset($args->format)		  ? $args->format		: "";
		$args->random		= isset($args->random)		  ? $args->random		: "";

		if (strlen($args->srchKeyword) > 0 ) {
			
			$strNaverURL = sprintf(
				"https://openapi.naver.com/v1/search/image?filter=large&query=%s&start=%d&display=%d",
				urlencode($args->srchKeyword), $args->listCount * ($args->pageNumber-1) + 1, $args->listCount);

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $strNaverURL); 
//			curl_setopt($ch, CURLOPT_HTTPHEADER,  0); 
			curl_setopt($ch, CURLOPT_POST,    false); 
			curl_setopt($ch, CURLOPT_USERAGENT, "CURL");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			$headers = array();
			$headers[] = "X-Naver-Client-Id: fRMYAKz_SOfD2nl6ZU6l";
			$headers[] = "X-Naver-Client-Secret: buSPTKcNAF";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$response = curl_exec ($ch);
			$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close ($ch);
			if($status_code == 200) {
//error_log("LSY => " . $response);
				$naverResult = json_decode($response);
			} else {
//error_log("LSY => " . $response);
				$naverResult = "";
			}

			$args->imageTotal = $naverResult->total;

			$args->pageTotal = intval($args->imageTotal / $naverResult->display) + 1;

		}

		if ($args->fmt == "TABLE_FULL") {
//			echo "<xmp>";
			if ($naverResult->total < 1) {
				echo "<div id=\"IMAGES_TOTAL\" style=\"display:none;\">" . 0 . "</div>" . "\n";
				echo "<div id=\"IMAGES_PER_PAGE\" style=\"display:none;\">" . 0 . "</div>" . "\n";
				echo "<tr><td>" . "寃?됱뼱 [" . $args->srchKeyword . "] ??????ъ쭊???놁뒿?덈떎." . "</td></tr>" . "\n";
				echo "<tr><td>" . "<img class=\"NAVER_IMAGE\" width=\"100%\" src=\"" . "http://images.gofreedownload.net/warning-caution-icon-sign-glassy-shiney-clip-art-7842.jpg" . "\">" . "</td></tr>" . "\n";
			} else {
				if (($args->pageNumber < 2) || ($args->SKIP == 'YES')) {
					echo "<div id=\"IMAGES_TOTAL\" style=\"display:none;\">" . $naverResult->total . "</div>" . "\n";
					echo "<div id=\"IMAGES_PER_PAGE\" style=\"display:none;\">" . $naverResult->display . "</div>" . "\n";
				}
				$ARR_RESULT = $naverResult->items;
				foreach($ARR_RESULT as $mKey => $mValue) {
					echo "<tr><td style=\"font-size:0.7em;\">" . $mValue->title . " - (" . $mValue->sizewidth . "," . $mValue->sizeheight . ")</td></tr>" . "\n";
					echo "<tr><td>" . "<img class=\"NAVER_IMAGE\" width=\"100%\" src=\"" . $mValue->link . "\" CAPTION=\"" . $mValue->title . "\">" . "</td></tr>" . "\n";
				}
			}
//			echo "</xmp>";
		} else if ($args->fmt == "TABLE_SMALL") {
//			echo "<xmp>";
			if ($naverResult->total < 1) {
				echo "<div id=\"IMAGES_TOTAL\" style=\"display:none;\">" . 0 . "</div>" . "\n";
				echo "<div id=\"IMAGES_PER_PAGE\" style=\"display:none;\">" . 0 . "</div>" . "\n";
				echo "<tr><td>" . "寃?됱뼱 [" . $args->srchKeyword . "] ??????ъ쭊???놁뒿?덈떎." . "</td></tr>" . "\n";
				echo "<tr><td>" . "<img class=\"NAVER_IMAGE\" width=\"100%\" src=\"" . "http://images.gofreedownload.net/warning-caution-icon-sign-glassy-shiney-clip-art-7842.jpg" . "\">" . "</td></tr>" . "\n";
			} else {
				if (($args->pageNumber < 2) || ($args->SKIP == 'YES')) {
					echo "<div id=\"IMAGES_TOTAL\" style=\"display:none;\">" . $naverResult->total . "</div>" . "\n";
					echo "<div id=\"IMAGES_PER_PAGE\" style=\"display:none;\">" . $naverResult->display . "</div>" . "\n";
				}
				$ARR_RESULT = $naverResult->items;
				foreach($ARR_RESULT as $mKey => $mValue) {
					echo "<tr>\n";
					echo "<td style=\"width:35%;\">" . "<img class=\"NAVER_IMAGE\" width=\"100%\" src=\"" . $mValue->link . "\" CAPTION=\"" . $mValue->title . "\">" . "</td>" . "\n";
					echo "<td rowspan=\"2\" style=\"font-size:0.7em;\">" . $mValue->title . "</td>" . "\n";
					echo "</tr>\n";
					echo "<tr>\n";
					echo "<td style=\"font-size:0.7em;\">" . "(" . $mValue->sizewidth . "," . $mValue->sizeheight . ")</td>" . "\n";
					echo "</tr>\n";
				}
			}
//			echo "</xmp>";
		} else {
			$objJSON = new stdClass();
			$objJSON->naverResult = $naverResult;
			$objJSON->listCount = $args->listCount;
			echo json_encode($objJSON) ;
		}

//		error_log("LSY - args : " . print_r($args,true));
//		error_log("LSY - objJSON : " . print_r($objJSON,true));

    }

}
    
?>

