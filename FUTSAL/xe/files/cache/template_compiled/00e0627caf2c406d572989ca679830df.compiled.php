<?php if(!defined("__XE__"))exit;?><style>
	.ars-config 			{width:100%; height:100%;}
	.ars-config table		{width:100%; height:100%; font-size:100%; border-collapse: separate; border-spacing: 1px; line-height: 100%;}
	.ars-config table th	{font-weight:bold; text-align: center; white-space:normal; vertical-align: middle; word-break:break-all; word-wrap:break-all; background:#4789b7; color:white; }
	.ars-config table td	{text-decoration:none; text-align: left;   white-space:normal; vertical-align: middle; word-break:break-all; word-wrap:break-all; background:#eee; padding:0 10px;}
</style>
<script>
function PUT_ARS_CONFIG_INFORMATION(OBJ_UPDATE, FUNC_AFTER) {
	QIIP_API_ACCESS({
			REQ: 'post_PUT_ROOT_INFO',
			PHONE_NO: _RS.PHONE_INFO.APP_NAME,
			PHONE_ID: _RS.PHONE_INFO.APP_NAME,
			CATEGORY: _RS.PHONE_INFO.APP_NAME,
			JSON_UPDATE: OBJ_UPDATE,
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
//			alert(JSON.stringify(JSON_RESULT, null, '\t'));
			if (FUNC_AFTER != undefined) FUNC_AFTER();
		}
	);
}
function GET_ARS_CONFIG_INFORMATION(FUNC_AFTER) {
	QIIP_API_ACCESS({
			REQ: 'post_GET_ROOT_INFO',
			PHONE_NO: _RS.PHONE_INFO.APP_NAME,
			PHONE_ID: _RS.PHONE_INFO.APP_NAME,
			CATEGORY: _RS.PHONE_INFO.APP_NAME,
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if (JSON_RESULT instanceof Object) {
				_RS.ARS_CONFIG = JSON_RESULT;
			} else {
				if ('INITIAL_POST_INFORMATION' in _RS.APP_CONFIG) {
					_RS.ARS_CONFIG = _RS.APP_CONFIG.INITIAL_POST_INFORMATION;
					_RS.ARS_CONFIG.PHONE_NO = _RS.PHONE_INFO.APP_NAME;
					_RS.ARS_CONFIG.PHONE_ID = _RS.PHONE_INFO.APP_NAME;
					PUT_ARS_CONFIG_INFORMATION(_RS.ARS_CONFIG);
				} else {
					_RS.ARS_CONFIG = {};
				}
			}
			if (FUNC_AFTER != undefined) FUNC_AFTER();
		}
	);
}
function DD() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_WORK_CONDITION',
			CONFIG_URL: window.location.origin + '?REQ=post_GET_ROOT_INFO&PHONE_NO=' + _RS.PHONE_INFO.APP_NAME + '&PHONE_ID=' + _RS.PHONE_INFO.APP_NAME + '&CATEGORY=' + _RS.PHONE_INFO.APP_NAME
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			var STR_LOG = '';
			if (JSON_RESULT instanceof Object) {
				STR_LOG = sprintf('<pre>%s</pre>', JSON.stringify(JSON_RESULT, null, '\t'));
			} else {
				STR_LOG = sprintf('<pre>%s</pre>', STR_RESULT);
			}
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		'DIV_LOG',
	    		STR_LOG,
	    		'me',
	    		'70%'
	    	);
		}
	);
}
	
function INIT_WIDGETS_FOR_MENU_CONTENTS() {
	GET_ARS_CONFIG_INFORMATION(function () {
		var STR_LOG = sprintf('<pre>%s</pre>', JSON.stringify(_RS.ARS_CONFIG, null, '\t'));
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		'DIV_LOG',
    		STR_LOG,
    		'me',
    		'70%'
    	);
    	
   		DD();
	});
	TOGGLE_SIDEMENU(function () {
		setTimeout(function (){
			QUERY_ars-config();
		}, 1000);
	});
}
</script>
<div class="ars-config">
	<div style="height:80%; width:100%;">
	</div>
	<div style="height:20%; width:100%; overflow:auto;" id="DIV_LOG">
	</div>
</div>
