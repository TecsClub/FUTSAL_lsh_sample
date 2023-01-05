<?php
if (!class_exists('MyCrypt')) {
	require_once dirname( __FILE__ ) . "/MyCrypt.php";
}

class POST_UTIL {

    function MERGE_AND_UPDATE_OBJECT($objA, $objB) {
//error_log("MERGE_AND_UPDATE_OBJECT : " . print_r($objB, true));
    	$objBVars = get_object_vars($objB);
		foreach($objBVars as $Key => $Value) {
			$objA->$Key = $objB->$Key;
		}
    	return $objA;
    }

    function IS_OBJECT_IDENTICAL($objA, $objB) {
    	$objBVarsA = get_object_vars($objA);
		foreach($objBVarsA as $Key => $Value) {
			if ($objA->$Key != $objB->$Key) {
				return false;
			}
		}

    	$objBVarsB = get_object_vars($objB);
		foreach($objBVarsB as $Key => $Value) {
			if ($objA->$Key != $objB->$Key) {
				return false;
			}
		}
		
    	return true;
    }

    function GET_MY_CATEGORY_ID($str_category_name) {
		$temp = wp_insert_term( $str_category_name, 'category');
		if ($temp instanceof WP_Error) {
//			error_log("LSY | GET_MY_CATEGORY_ID : " . print_r($temp, true));
			$result = $temp->error_data['term_exists'];
		} else {
			$result = $temp['term_id'];
		}
		return $result;
    }

    function GET_OLEAF_ON_PERIOD($POST_ID, $STR_DATE_FROM, $STR_DATE_TO) {
		global $wpdb;
		$query = "
		        SELECT      *
		        FROM        $wpdb->comments
		        WHERE       $wpdb->comments.comment_post_ID = '$POST_ID'
		        AND         $wpdb->comments.comment_date >= '$STR_DATE_FROM'
		        AND         $wpdb->comments.comment_date <= '$STR_DATE_TO'
		        ORDER BY    $wpdb->comments.comment_date desc
		";
		$result = $wpdb->get_results($query);
//error_log("GET_OLEAF_ON_TODAY : " . print_r($result,true) );
    	return $result;
    }

	function GET_ENCODED_STR_UPDATED_LEAF_AS_LOG($O_CUR_LEAF_CONTENT, $OBJ_UPDATE) {
		$oMyCrypt = new MyCrypt();
		if (isset($O_CUR_LEAF_CONTENT->ARRAY_ACCESS_LOG)) {
			$ARRAY_ACCESS_LOG = $O_CUR_LEAF_CONTENT->ARRAY_ACCESS_LOG;
		} else {
			$ARRAY_ACCESS_LOG = array();
		}
		
		$OBJ_UPDATE = $this->GET_STR_JSON_TO_JSON($OBJ_UPDATE);
		
		$NEW_ACCESS_LOG = new stdClass();
		$NEW_ACCESS_LOG->DATE_TIME = date("Y-m-d H:i:s");
//		$NEW_ACCESS_LOG->REQ = $OBJ_UPDATE->REQ;
//		$ARGS = clone $OBJ_UPDATE;
		
		if (isset($OBJ_UPDATE->STR_JSON_LOG)) {
			$NEW_ACCESS_LOG->OBJ_LOG = $OBJ_UPDATE->STR_JSON_LOG;
		} else if (isset($OBJ_UPDATE->STR_LOG)) {
			$NEW_ACCESS_LOG->OBJ_LOG = $OBJ_UPDATE->STR_LOG;
		} else if (isset($OBJ_UPDATE->JSON_LOG)) {
			$NEW_ACCESS_LOG->OBJ_LOG = $OBJ_UPDATE->JSON_LOG;
		} else {
			$NEW_ACCESS_LOG->OBJ_LOG = $OBJ_UPDATE;
		}

		array_unshift($ARRAY_ACCESS_LOG, $NEW_ACCESS_LOG);

//		error_log(print_r($NEW_ACCESS_LOG, true));
		
		$O_NEW_LEAF_CONTENT =  new stdClass();		
		$O_NEW_LEAF_CONTENT->ARRAY_ACCESS_LOG = $ARRAY_ACCESS_LOG;
		$STR_RESULT = $oMyCrypt->encrypt(TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($O_NEW_LEAF_CONTENT)));
//		$STR_RESULT = $oMyCrypt->encrypt((json_encode($O_NEW_LEAF_CONTENT)));

		return $STR_RESULT;
	}
	
	function GET_STR_JSON_TO_JSON($STR_JSON) {
		if (is_object($STR_JSON)) {
			$OBJ_RESULT = clone($STR_JSON);
//error_log("GET_STR_JSON_TO_JSON : OBJ_RESULT : " . print_r($OBJ_RESULT,true ));
			$ALL_KEYS = get_object_vars($OBJ_RESULT);
//error_log("GET_STR_JSON_TO_JSON : ALL_KEYS : " . print_r($ALL_KEYS,true ));
			foreach($ALL_KEYS as $ONE_KEY => $ONE_ITEM) {
//error_log(sprintf("GET_STR_JSON_TO_JSON : %s => %s", $ONE_KEY, print_r($ONE_ITEM, true)));
				$OBJ_RESULT->$ONE_KEY = $this->GET_STR_JSON_TO_JSON($ONE_ITEM);
			}
			return $OBJ_RESULT;
		} else if (is_array($STR_JSON)) {
			$ARR_RESULT = array();
			foreach($STR_JSON as $ONE_ITEM) {
				array_push($ARR_RESULT, $this->GET_STR_JSON_TO_JSON($ONE_ITEM));
			}
			return $ARR_RESULT;
		} else if (is_string($STR_JSON)) {
			$TEMP_OBJECT = json_decode(stripslashes($STR_JSON));
			if (is_object($TEMP_OBJECT)) {
				return $this->GET_STR_JSON_TO_JSON($TEMP_OBJECT);
			} else if (is_array($TEMP_OBJECT)) {
				return $this->GET_STR_JSON_TO_JSON($TEMP_OBJECT);
			} else {
				return $STR_JSON;
			}
		} else {
			return $STR_JSON;
		}
	}

	function GET_LOG_LIST($argsPARAM) {
		$args = clone $argsPARAM;
		$ARRAY_ACCESS_LOG = array();
		if (isset($args->PHONE_NO)) {
			$SRCH_TITLE = $args->PHONE_NO;
			$temp = $this->GET_OPOST_BY_CATEGORY_AND_TITLE_LIKE( $args->SVC_CATEGORY , $SRCH_TITLE);
			if (count($temp) > 0) {
				$oMyCrypt = new MyCrypt();
				foreach($temp as $oPost) {
					$TODAY = time();
					$STR_DATE_FROM	= date("Y-m-d 00:00:00", $TODAY);
					if (isset($args->STR_DATE_FROM)) {
						$STR_DATE_FROM	= substr($args->STR_DATE_FROM,0,10) . " 00:00:00";
					}
					$STR_DATE_TO	= date("Y-m-d 23:59:59", $TODAY);
					if (isset($args->STR_DATE_TO)) {
						$STR_DATE_TO	= substr($args->STR_DATE_TO,0,10)   . " 23:59:59";
					}
					$ARRAY_OBJ_LEAF = $this->GET_OLEAF_ON_PERIOD($oPost->ID, $STR_DATE_FROM, $STR_DATE_TO);
					foreach($ARRAY_OBJ_LEAF as $OBJ_LEAF) {
						$O_CUR_COMMENT_CONTENT = json_decode($oMyCrypt->decrypt($OBJ_LEAF->comment_content));
						foreach($O_CUR_COMMENT_CONTENT->ARRAY_ACCESS_LOG as $OBJ_ACCESS_LOG) {
							$OBJ_ACCESS_LOG = $this->GET_STR_JSON_TO_JSON($OBJ_ACCESS_LOG);
//error_log("GET_LOG_LIST : OBJ_ACCESS_LOG : " . print_r($OBJ_ACCESS_LOG,true ));
							if (isset($args->STR_FILTER)) {
								$ARRAY_STR_FILTER = explode(",", $args->STR_FILTER);
								$FLAG_FILTER_PASS = true;
								foreach($ARRAY_STR_FILTER as $ONE_FILTER) {
									if (strpos(json_encode($OBJ_ACCESS_LOG), $ONE_FILTER) === false) {
										$FLAG_FILTER_PASS = false; break;
									}
								}
								if ($FLAG_FILTER_PASS) {
//									array_unshift($ARRAY_ACCESS_LOG, $OBJ_ACCESS_LOG);
									array_push($ARRAY_ACCESS_LOG, $OBJ_ACCESS_LOG);
								}
							} else {
//								array_unshift($ARRAY_ACCESS_LOG, $OBJ_ACCESS_LOG);
								array_push($ARRAY_ACCESS_LOG, $OBJ_ACCESS_LOG);
							}
						}
					}
					break;
				}
			}
		}
// error_log("GET_LOG_LIST : ARRAY_ACCESS_LOG : " . print_r($ARRAY_ACCESS_LOG,true ));
		return json_encode($ARRAY_ACCESS_LOG);
	}

	function MY_ARRAY_PUSH($OBJ_ROOT, $ARRAY_NAME, $ARRAY_UNIQUE_KEY, $OBJ_UPDATE) {
//error_log("ROOT =>" . print_r($OBJ_ROOT, true));
		if (!isset($OBJ_ROOT->$ARRAY_NAME)) {
			$OBJ_ROOT->$ARRAY_NAME = array();
		}
		$FLAG_REPLACE = false;
		foreach($OBJ_ROOT->$ARRAY_NAME as $INDEX => $ONE_ITEM) {
			if ($ONE_ITEM->$ARRAY_UNIQUE_KEY == $OBJ_UPDATE->$ARRAY_UNIQUE_KEY) {
				array_splice($OBJ_ROOT->$ARRAY_NAME, $INDEX, 1, array($OBJ_UPDATE));
				$FLAG_REPLACE = true;
				break;
			}
		}
		if (!$FLAG_REPLACE) {
			array_push($OBJ_ROOT->$ARRAY_NAME, $OBJ_UPDATE);
		}
//error_log("ROOT AFTER =>" . print_r($OBJ_ROOT, true));
		return $OBJ_ROOT;
	}

    function GET_OPOST_BY_CATEGORY_AND_TITLE_LIKE($STR_CATEGOTY, $STR_TITLE) {
		global $wpdb;
		$CATEGORY_ID = $this->GET_MY_CATEGORY_ID($STR_CATEGOTY);
		$query = "
		        SELECT      *
		        FROM        $wpdb->posts
		        LEFT JOIN   $wpdb->term_relationships
		        ON          $wpdb->posts.ID = $wpdb->term_relationships.object_id
		        WHERE       $wpdb->posts.post_title LIKE '%$STR_TITLE%'
		        AND         $wpdb->term_relationships.term_taxonomy_id = $CATEGORY_ID
		        ORDER BY    $wpdb->posts.post_title
		";
		$result = $wpdb->get_results($query);
//		error_log("GET_OPOST_BY_CATEGORY_AND_TITLE_LIKE : " . print_r($query,true) );
//		error_log("GET_OPOST_BY_CATEGORY_AND_TITLE_LIKE : " . print_r($result,true) );
    	return $result;
    }

    function GET_OPOST_BY_CATEGORY_AND_TITLE($STR_CATEGOTY, $STR_TITLE) {
		global $wpdb;
		$CATEGORY_ID = $this->GET_MY_CATEGORY_ID($STR_CATEGOTY);
		$query = "
		        SELECT      *
		        FROM        $wpdb->posts
		        LEFT JOIN   $wpdb->term_relationships
		        ON          $wpdb->posts.ID = $wpdb->term_relationships.object_id
		        WHERE       $wpdb->posts.post_title LIKE '$STR_TITLE%'
		        AND         $wpdb->term_relationships.term_taxonomy_id = $CATEGORY_ID
		        ORDER BY    $wpdb->posts.post_title
		";
		$result = $wpdb->get_results($query);
//		error_log("GET_OPOST_BY_CATEGORY_AND_TITLE : " . print_r($result,true) );
    	return $result;
    }

    function GET_OLEAF_ON_TODAY($POST_ID) {
		global $wpdb;
//		$TODAY = substr(date("Y-m-d H:i"),0,12);
		$TODAY = date("Y-m-d");
		$query = "
		        SELECT      *
		        FROM        $wpdb->comments
		        WHERE       $wpdb->comments.comment_post_ID = '$POST_ID'
		        AND         $wpdb->comments.comment_date LIKE '$TODAY%'
		        ORDER BY    $wpdb->comments.comment_date
		";
		$result = $wpdb->get_results($query);
//error_log("GET_OLEAF_ON_TODAY : " . print_r($result,true) );
    	return $result;
    }

	function GET_POST_ROOT($args) {
//error_log("GET_POST_ROOT : " . print_r($args, true));
		$oMyCrypt = new MyCrypt();
//		$result = json_encode(new stdClass());
		$result = "";
		if (isset($args->PHONE_NO)) {
			if ($args->PHONE_NO == 'NOT_GRANTED') {
				$temp_result = new stdClass();
				$temp_result->AGREEMENT	= $args->PHONE_NO;
				$result = json_encode($temp_result);
			} else {
				$SRCH_TITLE = $args->PHONE_NO;
				$temp = $this->GET_OPOST_BY_CATEGORY_AND_TITLE_LIKE( $args->SVC_CATEGORY , $SRCH_TITLE);
				if (count($temp) > 0) {
					foreach($temp as $oPost) {
						$OBJ_TITLE_NEW	= new stdClass();
						$OBJ_TITLE_NEW->PHONE_ID = $args->PHONE_ID;
						$OBJ_TITLE_NEW->PHONE_NO = $args->PHONE_NO;

						$OBJ_TITLE_ORIGINAL = json_decode($oPost->post_title);
						$OBJ_TITLE_UPDATE = json_decode($oPost->post_title);
						$OBJ_TITLE_UPDATE = $this->MERGE_AND_UPDATE_OBJECT($OBJ_TITLE_UPDATE, $OBJ_TITLE_NEW);
/*
						if (!$this->IS_OBJECT_IDENTICAL($OBJ_TITLE_ORIGINAL, $OBJ_TITLE_UPDATE)) {
							$args->OBJ_UPDATE = new stdClass();
							$args->OBJ_UPDATE->PHONE_NO = $args->PHONE_NO;
							$args->OBJ_UPDATE->AGREEMENT= "USIM_CHANGED";
							$args->TITLE_UPDATE = json_encode($OBJ_TITLE_UPDATE);
							$this->UPDATE_POST_ROOT($args);
							
							$temp_result = $oMyCrypt->decrypt($oPost->post_content);
							$json_temp_result = json_decode($temp_result);
							$json_temp_result->PHONE_NO		= $args->PHONE_NO;
							$json_temp_result->AGREEMENT	= "USIM_CHANGED";
							$result = json_encode($json_temp_result);
//error_log("GET_POST_ROOT : " . print_r($result, true));
						} else {
							$result = $oMyCrypt->decrypt($oPost->post_content);
						}
*/
						$result = $oMyCrypt->decrypt($oPost->post_content);
						break;
					}
				}
			}
		}
//error_log("GET_POST_ROOT : " . print_r($result, true));
		return $result;
	}

	function UPDATE_POST_ROOT($args) {
		$oMyCrypt = new MyCrypt();
		$SRCH_TITLE = $args->PHONE_NO;
		
		$OBJ_TITLE	= new stdClass();
		if (isset($args->USER_CATEGORY)) {
			$OBJ_TITLE->USER_CATEGORY = $args->USER_CATEGORY;
		}
		$OBJ_TITLE->PHONE_ID = $args->PHONE_ID;
		$OBJ_TITLE->PHONE_NO = $args->PHONE_NO;
		$POST_TITLE = json_encode($OBJ_TITLE);

		$ARRAY_ATTACHES = array();
		if (isset($args->ATTACH)) {
			foreach($args->ATTACH as $KEY_NAME => $ONE_ATTACH) {
				$UNIQUE_KEY = (substr($ONE_ATTACH['tmp_name'],strrpos($ONE_ATTACH['tmp_name'],"/") + 1));
				$TODAY = time();
				$SAVE_FILE_PATH = sprintf(
					"%s/../../uploads/%s/%s_%s",
					__DIR__,
					date("Y/m/d", $TODAY),
					$UNIQUE_KEY,
					$ONE_ATTACH['name']
				);
				if (!file_exists(dirname($SAVE_FILE_PATH))) {
					mkdir(dirname($SAVE_FILE_PATH), 0777, true);
				}
				rename($ONE_ATTACH['tmp_name'], $SAVE_FILE_PATH);
				$ONE_ATTACH['tmp_name'] = $SAVE_FILE_PATH;
				$ONE_ATTACH_INFO = new stdClass();
				$ONE_ATTACH_INFO->STR_KEY	= $KEY_NAME;
				$ONE_ATTACH_INFO->STR_FILE = $ONE_ATTACH['name'];
				$ONE_ATTACH_INFO->STR_PATH = substr($ONE_ATTACH['tmp_name'], strpos($ONE_ATTACH['tmp_name'], "/uploads"));
				$ONE_ATTACH_INFO->STR_URL  = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/wp-content" . $ONE_ATTACH_INFO->STR_PATH;
				array_push($ARRAY_ATTACHES, $ONE_ATTACH_INFO);
// error_log(sprintf("ONE_ATTACH %s => %s", $KEY_NAME, print_r($ONE_ATTACH, true)));
			}
		}
// error_log(sprintf("ARRAY_ATTACHES %s", print_r($ARRAY_ATTACHES, true)));
// error_log(sprintf("_SERVER %s", print_r($_SERVER, true)));
		
		$temp = $this->GET_OPOST_BY_CATEGORY_AND_TITLE_LIKE( $args->SVC_CATEGORY , $SRCH_TITLE);

		if (count($temp) > 0) {

//error_log("GET_OPOST_BY_CATEGORY_AND_TITLE_LIKE count > 0 ");

			foreach($temp as $oPost) {
				$mObjectRootContents = json_decode($oMyCrypt->decrypt($oPost->post_content));

//				error_log("mObjectRootContents : BEFORE " . print_r($mObjectRootContents, true));
//				error_log("mObjectRootContents : OBJ_UPDATE " . print_r($args->OBJ_UPDATE, true));
				if(isset($args->OBJ_UPDATE->ATTACHES)) {
					$mObjectRootContents->ATTACHES = $args->OBJ_UPDATE->ATTACHES;
				}

				$ARRAY_ATTACHES_PREV = array();
				if (isset($mObjectRootContents->ATTACHES)) {
					$ARRAY_ATTACHES_PREV = $mObjectRootContents->ATTACHES;
				}
				if (isset($args->STR_JSON_ATTACH_REMOVES)) {
					if (is_string($args->STR_JSON_ATTACH_REMOVES)) {
						$ATTACH_REMOVES = json_decode(stripslashes($args->STR_JSON_ATTACH_REMOVES));
					} else {
						$ATTACH_REMOVES = $args->STR_JSON_ATTACH_REMOVES;
					}
					foreach($ATTACH_REMOVES as $ONE_PATH) {
						$ARRAY_ATTACHES_PREV_NEW = array();
						foreach($ARRAY_ATTACHES_PREV as $ONE_ATTACH) {
							if ($ONE_ATTACH->STR_PATH != $ONE_PATH) {
								array_push($ARRAY_ATTACHES_PREV_NEW, $ONE_ATTACH);
							} else {
								$STR_FILE_FOR_REMOVE = 
									sprintf(
										"%s/../..%s",
										__DIR__,
										$ONE_ATTACH->STR_PATH
									);
//error_log(sprintf("SHOULD REMOVE ATTACH FILE %s", $STR_FILE_FOR_REMOVE));
								unlink($STR_FILE_FOR_REMOVE);
							}
						}
						$ARRAY_ATTACHES_PREV = $ARRAY_ATTACHES_PREV_NEW;
					}
				}
				if ((count($ARRAY_ATTACHES) > 0) || isset($mObjectRootContents->ATTACHES)) {
					if (isset($args->ATTACH_LEAF)) {
						if (!isset($args->OBJ_LEAF)) $args->OBJ_LEAF = new stdClass();
						$args->OBJ_LEAF->ATTACHES = $ARRAY_ATTACHES;
					} else {
						$args->OBJ_UPDATE->ATTACHES = array_merge($ARRAY_ATTACHES_PREV, $ARRAY_ATTACHES);
					}
				}

				if (isset($args->OBJ_UPDATE->TITLE_UPDATE)) {
					$POST_TITLE = json_encode($args->OBJ_UPDATE->TITLE_UPDATE);
					unset($args->OBJ_UPDATE->TITLE_UPDATE);
				} else {
					$POST_TITLE = $oPost->post_title;
				}

				if (isset($args->ARRAY_NAME)) {
					$mObjectRootContents = $this->MY_ARRAY_PUSH($mObjectRootContents, $args->ARRAY_NAME, $args->ARRAY_UNIQUE_KEY, $args->OBJ_UPDATE);
				} else {
					$mObjectRootContents = $this->MERGE_AND_UPDATE_OBJECT($mObjectRootContents, $args->OBJ_UPDATE);
				}
//				error_log("mObjectRootContents : AFTER " . print_r($mObjectRootContents, true));
//				error_log("oPost : " . print_r($oPost, true));

				$update_post_args = array(
					'ID'			=> $oPost->ID,
					'post_title'    => $POST_TITLE,
					'post_content'	=> $oMyCrypt->encrypt(TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($mObjectRootContents)))
//					'post_content'	=> $oMyCrypt->encrypt((json_encode($mObjectRootContents)))
				);
//				remove_action('pre_post_update', 'wp_save_post_revision');	// stop revisions
				$O_POST_ID = wp_update_post( $update_post_args );
//				add_action('pre_post_update', 'wp_save_post_revision');		// enable revisions again
			}
		} else {
//error_log("GET_OPOST_BY_CATEGORY_AND_TITLE_LIKE count <= 0 ");
			$POST_DATA = array(
			  'post_title'    => $POST_TITLE,
			  'post_content'  => $oMyCrypt->encrypt(TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($args->OBJ_UPDATE))),
//			  'post_content'  => $oMyCrypt->encrypt((json_encode($args->OBJ_UPDATE))),
			  'post_status'   => 'publish',
			  'post_author'   => 1,
			  'post_category' => array( $this->GET_MY_CATEGORY_ID( $args->SVC_CATEGORY ) ),
			  'post_category_name' => $args->SVC_CATEGORY
			);
	    	$O_POST_ID = wp_insert_post( $POST_DATA );
		}
//		error_log("LSY O_POST_RESULT => " . print_r($O_POST_RESULT, true));

		if (isset($args->OBJ_LEAF)) {
			$ARR_OBJ_LEAF = $this->GET_OLEAF_ON_TODAY($O_POST_ID);
			if (count($ARR_OBJ_LEAF) > 0) {
				$FLAG_ALL_BIG = true;
				foreach($ARR_OBJ_LEAF as $OBJ_LEAF) {
//error_log("comment_content LENGTH : " . strlen($OBJ_LEAF->comment_content));
					if (strlen($OBJ_LEAF->comment_content) >= 65000) continue;
					$FLAG_ALL_BIG = false;
					$update_array = array();
					$update_array['comment_ID'] = $OBJ_LEAF->comment_ID;
					$O_CUR_COMMENT_CONTENT = json_decode($oMyCrypt->decrypt($OBJ_LEAF->comment_content));
					$update_array['comment_content'] = $this->GET_ENCODED_STR_UPDATED_LEAF_AS_LOG($O_CUR_COMMENT_CONTENT, $args->OBJ_LEAF);
					$IS_SUCCESS = wp_update_comment( $update_array );
					$O_COMMENT_ID = $OBJ_LEAF->comment_ID;
				}
				if ($FLAG_ALL_BIG) {
					$this->SAVE_TO_NEW_COMMENT($args, $O_POST_ID);
				}
			} else {
				$this->SAVE_TO_NEW_COMMENT($args, $O_POST_ID);
			}
		}
	}

	function SAVE_TO_NEW_COMMENT($args, $O_POST_ID) {
		$time = current_time('mysql');
		$data = array(
		    'comment_post_ID' => $O_POST_ID,
		    'comment_author' => (strlen($args->PHONE_NO) > 0) ? $args->PHONE_NO : $args->PHONE_ID,
//		    'comment_author_email' => 'admin@admin.com',
//		    'comment_author_url' => 'http://',
		    'comment_content' => $this->GET_ENCODED_STR_UPDATED_LEAF_AS_LOG(new stdClass(), $args->OBJ_LEAF),
		    'comment_type' => '',
		    'comment_parent' => 0,
		    'user_id' => 1,
		    'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
	    	'comment_agent' => $_SERVER['HTTP_USER_AGENT'],
		    'comment_date' => $time,
		    'comment_approved' => 1,
		);
		$O_COMMENT_ID = wp_insert_comment($data);
	}

    function GET_ALL_ROOT_ATTRIBUTE($args) {

//error_log(sprintf("GET_ALL_ROOT_ATTRIBUTE : %s", print_r($args, true)));

    	$oMyCrypt = new MyCrypt();

    	$oResultArray = array();
    	if (isset($args->SEARCH_KEY) && strlen($args->SEARCH_KEY) > 0) {
    		if (isset($args->ATTR_KEY) && strlen($args->ATTR_KEY) > 0) {
		    	$ATTR_KEY = $args->ATTR_KEY;
		    	$TEMP = $this->GET_OPOST_BY_CATEGORY_AND_TITLE_LIKE( $args->SVC_CATEGORY , $args->SEARCH_KEY);
//error_log(sprintf("GET_ALL_ROOT_ATTRIBUTE TEMP %s", print_r($TEMP, true)));
		    	foreach($TEMP as $ONE_POST) {
		    		$OBJ_POST_CONTENTS = json_decode($oMyCrypt->decrypt($ONE_POST->post_content));
			    	if (isset($args->PHP_FILTER)) {
						require( __DIR__ . '../../../index.php' );
//			    		$PHP_FILTER = str_replace("POST_CONTENTS->", "\$OBJ_POST_CONTENTS->\$", $args->PHP_FILTER);
//			    		$TEMP_RESULT = eval($PHP_FILTER);
			    		$TEMP_RESULT = eval($args->PHP_FILTER);
			    		if ($TEMP_RESULT != NULL) {
				    		$OBJ_TO_ADD = new stdClass();
				    		$OBJ_TO_ADD->PHONE_ID	= $OBJ_POST_CONTENTS->PHONE_ID;
				    		$OBJ_TO_ADD->PHONE_NO	= $OBJ_POST_CONTENTS->PHONE_NO;
				    		$OBJ_TO_ADD->$ATTR_KEY	= $TEMP_RESULT;
							array_push($oResultArray, $OBJ_TO_ADD);
			    		}
			    	} else {
			    		$OBJ_TO_ADD = new stdClass();
			    		$OBJ_TO_ADD->PHONE_ID	= $OBJ_POST_CONTENTS->PHONE_ID;
			    		$OBJ_TO_ADD->PHONE_NO	= $OBJ_POST_CONTENTS->PHONE_NO;
			    		$OBJ_TO_ADD->$ATTR_KEY	= $OBJ_POST_CONTENTS->$ATTR_KEY;
						array_push($oResultArray, $OBJ_TO_ADD);
			    	}
		    	}
    		}
    	}
//    	error_log(sprintf("GET_ALL_ROOT_ATTRIBUTE : %s", print_r($oResultArray, true)));
    	return TECS_CLUB_UTILS::remove_unicode_escape_sequence(json_encode($oResultArray));
    }

    function IS_MEMBER($SVC_CATEGORY, $PHONE_NO) {
    	$TEMP = $this->GET_OPOST_BY_CATEGORY_AND_TITLE_LIKE( $SVC_CATEGORY , $PHONE_NO);
    	$FLAG_IS_MEMBER = false;
    	foreach($TEMP as $ONE_POST) {
    		$FLAG_IS_MEMBER = true; break;
    	}
    	return $FLAG_IS_MEMBER;
    }

    function FILTER_CONTACTS($args) {
    	$VARS = json_decode($args->VARS);
    	
    	$oMyCrypt = new MyCrypt();
    	$oResultArray = array();
    	foreach($VARS->JSON_ARRAY_CONTACTS as $ONE_CONTACTS) {
    		$ONE_CONTACTS_CLONE = clone $ONE_CONTACTS;
    		if ($this->IS_MEMBER($args->SVC_CATEGORY, $ONE_CONTACTS->NUMBER)) {
    			$ONE_CONTACTS_CLONE->MEMBER = true;
	    		array_push($oResultArray, $ONE_CONTACTS_CLONE);
    		} else {
    			$ONE_CONTACTS_CLONE->MEMBER = false;
    			if (true) {
		    		array_push($oResultArray, $ONE_CONTACTS_CLONE);
    			}
    		}
    	}
    	$VARS->JSON_ARRAY_CONTACTS = $oResultArray;
    	$result = remove_unicode_escape_sequence(json_encode($VARS));
//    	$result = (json_encode($VARS));
    	return $result;
    }

    function FIND_ALL_GCM_REGIST_ID_AND_SEND_GCM_MESSAGE($args) {

    	$oMyCrypt = new MyCrypt();
    	$oResultArray = array();
    	
    	if (isset($args->SEARCH_KEY) && strlen($args->SEARCH_KEY) > 0) {
    		
	    	$TEMP = $this->GET_OPOST_BY_CATEGORY_AND_TITLE_LIKE( $args->SVC_CATEGORY , $args->SEARCH_KEY);

	    	foreach($TEMP as $ONE_POST) {
	    		$OBJ_POST_CONTENT = json_decode($oMyCrypt->decrypt($ONE_POST->post_content));
	    		// It is ALL THE SAME
	    		$GCM_API_KEY = $OBJ_POST_CONTENT->GCM_API_KEY;
				array_push($oResultArray, $OBJ_POST_CONTENT->GCM_REGIST_ID);
	    	}
	    	if (isset($args->JSON_STR_PLAIN)) {
//error_log('FIND_ALL_GCM_REGIST_ID_AND_SEND_GCM_MESSAGE : JSON_STR_PLAIN => ' . print_r($args->JSON_STR_PLAIN,true));
//error_log('FIND_ALL_GCM_REGIST_ID_AND_SEND_GCM_MESSAGE : JSON_STR_PLAIN => ' . print_r(stripslashes($args->JSON_STR_PLAIN),true));
	    		$args->JSON_STR_GCM_DATA = $oMyCrypt->encrypt(stripslashes($args->JSON_STR_PLAIN));
	    	}

			$PHP_GCMPushMessage = dirname( __FILE__ ) . "/GCMPushMessage.php";
			if (file_exists($PHP_GCMPushMessage)) {
				require_once $PHP_GCMPushMessage;

				$oGCM_Sender = new GCMPushMessage($GCM_API_KEY);
				$oGCM_Sender->setDevices($oResultArray);
				$RESULT_OF_oGCM_Sender = $oGCM_Sender->send($args->JSON_STR_GCM_DATA);
			}

//			error_log(print_r($RESULT_OF_oGCM_Sender,true));
    	}

		$args->JSON_STR_GCM_DATA = $oMyCrypt->decrypt($args->JSON_STR_GCM_DATA);
		
		if (isset($args->JSON_STR_GCM_DATA->GCM_MODE)) {
			if (strpos($args->JSON_STR_GCM_DATA->GCM_MODE, "LOCATION") === false) {
			} else {
error_log(print_r($oMyCrypt->decrypt($args->JSON_STR_GCM_DATA),true));

		    	$args->OBJ_LEAF		= $this->GET_LOG_OBJECT($args);
				$args->OBJ_UPDATE	= new stdClass();
				$this->UPDATE_POST_ROOT($args);
			}
		}
    	
//    	return remove_unicode_escape_sequence(stripslashes(json_encode($RESULT_OF_oGCM_Sender)));
    	return stripslashes($RESULT_OF_oGCM_Sender);
//    	return (json_encode($RESULT_OF_oGCM_Sender));
    }    
    
}
    
?>

