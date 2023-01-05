<?php if(!defined("__XE__"))exit;?><script>
var ARSAUTH_WS_SERVER_URL_FOR_CALL_OUT	= '';
var ARSAUTH_WS_CHANNEL		= 'arsauth-status';
var DIV_POPUP_ARSAUTH_STATUS = 'DIV_POPUP_ARSAUTH_STATUS';
var JSON_ARSAUTH_REQUEST = {
	CMD: "ARSAUTH_CALL",
//	CMD: "ARSAUTH_WAIT",
	APIKEY: "7bca4c6b8e915ed3a313defd21b9385b",
    CALL_SCENARIO : "MENT_AND_HANGUP",
    CALL_TO : "01400000000",
    CALL_TO : "01025412563",
    CALL_FROM : "07080162500",
//    CALL_FROM : "TEST",
	CALL_WAIT_TIME: 45,
	MENT_INTRO: '안녕하세요? 교육 학술정보원, 대량통화, 테스트 입니다. 인증 번호를, 입력받아, 연동하는, 절차를 처리합니다. 감사합니다.',
	MULTI_CALL_ENABLE: false,
	MULTI_CALL_TARGET: 'CALL_TO',
	MULTI_CALL_PREFIX: "07080890",
	MULTI_CALL_CURRENT: 0,
	MULTI_CALL_FINISH: 499,
	MULTI_CALL_DELAY_MS: 100,
};
var OBJ_POPUP_CALL_OUT = null;
function INIT_WIDGETS_POPUP_CALL_OUT(OBJ_POPUP) {
	OBJ_POPUP_CALL_OUT = OBJ_POPUP;
	$(".QIIP_POPUP_BUTTONS").jqxButton({
		width: '100%',
		height: '100%'
	}).on('click', function () {
		var ID = $(this).attr('ID');
		if (ID == 'DUMMY') {
		} else if (ID == 'BTN_CLOSE_POPUP') {
			QIIP_JQX_CLOSE_WINDOW(OBJ_POPUP_CALL_OUT);
		} else if (ID == 'BTN_EXEC_ARSAUTH') {
			// 두번 클릭 방지!
			$(this).button({disabled: true });
			
			var STR_JSON_ARSAUTH_REQUEST = $("#STR_JSON_ARSAUTH_REQUEST").val();
	        try {
	          var JSON_PARSED = JSON.parse(STR_JSON_ARSAUTH_REQUEST);
	          	  JSON_PARSED.IVR_URL = sprintf('http://%s',IVR_SERVER_SELECTED.SERVER_IP);
	        } catch (e) {
				$(this).button({disabled: false });
		    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
		    		DIV_POPUP_ARSAUTH_STATUS,
		    		'이건 JSON 스트링이 아닌것 같아요! : ' + STR_JSON_ARSAUTH_REQUEST,
		    		'me',
		    		'70%'
		    	);
		    	
	          return;
	        }
			QIIP_ARSAUTH_REQUEST(JSON_PARSED);
		}
	});
	
	$(".QIIP_POPUP_BUTTONS").button({width : '100%',height : '100%'});
	$("#BTN_EXEC_ARSAUTH").on('click', function () {
    });
   	ARSAUTH_WS_SERVER_URL_FOR_CALL_OUT = IP_TO_WS_SERVER_URL(IVR_SERVER_SELECTED.SERVER_IP);
	INIT_WS_CONNECTION_FOR_POPUP_CALL_OUT(ARSAUTH_WS_SERVER_URL_FOR_CALL_OUT, ARSAUTH_WS_CHANNEL);
//    $('#BTN_EXEC_ARSAUTH').button({disabled: false });
}
var WS_CONNECTION_FOR_POPUP_CALL_OUT = {};
function INIT_WS_CONNECTION_FOR_POPUP_CALL_OUT(ws_server, ws_channel) {
    // if user is running mozilla then use it's built-in WebSocket
    window.WebSocket = window.WebSocket || window.MozWebSocket;
  
    // if browser doesn't support WebSocket, just show some notification and exit
    if (!window.WebSocket) {
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_POPUP_ARSAUTH_STATUS,
    		'죄송합니다, 접속에 사용하신 웹 브라우저가 WebSockets 기능을 지원하지 않습니다.',
    		'me',
    		'70%'
    	);
		return;
    }
    // open connection
    WS_CONNECTION_FOR_POPUP_CALL_OUT = new WebSocket(ws_server, ws_channel);
    WS_CONNECTION_FOR_POPUP_CALL_OUT.onopen = function () {
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_POPUP_ARSAUTH_STATUS,
    		sprintf( "WS_CONNECTION_FOR_POPUP_CALL_OUT : new WebSocket('%s', '%s') 이 연결되었습니다. ", ws_server, ws_channel),
    		'me',
    		'70%'
    	);
    };
    
    WS_CONNECTION_FOR_POPUP_CALL_OUT.onerror = function (error) {
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_POPUP_ARSAUTH_STATUS,
    		'WebSocket 연결에 어떤 문제가 있거나 WebSocket 서버가 응답하지 않습니다.',
    		'me',
    		'70%'
    	);
    };
    // most important part - incoming messages
    WS_CONNECTION_FOR_POPUP_CALL_OUT.onmessage = function (message) {
        // try to parse JSON message. Because we know that the server always returns
        // JSON this should work without any problem but we should make sure that
        // the massage is not chunked or otherwise damaged.
        try {
          var JSON_PARSED = JSON.parse(message.data);
        } catch (e) {
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_POPUP_ARSAUTH_STATUS,
	    		'이건 JSON 스트링이 아닌것 같아요! : ' + message.data,
	    		'me',
	    		'70%'
	    	);
			return;
        }
        // NOTE: if you're not sure about the JSON structure
        // check the server source code above
        if ('TYPE' in JSON_PARSED) {
        	var STR_FOR_LOG = '';
			var TYPE = JSON_PARSED.TYPE;
			if (TYPE == 'WS_CONNECTION_ID') {			// 대소문자 구분!
				JSON_ARSAUTH_REQUEST.WS_CONNECTION_ID = JSON_PARSED.WS_CONNECTION_ID;
				$("#STR_JSON_ARSAUTH_REQUEST").val(JSON.stringify(JSON_ARSAUTH_REQUEST, null, '  '));
				$('#BTN_EXEC_ARSAUTH').button({disabled: false });
				STR_FOR_LOG = JSON.stringify(JSON_PARSED);
			} else if (TYPE == 'ARSAUTH-STATUS') {	// 대소문자 구분!
				if (!IS_VALID_REMOTE_FROM(JSON_PARSED)) {
					STR_FOR_LOG = sprintf('%s:%d : %s',
						JSON_PARSED.REMOTE_ADDR,
						JSON_PARSED.REMOTE_PORT,
						'허용되지 않은 원격 주소에서 들어온 패킷 입니다.'
					);
					STR_FOR_LOG = '';
				} else {
				    if (JSON_PARSED.CALL_END) {
					  // 버튼을 다시 활성화!
					  $('#BTN_EXEC_ARSAUTH').button({disabled: false });
					  	if (JSON_PARSED.CALL_STATUS.CODE == 109) {
							STR_FOR_LOG = sprintf('%s:%d : %s',
								JSON_PARSED.REMOTE_ADDR,
								JSON_PARSED.REMOTE_PORT,
								sprintf('%s : %s',JSON_PARSED.CALL_STATUS.CODE_STR, JSON_PARSED.CALL_STATUS.MESSAGE.DETECT_MENT)
							);
					  	} else {
							STR_FOR_LOG = sprintf('%s:%d : %s',
								JSON_PARSED.REMOTE_ADDR,
								JSON_PARSED.REMOTE_PORT,
								'통화가 종료되었습니다.'
							);
					  	}
				    } else {
						STR_FOR_LOG = sprintf('%s:%d : %s',
							JSON_PARSED.REMOTE_ADDR,
							JSON_PARSED.REMOTE_PORT,
							JSON_PARSED.CALL_STATUS.MESSAGE.STEP_ATTRIBUTE
						);
				    }
				}
			} else if (TYPE == 'ARSAUTH_RESULT') {	// 대소문자 구분!
				if (JSON_PARSED.CODE != 200) {
				  // 버튼을 다시 활성화!
				  $('#BTN_EXEC_ARSAUTH').button({disabled: false });
				}
				
				STR_FOR_LOG = JSON.stringify(JSON_PARSED);
			}
			if (STR_FOR_LOG.length > 0) {
		    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
		    		DIV_POPUP_ARSAUTH_STATUS,
		    		STR_FOR_LOG,
		    		'me',
		    		'70%'
		    	);
			}
			
        } else {
			// 버튼을 다시 활성화!
			$('#BTN_EXEC_ARSAUTH').button({disabled: false });
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		DIV_POPUP_ARSAUTH_STATUS,
	    		'흠..., JSON 스트링이 이런식이면 곤란한데...  TYPE 속성이 없쟎아...: ' + JSON.stringify(JSON_PARSED, null, '\t'),
	    		'me',
	    		'70%'
	    	);
        }
    };
    WS_CONNECTION_FOR_POPUP_CALL_OUT.onclose  = function () {
    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
    		DIV_POPUP_ARSAUTH_STATUS,
    		'WebSocket 연결이 끊어졌습니다. 1초 이내에 WebSocket 연결을 재시도 합니다.',
    		'me',
    		'70%'
    	);
		//try to reconnect in 5 seconds
		setTimeout(function(){INIT_WS_CONNECTION_FOR_POPUP_CALL_OUT(ARSAUTH_WS_SERVER_URL_FOR_CALL_OUT, ARSAUTH_WS_CHANNEL)}, 1000);
    };
    
}
function QIIP_ARSAUTH_REQUEST(JSON_ARSAUTH_REQUEST) {
	if (('MULTI_CALL_ENABLE' in JSON_ARSAUTH_REQUEST) && (JSON_ARSAUTH_REQUEST.MULTI_CALL_ENABLE)) {
		if (JSON_ARSAUTH_REQUEST.MULTI_CALL_CURRENT <= JSON_ARSAUTH_REQUEST.MULTI_CALL_FINISH) {
			var LENGTH_FORMAT = '%0' + (11 - JSON_ARSAUTH_REQUEST.MULTI_CALL_PREFIX.length) + 'd';
			if (JSON_ARSAUTH_REQUEST.MULTI_CALL_TARGET == 'CALL_TO') {
				JSON_ARSAUTH_REQUEST.CALL_TO	= sprintf('%s' + LENGTH_FORMAT, JSON_ARSAUTH_REQUEST.MULTI_CALL_PREFIX, JSON_ARSAUTH_REQUEST.MULTI_CALL_CURRENT);
			} else {
				JSON_ARSAUTH_REQUEST.CALL_FROM	= sprintf('%s' + LENGTH_FORMAT, JSON_ARSAUTH_REQUEST.MULTI_CALL_PREFIX, JSON_ARSAUTH_REQUEST.MULTI_CALL_CURRENT);
			}
			JSON_ARSAUTH_REQUEST.MULTI_CALL_CURRENT += 1;
			console.log(JSON_ARSAUTH_REQUEST);
			WS_CONNECTION_FOR_POPUP_CALL_OUT.send(JSON.stringify(JSON_ARSAUTH_REQUEST));
			setTimeout(function () {
				QIIP_ARSAUTH_REQUEST(JSON_ARSAUTH_REQUEST);
			}, JSON_ARSAUTH_REQUEST.MULTI_CALL_DELAY_MS);
		}
	} else {
		WS_CONNECTION_FOR_POPUP_CALL_OUT.send(JSON.stringify(JSON_ARSAUTH_REQUEST));
	}
}
</script>
<div class="qiip_popup">
	<div style="width:100%; height:10%;">
		<table>
			<col width="95%"/>
			<col width=" 5%"/>
			<tr>
				<th style="font-size:250%; text-decoration:bold;">ARS SCENARIO PLAYER DEMONSTRATION WITH {{JSON_ARGS.IVR_ADDR}}</th>
				<td>
					<button style="width:100%;height:100%;" class="QIIP_POPUP_BUTTONS" id='BTN_CLOSE_POPUP'>닫기</button>
				</td>
			</tr>
		</table>
	</div>
	<div style="width:100%; height:85%;">
		<div style="width:90%; height:100%;box-sizing:border-box;padding:1%;float:left;">
			<div style="width:70%; height:100%;border: 1px solid gray;box-sizing:border-box;overflow:auto;float:left;" id="DIV_POPUP_ARSAUTH_STATUS">
			</div>
			<div style="width:30%; height:100%;box-sizing:border-box;float:left;">
				<textarea style="width:100%;height:100%;" id="STR_JSON_ARSAUTH_REQUEST"></textarea>
			</div>
		</div>
		<div style="width:10%; height:100%;box-sizing:border-box;padding:1%;float:left;">
			<button style="width:100%;height:100%;" class="QIIP_POPUP_BUTTONS" id='BTN_EXEC_ARSAUTH'>START<br/><br/>ARS<br/><br/>SCENARIO</button>
		</div>
	</div>
	<div style="width:100%; height:5%;">
		<table>
			<tr>
				<th style="font-size:100%; text-decoration:bold;" colspan="2">
				TECS.CLUB(C) All Rights Reserved.
				</th>
			</tr>
		</table>
	</div>
</div>
