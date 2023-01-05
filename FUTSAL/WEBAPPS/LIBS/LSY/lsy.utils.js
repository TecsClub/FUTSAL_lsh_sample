/* global cordova */
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

function IS_MOBILE() {
	var isMobile = false; //initiate as false
	// device detection
	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
	    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;
	return isMobile;
}

function JSON_PARSE_IF_CAN(STR_JSON) {
	var JSON_RESULT; try { JSON_RESULT = JSON.parse(STR_JSON); } catch(e) { JSON_RESULT = STR_JSON; }
    
	if (JSON_RESULT instanceof Array) {
		var JSON_ARRAY_TEMP = [];
		JSON_RESULT.forEach(function (ONE_ITEM) {
			JSON_ARRAY_TEMP.push(JSON_PARSE_IF_CAN(ONE_ITEM));
		});
		JSON_RESULT = JSON_ARRAY_TEMP;
	} else if (JSON_RESULT instanceof Object) {
		var JSON_OBJ_TEMP	= {};
		var KEYS = Object.keys(JSON_RESULT);
		KEYS.forEach(function (ONE_KEY) {
			JSON_OBJ_TEMP[ONE_KEY] = JSON_PARSE_IF_CAN(JSON_RESULT[ONE_KEY]);
		});
		JSON_RESULT = JSON_OBJ_TEMP;
	}
	return JSON_RESULT;
}

function QIIP_STR_SPLIT (string, splitLength) { // eslint-disable-line camelcase
	//  discuss at: http://locutus.io/php/str_split/
	// original by: Martijn Wieringa
	// improved by: Brett Zamir (http://brett-zamir.me)
	// bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
	//  revised by: Theriault (https://github.com/Theriault)
	//  revised by: Rafał Kukawski (http://blog.kukawski.pl)
	//    input by: Bjorn Roesbeke (http://www.bjornroesbeke.be/)
	//   example 1: str_split('Hello Friend', 3)
	//   returns 1: ['Hel', 'lo ', 'Fri', 'end']

	if (splitLength === null) {
		splitLength = 1
	}
	if (string === null || splitLength < 1) {
		return false
	}

	string += ''
	var chunks = []
	var pos = 0
	var len = string.length

	while (pos < len) {
		chunks.push(string.slice(pos, pos += splitLength))
	}

	return chunks
}

function ARR_TO_TABLE_CENTER(str_arr) {
    var str_HTML  = '';
        str_HTML += '<table>';
    for (var i=0; i<str_arr.length; i++) {
        str_HTML += '<tr>';
        str_HTML += '<td style="text-align:center;">';
        str_HTML += str_arr[i];
        str_HTML += '</td>';
        str_HTML += '</tr>';
    }
        str_HTML += '</table>';
    return str_HTML;
}

function ARR_TO_TABLE(str_arr) {
    var str_HTML  = '';
        str_HTML += '<table>';
    for (var i=0; i<str_arr.length; i++) {
        str_HTML += '<tr>';
        str_HTML += '<td>';
        str_HTML += str_arr[i];
        str_HTML += '</td>';
        str_HTML += '</tr>';
    }
        str_HTML += '</table>';
    return str_HTML;
}

function TO_TABLE_CENTER(str) {
    var str_HTML  = '';
        str_HTML += '<table>';
        str_HTML += '<tr>';
        str_HTML += '<td style="text-align:center;">';
        str_HTML += str;
        str_HTML += '</td>';
        str_HTML += '</tr>';
        str_HTML += '</table>';
    return str_HTML;
}

function TO_TABLE_XMP(str) {
    var str_HTML  = '';
        str_HTML += '<table>';
        str_HTML += '<tr>';
        str_HTML += '<th align="left">';
        str_HTML += '<xmp>';
        str_HTML += str;
        str_HTML += '</xmp>';
        str_HTML += '</th>';
        str_HTML += '</tr>';
        str_HTML += '</table>';
    return str_HTML;
}


function NC_(ARGS, $ionicPopup, FUNC_SUCCESS, FUNC_ERROR) {
    if ($ionicPopup == undefined) {
        if (FUNC_SUCCESS == undefined) 
            FUNC_SUCCESS = function(StrEcho) {   // DEFAULT SUCCESS CALLBACk
                alert(StrEcho);
            };
        if (FUNC_ERROR == undefined) 
            FUNC_ERROR = function(err) {         // DEFAULT ERROR CALLBACk
                alert(err);
            };
    } else {
        if (FUNC_SUCCESS == undefined) 
            FUNC_SUCCESS = function(StrEcho) {   // DEFAULT SUCCESS CALLBACk
                $ionicPopup.alert({
                    title: 'CORDOVA SUCCESS',
                    template: TO_TABLE_CENTER(StrEcho)
                });
            };
        if (FUNC_ERROR == undefined) 
            FUNC_ERROR = function(err) {         // DEFAULT ERROR CALLBACk
                $ionicPopup.alert({
                    title: 'CORDOVA ERROR',
                    template: TO_TABLE_CENTER(err)
                });
            };
    }
    cordova.exec( FUNC_SUCCESS, FUNC_ERROR, "NC", "DUMMY", [ARGS]);
}

function NC(ARGS, $ionicPopup, FUNC_SUCCESS, FUNC_ERROR) {
    if ($ionicPopup == undefined) {
        if (FUNC_SUCCESS == undefined)
            FUNC_SUCCESS = function(StrEcho) {   // DEFAULT SUCCESS CALLBACk
            };
        if (FUNC_ERROR == undefined)
            FUNC_ERROR = function(err) {         // DEFAULT ERROR CALLBACk
            };
    } else {
        if (FUNC_SUCCESS == undefined)
            FUNC_SUCCESS = function(StrEcho) {   // DEFAULT SUCCESS CALLBACk
            };
        if (FUNC_ERROR == undefined)
            FUNC_ERROR = function(err) {         // DEFAULT ERROR CALLBACk
            };
    }
    cordova.exec( FUNC_SUCCESS, FUNC_ERROR, "NC", "DUMMY", [ARGS]);
}

function QIIP_GET_CONTACTS_FOR(TEXT_TARGET, SET_VALUE_NAME, MEMBER_CHECK) {
	if ($('#' + TEXT_TARGET).val().length > 2) {
		QIIP_GET_CONTACTS_FOR_SUB(TEXT_TARGET, SET_VALUE_NAME, MEMBER_CHECK);
	} else {
		if ($('#' + TEXT_TARGET).val().length < 2) {
			$('#' + TEXT_TARGET).attr('placeholder','검색어를 2글자 이상 입력 하십시오.');
		} else {
			QIIP_GET_CONTACTS_FOR_SUB(TEXT_TARGET, SET_VALUE_NAME, MEMBER_CHECK);
		}
	}
}

function QIIP_GET_CONTACTS_FOR_SUB(TEXT_TARGET, SET_VALUE_NAME, MEMBER_CHECK) {
	var ATTR_NAME = SET_VALUE_NAME ? 'DISPLAY_NAME' : 'PHONE_NO';
	if (MEMBER_CHECK != undefined) {
		QIIP_APP_GET_CONTACTS({
			"STR_FILTER"	: $('#'+TEXT_TARGET).val(),
			"DIV_ID_RESULT"	: TEXT_TARGET,
			"FUNC_ON_RESULT": 'QIIP_ON_GET_CONTACTS("' + TEXT_TARGET + '", "' + ATTR_NAME + '")', // TEXT_ONLY, SINGLE_QUOTATION REQUIRED!!
			"MEMBER_CHECK"	: "YES",
		});
	} else {
		QIIP_APP_GET_CONTACTS({
			"STR_FILTER"	: $('#'+TEXT_TARGET).val(),
			"DIV_ID_RESULT"	: TEXT_TARGET,
			"FUNC_ON_RESULT": 'QIIP_ON_GET_CONTACTS("' + TEXT_TARGET + '", "' + ATTR_NAME + '")', // TEXT_ONLY, SINGLE_QUOTATION REQUIRED!!
		});
	}
}

function QIIP_ON_GET_CONTACTS(DIV_ID_TEXT, SET_VALUE) {
	if (SET_VALUE != undefined) {
		$('#'+DIV_ID_TEXT).val(
			$('#'+DIV_ID_TEXT).attr(SET_VALUE)
		);
	}
}

function QIIP_REASSIGN_PHONE_NO_ATTRIBUTE(OBJ) {
	if (QIIP_IS_VALID_PHONE_NO($(OBJ).val())) {
		$(OBJ).attr('PHONE_NO', $(OBJ).val());
		$(OBJ).attr('DISPLAY_NAME',$(OBJ).val());
	}
}

function QIIP_ASSIGN_PHONE_NO_AND_NAME_ATTRIBUTE(ID_PHONE_NO, ID_DISPLAY_NAME, ID_TARGET) {
	var PHONE_NO		= $('#'+ID_PHONE_NO).val();
	if (PHONE_NO.length < 1) return;
	var DISPLAY_NAME	= $('#'+ID_DISPLAY_NAME).val();
	if (DISPLAY_NAME.length < 1) DISPLAY_NAME = PHONE_NO;
	$('#'+ID_TARGET).attr('PHONE_NO',		PHONE_NO);
	$('#'+ID_TARGET).attr('DISPLAY_NAME',	DISPLAY_NAME);
}

function QIIP_TEXT_PHONE_NO_ATTR_TO_OBJECT(DIV_ID_TEXT) {
	return {
		"PHONE_NO":		(($('#'+DIV_ID_TEXT).attr('PHONE_NO') != undefined) && ($('#'+DIV_ID_TEXT).attr('PHONE_NO').length > 0))? $('#'+DIV_ID_TEXT).attr('PHONE_NO') : $('#'+DIV_ID_TEXT).val(),
		"MEMBER":		$('#'+DIV_ID_TEXT).attr('MEMBER'),
		"DISPLAY_NAME":	$('#'+DIV_ID_TEXT).attr('DISPLAY_NAME')
	};
}

// RegExp에 중괄호가 있기 때문에 xe COMPILE 불가...
function QIIP_IS_VALID_PHONE_NO(TEST_NUMBER) {
	if (TEST_NUMBER == undefined) return false;
	if (TEST_NUMBER.length < 9) return false;
	if (TEST_NUMBER.length > 12) return false;
	var patt_ALPHA_EXIST = new RegExp(/[A-Za-z]+/);
	if (patt_ALPHA_EXIST.test(TEST_NUMBER)) return false;
//	var patt_PHONE_NO = new RegExp(/0\d{1,2}\-\d{3,4}\-\d{4}|0\d{1,2}\d{3,4}\d{4}/);
	var patt_PHONE_NO = new RegExp(/0\d{1,3}\-\d{3,4}\-\d{4}|0\d{1,3}\d{3,4}\d{4}/);
	return patt_PHONE_NO.test(TEST_NUMBER);
}
function QIIP_IS_VALID_M_PHONE_NO(TEST_NUMBER) {
	if (TEST_NUMBER == undefined) return false;
	if (TEST_NUMBER.length < 10) return false;
	if (TEST_NUMBER.length > 11) return false;
	var patt_ALPHA_EXIST = new RegExp(/[A-Za-z]+/);
	if (patt_ALPHA_EXIST.test(TEST_NUMBER)) return false;
	var patt_PHONE_NO = new RegExp(/01[0,1,7,8,9]\-\d{3,4}\-\d{4}|01[0,1,7,8,9]\d{3,4}\d{4}/);
	return patt_PHONE_NO.test(TEST_NUMBER);
}
function QIIP_IS_VALID_EMAIL(TEST_STRING) {
	var EMAIL_REGEXP = /^[a-z0-9!#$%&'*+\/=?^_`{|}~.-]+@[a-z0-9]([a-z0-9-]*[a-z0-9])?(\.[a-z0-9]([a-z0-9-]*[a-z0-9])?)*$/i;
	return EMAIL_REGEXP.test(TEST_STRING);
}

function TO_KOREAN_READABLE(PhoneNo) {
	var t = PhoneNo;
	var result = "";
	if (t.substring(0,2) == "02") {
		if (t.length < 10) {
			result = t.substring(0,2) + "-" + t.substring(2,5) + "-" + t.substring(5);
		} else {
			result = t.substring(0,2) + "-" + t.substring(2,6) + "-" + t.substring(6);
		}
	} else if (t.substring(0,1) != "0") {
		result = t.substring(0,4) + "-" + t.substring(4);
	} else {
		if (t.length < 11) {
			result = t.substring(0,3) + "-" + t.substring(3,6) + "-" + t.substring(6);
		} else {
			result = t.substring(0,3) + "-" + t.substring(3,7) + "-" + t.substring(7);
		}
	}
	return result;
}

function QIIP_APP_SECS_TO_TIME_STRING(secs) {
    secs = Math.round(secs);
    var hours = Math.floor(secs / (60 * 60));

    var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);

    var divisor_for_seconds = divisor_for_minutes % 60;
    var seconds = Math.ceil(divisor_for_seconds);

    var result =
    	(hours > 0 ? hours + " 시간 " : "") +
    	((hours > 0) || (minutes > 0) ? minutes + " 분 " : "") + seconds + " 초";

    return "[" + result + "]";
}

function QIIP_APP_IMAGE_UPDATE(strJSON_BASE64) {
	var objParam = JSON.parse(Base64.decode(strJSON_BASE64));
//	console.log(JSON.stringify(objParam));
	if (objParam.IMAGE_ID != "") {
		$("#" + objParam.IMAGE_ID).attr("src", "data:image/jpeg;base64," + objParam.IMAGE_DATA_BASE64);
	}
}

function QIIP_APP_OBJ_KEY_VALUE(KEY, VALUE) {
	return {"KEY" : KEY, "VALUE": VALUE};
}

var  QIIP_APP_LOG_CONSOLE = {
        CHAT_TOGGLE: true
     };
QIIP_APP_LOG_CONSOLE.CHAT_LOG = function(div_scroll, message, talker, width) {
    var element_scroll = document.querySelector('#' + div_scroll);

    var div = document.createElement('div');
    div.classList.add('bubble');
    if (talker != undefined) {
    	div.classList.add(talker);
    } else {
        if (QIIP_APP_LOG_CONSOLE.CHAT_TOGGLE) {
            div.classList.add('me');
        } else {
            div.classList.add('you');
        }
        QIIP_APP_LOG_CONSOLE.CHAT_TOGGLE = !QIIP_APP_LOG_CONSOLE.CHAT_TOGGLE;
    }
    if (width != undefined) {
    	div.style.minWidth = width;
    }
//    div.innerHTML = '<xmp>' + message + '</xmp>';
    div.innerHTML = message;
    element_scroll.appendChild(div);

    while (element_scroll.childNodes.length > 100) {
        element_scroll.removeChild(element_scroll.firstChild);
    }
    element_scroll.scrollTop = element_scroll.scrollHeight;

};

function QIIP_APP_SET_CALLBACK_SCRIPT(TARGET, CALLBACK_SCRIPT) {
	NC({
		CMD: 'SET_CALLBACK_SCRIPT',
		TARGET: TARGET,
		CALLBACK_SCRIPT: CALLBACK_SCRIPT
	});
}

function QIIP_APP_GET_CONTACTS(OBJ_PARAMS) {
	if (OBJ_PARAMS.STR_FILTER == undefined) OBJ_PARAMS.STR_FILTER = "";
	NC({
			CMD: 'GET_CONTACTS',
			STR_FILTER: OBJ_PARAMS.STR_FILTER,
		},
		undefined,
		function (RESULT) {
//			alert(JSON.stringify(RESULT, null, '\t'));
			OBJ_PARAMS.JSON_ARRAY_CONTACTS = RESULT;
			if (OBJ_PARAMS.MEMBER_CHECK != undefined) {
				QIIP_APP_SELECT_ONE_ITEM_FROM_CONTACTS_MEMBER_CHECK(OBJ_PARAMS);
			} else {
				QIIP_APP_SELECT_ONE_ITEM_FROM_CONTACTS(OBJ_PARAMS);
			}
		}
	);
}

function QIIP_APP_SELECT_ONE_ITEM_FROM_CONTACTS(OBJ_PARAMS) {
	
	var JSON_ARGS_BASE64 = Base64.encode(JSON.stringify(OBJ_PARAMS));
	
	NC(
		{
		  CMD: 'HTTP_ACCESS',
		  HttpAccessInformation: {
				"SERVER_URL" : API_SERVER_URL,
				"PARAMS" : [
					QIIP_APP_OBJ_KEY_VALUE("cmd", "api_GetPage"),
					QIIP_APP_OBJ_KEY_VALUE("FLDR_TEMPLATE", "IONIC/COMMONS/POPUP"),
					QIIP_APP_OBJ_KEY_VALUE("FILE_TEMPLATE", "SELECT_ONE_ITEM_FROM_CONTACTS.html"),
					QIIP_APP_OBJ_KEY_VALUE("XE_COMPILE", "YES"),
					QIIP_APP_OBJ_KEY_VALUE("JSON_ARGS_BASE64", JSON_ARGS_BASE64),
				]
			}
		},
		undefined,
		function(RESULT) {
			var OBJ_POPUP = QIIP_JQX_POPUP_WINDOW({
	            showCollapseButton: true, 
	            height: '95%',
	            width: '90%',
	            minHeight: 100,
	            minWidth: 100,
//	            position: [0, TOP_MARGIN_Y],
				},
				'연락처 선택',
				RESULT.RESULT_CONTENTS
			);
/*
			if (OBJ_PARAMS.TOP_MARGIN != undefined) {
				var MARGIN_X = ((100 - 90) / 2) * parseInt($(window).height()) / 100;
				var MARGIN_Y = OBJ_PARAMS.TOP_MARGIN * parseInt($(window).height()) / 100;
				OBJ_POPUP.jqxWindow('move', MARGIN_X, MARGIN_Y);
			}
*/

			INIT_WIDGETS_FOR_POPUP_SELECT_ONE_ITEM_FROM_CONTACTS(OBJ_POPUP);
		}
	);
}

function QIIP_APP_SELECT_ONE_ITEM_FROM_CONTACTS_MEMBER_CHECK(OBJ_PARAMS) {
	NC(
		{
		  CMD: 'HTTP_ACCESS',
		  HttpAccessInformation: {
				"SERVER_URL" : API_SERVER_URL,
				"PARAMS" : [
					QIIP_APP_OBJ_KEY_VALUE("cmd", "api_FilterContacts"),
					QIIP_APP_OBJ_KEY_VALUE("VARS", OBJ_PARAMS),
				]
			}
		},
		undefined,
		function(RESULT) {
			QIIP_APP_SELECT_ONE_ITEM_FROM_CONTACTS(RESULT.RESULT_CONTENTS);
		}
	);
}

function QIIP_POPUP_FOR_ALERT(TITLE, ARRAY_FOR_MESSAGE, FUNC_OK, args_WIDTH, args_HEIGHT, TIME_TO_CLOSE, NO_BUTTON) {
	var FLAG_NO_BUTTON = false; if (NO_BUTTON != undefined) FLAG_NO_BUTTON = NO_BUTTON;
	var JSON_ARGS_BASE64 = Base64.encode(JSON.stringify({
		ARRAY_FOR_MESSAGE:	ARRAY_FOR_MESSAGE,
		FLAG_NO_BUTTON:		FLAG_NO_BUTTON
	}));
	var WIDTH  = '70%'; if (args_WIDTH  != undefined) WIDTH  = args_WIDTH  + '%';
	var HEIGHT = '75%'; if (args_HEIGHT != undefined) HEIGHT = args_HEIGHT + '%';
	QIIP_HTTP_ACCESS(
		undefined,
		undefined,{
			"DESK_TOP": !ACCESS_FROM_APP,
			"SERVER_URL" : API_SERVER_URL,
			"PARAMS" : [
				QIIP_APP_OBJ_KEY_VALUE("cmd", "api_GetPage"),
				QIIP_APP_OBJ_KEY_VALUE("FLDR_TEMPLATE", "IONIC/COMMONS/POPUP"),
				QIIP_APP_OBJ_KEY_VALUE("FILE_TEMPLATE", "POPUP_FOR_ALERT.html"),
				QIIP_APP_OBJ_KEY_VALUE("JSON_ARGS_BASE64", JSON_ARGS_BASE64),
			]
		}, function (RESULT) {
			var OBJ_POPUP = QIIP_JQX_POPUP_WINDOW({
	            showCollapseButton: true, 
	            height: HEIGHT,
	            width: WIDTH,
	            minHeight: 100,
	            minWidth: 100,
				},
				TITLE,
				RESULT
			);
		  	INIT_WIDGETS_POPUP_FOR_ALERT(OBJ_POPUP, FUNC_OK, TIME_TO_CLOSE);
		}
	);
}

function QIIP_POPUP_FOR_YES_NO(TITLE, ARRAY_FOR_MESSAGE, FUNC_YES, FUNC_NO,  args_WIDTH, args_HEIGHT, TIME_TO_CLOSE) {
	var JSON_ARGS_BASE64 = Base64.encode(JSON.stringify(ARRAY_FOR_MESSAGE));
	var WIDTH  = '70%'; if (args_WIDTH  != undefined) WIDTH  = args_WIDTH  + '%';
	var HEIGHT = '75%'; if (args_HEIGHT != undefined) HEIGHT = args_HEIGHT + '%';
	QIIP_HTTP_ACCESS(
		undefined,
		undefined,{
			"DESK_TOP": !ACCESS_FROM_APP,
			"SERVER_URL" : API_SERVER_URL,
			"PARAMS" : [
				QIIP_APP_OBJ_KEY_VALUE("cmd", "api_GetPage"),
				QIIP_APP_OBJ_KEY_VALUE("FLDR_TEMPLATE", "IONIC/COMMONS/POPUP"),
				QIIP_APP_OBJ_KEY_VALUE("FILE_TEMPLATE", "POPUP_FOR_YES_NO.html"),
				QIIP_APP_OBJ_KEY_VALUE("JSON_ARGS_BASE64", JSON_ARGS_BASE64),
			]
		}, function (RESULT) {
			var OBJ_POPUP = QIIP_JQX_POPUP_WINDOW({
	            showCollapseButton: true, 
	            height: HEIGHT,
	            width: WIDTH,
	            minHeight: 100,
	            minWidth: 100,
				},
				TITLE,
				RESULT
			);
		  	INIT_WIDGETS_POPUP_FOR_YES_NO(OBJ_POPUP, FUNC_YES, FUNC_NO, TIME_TO_CLOSE);
		}
	);
}


function QIIP_APP_VOICE_TRANSCRIPTION(strJSON_BASE64) {
	var objParam = JSON.parse(Base64.decode(strJSON_BASE64));
//	console.log(JSON.stringify(objParam));
	if (!('DIV_SCROLL' in objParam)) return;
	QIIP_APP_LOG_CONSOLE.CHAT_LOG(objParam.DIV_SCROLL, JSON.stringify(objParam.CALLBACK_PARAMS), undefined, '70%');
}

function QIIP_APP_NATIVE_ACCESS(NATIVE_ACCESS_INFORMATION) {
	var strJSON_Param = JSON.stringify(NATIVE_ACCESS_INFORMATION);
	return WEB_UI_Interface.NATIVE_CALL(strJSON_Param);
}

function QIIP_DISP_SPEECH_RECOGNITION_DIALOG(PROMPT_BASE64) {
	var ARR_PROMPT = JSON.parse(Base64.decode(PROMPT_BASE64));
	var TITLE = '음성 인식 기능이 동작 중 입니다.';
	var strHTML  = '';
		strHTML += '<div style="height:5%;" class="WV_STT_PROGRESSBAR"></div>';
		strHTML += '<div style="height:95%;">';
			strHTML += "<table class=\"BOX_RESULT\">";
			for (var i=0; i<ARR_PROMPT.length; i++) {
				if (ARR_PROMPT[i].length > 0) {
				strHTML += "<tr>";
				if (i == 0) {
					strHTML += "<th>" + ARR_PROMPT[i] + "</th>";
				} else {
					strHTML += "<td>" + ARR_PROMPT[i] + "</td>";
				}
				strHTML += "</tr>";
				}
			}
			strHTML += "</table>";
		strHTML += '</div>';
/*
	QIIP_SPEECH_RECOGNITION_DIALOG = qiip_dialog_with_buttons(
		strHTML, 50, TITLE, [
			{'FUNC_EXEC':'QIIP_DISP_SPEECH_RECOGNITION_CANCLE()', 'STR_BUTTON':'음성 인식 취소'},
			{'FUNC_EXEC':'qiip_nop()', 'STR_BUTTON':'이게뭐야?'},
		]
	);
*/
	QIIP_SPEECH_RECOGNITION_DIALOG = qiip_dialog_for_speech_recognition(
		strHTML,
		'QIIP_DISP_SPEECH_RECOGNITION_CANCLE()',
		50,
		TITLE
	);
//	QIIP_SPEECH_RECOGNITION_DIALOG = qiip_info_dialog_no_button(strHTML, 50, TITLE);
	$( ".WV_STT_PROGRESSBAR" ).progressbar({value:1, max:100});
}

function QIIP_DISP_SPEECH_RECOGNITION_CANCLE() {
	var NATIVE_ACCESS_INFORMATION = {
			"REQUEST" : "SPEECH_RECOGNITION_CANCLE",
		};

	var result = JSON.parse(QIIP_APP_NATIVE_ACCESS(NATIVE_ACCESS_INFORMATION));
	return result;
}

function QIIP_DISP_SPEECH_RECOGNITION_DIALOG_SUB(strHTML, HEIGHT, TITLE) {
	QIIP_SPEECH_RECOGNITION_DIALOG = qiip_info_dialog_no_button(strHTML, HEIGHT, TITLE);
	$( ".WV_STT_PROGRESSBAR" ).progressbar({value:1, max:100});
}

function QIIP_CLOSE_SPEECH_RECOGNITION_DIALOG() {
	qiip_close_dialog(QIIP_SPEECH_RECOGNITION_DIALOG);
}

function QIIP_TTS_PROGRESSBAR_POSITION(position) {
   $( ".WV_TTS_PROGRESSBAR" ).progressbar( "value", position );
}

function QIIP_STT_PROGRESSBAR_POSITION(position) {
   $( ".WV_STT_PROGRESSBAR" ).progressbar( "value", position );
}

function QIIP_SET_CONTENTS_FROM_REQUEST_WITH_STR_JSON(strJSON) {
//	console.log(strJSON);
    try{
		var objParam = JSON.parse(strJSON);
//		console.log(JSON.stringify(objParam));
//		alert(JSON.stringify(objParam));
//		alert(objParam.Contents);
//		console.log(objParam.Contents);
		if (objParam.FILL_TYPE == "HTML")	{
			if ((objParam.DIV_ID_RESULT != undefined) && (objParam.DIV_ID_RESULT != ""))	$("#" + objParam.DIV_ID_RESULT).html(objParam.Contents);
		} else {
			if ((objParam.DIV_ID_RESULT != undefined) && (objParam.DIV_ID_RESULT != ""))	$("#" + objParam.DIV_ID_RESULT).text(objParam.Contents);
		}
		if ((objParam.FUNC_EXEC != undefined) && (objParam.FUNC_EXEC != ""))			eval(objParam.FUNC_EXEC);
    } catch (e) {
		console.log('Exception in ' + e);
    }

}

function QIIP_SET_CONTENTS_WITH_STR_JSON_BASE64(strJSON_BASE64) {
//	console.log(strJSON_BASE64);
//	console.log(Base64.decode(strJSON_BASE64));
    try{
//		var STR_JSON_objParam = decodeURIComponent(Base64.decode(strJSON_BASE64));
//		var objParam = JSON.parse(STR_JSON_objParam);

		var objParam = JSON.parse(Base64.decode(strJSON_BASE64));
		
//		console.log(JSON.stringify(objParam));
//		alert(JSON.stringify(objParam));
//		alert(objParam.Contents);
//		console.log(objParam.Contents);
		if (objParam.FILL_TYPE == "HTML")	{
			if ((objParam.DIV_ID_RESULT != undefined) && (objParam.DIV_ID_RESULT != ""))	$("#" + objParam.DIV_ID_RESULT).html(objParam.Contents);
		} else {
			if ((objParam.DIV_ID_RESULT != undefined) && (objParam.DIV_ID_RESULT != ""))	$("#" + objParam.DIV_ID_RESULT).text(objParam.Contents);
		}
		if ((objParam.FUNC_EXEC != undefined) && (objParam.FUNC_EXEC != ""))			eval(objParam.FUNC_EXEC);
    } catch (e) {
		console.log('Exception in ' + e);
    }

}

function QIIP_JQX_CLOSE_WINDOW(args_OBJ_WINDOW) {
	args_OBJ_WINDOW.jqxWindow('close');
}

var QIIP_JQX_POPUP_WINDOW_ARRAY = [];

function QIIP_JQX_POPUP_WINDOW(args_Properties, HTML_TITLE, HTML_CONTENTS) {
	var RESULT_QIIP_POPUP_WINDOW = null;
	var FLAG_OPEN_EXIST_WINDOW = false;
	var ACTIVE_INDEX = -1;

	for (var i=0; i<QIIP_JQX_POPUP_WINDOW_ARRAY.length; i++) {
		if (!QIIP_JQX_POPUP_WINDOW_ARRAY[i].jqxWindow('isOpen')) {
			QIIP_JQX_POPUP_WINDOW_ARRAY[i].jqxWindow('destroy');
			QIIP_JQX_POPUP_WINDOW_ARRAY[i].jqxWindow(args_Properties);
			QIIP_JQX_POPUP_WINDOW_ARRAY[i].jqxWindow('setTitle',   HTML_TITLE);
			QIIP_JQX_POPUP_WINDOW_ARRAY[i].jqxWindow('setContent', HTML_CONTENTS);
			QIIP_JQX_POPUP_WINDOW_ARRAY[i].jqxWindow('open');
			QIIP_JQX_POPUP_WINDOW_ARRAY[i].jqxWindow('bringToFront');
			FLAG_OPEN_EXIST_WINDOW = true;
			RESULT_QIIP_POPUP_WINDOW = QIIP_JQX_POPUP_WINDOW_ARRAY[i];
			ACTIVE_INDEX = i;
			break;
		}
	}
	
	if (!FLAG_OPEN_EXIST_WINDOW) {
		var COUNT = QIIP_JQX_POPUP_WINDOW_ARRAY.length;
		$(document.body).append(
			'<div id="QIIP_POPUP_WINDOW_' + COUNT + '">' + 
				'<div id="QIIP_POPUP_WINDOW_HEADER' + COUNT + '" >Header ' + COUNT + '</div>' +
				'<div id="QIIP_POPUP_WINDOW_CONTENTS' + COUNT + '">Content of window ' + COUNT + '</div>' + 
			'</div>'
		);
		$('#QIIP_POPUP_WINDOW_' + COUNT).jqxWindow(args_Properties);
		$('#QIIP_POPUP_WINDOW_' + COUNT).jqxWindow('setTitle',   HTML_TITLE);
		$('#QIIP_POPUP_WINDOW_' + COUNT).jqxWindow('setContent', HTML_CONTENTS);
		$('#QIIP_POPUP_WINDOW_' + COUNT).jqxWindow('open');
		$('#QIIP_POPUP_WINDOW_' + COUNT).jqxWindow('bringToFront');
		RESULT_QIIP_POPUP_WINDOW = $('#QIIP_POPUP_WINDOW_' + COUNT);
		ACTIVE_INDEX = COUNT;
		QIIP_JQX_POPUP_WINDOW_ARRAY.push(RESULT_QIIP_POPUP_WINDOW);
	}
//	console.log('QIIP_JQX_POPUP_WINDOW = QIIP_POPUP_WINDOW_' + ACTIVE_INDEX);
	return RESULT_QIIP_POPUP_WINDOW;
}

function QIIP_POST_ACCESS_LOG(JSON_ARGS) {

	var PARAMS = [
				QIIP_APP_OBJ_KEY_VALUE("cmd", "api_LOG"),
				QIIP_APP_OBJ_KEY_VALUE("STR_JSON_LOG", JSON.stringify(JSON_ARGS)),
			];
	if (!ACCESS_FROM_APP) {
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("PHONE_ID", _RS.PHONE_INFO.PHONE_ID));
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("PHONE_NO", _RS.PHONE_INFO.PHONE_NO));
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("CATEGORY", _RS.PHONE_INFO.APP_NAME));
	}

	QIIP_HTTP_ACCESS(
		undefined,
		undefined,{
			"DESK_TOP": !ACCESS_FROM_APP,
			"SERVER_URL" : API_SERVER_URL,
			"PARAMS" : PARAMS
		}, function (RESULT) {
		}
	);

/*
	NC({
		CMD: 'POST_ACCESS_LOG',
		JSON_ARGS: JSON_ARGS
	});
*/
}

function QIIP_HTTP_ACCESS($ionicPopup, ionicPopup_OPTIONS, HttpAccessInformation, ON_RESULT) {
	if (HttpAccessInformation == undefined) return;
	if ('DESK_TOP' in HttpAccessInformation) {
		if (HttpAccessInformation.DESK_TOP) {
			QIIP_HTTP_ACCESS_WEB($ionicPopup, ionicPopup_OPTIONS, HttpAccessInformation, ON_RESULT);
			return;
		}
	}
	if ($ionicPopup != undefined) {
		var OBJ_POPUP = $ionicPopup.show(ionicPopup_OPTIONS);
	}
	NC({
		CMD: 'HTTP_ACCESS',
		HttpAccessInformation: HttpAccessInformation,
	},
	$ionicPopup,
	function(RESULT) {
		if (OBJ_POPUP != undefined) OBJ_POPUP.close();
		if (ON_RESULT != undefined) ON_RESULT(RESULT.RESULT_CONTENTS);
	});
}

function QIIP_WP_ACCESS(PHP_CODES, ON_RESULT, ARRAY_PARAMS) {
	var PARAMS = [];
		PARAMS.push(
			QIIP_APP_OBJ_KEY_VALUE("cmd", "api_WP_ACCESS")
		);
		PARAMS.push(
			QIIP_APP_OBJ_KEY_VALUE("PHP_CODES", PHP_CODES)
		);
	if (ARRAY_PARAMS != undefined) {
		ARRAY_PARAMS.forEach(function (ONE_PARAM) {
			PARAMS.push(ONE_PARAM);
		});
	}
	
	QIIP_HTTP_ACCESS(
		undefined,
		undefined,{
			"DESK_TOP": true,
			"SERVER_URL" : window.location.origin,
			"PARAMS" : PARAMS
		}, function (RESULT) {
			if (ON_RESULT != undefined) ON_RESULT(RESULT);
		}
	);
}

function QIIP_HTTP_ACCESS_WEB($ionicPopup, ionicPopup_OPTIONS, HttpAccessInformation, ON_RESULT) {

	if (HttpAccessInformation == undefined) return;

	if ($ionicPopup != undefined) {
		var OBJ_POPUP = $ionicPopup.show(ionicPopup_OPTIONS);
	}
	
//	alert(JSON.stringify(HttpAccessInformation, null, '\t'));
/*
	var POST_DATAS = {PASS:1};
	if ('PARAMS' in HttpAccessInformation) {
		HttpAccessInformation.PARAMS.forEach(function (KEY_VALUE) {
			POST_DATAS[KEY_VALUE.KEY] = KEY_VALUE.VALUE;
		});
	}
//	alert(JSON.stringify(POST_DATAS, null, '\t'));
	if ('ATTACHES' in HttpAccessInformation) {
		HttpAccessInformation.ATTACHES.forEach(function (ONE_ATTACH) {
			POST_DATAS[ONE_ATTACH.NAME] = new FormData($('#' + ONE_ATTACH.DOM_ID));
		});
		alert(JSON.stringify(POST_DATAS, null, '\t'));
	}
*/

	var POST_DATAS = new FormData();
		POST_DATAS.append('PASS',"1");
	if (window.location.origin != HttpAccessInformation.SERVER_URL) {
//		alert(sprintf('%s vs %s', window.location.origin, HttpAccessInformation.SERVER_URL));
		POST_DATAS.append('cmd', 'api_HTTP_ACCESS');
		POST_DATAS.append('URL', HttpAccessInformation.SERVER_URL);
		HttpAccessInformation.SERVER_URL = window.location.origin;
	}
	if ('PARAMS' in HttpAccessInformation) {
		HttpAccessInformation.PARAMS.forEach(function (KEY_VALUE) {
			POST_DATAS.append(KEY_VALUE.KEY, KEY_VALUE.VALUE);
		});
	}
	
//	alert(JSON.stringify(POST_DATAS, null, '\t'));
	if ('ATTACHES' in HttpAccessInformation) {
		HttpAccessInformation.ATTACHES.forEach(function (ONE_ATTACH) {
			POST_DATAS.append(ONE_ATTACH.NAME, ONE_ATTACH.FILE);
		});
	}
	
	
	$.ajax({
		url : HttpAccessInformation.SERVER_URL,
		type : 'post',
		data : POST_DATAS,
		async: true, 
		contentType: false,
		processData: false,
//		dataType : "text",
//		contentType:"application/json; charset=UTF-8",
		success : function(result) {
			if (OBJ_POPUP != undefined) OBJ_POPUP.close();
			if (ON_RESULT != undefined) ON_RESULT(result);
		},
		error : function(request,status,error) {
			var str_error_info = "code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error;
//			console.log(str_error_info);
			if (OBJ_POPUP != undefined) OBJ_POPUP.close();
			if (ON_RESULT != undefined) ON_RESULT(str_error_info);
		}
	});
	
}

function QIIP_UPDATE_POST_ROOT(OBJ_UPDATE, ON_FINISH) {
	var PARAMS = [];
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("cmd","api_UPDATE_ROOT_INFO"));
		
	if ('TITLE_UPDATE' in OBJ_UPDATE) {
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("TITLE_UPDATE", OBJ_UPDATE.TITLE_UPDATE));
		delete(OBJ_UPDATE.TITLE_UPDATE);
	}
	if ('BASE64' in OBJ_UPDATE) {
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("BASE64_STR_JSON_UPDATE", Base64.encode(JSON.stringify(OBJ_UPDATE))));
	} else {
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("STR_JSON_UPDATE", JSON.stringify(OBJ_UPDATE)));
	}

/*	
	if ('DESK_TOP' in OBJ_UPDATE) {
		var PHONE_ID = OBJ_UPDATE.PHONE_ID; delete(OBJ_UPDATE.PHONE_ID);
		var PHONE_NO = OBJ_UPDATE.PHONE_NO; delete(OBJ_UPDATE.PHONE_NO);
		var CATEGORY = OBJ_UPDATE.CATEGORY; delete(OBJ_UPDATE.CATEGORY);
		delete(OBJ_UPDATE.DESK_TOP);

		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("PHONE_ID", PHONE_ID));
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("PHONE_NO", PHONE_NO));
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("CATEGORY", CATEGORY));
	}
*/
	
	if (!ACCESS_FROM_APP) {
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("PHONE_ID", _RS.PHONE_INFO.PHONE_ID));
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("PHONE_NO", _RS.PHONE_INFO.PHONE_NO));
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("CATEGORY", _RS.PHONE_INFO.APP_NAME));
	}
	
//	alert(JSON.stringify(PARAMS, null, '\t'));
	
	QIIP_HTTP_ACCESS(
		undefined,
		undefined,{
			"DESK_TOP": !ACCESS_FROM_APP,
			"SERVER_URL" : API_SERVER_URL,
			"PARAMS" : PARAMS
		},
		ON_FINISH
	);
}

function QIIP_UPDATE_POST_ROOT_WITH_CATEGORY(STR_CATEGORY, OBJ_UPDATE, ON_FINISH) {
	var PARAMS = [
				QIIP_APP_OBJ_KEY_VALUE("cmd","api_UPDATE_ROOT_INFO"),
				QIIP_APP_OBJ_KEY_VALUE("STR_JSON_UPDATE", JSON.stringify(OBJ_UPDATE)),
				QIIP_APP_OBJ_KEY_VALUE("STR_CATEGORY", STR_CATEGORY),
			];
	if (!ACCESS_FROM_APP) {
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("PHONE_ID", _RS.PHONE_INFO.PHONE_ID));
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("PHONE_NO", _RS.PHONE_INFO.PHONE_NO));
		PARAMS.push(QIIP_APP_OBJ_KEY_VALUE("CATEGORY", _RS.PHONE_INFO.APP_NAME));
	}

	QIIP_HTTP_ACCESS(
		undefined,
		undefined,{
			"DESK_TOP": !ACCESS_FROM_APP,
			"SERVER_URL" : API_SERVER_URL,
			"PARAMS" : PARAMS
		},
		ON_FINISH
	);
}
