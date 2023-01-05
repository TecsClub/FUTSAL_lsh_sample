<?php if(!defined("__XE__"))exit;?><style>
	.ivr_monitor 			{width:100%; height:100%;}
	.ivr_monitor table		{width:100%; height:100%; font-size:100%; border-collapse: separate; border-spacing: 1px; line-height: 100%;}
	.ivr_monitor table th	{font-weight:bold; text-align: center; white-space:normal; vertical-align: middle; word-break:break-all; word-wrap:break-all; background:#4789b7; color:white; }
	.ivr_monitor table td	{text-decoration:none; text-align: left;   white-space:normal; vertical-align: middle; word-break:break-all; word-wrap:break-all; background:#eee; padding:0 10px;}
	
	.ivr_call_status 			{width:100%; height:100%; background:white;}
	.ivr_call_status table		{width:100%; height:100%; font-size:100%; border: 0px;  line-height: 100%;}
	.ivr_call_status table th	{border: 0px; text-align: center;   }
	.ivr_call_status table td	{border: 0px; }
</style>
<script>
var DIV_CALL_STATUS_LOG = 'DIV_CALL_STATUS_LOG';
_RS.GRID_COLS = 10;
_RS.GRID_ROWS = 100;
_RS.NumberArray = function(n) {
	var A = [];
	for (var i=0; i<n; i++) {
		A.push(i);
	}
	return A; 
}
var IVR_SERVER_SELECTED		= null;
var ARSAUTH_WS_SERVER_URL	= '';
var ARSAUTH_WS_CHANNEL		= 'arsauth-status';
//var ARSAUTH_WS_CHANNEL		= 'WS/VMS_DETECTOR';
var CALL_GRID_STATUS = [];
var TOGGLE_CALL_STATUS_LOG = false;
var TOGGLE_CALL_WAVE = false;
var FLAG_CALL_AMOUNT_WINDOW = false;
var FLAG_CALL_OUT_WINDOW = false;
var STR_HTML_CALL_STATUS = null;
function IP_TO_WS_SERVER_URL(STR_IP) {
//	return 'ws://' + STR_IP + ':3000';
	return 'ws://' + window.location.hostname + ':3000';
//	return 'ws://pbx.q1p.win:8080/API/';
}
function IP_TO_VMS_SERVER_URL(STR_IP) {
	return 'ws://' + STR_IP + ':8080/API/WS/VMS_DETECTOR';
}
function REQUEST_CALL_FILE_STREAMMING(JSON_REQUEST) {
//	alert(JSON.stringify(JSON_REQUEST, null, '\t'));
	INIT_WS_CONNECTION_FOR_VMS_MONITOR(
		IP_TO_VMS_SERVER_URL(JSON_REQUEST.IVR_ADDR), '', JSON_REQUEST
	);
	
}
function REFRESH_BTN_PAGE() {
	if ($(".BTN_IVR_MONITOR").length < 1) return;
	
	$(".BTN_IVR_MONITOR").jqxButton({
		width: '100%',
		height: '100%'
	}).on('click', function () {
		var ID = $(this).attr('ID');
		if (ID == 'DUMMY') {
		} else if (ID == 'BTN_CALL_PLAYBACK') {
			REQUEST_CALL_FILE_STREAMMING({
				REQUEST:				'CALL_FILE_STREAMMING',
				IVR_ADDR:				$(this).attr('IVR_ADDR'),
				CALL_END:				JSON.parse($(this).attr('CALL_END')),
				CALL_FILE_PATH_PREFIX:	$(this).attr('CALL_FILE_PATH_PREFIX')
			});
		}
	});
}
function LAUNCH_CALL_OUT_POPUP_WINDOW() {
	var JSON_ARGS = {
			IVR_ADDR: IVR_SERVER_SELECTED.SERVER_IP
		};
	var JSON_ARGS_BASE64 = Base64.encode(JSON.stringify(JSON_ARGS));
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'PAGES/APP_CONTENTS_LEGACY_CALL_OUT.html',
			JSON_ARGS_BASE64: JSON_ARGS_BASE64,
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(JSON_ARGS, STR_RESULT);
			var OBJ_POPUP = QIIP_JQX_POPUP_WINDOW({
			        showCollapseButton: true, 
			        showAnimationDuration: 0,
			        closeAnimationDuration: 0,
			        minHeight: 100,
			        minWidth: 100,
			        maxWidth: 3000,
			        
			        width: '95%',
			        height: '95%',
				},
				IVR_SERVER_SELECTED.SERVER_IP + ' 를 통한 전화걸기',
				HTML_COMPILED,
				function () {
					// ON_CLOSE
					FLAG_CALL_OUT_WINDOW = false;
				}
			);
			INIT_WIDGETS_POPUP_CALL_OUT(OBJ_POPUP);
			FLAG_CALL_OUT_WINDOW = true;
			
		},{
			title: _RS.PHONE_INFO.APP_NAME + ' 안내',
			template: ARR_TO_TABLE_CENTER([
				'화면을 구성하고 있습니다.'
			]),
			cssClass: 'qiip_popup'
		}
	);
}
function LAUNCH_CALL_AMOUNT_WINDOW() {
	var JSON_ARGS = {
			IVR_ADDR: IVR_SERVER_SELECTED.SERVER_IP
		};
	var JSON_ARGS_BASE64 = Base64.encode(JSON.stringify(JSON_ARGS));
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'PAGES/APP_CONTENTS_CALL_AMOUNT.html',
			JSON_ARGS_BASE64: JSON_ARGS_BASE64,
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(JSON_ARGS, STR_RESULT);
			var OBJ_POPUP = QIIP_JQX_POPUP_WINDOW({
			        showCollapseButton: true, 
			        showAnimationDuration: 0,
			        closeAnimationDuration: 0,
			        width: '95%',
			        height: '95%',
//			        height: '25%',
//			        position: { x: '2%', y: '74%' },
			        minHeight: 100,
			        minWidth: 100,
			        maxWidth: 3000,
				},
				'IVR 통화량',
				HTML_COMPILED,
				function () {
					// ON_CLOSE
					FLAG_CALL_AMOUNT_WINDOW = false;
				}
			);
			INIT_WIDGETS_POPUP_CALL_AMOUNT(OBJ_POPUP);
			FLAG_CALL_AMOUNT_WINDOW = true;
			
		},{
			title: _RS.PHONE_INFO.APP_NAME + ' 안내',
			template: ARR_TO_TABLE_CENTER([
				'화면을 구성하고 있습니다.'
			]),
			cssClass: 'qiip_popup'
		}
	);
}
function INIT_WIDGETS_FOR_MENU_CONTENTS() {
	$(".BTN_IVR_MONITOR").jqxButton({
		width: '100%',
		height: '100%'
	}).on('click', function () {
		var ID = $(this).attr('ID');
		if (ID == 'DUMMY') {
		} else if (ID == 'BTN_TOGGLE_CALL_STATUS_LOG') {
			TOGGLE_CALL_STATUS_LOG = !TOGGLE_CALL_STATUS_LOG;
			UPDATE_LAYOUT();
		} else if (ID == 'BTN_TOGGLE_CALL_WAVE') {
			TOGGLE_CALL_WAVE = !TOGGLE_CALL_WAVE;
			UPDATE_LAYOUT();
		} else if (ID == 'BTN_CALL_OUT') {
			LAUNCH_CALL_OUT_POPUP_WINDOW();
		} else if (ID == 'BTN_CALL_AMOUNT') {
			LAUNCH_CALL_AMOUNT_WINDOW();
		} else if (ID == 'BTN_POPUP_SYSTEM_STATUS') {
			POPUP_IFRAME({
				TITLE: IVR_SERVER_SELECTED.SERVER_IP + ' 설정화면',
				DIV_ID: 'FRAME_IVR_DASHBOARD',
				IFRAME_URL: sprintf('http://%s', IVR_SERVER_SELECTED.SERVER_IP)
			});
		} else if (ID == 'BTN_POPUP_MYSQL') {
			POPUP_IFRAME({
				TITLE: IVR_SERVER_SELECTED.SERVER_IP + ' MYSQL',
				DIV_ID: 'FRAME_MYSQL',
				IFRAME_URL: sprintf('http://%s/mysql', IVR_SERVER_SELECTED.SERVER_IP)
			});
		}
	});
	for (var i=0; i<(_RS.GRID_ROWS * _RS.GRID_COLS); i++) {
		CALL_GRID_STATUS.push({});
	}
	UPDATE_LAYOUT();
	LOAD_STR_HTML_CALL_STATUS();
	LOAD_CONFIG();
	
	TOGGLE_SIDEMENU();
	
}
function POPUP_IFRAME(JSON_ARGS, ON_CLOSE) {
	console.log(JSON_ARGS);
	var OBJ_POPUP = QIIP_JQX_POPUP_WINDOW({
	        showCollapseButton: true, 
	        showAnimationDuration: 0,
	        closeAnimationDuration: 0,
	        minHeight: 100,
	        minWidth: 100,
	        maxWidth: 3000,
	        
	        width: '95%',
	        height: '95%',
		},
		JSON_ARGS.TITLE,
		'<iframe style="width:100%;height:100%;overflow:auto;" id="' + JSON_ARGS.DIV_ID + '"></iframe>',
		ON_CLOSE
	);
//	$('#FRAME_IVR_DASHBOARD').attr('src', 'http://' + IVR_SERVER_SELECTED.SERVER_IP + '/admin/config.php?STAT_ONLY');
	$('#' + JSON_ARGS.DIV_ID).attr('src', JSON_ARGS.IFRAME_URL);
}
function LOAD_STR_HTML_CALL_STATUS() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_FILE',
			FLDR: _FLDR_TEMPLATE,
			FILE: 'PAGES/APP_CONTENTS_CALL_STATUS.html',
		},function(STR_RESULT) {
			STR_HTML_CALL_STATUS = STR_RESULT;
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_CALL_STATUS_LOG,
	    		'<pre>' + STR_RESULT + '</pre>',
	    		'me',
	    		'70%'
	    	);
		}
	);
}
function UPDATE_LAYOUT() {
	if (TOGGLE_CALL_STATUS_LOG) {
		$('#DIV_CALL_STATUS').css('width','60%');
		$('#DIV_CALL_STATUS_LOG').css('width','40%');
		$('#BTN_TOGGLE_CALL_STATUS_LOG').html('풍선로그 가리기');
	} else {
		$('#DIV_CALL_STATUS').css('width','100%');
		$('#DIV_CALL_STATUS_LOG').css('width','0%');
		$('#BTN_TOGGLE_CALL_STATUS_LOG').html('풍선로그 보이기');
	}
	if (TOGGLE_CALL_WAVE) {
		$('#DIV_NAUTES_SoundVisualizer').css('height','10%');
		$('#DIV_NAUTES_SoundVisualizer').show();
		$('#DIV_CALL_GRID').css('height','90%');
		$('#BTN_TOGGLE_CALL_WAVE').html('음성파형 가리기');
		if (_NAUTES_SoundVisualizer == undefined) {
			INIT_NAUTES_SoundVisualizer();
		}
	} else {
		$('#DIV_NAUTES_SoundVisualizer').css('height','0%');
		$('#DIV_NAUTES_SoundVisualizer').hide();
		$('#DIV_CALL_GRID').css('height','100%');
		$('#BTN_TOGGLE_CALL_WAVE').html('음성파형 보이기');
	}
	
	
}
function LOAD_CONFIG() {
	INIT_WIDGETS_FOR_SELECT_IVR_SERVER(_RS.APP_CONFIG.IVR_LEGACY_SERVER_IPS);
	IVR_SERVER_SELECTED = _RS.APP_CONFIG.IVR_LEGACY_SERVER_IPS[0];
	CHANGE_MONITOR_TARGET_IVR_SERVER();
	return;
/*	
	QIIP_API_ACCESS({
			REQ: 'api_GET_FILE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'PAGES/CONFIG.JSON',
		},function(STR_RESULT) {
			_RS.CONFIG = {};
			try { _RS.CONFIG = JSON.parse(STR_RESULT); } catch(e) { }
			_RS.$apply();
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_CALL_STATUS_LOG,
	    		'<pre>' + JSON.stringify(_RS.CONFIG, null, '\t') + '</pre>',
	    		'me',
	    		'70%'
	    	);
	    	
			INIT_WIDGETS_FOR_SELECT_IVR_SERVER(_RS.CONFIG.IVR_LEGACY_SERVER_IPS);
	    	IVR_SERVER_SELECTED = _RS.CONFIG.IVR_LEGACY_SERVER_IPS[0];
			CHANGE_MONITOR_TARGET_IVR_SERVER();
		}
	);
*/
}
function INIT_WIDGETS_FOR_SELECT_IVR_SERVER(ARRAY_IVR_SERVER) {
	$("#SELECT_STATUS_COLS").jqxDropDownList({
		width: '100%',
		source: [
			{
				DISP: '10',
				VALUE: 10
			},
		],
		displayMember: 'DISP',
		valueMember: 'VALUE',
		selectedIndex: 0
	}).on('change', function (event) {
		var args = event.args;
		if (args) {
			_RS.GRID_COLS = args.item.originalItem.VALUE;
			_RS.$apply();
		}
	});
	$("#SELECT_STATUS_ROWS").jqxDropDownList({
		width: '100%',
		source: [
			{
				DISP: '10',
				VALUE: 10
			},
			{
				DISP: '20',
				VALUE: 20
			},
			{
				DISP: '50',
				VALUE: 50
			},
			{
				DISP: '100',
				VALUE: 100
			},
			{
				DISP: '200',
				VALUE: 200
			},
		],
		displayMember: 'DISP',
		valueMember: 'VALUE',
		selectedIndex: 3
	}).on('change', function (event) {
		var args = event.args;
		if (args) {
			_RS.GRID_ROWS = args.item.originalItem.VALUE;
			_RS.$apply();
		}
	});
	$("#SELECT_IVR_SERVER").jqxDropDownList({
		width: '100%',
		source: ARRAY_IVR_SERVER,
		displayMember: 'SERVER_NAME',
		valueMember: 'SERVER_IP',
		selectedIndex: 0
	}).on('change', function (event) {
		var args = event.args;
		if (args) {
			// index represents the item's index.                      
			var index = args.index;
			var item = args.item;
			// get item's label and value.
			var label = item.label;
			var value = item.value;
			var type = args.type;
			IVR_SERVER_SELECTED = item.originalItem;
			CHANGE_MONITOR_TARGET_IVR_SERVER();
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_CALL_STATUS_LOG,
	    		'<pre> CHANGE_TO => ' + JSON.stringify(IVR_SERVER_SELECTED, null, '\t') + '</pre>',
	    		'me',
	    		'70%'
	    	);
		}
	});
}
function CHANGE_MONITOR_TARGET_IVR_SERVER() {
	if (typeof WS_CONNECTION_FOR_IVR_MONITOR !== 'undefined' && WS_CONNECTION_FOR_IVR_MONITOR !== null) WS_CONNECTION_FOR_IVR_MONITOR.CLOSE_FORCE();
	ARSAUTH_WS_SERVER_URL = IP_TO_WS_SERVER_URL(IVR_SERVER_SELECTED.SERVER_IP);
	INIT_WS_CONNECTION_FOR_IVR_MONITOR(ARSAUTH_WS_SERVER_URL, ARSAUTH_WS_CHANNEL);
//	$('#FRAME_IVR_DASHBOARD').attr('src', 'http://' + IVR_SERVER_SELECTED.SERVER_IP + '/admin/config.php?STAT_ONLY');
//	$('#FRAME_IVR_CONFIG_PAGE').attr('src', 'http://' + IVR_SERVER_SELECTED.SERVER_IP + '/admin/config.php?display=arsauth&STAT_ONLY');
}
function IS_VALID_REMOTE_FROM(JSON_ARGS) {
	var RESULT = false;
	_RS.APP_CONFIG.IVR_LEGACY_SERVER_IPS.forEach(function (ONE_IVR_SERVER) {
		if (JSON_ARGS.REMOTE_ADDR == ONE_IVR_SERVER.SERVER_IP) {
			RESULT = true;
		}
	});
//	console.log('IS_VALID_REMOTE_FROM : ' + RESULT);
	return RESULT;
}
var WS_CONNECTION_FOR_IVR_MONITOR = undefined;
function INIT_WS_CONNECTION_FOR_IVR_MONITOR(ws_server, ws_channel) {
	WS_CONNECTION_FOR_IVR_MONITOR = {};
    // if user is running mozilla then use it's built-in WebSocket
    window.WebSocket = window.WebSocket || window.MozWebSocket;
  
    // if browser doesn't support WebSocket, just show some notification and exit
    if (!window.WebSocket) {
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_CALL_STATUS_LOG,
    		'죄송합니다, 접속에 사용하신 웹 브라우저가 WebSockets 기능을 지원하지 않습니다.',
    		'me',
    		'70%'
    	);
      return;
    }
    // open connection
    WS_CONNECTION_FOR_IVR_MONITOR = new WebSocket(ws_server, ws_channel);
//	var WS_URL = ws_server + ws_channel;
//    WS_CONNECTION_FOR_IVR_MONITOR = new WebSocket(WS_URL);
    WS_CONNECTION_FOR_IVR_MONITOR.onopen = function () {
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_CALL_STATUS_LOG,
    		sprintf( "ASTERISK IVR 시스템에 연결되었습니다."),
    		'me',
    		'70%'
    	);
    };
    
    WS_CONNECTION_FOR_IVR_MONITOR.onerror = function (error) {
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_CALL_STATUS_LOG,
    		'ASTERISK IVR 시스템에 어떤 문제가 있거나 ASTERISK IVR 시스템이 응답하지 않습니다.',
    		'you',
    		'70%'
    	);
    };
    // most important part - incoming messages
    WS_CONNECTION_FOR_IVR_MONITOR.onmessage = function (message) {
        // try to parse JSON message. Because we know that the server always returns
        // JSON this should work without any problem but we should make sure that
        // the massage is not chunked or otherwise damaged.
        try {
          var JSON_PARSED = JSON.parse(message.data);
        } catch (e) {
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_CALL_STATUS_LOG,
	    		'이건 JSON 스트링이 아닌것 같아요! : ' + message.data,
	    		'me',
	    		'70%'
	    	);
			return;
        }
        // NOTE: if you're not sure about the JSON structure
        // check the server source code above
        if ('TYPE' in JSON_PARSED) {
        	if (TOGGLE_CALL_STATUS_LOG) {
		    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
		    		DIV_CALL_STATUS_LOG,
		    		'<pre>' + JSON.stringify(JSON_PARSED, null, '  ') + '</pre>',
		    		'you',
		    		'70%'
		    	);
        	}
		  
			var TYPE = JSON_PARSED.TYPE;
			if (TYPE == 'WS_CONNECTION_ID') {			// 대소문자 구분!
			  	var REQUEST = {
			  		CMD: 'REGIST_AS_MONITOR',
			  		WS_CONNECTION_ID: JSON_PARSED.WS_CONNECTION_ID
			  	};
			  	
		      	WS_CONNECTION_FOR_IVR_MONITOR.send(JSON.stringify(REQUEST));
		    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
		    		DIV_CALL_STATUS_LOG,
		    		'<pre>' + JSON.stringify(REQUEST, null, '  ') + '</pre>',
		    		'me',
		    		'70%'
		    	);
			} else if (TYPE == 'ARSAUTH-STATUS') {	// 대소문자 구분!
				if (!IS_VALID_REMOTE_FROM(JSON_PARSED)) {
					
		        	if (TOGGLE_CALL_STATUS_LOG) {
						STR_FOR_LOG = sprintf('%s:%d : %s',
							JSON_PARSED.REMOTE_ADDR,
							JSON_PARSED.REMOTE_PORT,
							'허용되지 않은 원격 주소에서 들어온 패킷 입니다.'
						);
				    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
				    		DIV_CALL_STATUS_LOG,
				    		STR_FOR_LOG,
				    		'me',
				    		'70%'
				    	);
		        	}
				} else {
					if (!FLAG_CALL_OUT_WINDOW) {
						UPDATE_CALL_GRID_STATUS(JSON_PARSED);
					}
				}
    
			} else if (TYPE == 'ARSAUTH_RESULT') {	// 대소문자 구분!
				if (JSON_PARSED.CODE != 200) {
			    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
			    		DIV_CALL_STATUS_LOG,
			    		'ASTERISK IVR 시스템에 장애가 발생했습니다.<br/><br/>' +
			    		sprintf("장애 원인은<br/><br/>[%s]<br/><br/>입니다.<br/><br/>", JSON_PARSED.MESSAGE) +
			    		'최대한 빠른 시일 내에 복구하도록 하겠습니다.',
			    		'you',
			    		'70%'
			    	);
				} else {
				}
			}
		} else if ('DETECT_ID' in JSON_PARSED) {
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_CALL_STATUS_LOG,
	    		'<pre>' + JSON.stringify(JSON_PARSED, null, '  ') + '</pre>',
	    		'you',
	    		'70%'
	    	);
//			UPDATE_VMS_GRID_STATUS(JSON_PARSED);
		} else if ('SAMPLE_BYTES' in JSON_PARSED) {
/*
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_CALL_STATUS_LOG,
	    		'<pre>' + JSON.stringify(JSON_PARSED, null, '  ') + '</pre>',
	    		'me',
	    		'70%'
	    	);
*/
	    	_NAUTES_SoundVisualizer.PUT_UDP_JSON_SAMPLES_TO_SOUND_QUEUE(JSON_PARSED);
		} else if ('CPU_USAGE' in JSON_PARSED) {
	        if (JSON_PARSED.REMOTE_ADDR == IVR_SERVER_SELECTED.SERVER_IP) {
				UPDATE_SYSTEM_STATUS(JSON_PARSED);
	        }
			
		} else if ('IVR_TASK_STATUS' in JSON_PARSED) {
	        if (JSON_PARSED.REMOTE_ADDR == IVR_SERVER_SELECTED.SERVER_IP) {
				if (!FLAG_CALL_OUT_WINDOW) {
					UPDATE_CALL_GRID_STATUS(JSON_PARSED);
				}
	        }
		} else if ('SCENARIO_LOG' in JSON_PARSED) {
		} else if ('R2P_LOG_SOCKET_TASK' in JSON_PARSED) {
			
		} else if ('PLAIN_LOG_MESSAGE' in JSON_PARSED) {
			return;
	        if (JSON_PARSED.REMOTE_ADDR == IVR_SERVER_SELECTED.SERVER_IP) {
		    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
		    		DIV_CALL_STATUS_LOG,
		    		JSON_PARSED.PLAIN_LOG_MESSAGE,
		    		'me',
		    		'70%'
		    	);
	        }
        } else {
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_CALL_STATUS_LOG,
	    		'흠..., JSON 스트링이 이런식이면 곤란한데...  TYPE 속성이 없쟎아...: ' + JSON.stringify(JSON_PARSED, null, '\t'),
	    		'me',
	    		'70%'
	    	);
        }
    };
    WS_CONNECTION_FOR_IVR_MONITOR.onclose  = function () {
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_CALL_STATUS_LOG,
    		'ASTERISK IVR 시스템과 연결이 끊어졌습니다. 1초 이내에 연결을 재시도 합니다.',
    		'me',
    		'70%'
    	);
		//try to reconnect in 1 seconds
		setTimeout(function(){INIT_WS_CONNECTION_FOR_IVR_MONITOR(ARSAUTH_WS_SERVER_URL, ARSAUTH_WS_CHANNEL)}, 1000);
    };
    WS_CONNECTION_FOR_IVR_MONITOR.CLOSE_FORCE  = function () {
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_CALL_STATUS_LOG,
    		'ASTERISK IVR 시스템과 연결을 정상적으로 종료 합니다.',
    		'me',
    		'70%'
    	);
    	WS_CONNECTION_FOR_IVR_MONITOR.onclose  = function () {}; // disable onclose handler first
    	WS_CONNECTION_FOR_IVR_MONITOR.close();
    	WS_CONNECTION_FOR_IVR_MONITOR = undefined;
    }
}
function UPDATE_SYSTEM_STATUS(JSON_PARSED) {
	var STR_HTML = '';
		STR_HTML += '<div class="ivr_call_status">';
		STR_HTML += '<table>';
		STR_HTML += '	<col width="10%" >';
		STR_HTML += '	<col width="10%" >';
		STR_HTML += '	<col width="10%" >';
		STR_HTML += '	<col width="10%" >';
		STR_HTML += '	<col width="10%" >';
		STR_HTML += '	<col width="10%" >';
		STR_HTML += '	<col width="10%" >';
		STR_HTML += '	<col width="10%" >';
		STR_HTML += '	<col width="10%" >';
		STR_HTML += '	<col width="10%" >';
		STR_HTML += '	<tr>';
		STR_HTML += '		<th style="text-align:center; background:#94bbd6; color:black; font-size:0.8em;">';
		STR_HTML += 'CPU_USAGE';
		STR_HTML += '		</th>';
		STR_HTML += '		<td style="text-align:center;" >';
		STR_HTML += JSON_PARSED.CPU_USAGE;
		STR_HTML += '		</td>';
		STR_HTML += '		<th style="text-align:center; background:#94bbd6; color:black; font-size:0.8em;">';
		STR_HTML += 'NET_USAGE';
		STR_HTML += '		</th>';
		STR_HTML += '		<td style="text-align:center;" >';
		STR_HTML += JSON_PARSED.NET_USAGE;
		STR_HTML += '		</td>';
		STR_HTML += '		<th style="text-align:center; background:#94bbd6; color:black; font-size:0.8em;">';
		STR_HTML += 'MEM_USAGE';
		STR_HTML += '		</th>';
		STR_HTML += '		<td style="text-align:center;" >';
		STR_HTML += JSON_PARSED.MEM_USAGE;
		STR_HTML += '		</td>';
		STR_HTML += '		<th style="text-align:center; background:#94bbd6; color:black; font-size:0.8em;">';
		STR_HTML += 'IVR_CHANNEL';
		STR_HTML += '		</th>';
		STR_HTML += '		<td style="text-align:center;" >';
		STR_HTML += sprintf('%03d/%03d', JSON_PARSED.IVR_CHANNEL_ASSIGNED, JSON_PARSED.IVR_CHANNEL_TOTAL);
		STR_HTML += '		</td>';
		STR_HTML += '		<th style="text-align:center; background:#94bbd6; color:black; font-size:0.8em;">';
		STR_HTML += 'IVR_TASK';
		STR_HTML += '		</th>';
		STR_HTML += '		<td style="text-align:center;" >';
		STR_HTML += sprintf('%03d/%03d', JSON_PARSED.IVR_TASK_ASSIGNED, JSON_PARSED.IVR_TASK_TOTAL);
		STR_HTML += '		</td>';
		STR_HTML += '	</tr>';
		STR_HTML += '</table>';	
		STR_HTML += '</div>';
	$('#DIV_SYSTEM_STATUS').html(STR_HTML);
	
}
function UPDATE_CALL_GRID_STATUS(JSON_PARSED) {
	var INDEX_FOUNDED = JSON_PARSED.IVR_TASK_INDEX_UPDATED;
	$('#CALL_GRID_' + INDEX_FOUNDED).html(GET_HTML_STATUS(JSON_PARSED));
	if (JSON_PARSED.IVR_TASK_STATUS == 'IDLE') {
		$('#CALL_GRID_' + INDEX_FOUNDED).html('');
	}
}
function GET_HTML_STATUS_DISABLE(JSON_PARSED) {
	var STR_RESULT = QIIP_STATIC_HTML(JSON_PARSED, STR_HTML_CALL_STATUS);
	return STR_RESULT;
}
function GET_HTML_STATUS(JSON_PARSED) {
	var BACKGROUND_COLOR = 'yellow';
	if (JSON_PARSED.IVR_TASK_STATUS == 'CALL_CONNECTING') {
		BACKGROUND_COLOR = 'yellow;'
	} else if (JSON_PARSED.IVR_TASK_STATUS == 'CALLING') {
		BACKGROUND_COLOR = 'lightblue;'
	} else if (JSON_PARSED.IVR_TASK_STATUS == 'TASK_COMPLETING') {
		BACKGROUND_COLOR = 'lightred;'
	} else if (JSON_PARSED.IVR_TASK_STATUS == 'IDLE') {
		BACKGROUND_COLOR = 'white';
	}
	var STR_HTML = '';
		STR_HTML += '<div class="ivr_call_status">';
		STR_HTML += '<table>';
		STR_HTML += '	<tr>';
		STR_HTML += '		<th style="text-align:center; background:#94bbd6; color:black; font-size:0.8em;">';
		STR_HTML += JSON_PARSED.REMOTE_ADDR;
		STR_HTML += '		</th>';
		STR_HTML += '	</tr>';
		STR_HTML += '	<tr>';
		STR_HTML += '		<th style="text-align:center; background:' + BACKGROUND_COLOR + '; color:black; font-weight:normal; font-size:0.8em;">';
		STR_HTML += JSON_PARSED.IVR_TASK_SCENARIO_NAME;
		STR_HTML += '		</th>';
		STR_HTML += '	</tr>';
		STR_HTML += '	<tr>';
		STR_HTML += '		<th style="text-align:center; background:' + BACKGROUND_COLOR + '; color:black; font-weight:normal; font-size:0.8em;">';
		STR_HTML += JSON_PARSED.IVR_TASK_PHONE_NO;
		STR_HTML += '		</th>';
		STR_HTML += '	</tr>';
		STR_HTML += '	<tr>';
		STR_HTML += '		<th style="text-align:center; background:' + BACKGROUND_COLOR + '; color:black; font-weight:normal; font-size:0.8em;">';
		STR_HTML += JSON_PARSED.IVR_TASK_STATUS;
		STR_HTML += '		</th>';
		STR_HTML += '	</tr>';
		STR_HTML += '</table>';	
		STR_HTML += '</div>';
	return STR_HTML;
}
function TEST2() {
	var filename = "readme.txt";
	var text = "Text of the file goes here.";
	var blob = new Blob([text], {type:'text/plain'});
	var link = document.createElement("a");
	link.download = filename;
	link.innerHTML = "Download File";
	link.href = window.URL.createObjectURL(blob);
//	document.body.appendChild(link);
	return link.outerHTML;
}
function downloadAll_TEST() {
	download_files([
		'http://ask-regard.call-save.biz?PASS=1&cmd=api_YOUTUBE_MP3&YOUTUBE_videoId=yQxB1M0VZLU&EXT=.mp3',
		'http://ask-regard.call-save.biz?PASS=1&cmd=api_YOUTUBE_MP3&YOUTUBE_videoId=VxohG-rWTuI&EXT=.mp3',
		'http://ask-regard.call-save.biz?PASS=1&cmd=api_YOUTUBE_MP3&YOUTUBE_videoId=5_N4XhpB_Ts&EXT=.mp3',
		'http://ask-regard.call-save.biz?PASS=1&cmd=api_YOUTUBE_MP3&YOUTUBE_videoId=9Wp3a2DnkoE&EXT=.mp3',
		'http://ask-regard.call-save.biz?PASS=1&cmd=api_YOUTUBE_MP3&YOUTUBE_videoId=KzfCp-rBZvg&EXT=.mp3',
		'http://ask-regard.call-save.biz?PASS=1&cmd=api_YOUTUBE_MP3&YOUTUBE_videoId=2TO0M3sf8E4&EXT=.mp3'
	]);
}
function download_files(ar) {
    var prevfun=function(){};
    ar.forEach(function(address) {  
        var pp=prevfun;
        var fun=function() {
                var form = $('<form action="' + address + '" method="POST"><input type="hidden" name="error_return_url" value="<?php echo htmlspecialchars(getRequestUriByServerEnviroment(), ENT_COMPAT | ENT_HTML401, 'UTF-8', false) ?>" /><input type="hidden" name="act" value="<?php echo $__Context->act ?>" /><input type="hidden" name="mid" value="<?php echo $__Context->mid ?>" /><input type="hidden" name="vid" value="<?php echo $__Context->vid ?>" /></form>');
                $('body').append(form);
                $(form).submit();
                setTimeout(function() {
                    $(document).one('mousemove', function() { //<--slightly hacky!
                        form.remove();
                        pp();
                    });
                },500);
        }
        prevfun=fun; 
      });
      prevfun();   
}
var WS_CONNECTION_FOR_VMS_MONITOR = undefined;
function INIT_WS_CONNECTION_FOR_VMS_MONITOR(ws_server, ws_channel, JSON_REQUEST) {
	WS_CONNECTION_FOR_VMS_MONITOR = {};
    // if user is running mozilla then use it's built-in WebSocket
    window.WebSocket = window.WebSocket || window.MozWebSocket;
  
    // if browser doesn't support WebSocket, just show some notification and exit
    if (!window.WebSocket) {
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_CALL_STATUS_LOG,
    		'죄송합니다, 접속에 사용하신 웹 브라우저가 WebSockets 기능을 지원하지 않습니다.',
    		'me',
    		'70%'
    	);
      return;
    }
    // open connection
	var WS_URL = ws_server + ws_channel;
    WS_CONNECTION_FOR_VMS_MONITOR = new WebSocket(WS_URL);
    WS_CONNECTION_FOR_VMS_MONITOR.onopen = function () {
/*    	
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_CALL_STATUS_LOG,
    		'<button onclick="downloadAll_TEST()">downloadAll_TEST()</button>',
    		'me',
    		'70%'
    	);
*/
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_CALL_STATUS_LOG,
    		sprintf( "VMS DETECTOR MONITOR 시스템에 연결되었습니다." + TEST2()),
    		'me',
    		'70%'
    	);
		WS_CONNECTION_FOR_VMS_MONITOR.send(JSON.stringify(JSON_REQUEST, null, '\t'));
    };
    
    WS_CONNECTION_FOR_VMS_MONITOR.onerror = function (error) {
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_CALL_STATUS_LOG,
    		'VMS DETECTOR MONITOR 시스템에 어떤 문제가 있거나 VMS DETECTOR MONITOR 시스템이 응답하지 않습니다.',
    		'you',
    		'70%'
    	);
    };
    // most important part - incoming messages
    WS_CONNECTION_FOR_VMS_MONITOR.onmessage = function (message) {
        // try to parse JSON message. Because we know that the server always returns
        // JSON this should work without any problem but we should make sure that
        // the massage is not chunked or otherwise damaged.
        try {
          var JSON_PARSED = JSON.parse(message.data);
        } catch (e) {
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_CALL_STATUS_LOG,
	    		'이건 JSON 스트링이 아닌것 같아요! : ' + message.data,
	    		'me',
	    		'70%'
	    	);
			return;
        }
        // NOTE: if you're not sure about the JSON structure
        // check the server source code above
        if ('TYPE' in JSON_PARSED) {
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_CALL_STATUS_LOG,
	    		'<pre>' + JSON.stringify(JSON_PARSED, null, '  ') + '</pre>',
	    		'you',
	    		'70%'
	    	);
//			UPDATE_VMS_GRID_STATUS(JSON_PARSED);
		} else if ('DETECT_ID' in JSON_PARSED) {
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_CALL_STATUS_LOG,
	    		'<pre>' + JSON.stringify(JSON_PARSED, null, '  ') + '</pre>',
	    		'you',
	    		'70%'
	    	);
//			UPDATE_VMS_GRID_STATUS(JSON_PARSED);
		} else if ('SAMPLE_BYTES' in JSON_PARSED) {
/*
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_CALL_STATUS_LOG,
	    		'<pre>' + JSON.stringify(JSON_PARSED, null, '  ') + '</pre>',
	    		'me',
	    		'70%'
	    	);
*/
	    	if (JSON_PARSED.SAMPLE_INDEX < 1) {
		    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
		    		DIV_CALL_STATUS_LOG,
		    		'새로운거 발견! 큐를 지우고 시작..',
		    		'me',
		    		'70%'
		    	);
	    		_NAUTES_SoundVisualizer.CLEAR_SOUND_QUEUE();
	    	}
	    	_NAUTES_SoundVisualizer.PUT_UDP_JSON_SAMPLES_TO_SOUND_QUEUE(JSON_PARSED);
	    	
        } else {
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_CALL_STATUS_LOG,
	    		'흠..., JSON 스트링이 이런식이면 곤란한데...  필요한 속성이 없쟎아...' + 
	    		'<pre>\n' + JSON.stringify(JSON_PARSED, null, '\t') + '</pre>',
	    		'me',
	    		'70%'
	    	);
        }
    };
    WS_CONNECTION_FOR_VMS_MONITOR.onclose  = function () {
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_CALL_STATUS_LOG,
    		'VMS DETECTOR MONITOR 시스템과 연결이 끊어졌습니다. 1초 이내에 연결을 재시도 합니다.',
    		'me',
    		'70%'
    	);
		//try to reconnect in 1 seconds
		setTimeout(function(){INIT_WS_CONNECTION_FOR_VMS_MONITOR(ARSAUTH_WS_SERVER_URL, ARSAUTH_WS_CHANNEL)}, 1000);
    };
    WS_CONNECTION_FOR_VMS_MONITOR.CLOSE_FORCE  = function () {
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_CALL_STATUS_LOG,
    		'VMS DETECTOR MONITOR 시스템과 연결을 정상적으로 종료 합니다.',
    		'me',
    		'70%'
    	);
    	WS_CONNECTION_FOR_VMS_MONITOR.onclose  = function () {}; // disable onclose handler first
    	WS_CONNECTION_FOR_VMS_MONITOR.close();
    	WS_CONNECTION_FOR_VMS_MONITOR = undefined;
    }
}
var _NAUTES_SoundVisualizer = undefined;
function INIT_NAUTES_SoundVisualizer() {
	_NAUTES_SoundVisualizer = new NAUTES_SoundVisualizer({
		DOM_ID_FOR_RENDERING: 'DIV_NAUTES_SoundVisualizer',
		DOWNLOAD_DISABLE: false,
		WAVE_DISPLAY_ONLY: true,
	});
/*
	_NAUTES_SoundVisualizer.WAE_PLAYLIST.load([{
			src: 'http://ask-regard.call-save.biz?PASS=1&cmd=api_YOUTUBE_MP3&YOUTUBE_videoId=yQxB1M0VZLU&EXT=.mp3'
	}]).then(function() {
	});
*/
}
</script>
<div class="ivr_monitor">
	<div style="height:5%; overflow:auto;">
		<table>
			<col width="10%" />
			<col width="10%" />
			<col width="5%" />
			<col width="6%" />
			<col width="5%" />
			<col width="6%" />
			<col width="13%" />
			
			<col width="9%" />
			<col width="9%" />
			<col width="9%" />
			<col width="9%" />
			<col width="9%" />
			<tr>
				<th style="background:#94bbd6; color:#333;">SELECT IVR</th>
				<td>
					<div id="SELECT_IVR_SERVER" />
				</td>
				<th style="background:#94bbd6; color:#333;">COLS</th>
				<td>
					<div id="SELECT_STATUS_COLS" />
				</td>
				<th style="background:#94bbd6; color:#333;">ROWS</th>
				<td>
					<div id="SELECT_STATUS_ROWS" />
				</td>
				
				<td>
					<button class="BTN_IVR_MONITOR" id="BTN_TOGGLE_CALL_WAVE">
					</button>
				</td>
				<td>
					<button class="BTN_IVR_MONITOR" id="BTN_TOGGLE_CALL_STATUS_LOG">
					</button>
				</td>
				<td>
					<button class="BTN_IVR_MONITOR" id="BTN_CALL_AMOUNT">
						통화량 창
					</button>
				</td>
				
				<td>
					<button class="BTN_IVR_MONITOR" id="BTN_CALL_OUT">
						전화걸기
					</button>
				</td>
				<td>
					<button class="BTN_IVR_MONITOR" id="BTN_POPUP_SYSTEM_STATUS">
						대쉬보드
					</button>
				</td>
				<td>
					<button class="BTN_IVR_MONITOR" id="BTN_POPUP_MYSQL">
						MYSQL
					</button>
				</td>
			</tr>
		</table>
	</div>
	<div style="height:5%; overflow:auto;" id="DIV_SYSTEM_STATUS">
	</div>
	<div style="height:90%;">
		<div style="width:60%;height:100%;float:left;" id="DIV_CALL_STATUS">
			<div style="width:100%;height:30%;" id="DIV_NAUTES_SoundVisualizer">
			</div>
			<div style="width:100%;height:70%;overflow:auto;" id="DIV_CALL_GRID">
				<table style="width:100%;height:100%;">
					<col width="5%" />
			      	<col ng-repeat="nCol in NumberArray(GRID_COLS)" width="{{ 95 / GRID_COLS }}%" >
			      	</col>
				  	<tr style="height:50px;">
				      	<td>
				  		</td>
				      	<th ng-repeat="nCol in NumberArray(GRID_COLS)" >
				      		{{nCol}}
				      	</th>
				  	</tr>
				  	<tr style="height:150px;" ng-repeat="nRow in NumberArray(GRID_ROWS)">
				      	<th style="text-align:center;">
				      		{{nRow * GRID_COLS}}
				      	</th>
				      	<td ng-repeat="nCol in NumberArray(GRID_COLS)" >
				      		<div style="width:100%; height:100%;overflow:auto;" id="CALL_GRID_{{nRow*GRID_COLS + nCol}}">
				      		</div>
				      	</td>
				  	</tr>
				</table>
			</div>
		</div>
		<div style="width:40%;height:100%;float:left;background-color:#c9c9c9;overflow:auto;" id="DIV_CALL_STATUS_LOG">
		</div>
	</div>
</div>