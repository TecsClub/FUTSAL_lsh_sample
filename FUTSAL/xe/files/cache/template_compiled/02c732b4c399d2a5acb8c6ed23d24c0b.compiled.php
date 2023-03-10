<?php if(!defined("__XE__"))exit;?><script>
var USER_DATA = {};
var USER_DATA_FOR_CONTENT = {};
function TT(args_JSON) {
	QIIP_JQX_POPUP_WINDOW({
        showCollapseButton: true, 
        height: '80%',
        width: '80%',
        minHeight: 100,
        minWidth: 100,
		},
		'TT',
		'<xmp>' + JSON.stringify(args_JSON, null, '\t') + '</xmp>'
	);
	
}
function INIT_WIDGETS_FOR_CONTENTS(){
	GET_USER_DATA();
}
function GET_USER_DATA() {
	var PHP_CODES  = '';
		PHP_CODES += 'return json_encode(wp_get_current_user());';
	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if ('ID' in JSON_RESULT) {
				USER_DATA = JSON_RESULT;
				GET_USER_META(USER_DATA.ID);
			} else {
				// NO_LOGIN CASE
			}
		}
	);
	
}
function GET_USER_META(ID) {
	var PHP_CODES  = '';
		PHP_CODES += '$META_RESULT = json_encode(get_user_meta(';
		PHP_CODES += ID;
		PHP_CODES += '));';
		PHP_CODES += 'return $META_RESULT;';
		
	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			
			if ('NOOL_NAME' in JSON_RESULT) {
				USER_DATA.data.META = JSON_RESULT;
				USER_DATA_FOR_CONTENT = USER_DATA;
				if(USER_DATA.allcaps.level_1) {
					GET_ALL_USER_DATA();
				} else {
					LOAD_MOTION_DATA();
				}
				
/*
				$('#DIV_CONTENTS').html(
					'<xmp>' + JSON.stringify(USER_DATA, null, '\t') + '</xmp>'
				);
*/
			} else {
				LOAD_PAGE_FOR_INPUT_USER_META_DATA(USER_DATA);
			}
		}
	);
	
}
var ALL_USER_DATA = {
};
function GET_ALL_USER_DATA() {
	var PHP_CODES  = '';
		PHP_CODES += '$RESULT_USER_LIST = array();';
		PHP_CODES += '$USER_LIST = get_users();';
		PHP_CODES += 'foreach($USER_LIST as $ONE_USER) { ';
		PHP_CODES += '	$ONE_USER->META = get_user_meta($ONE_USER->ID);';
		PHP_CODES += '	array_push($RESULT_USER_LIST, $ONE_USER);';
		PHP_CODES += '}';
		PHP_CODES += 'return $RESULT_USER_LIST;';
		
	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			ALL_USER_DATA = JSON_RESULT;
//			TT(ALL_USER_DATA);
			POPUP_USER_SELECT();
			LOAD_ADMIN_DIV_HEADER();
		}
	);
	
}
function LOAD_ADMIN_DIV_HEADER() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'PAGES/APP_CONTENTS_ADMIN_HEADER.html',
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(USER_DATA_FOR_CONTENT, STR_RESULT);
			$('#DIV_HEADER').html(HTML_COMPILED); _RS.$apply();
			INIT_WIDGETS_FOR_DIV_ADMIN_HEADER();
		}
	);
}
function POPUP_USER_SELECT() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'PAGES/POPUP_USER_SELECT.html',
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(ALL_USER_DATA, STR_RESULT);
			var OBJ_POPUP_FOR_ALERT = QIIP_JQX_POPUP_WINDOW({
	            showCollapseButton: true, 
	            height: '13.5%',
	            width: '20%',
	            minHeight: 100,
	            minWidth: 100,
				},
				'????????? ??????',
				HTML_COMPILED
			);
			_RS.$apply();
			INIT_WIDGETS_FOR_POPUP_USER_SELECT(OBJ_POPUP_FOR_ALERT);
		}
	);
}
function UPDATE_USER_META_IN_APP_CONTENTS(ID, META_KEY, META_VALUE) {
	var PHP_CODES  = '';
		PHP_CODES += '$UPDATE_RESULT = update_user_meta(';
		PHP_CODES += ID + ',';
		PHP_CODES += '"' + META_KEY + '",';
		PHP_CODES += '"' + META_VALUE + '"';
		PHP_CODES += ');';
		PHP_CODES += 'return $UPDATE_RESULT;';
		
	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
		}
	);
	
}
function LOAD_MOTION_DATA() {
	var STR_SQL  = '';
		STR_SQL += 'SELECT * FROM T_MOTION_HISTORY ';
		STR_SQL += 'WHERE U_id="' + USER_DATA_FOR_CONTENT.data.ID + '" ';
		STR_SQL += 'ORDER BY ACTION_DATE DESC, ACTION_TIME DESC LIMIT 1 ';
		
	QIIP_API_ACCESS({
			REQ: 'api_DB_ACCESS',
			STR_SQL_BASE64: Base64.encode(STR_SQL),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			
			USER_DATA_FOR_CONTENT.MOTION_DATA = JSON_RESULT[0];			
			var STR_ERR_MESSAGE = '';
			var FLAG_ERROR = false;
			
			if (USER_DATA_FOR_CONTENT.MOTION_DATA == null) {
				STR_ERR_MESSAGE = '???????????? ???????????? ????????????. ?????? ???????????? ??????????????????.';
				FLAG_ERROR = true;
			}
			
			if (FLAG_ERROR) {
				QIIP_POPUP_FOR_ALERT(
				"??????",
				[
					STR_ERR_MESSAGE
				],
				function(){
				}
				,
				20,
				16.5
				);
				
			} else {
				LOAD_3_MEMO_DATA();
				UPDATE_USER_META_IN_APP_CONTENTS(USER_DATA.data.ID, "LAST_LOGIN", dateFormat(new Date(), 'yyyy.mm.dd') );
				QIIP_JQX_CLOSE_WINDOW(POPUP_USER_SELECT);
			}
			
		}
	);
}
function LOAD_3_MEMO_DATA() {
	var STR_SQL  = '';
		STR_SQL += 'SELECT T_ID, ACTION_DATE, MEMO  FROM T_MOTION_HISTORY ';
		STR_SQL += 'WHERE U_id="' + USER_DATA_FOR_CONTENT.data.ID + '" ';
		STR_SQL += 'ORDER BY ACTION_DATE DESC, ACTION_TIME DESC LIMIT 3 ';
		
	QIIP_API_ACCESS({
			REQ: 'api_DB_ACCESS',
			STR_SQL_BASE64: Base64.encode(STR_SQL),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			USER_DATA_FOR_CONTENT.MOTION_DATA.MEMO_LAST_3 = JSON_RESULT;
			LOAD_ALL_TRAINNING_COUNT();
//			TT(USER_DATA);
		}
	);
}
function LOAD_ALL_TRAINNING_COUNT() {
	var STR_SQL  = '';
		STR_SQL += 'SELECT COUNT(*) as TRAINNING_COUNT FROM T_MOTION_HISTORY ';
		STR_SQL += 'WHERE U_id="' + USER_DATA_FOR_CONTENT.data.ID + '" ';
		
	QIIP_API_ACCESS({
			REQ: 'api_DB_ACCESS',
			STR_SQL_BASE64: Base64.encode(STR_SQL),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			USER_DATA_FOR_CONTENT.MOTION_DATA.TRAINNING_COUNT = JSON_RESULT[0].TRAINNING_COUNT;
			LOAD_ALL_TRAINNING_MINUTES();
		}
	);
}
function LOAD_ALL_TRAINNING_MINUTES() {
	var STR_SQL  = '';
		STR_SQL += 'SELECT SUM(ACTION_MINUTES) as TRAINNING_MINUTES FROM T_MOTION_HISTORY ';
		STR_SQL += 'WHERE U_id="' + USER_DATA_FOR_CONTENT.data.ID + '" ';
		
	QIIP_API_ACCESS({
			REQ: 'api_DB_ACCESS',
			STR_SQL_BASE64: Base64.encode(STR_SQL),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			USER_DATA_FOR_CONTENT.MOTION_DATA.TRAINNING_MINUTES = JSON_RESULT[0].TRAINNING_MINUTES;
			
//			TT(USER_DATA_FOR_CONTENT);
			LOAD_ALL_DATA_FOR_GRAPH();
		}
	);
	
}
function LOAD_ALL_DATA_FOR_GRAPH() {
	var STR_SQL  = '';
		STR_SQL += 'SELECT ACTION_DATE,  ';
		STR_SQL += ' (ACTION_LA + ACTION_RA + ACTION_RPO + ACTION_LPO) / 4 as ACTIVE_AVE, ';
		STR_SQL += ' (MAX_ANGLE_LH + MAX_ANGLE_RH) / 2 as WRIST_AVE, ';
		STR_SQL += ' (ACTION_STL + ACTION_STR) / 2 as MUSCLE_AVE, ';
		STR_SQL += ' (AVE_ANGLE_LH + AVE_ANGLE_RH) / 2 as ACCURACY_AVE ';
		STR_SQL += ' FROM T_MOTION_HISTORY ';
		STR_SQL += 'WHERE U_id="' + USER_DATA_FOR_CONTENT.data.ID + '" ';
		STR_SQL += 'ORDER BY ACTION_DATE ASC, ACTION_TIME ASC LIMIT 7 ';
		
	QIIP_API_ACCESS({
			REQ: 'api_DB_ACCESS',
			STR_SQL_BASE64: Base64.encode(STR_SQL),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			USER_DATA_FOR_CONTENT.MOTION_DATA.GRAPH_DATA = JSON_RESULT;
//			TT(USER_DATA_FOR_CONTENT);
			LOAD_ALL_CONTENTS();
			
		}
	);
}
function LOAD_ALL_CONTENTS() {
	LOAD_DIV_HEADER();
	LOAD_DIV_LEFTCON();
	LOAD_DIV_RIGHTCON1();
	LOAD_DIV_RIGHTCON2();
}
function LOAD_DIV_HEADER() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'PAGES/APP_CONTENTS_HEADER.html',
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(USER_DATA_FOR_CONTENT, STR_RESULT);
			$('#DIV_HEADER').html(HTML_COMPILED); _RS.$apply();
			INIT_WIDGETS_FOR_DIV_HEADER();
		}
	);
}
function LOAD_DIV_LEFTCON() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'PAGES/APP_CONTENTS_LEFTCON.html',
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(USER_DATA_FOR_CONTENT, STR_RESULT);
			$('#DIV_LEFTCON').html(HTML_COMPILED); _RS.$apply();
			INIT_WIDGETS_FOR_DIV_LEFTCON();
		}
	);
}
function LOAD_DIV_RIGHTCON1() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'PAGES/APP_CONTENTS_RIGHTCON1.html',
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(USER_DATA_FOR_CONTENT, STR_RESULT);
			$('#DIV_RIGHTCON1').html(HTML_COMPILED); _RS.$apply();
			INIT_WIDGETS_FOR_DIV_RIGHTCON1();
		}
	);
}
function LOAD_DIV_RIGHTCON2() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'PAGES/APP_CONTENTS_RIGHTCON2.html',
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(USER_DATA_FOR_CONTENT, STR_RESULT);
			$('#DIV_RIGHTCON2').html(HTML_COMPILED); _RS.$apply();
			INIT_WIDGETS_FOR_DIV_RIGHTCON2();
		}
	);
}
function LOAD_PAGE_FOR_INPUT_USER_META_DATA(USER_DATA) {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'PAGES/PAGE_FOR_INPUT_USER_META_DATA.html',
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(USER_DATA, STR_RESULT);
			$('body').html(HTML_COMPILED); _RS.$apply();
			INIT_WIDGETS_FOR_PAGE();
		}
	);
}
</script>
<header id="DIV_HEADER"></header>
<div class="con_wrap">
	<div class="left_con" id="DIV_LEFTCON"></div>
	<div class="right_con">
		<div class="chart_group" id="DIV_RIGHTCON1"></div>
		<div class="save_clip" id="DIV_RIGHTCON2"></div>
	</div>
</div>