var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

var FLAG_PREVENT_TWICE_CLICK = false;
var IVR_APIKEY = '8391b7038eb10f6e0d6d2adac1980e48';
var IVR_NUMBER = '18776421';
var _API_SERVER_URL = window.location.origin;
var _FLDR_TEMPLATE_BASE = '';
var _FLDR_TEMPLATE = '';
var _WP_ROOT = '';
var ANGULAR_WEBAPPS;
var _RS = {};
var _AC = {};
var _FT = {};


var ID_UNIQUE_INDEX = 0;
function GET_UNIQUE_INDEX() {
	ID_UNIQUE_INDEX = (ID_UNIQUE_INDEX + 1) % 10000000;
	return ID_UNIQUE_INDEX;
}

function QIIP_ANGULAR_INIT(ARGS) {
	ANGULAR_WEBAPPS = angular.module(ARGS.ng_app, ARGS.ng_app_injects);
	ANGULAR_WEBAPPS.controller(ARGS.ng_controller, function ($scope, $compile, $filter) {
		_RS = $scope;
		_AC = $compile;
		_FT = $filter;
		if (ARGS.hasOwnProperty('PHONE_INFO'))	_RS.PHONE_INFO = ARGS.PHONE_INFO;
		if (ARGS.hasOwnProperty('AUX_INFO'))	_RS.AUX_INFO = ARGS.AUX_INFO;
		_RS.FORCE_WEB = false;
		if ('FORCE_WEB' in ARGS) _RS.FORCE_WEB = ARGS.FORCE_WEB;

		if (typeof WEB_UI_Interface !== 'undefined') {
			_RS._ACCESS_FROM_APP = true;
		} else {
			_RS._ACCESS_FROM_APP = false;
		}
		if (_RS.FORCE_WEB) _RS._ACCESS_FROM_APP = false;

		_RS._IS_MOBILE = QIIP_IS_MOBILE();
	});
	ANGULAR_WEBAPPS.filter('prettyJSON', function () {
		return function(json) {
			if (json instanceof Object) {
//				return angular.toJson(json, true).replace(/^\s+|\s+$/g,'');
//				return JSON.stringify(json, null, '\t');
				return angular.toJson(json, true);
			} else {
				var STR_JSON = (json != undefined) ? json.replace(/(<([^>]+)>)/gi, '') : '';
				var JSON_RESULT = JSON_PARSE_IF_CAN(unescape(STR_JSON));
				if (JSON_RESULT instanceof Object) {
//					return angular.toJson(JSON_RESULT, true).replace(/^\s+|\s+$/g,'');
//					return JSON.stringify(JSON_RESULT, null, '\t');
					return angular.toJson(JSON_RESULT, true);
				} else {
//					return json.replace(/^\s+|\s+$/g,'');
					return json;
				}
			}
		}
	});

	if(!('QIIP_APP_INIT_FUNC' in ARGS)){
		QIIP_APP_INIT();
	} else {
		ARGS.QIIP_APP_INIT_FUNC();
	}
	
}

function QIIP_CLONE(args_JSON) {
	return JSON.parse(JSON.stringify(args_JSON));
}

function QIIP_REGIST_RS_FUNCTION(FUNC_NAME, FUNC) {
	_RS[FUNC_NAME] = FUNC;
}

function QIIP_STATIC_HTML(JSON_ARGS, STR_HTML) {
	_RS.JSON_ARGS = JSON_ARGS;
	var HTML_COMPILED = _AC(STR_HTML)(_RS); 
	$('body').append('<div id="DIV_TEMP_FOR_STATIC_HTML" style="display:hidden;"></div>');
	$('#DIV_TEMP_FOR_STATIC_HTML').html(HTML_COMPILED);
	_RS.$apply();
	var HTML_RESULT =  $('#DIV_TEMP_FOR_STATIC_HTML').html();
	delete(_RS.JSON_ARGS);
	$('#DIV_TEMP_FOR_STATIC_HTML').remove();
	return HTML_RESULT;
}

function QIIP_INIT_BODY_SIZE() {
	/* HTML5 표준이 정해져 있다. 
	// 가로 길이
	window.innerWidth // 브라우저 윈도우 두께를 제외한 실질적 가로 길이
	window.outerWidth // 브라우저 윈도우 두께를 포함한 브라우저 전체 가로 길이
	//세로길이
	window.innerHeight // 브라우저 윈도우 두께를 제외한 실질적 세로 길이
	window.outerHeight // 브라우저 
	*/
	$('body').css('width',  window.innerWidth);
	$('body').css('height', window.innerHeight);
}

function QIIP_APP_INIT() {
	$(window).resize(function() {
		QIIP_INIT_BODY_SIZE();
	});
	
//	alert($.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop);
//	alert($.fn.modal.prototype.constructor.Constructor.DEFAULTS.keyboard);
	
	$.fn.modal.prototype.constructor.Constructor.DEFAULTS.backdrop = 'static';
	$.fn.modal.prototype.constructor.Constructor.DEFAULTS.keyboard =  false;

	$(document).on('show.bs.modal', '.modal', function (event) {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
	
	QIIP_INIT_BODY_SIZE();
	setTimeout(function() {
		if (_RS._ACCESS_FROM_APP) {
			QIIP_APPS_NATIVE_ACCESS({
				REQUEST: 'GET_START_UP_CONFIG',
				FULL_CONTENTS: false,
				STR_KEY: 'API_SERVER_URL',
			}, function (RESULT) {
				_API_SERVER_URL = RESULT;
				QIIP_APP_SET_WP_ROOT();
			});
		} else {
			QIIP_APP_SET_WP_ROOT();
		}
	}, 10);
}

function QIIP_APP_ALERT(args_MESSAGE, FUNC_OK, FUNC_CLOSE, TIMEOUT) {
	var UNIQUE_ID = sprintf("ALERT_%08d", GET_UNIQUE_INDEX());
	var JSON_ARGS = {
			UNIQUE_ID: UNIQUE_ID,
			TITLE: '안내',
			MESSAGES: []
		};
	if (args_MESSAGE instanceof Array) { // Array Check First!!
		JSON_ARGS.MESSAGES = args_MESSAGE;
	} else if (args_MESSAGE instanceof Object) {
		JSON_ARGS = args_MESSAGE;
		JSON_ARGS.UNIQUE_ID = UNIQUE_ID;
	} else {
		JSON_ARGS.MESSAGES = args_MESSAGE;
	}
	if (!('FILE_TEMPLATE' in JSON_ARGS)) JSON_ARGS.FILE_TEMPLATE = 'POPUP/ALERT.html'
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: JSON_ARGS.FILE_TEMPLATE,
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(JSON_ARGS, STR_RESULT);
			$('body').append(HTML_COMPILED);
			$('#'+UNIQUE_ID).on('hidden.bs.modal', function () {
				$('#'+UNIQUE_ID).remove();
				if (FUNC_CLOSE != undefined) FUNC_CLOSE();
			});
/*
			if ('CSS' in JSON_ARGS) {
			} else {
				JSON_ARGS.CSS = { width: '50%' };
			}
			$('#FRAME_' + UNIQUE_ID).css(JSON_ARGS.CSS);
*/
			if ('CSS' in JSON_ARGS) {
				$('#FRAME_' + UNIQUE_ID).css(JSON_ARGS.CSS);
			}
			$('#'+UNIQUE_ID).modal('show');
			$('.BTN_ALERT').on('click', function () {
				var ID = $(this).attr('ID');
				if (ID == 'DUMMY') {
				} else if (ID == 'X') {
				} else if (ID == 'OK') {
					if (FUNC_OK != undefined) FUNC_OK();
				}
				$('#'+UNIQUE_ID).modal('hide');
			});
		}
	);
	if ((TIMEOUT != undefined) && (FUNC_OK != undefined)) {
		setTimeout(function () {
			FUNC_OK();
			$('#'+UNIQUE_ID).modal('hide');
			setTimeout(function () {
				$('#'+UNIQUE_ID).remove();
			},500);
		}, TIMEOUT);
	}
}

function QIIP_APP_MODAL_POPUP(JSON_ARGS) {
	var UNIQUE_ID = sprintf("MODAL_POPUP_%08d", GET_UNIQUE_INDEX());
	JSON_ARGS.UNIQUE_ID = UNIQUE_ID;
	if (!('FILE_TEMPLATE' in JSON_ARGS)) JSON_ARGS.FILE_TEMPLATE = 'POPUP/MODAL_POPUP.html'
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: JSON_ARGS.FILE_TEMPLATE,
		},function(STR_RESULT) {
//			var HTML_COMPILED = _AC(STR_RESULT)(_RS); 
//			$('body').append(HTML_COMPILED); _RS.$apply();
			var HTML_COMPILED = QIIP_STATIC_HTML(JSON_ARGS, STR_RESULT);
			$('body').append(HTML_COMPILED);
			if ('CSS' in JSON_ARGS) $('#FRAME_' + UNIQUE_ID).css(JSON_ARGS.CSS);
			if ('CONTENT' in JSON_ARGS) $('#CONTENT_' + UNIQUE_ID).html(_AC(JSON_ARGS.CONTENT)(_RS));
			_RS.$apply();
			$('#'+UNIQUE_ID).on('hidden.bs.modal', function () {
				$('#'+UNIQUE_ID).remove();
			});
/*
			if ('BACKDROP' in JSON_ARGS) {
				if (JSON_ARGS.BACKDROP) {
					$('#'+UNIQUE_ID).modal({
						backdrop: 'static',
						keyboard: false,
					});
				}
			}
*/
			$('#'+UNIQUE_ID).modal('show');
			if ('INIT_FUNC' in JSON_ARGS) JSON_ARGS.INIT_FUNC(UNIQUE_ID);
		}
	);
}

function QIIP_APP_SET_WP_ROOT() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_WP_ROOT',
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if (JSON_RESULT instanceof Object) {
				_WP_ROOT = JSON_RESULT._WP_ROOT;
				_FLDR_TEMPLATE_BASE = sprintf('%s/WEBAPPS', _WP_ROOT);
			}
			QIIP_SET_FLDR_TEMPLATE();
		}
	);
}

function QIIP_SET_FLDR_TEMPLATE() {
	if (_RS._ACCESS_FROM_APP) {

		QIIP_APPS_NATIVE_ACCESS({
			REQUEST: 'GET_PHONE_INFO',
			READ_PHONE_STATE: false,
			FULL_CONTENTS: false,
		}, function (RESULT) {
			_RS.PHONE_INFO = RESULT;
			_FLDR_TEMPLATE = sprintf('%s/WEBAPPS/APPS/%s', _WP_ROOT, _RS.PHONE_INFO.APP_NAME);

			QIIP_APP_GET_PHONE_INFO(
				function () {
					QIIP_APP_LOAD_CONFIG();
				},
				function () {
					QIIP_APP_ALERT([
						'요청드린 권한을 허용하지 않았기 때문에,...',
						_RS.PHONE_INFO.APP_NAME + ' 를 종료합니다.'
					],function () {
						QIIP_APPS_NATIVE_ACCESS({
							REQUEST: 'APP_FINISH',
						}, function (RESULT) {

						});
					});
				}
			);
		});
	} else {
		if ('PHONE_INFO' in _RS) {
			_FLDR_TEMPLATE = sprintf('%s/WEBAPPS/APPS/%s', _WP_ROOT, _RS.PHONE_INFO.APP_NAME);
			QIIP_APP_LOAD_CONFIG();
		} else {
			_RS.PHONE_INFO = {
				APP_NAME: '',
				PHONE_ID: 'NOT_GRANTED',
				PHONE_NO: 'NOT_GRANTED'
			};
			QIIP_APP_ALERT([
				'APP_NAME 설정이 없습니다!'
			],function () {
//					window.location.replace(_API_SERVER_URL);
			});
		}
	}
}

function QIIP_SET_FLDR_TEMPLATE_SUB() {
	_FLDR_TEMPLATE_BASE = sprintf('%s/WEBAPPS', _WP_ROOT);
	QIIP_API_ACCESS({
			REQ: 'api_GET_FILE',
			FLDR: _FLDR_TEMPLATE_BASE,
			FILE: 'CONFIG.JSON'
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if (JSON_RESULT instanceof Object) {
				_RS.PHONE_INFO = JSON_RESULT;
				_FLDR_TEMPLATE = sprintf('%s/WEBAPPS/APPS/%s', _WP_ROOT, _RS.PHONE_INFO.APP_NAME);
				QIIP_APP_LOAD_CONFIG();
			} else {
				QIIP_APP_ALERT(
					sprintf('%s/CONFIG.JSON 파일에 오류가 있습니다.', _FLDR_TEMPLATE_BASE),
					function() {
						
					}
				);
			}
		}
	);
}

function QIIP_APP_GET_PHONE_INFO(FUNC_GRANTED, FUNC_NOT_GRANTED) {
	QIIP_APPS_NATIVE_ACCESS({
		REQUEST: 'GET_PHONE_INFO',
		READ_PHONE_STATE: true,
		FULL_CONTENTS: false,
	}, function (RESULT) {
		_RS.PHONE_INFO = RESULT;
//		alert(JSON.stringify(_RS.PHONE_INFO, null, '\t'));
		if (_RS.PHONE_INFO.PHONE_NO == 'NOT_GRANTED') {
			QIIP_APP_ALERT({
				MESSAGES: [
					_RS.PHONE_INFO.APP_NAME + ' 를 정상적으로 이용하시려면...',
					'요청드린 권한을 허용하셔야 합니다.',
					'권한 허용을 재시도 하시겠습니까?',
				],
				FILE_TEMPLATE: 'POPUP/YES_NO.html',
			},function () {
				QIIP_APP_GET_PHONE_INFO(FUNC_GRANTED, FUNC_NOT_GRANTED);
			}, function () {
				if (FUNC_NOT_GRANTED != undefined) FUNC_NOT_GRANTED();
			});
		} else {
			if (FUNC_GRANTED != undefined) FUNC_GRANTED();
		}
	});
}

function QIIP_APP_LOAD_CONFIG() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_FILE',
			FLDR: _FLDR_TEMPLATE,
			FILE: 'CONFIG.JSON'
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if (JSON_RESULT instanceof Object) {
				_RS.APP_CONFIG = JSON_RESULT;

				QIIP_APP_LOAD_SERVICE_PAGE();
				
			} else {

				QIIP_APP_ALERT([
					sprintf('%s/CONFIG.JSON 파일에 오류가 있습니다.', _FLDR_TEMPLATE)
				],function () {
	//					window.location.replace(_API_SERVER_URL);
				});

			}
		}
	);
}

function QIIP_APP_CHECK_BROWSER() {
//	console.log(navigator.userAgent);
	var STR_userAgent = navigator.userAgent.toUpperCase();
	var VALUE_RESULT = false;

	if ('CHROME_ONLY' in _RS.APP_CONFIG) {
		if (!_RS.APP_CONFIG.CHROME_ONLY) {
			VALUE_RESULT = true;
		}
	}

	if ((STR_userAgent.indexOf('CHROME') > 0)) {
		VALUE_RESULT = true;
	} else if ((STR_userAgent.indexOf('CHROME') >= 0) && (STR_userAgent.indexOf('EDGE') >= 0)) {
//		VALUE_RESULT = false;
	} else if ((STR_userAgent.indexOf('CRIOS') >= 0)) {
		VALUE_RESULT = true;
	} else if ((STR_userAgent.indexOf('FIREFOX') >= 0)) {
		VALUE_RESULT = true;
	} else if (QIIP_IS_MOBILE()) {
		VALUE_RESULT = true;
	}
//		VALUE_RESULT = true;

	if (!VALUE_RESULT) {
		QIIP_API_ACCESS({
				REQ: 'api_GET_PAGE',
				FLDR_TEMPLATE: _FLDR_TEMPLATE,
				FILE_TEMPLATE: 'LOGIN/APP_CONTENTS_CHROME_ONLY.html',
			},function(STR_RESULT) {
				var HTML_COMPILED = _AC(STR_RESULT)(_RS);
				$('body').html(HTML_COMPILED); _RS.$apply();
				INIT_WIDGETS_FOR_CHROME_ONLY();
			}
		);
	}

	return VALUE_RESULT;
}

function QIIP_APP_UPDATE_LOGIN_INFO(USER_ID, FUNC_AFTER) {
	
	var PHP_CODES  = "";
		PHP_CODES += "return get_user_by('login', '" + USER_ID + "');";

	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
		    var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			_RS.LOGIN_INFO = JSON_RESULT; // GLOBAL 변수에 저장
			if (FUNC_AFTER != undefined) FUNC_AFTER();
		}
	);
}

function QIIP_APP_CHECK_IF_LOGIN(FUNC_AFTER_LOGIN) {
	
	if (!QIIP_APP_CHECK_BROWSER()) return;
	
	var PHP_CODES  = "";
		PHP_CODES += "if (is_user_logged_in()) {";
		PHP_CODES += "  $RESULT = json_encode(wp_get_current_user());";
		PHP_CODES += "} else {";
//		PHP_CODES += "  $RESULT = wp_login_form(array('echo' => false));";
//		PHP_CODES += "  $RESULT = json_encode(new stdClass());";
		PHP_CODES += "  $OBJ_RESULT = new stdClass();";
		PHP_CODES += "  $OBJ_RESULT->USERS_CAN_REGISTER = get_option('users_can_register');";
		PHP_CODES += "  $RESULT = json_encode($OBJ_RESULT);";
		PHP_CODES += "}";
		PHP_CODES += "return $RESULT;";

	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
		    if (false) {
				var DISP_RESULT = 'NO_RESULT';
			    try {
			    	DISP_RESULT = JSON.stringify(JSON.parse(STR_RESULT), null, '\t');
			    } catch(e) {
			    	DISP_RESULT = RESULT;
			    }
				$('body').html(
					'<xmp>' + DISP_RESULT + '</xmp>'
				);
		    } else {
			    var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
//alert(JSON.stringify(JSON_RESULT, null, '\t'));
				if ('ID' in JSON_RESULT) {
					_RS.LOGIN_INFO = JSON_RESULT; // GLOBAL 변수에 저장
//					QIIP_APP_ALERT([_RS.LOGIN_INFO]);
					QIIP_ADD_USER_META_DATA(FUNC_AFTER_LOGIN);
				} else {
					_RS.USERS_CAN_REGISTER = JSON_RESULT.USERS_CAN_REGISTER;
					QIIP_APP_LOAD_LOGIN_FORM(FUNC_AFTER_LOGIN);
				}
		    }
		}
	);
}

function QIIP_STR_1ST_SAME_PART(STR_A, STR_B) {
	var STR_RESULT = "";
	var LENGTH_MIN = STR_A.length; if (LENGTH_MIN > STR_B.length); LENGTH_MIN = STR_B.length;
	for (var i=0; i<LENGTH_MIN; i++) {
		if (STR_A.charAt(i) == STR_B.charAt(i)) {
			STR_RESULT += STR_A.charAt(i);
		} else {
			break;
		}
	}
	return STR_RESULT;
}

function QIIP_ADD_USER_META_DATA(FUNC_AFTER_LOGIN) {
	var PHP_CODES  = '';
		PHP_CODES += 'return array_map( function( $a ){ return $a[0]; }, get_user_meta( ' + _RS.LOGIN_INFO.ID + ' ) );';

	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
//			if ((typeof JSON_RESULT === 'object') && ('errors' in JSON_RESULT)) {
			if ((typeof JSON_RESULT === 'object') && (true)) {
				_RS.LOGIN_INFO.META_DATA	= JSON_RESULT;
				_RS.LOGIN_INFO.PHONE_ID		= 'PSEUDO_PHONE_ID_' + _RS.LOGIN_INFO.data.user_login;
				_RS.LOGIN_INFO.PHONE_NO		= _RS.LOGIN_INFO.data.user_login;
				_RS.PHONE_INFO.PHONE_ID		= 'PSEUDO_PHONE_ID_' + _RS.LOGIN_INFO.data.user_login;
				_RS.PHONE_INFO.PHONE_NO		= _RS.LOGIN_INFO.data.user_login;
				if (FUNC_AFTER_LOGIN != undefined) FUNC_AFTER_LOGIN();
			} else {
				QIIP_APP_ALERT([
					JSON.stringify(JSON_RESULT, null, '\t')
				],function () {
//					window.location.replace(_API_SERVER_URL);
				});
			}
		}
	);

}


function QIIP_APP_LOAD_SERVICE_PAGE() {
	if (!_RS.APP_CONFIG.LOGIN_BASE) {
		QIIP_APP_LOAD_SERVICE_PAGE_SUB();
		return;
	}
	if (_RS.PHONE_INFO.PHONE_NO == 'NOT_GRANTED') {
		QIIP_APP_CHECK_IF_LOGIN(function () {
			if ('INITIAL_POST_INFORMATION' in _RS.APP_CONFIG) {
				QIIP_APP_DO_JOB_WITH_INITIAL_POST_INFORMATION(function () {
					QIIP_APP_LOAD_SERVICE_PAGE_SUB();
				});
			} else {
				QIIP_APP_LOAD_SERVICE_PAGE_SUB();
			}
		});
	} else {
		QIIP_APP_UPDATE_LOGIN_INFO(
			_RS.PHONE_INFO.PHONE_NO,
			function () {
				if ('INITIAL_POST_INFORMATION' in _RS.APP_CONFIG) {
					QIIP_APP_DO_JOB_WITH_INITIAL_POST_INFORMATION(function () {
						QIIP_APP_LOAD_SERVICE_PAGE_SUB();
					});
				} else {
					QIIP_APP_LOAD_SERVICE_PAGE_SUB();
				}
			}
		);
	}
}

function QIIP_APP_LOAD_SERVICE_PAGE_SUB() {

	if ('SIDEMENU' in _RS.APP_CONFIG) {
		if (_RS.APP_CONFIG.SIDEMENU.MENUITEMS.length > 0) {
			QIIP_APP_INIT_SIDEMENU();
		}
	} else if ('NO_MENU_CONTENTS' in _RS.APP_CONFIG) {
		QIIP_APP_INIT_NO_MENU();
	} else if ('QIIP_MENU_INFORMATION' in _RS.APP_CONFIG) {
		$('body').html('');
		$('body').append(sprintf('<div id="%s"></div>', _RS.APP_CONFIG.QIIP_MENU_INFORMATION.DIV_ID_MENU));
		$('body').append(sprintf('<div id="%s"></div>', _RS.APP_CONFIG.QIIP_MENU_INFORMATION.DIV_ID_CONTENT));
		QIIP_APP_INIT_PAGE_MENU();
	} else {
		QIIP_APP_ALERT([
			'<xmp>' + JSON.stringify(_RS.PHONE_INFO, null, '\t') + '</xmp>',
			'<xmp>' + JSON.stringify(_RS.LOGIN_INFO, null, '\t') + '</xmp>'
		],function () {
	//			window.location.replace(_API_SERVER_URL);
		});
	}
}

function QIIP_APP_LOGOUT() {
	var PHP_CODES  = '';
		PHP_CODES += 'return wp_logout();';

	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
			window.location.replace(_API_SERVER_URL + '?S=' + _RS.PHONE_INFO.APP_NAME);
		}
	);
}

function QIIP_APP_LOAD_LOGIN_FORM(FUNC_AFTER_LOGIN) {

	var FILE_TEMPLATE = '';
	if ('QIIP_LOGIN_INFO' in _RS.APP_CONFIG) {
		FILE_TEMPLATE = _RS.APP_CONFIG.QIIP_LOGIN_INFO.LOGIN_INIT.TEMPLATE;
	} else {
		if ('LOGIN_IDPW' in _RS.APP_CONFIG) {
			if (_RS.APP_CONFIG.LOGIN_IDPW) {
				FILE_TEMPLATE = 'LOGIN/APP_CONTENTS_IDPW_LOGIN_FORM.html';
			} else {
				FILE_TEMPLATE = 'LOGIN/APP_CONTENTS_LOGIN_FORM.html';
			}
		} else {
			FILE_TEMPLATE = 'LOGIN/APP_CONTENTS_LOGIN_FORM.html';
		}
	}

	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: FILE_TEMPLATE,
		},function(STR_RESULT) {
			var HTML_COMPILED = _AC(STR_RESULT)(_RS);
			if ('QIIP_LOGIN_INFO' in _RS.APP_CONFIG) {
				if ($('TAG_QIIP_LOGIN').length <= 0) $('body').append('<TAG_QIIP_LOGIN></TAG_QIIP_LOGIN>');
				$('TAG_QIIP_LOGIN').html(HTML_COMPILED); _RS.$apply();
				eval(_RS.APP_CONFIG.QIIP_LOGIN_INFO.LOGIN_INIT.INIT_FUNC);
			} else {
				$('body').html(HTML_COMPILED); _RS.$apply();
				INIT_WIDGETS_FOR_LOGIN_FORM();
			}
		}
	);
}

function QIIP_APP_INIT_NO_MENU() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: _RS.APP_CONFIG.NO_MENU_CONTENTS.MENU_CONTENTS,
		},function(STR_RESULT) {
			$('body').html(_AC(STR_RESULT)(_RS)); _RS.$apply();
			eval(_RS.APP_CONFIG.NO_MENU_CONTENTS.MENU_INIT_FUNC);
		}
	);
}

function QIIP_APP_INIT_PAGE_MENU() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: _RS.APP_CONFIG.QIIP_MENU_INFORMATION.MENU_TEMPLATE,
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(_RS.APP_CONFIG.QIIP_MENU_INFORMATION.JSON_MENU, STR_RESULT);
			$('#' + _RS.APP_CONFIG.QIIP_MENU_INFORMATION.DIV_ID_MENU).html(HTML_COMPILED);

			QIIP_REGIST_RS_FUNCTION('ON_MENU_CLICK',ON_MENU_CLICK);
			
			if (!_RS._ACCESS_FROM_APP) {
//				QIIP_REGIST_RS_FUNCTION('QIIP_APP_LOGOUT',QIIP_APP_LOGOUT);
			}
			
			eval(_RS.APP_CONFIG.QIIP_MENU_INFORMATION.MENU_INIT_FUNC);

//			ON_MENU_CLICK(_RS.APP_CONFIG.SIDEMENU.MENUITEMS[0]);
			if ('HOME_CONTENTS' in _RS.APP_CONFIG.QIIP_MENU_INFORMATION) {
				QIIP_APP_LOAD_CONTENTS({
					FILE_TEMPLATE: _RS.APP_CONFIG.QIIP_MENU_INFORMATION.HOME_CONTENTS.TEMPLATE,
					INIT_FUNC: _RS.APP_CONFIG.QIIP_MENU_INFORMATION.HOME_CONTENTS.INIT_FUNC
				});
			}
		}
	);
}

function QIIP_APP_LOAD_CONTENTS(ARGS) {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: ARGS.FILE_TEMPLATE,
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(_RS.APP_CONFIG.PAGE_MENU, STR_RESULT);
			$('#' + _RS.APP_CONFIG.QIIP_MENU_INFORMATION.DIV_ID_CONTENT).html(HTML_COMPILED);
			if ('INIT_FUNC' in ARGS) eval(ARGS.INIT_FUNC);
		}
	);
}

function QIIP_APP_INIT_SIDEMENU() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: _RS.APP_CONFIG.SIDEMENU.FILE_TEMPLATE,
		},function(STR_RESULT) {
			$('body').html(_AC(STR_RESULT)(_RS)); _RS.$apply();
//			$('body').html(_AC(STR_RESULT)(_RS)); _RS.$apply();

			QIIP_REGIST_RS_FUNCTION('ON_MENU_CLICK',ON_MENU_CLICK);
			if (!_RS._ACCESS_FROM_APP) {
				if (('MENUITEMS_FOR_DESKTOP' in _RS.APP_CONFIG.SIDEMENU) && ('DESKTOP_MENU_USERS' in _RS.APP_CONFIG.SIDEMENU)) {
					if (_RS.APP_CONFIG.SIDEMENU.DESKTOP_MENU_USERS.indexOf(_RS.PHONE_INFO.PHONE_NO) >= 0) {
						_RS.APP_CONFIG.SIDEMENU.MENUITEMS_FOR_DESKTOP.forEach(function (ONE_DESKTOP_MENUITEM) {
	//						_RS.APP_CONFIG.SIDEMENU.MENUITEMS.unshift(ONE_DESKTOP_MENUITEM);
							_RS.APP_CONFIG.SIDEMENU.MENUITEMS.push(ONE_DESKTOP_MENUITEM);
						});
					}
				}
				
				QIIP_REGIST_RS_FUNCTION('QIIP_APP_LOGOUT',QIIP_APP_LOGOUT);
			}
			ON_MENU_CLICK(_RS.APP_CONFIG.SIDEMENU.MENUITEMS[0]);
			SET_SIDEMENU_EVENT();
		}
	);
}

function QIIP_GET_DOM_ATTRIBUTES( $node ) {
    var attrs = {};
    $.each( $node.attributes, function ( index, attribute ) {
        attrs[attribute.name] = attribute.value;
    } );
    return attrs;
}

function QIIP_APP_DO_JOB_WITH_INITIAL_POST_INFORMATION(FUNC_AFTER) {
	QIIP_API_ACCESS({
			REQ: 'post_GET_ROOT_INFO',
			PHONE_NO: _RS.PHONE_INFO.PHONE_NO,
			PHONE_ID: _RS.PHONE_INFO.PHONE_ID,
			SVC_CATEGORY: _RS.PHONE_INFO.APP_NAME,
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if (JSON_RESULT instanceof Object) {
				_RS.OBJ_POST_ROOT = JSON_RESULT;
			} else {
				if ('INITIAL_POST_INFORMATION' in _RS.APP_CONFIG) {
					_RS.OBJ_POST_ROOT = _RS.APP_CONFIG.INITIAL_POST_INFORMATION;
					_RS.OBJ_POST_ROOT.PHONE_NO = _RS.PHONE_INFO.PHONE_NO;
					_RS.OBJ_POST_ROOT.PHONE_ID = _RS.PHONE_INFO.PHONE_ID;
					QIIP_UPDATE_POST_ROOT(_RS.OBJ_POST_ROOT);
				}
			}
			if (FUNC_AFTER != undefined) FUNC_AFTER();
		}
	);
}

function PUT_APP_SETTINGS(NEW_APP_SETTINGS) {
	if (!_RS._ACCESS_FROM_APP) return;

	QIIP_APPS_NATIVE_ACCESS({
		REQUEST: 'PUT_PHONE_CONFIG',
		CONFIG_KEY: 'APP_SETTINGS',
		CONFIG_VALUE: NEW_APP_SETTINGS,
	}, function (RESULT) {
//		alert(JSON.stringify(RESULT, null, '\t'));
/*
	},{
		title: _RS.PHONE_INFO.APP_NAME + ' 안내',
		template: ARR_TO_TABLE_CENTER([
			'설정 사항을 폰으로 저장하고 있습니다.'
		]),
		cssClass: 'qiip_popup'
*/
	});
	
}

function QIIP_UPDATE_POST_ROOT(OBJ_UPDATE, FUNC_AFTER) {
	QIIP_API_ACCESS({
			REQ: 'post_PUT_ROOT_INFO',
			PHONE_NO: _RS.PHONE_INFO.PHONE_NO,
			PHONE_ID: _RS.PHONE_INFO.PHONE_ID,
			SVC_CATEGORY: _RS.PHONE_INFO.APP_NAME,
			JSON_UPDATE: OBJ_UPDATE,
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
//			alert(JSON.stringify(JSON_RESULT, null, '\t'));
			if (FUNC_AFTER != undefined) FUNC_AFTER();
		}
	);
}

function QIIP_LOAD_PDF_VIEWER(JSON_ARGS) {
	if (!('URL' in JSON_ARGS)) {
		QIIP_APP_ALERT([
			'URL 속성을 지정하지 않았습니다.',
			'<pre>' + JSON.stringify(JSON_ARGS, null, '\t') + '</pre>'
		]);
		return;
	}
	if (!('DIV' in JSON_ARGS)) {
		QIIP_APP_ALERT([
			'DIV 속성을 지정하지 않았습니다.',
			'<pre>' + JSON.stringify(JSON_ARGS, null, '\t') + '</pre>'
		]);
		return;
	}
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: '../../COMMONS/PDF_VIEWER/QIIP_PDF_VIEWER.html',
		},function(STR_RESULT) {
			$('#' + JSON_ARGS.DIV).html(STR_RESULT);
			INIT_WIDGETS_PDF_VIEWER(JSON_ARGS);
		}
	);
}


function QIIP_POST_ACCESS_LOG(JSON_ARGS) {

//	alert(JSON.stringify(JSON_ARGS, null, '\t'));
	
	QIIP_API_ACCESS({
			REQ: 'post_LOG',
			PHONE_NO: _RS.PHONE_INFO.PHONE_NO,
			PHONE_ID: _RS.PHONE_INFO.PHONE_ID,
			SVC_CATEGORY: _RS.PHONE_INFO.APP_NAME,
			STR_JSON_LOG: JSON.stringify(JSON_ARGS),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
//			alert(JSON.stringify(JSON_RESULT, null, '\t'));
		}
	);
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

function QIIP_IS_MOBILE() {
	var isMobile = false; //initiate as false
	// device detection
	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
	    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;
	return isMobile;
}

function JSON_PARSE_IF_CAN(STR_JSON) {
//	console.log('JSON_PARSE_IF_CAN STR_JSON => ' + typeof STR_JSON);
//	console.log('JSON_PARSE_IF_CAN STR_JSON => ' + JSON.stringify(STR_JSON));
	if (typeof STR_JSON == 'string') {
		STR_JSON = unescape(STR_JSON);
	}
	var JSON_RESULT; try {
		JSON_RESULT = JSON.parse(STR_JSON);
		if (typeof JSON_RESULT == 'number') {
			if (STR_JSON.substring(0,1) == '0') {
				JSON_RESULT = STR_JSON;
			}
		}
	} catch(e) {
		JSON_RESULT = STR_JSON;
	}
	if (JSON_RESULT == Infinity) {
		JSON_RESULT = STR_JSON;
	}
//	console.log('JSON_PARSE_IF_CAN JSON_RESULT => ' + JSON_RESULT);
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
        str_HTML += '<div class="qiip_index" style="width:100%;height:100%;background-color:#c9c9c9;overflow:auto;">';
        str_HTML += '<table>';
    for (var i=0; i<str_arr.length; i++) {
        str_HTML += '<tr>';
        str_HTML += '<td style="text-align:center;">';
        str_HTML += str_arr[i];
        str_HTML += '</td>';
        str_HTML += '</tr>';
    }
        str_HTML += '</table>';
        str_HTML += '</div>';
    return str_HTML;
}

function ARR_TO_TABLE(str_arr) {
    var str_HTML  = '';
        str_HTML += '<div class="qiip_index" style="width:100%;height:100%;background-color:#c9c9c9;overflow:auto;">';
        str_HTML += '<table>';
    for (var i=0; i<str_arr.length; i++) {
        str_HTML += '<tr>';
        str_HTML += '<td>';
        str_HTML += str_arr[i];
        str_HTML += '</td>';
        str_HTML += '</tr>';
    }
        str_HTML += '</table>';
        str_HTML += '</div>';
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

function IN_DIV_FULL(str) {
    var str_HTML  = '';
        str_HTML += '<div class="qiip_index">';
        str_HTML += '<table>';
        str_HTML += '<tr>';
        str_HTML += '<td>';
        str_HTML += str;
        str_HTML += '</th>';
        str_HTML += '</tr>';
        str_HTML += '</table>';
        str_HTML += '</div>';
    return str_HTML;
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



function QIIP_GET_CONTACTS_FOR(TEXT_TARGET, SET_VALUE_NAME, MEMBER_CHECK) {
	if (!_RS._ACCESS_FROM_APP) return;
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

function QIIP_APP_GET_CONTACTS(OBJ_PARAMS) {
	if (OBJ_PARAMS.STR_FILTER == undefined) OBJ_PARAMS.STR_FILTER = "";

	QIIP_APPS_NATIVE_ACCESS({
		REQUEST: 'GET_CONTACTS',
		STR_FILTER: OBJ_PARAMS.STR_FILTER,
		FULL_CONTENTS: true,
	}, function (RESULT) {
//		alert(JSON.stringify(RESULT, null, '\t'));
		if (RESULT.STATUS != 200) {
			QIIP_APP_ALERT({
				MESSAGES: [
					'폰 내부의 주소록을 검색하시려면...',
					'요청드린 권한을 허용하셔야 합니다.',
					'권한 허용을 재시도 하시겠습니까?',
				],
				FILE_TEMPLATE: 'POPUP/YES_NO.html',
			},function () {
				QIIP_APP_GET_CONTACTS(OBJ_PARAMS);
			}, function () {
			});
		} else {
			OBJ_PARAMS.JSON_ARRAY_CONTACTS = RESULT.RESULT_CONTENTS;
			if (OBJ_PARAMS.MEMBER_CHECK != undefined) {
				QIIP_APP_SELECT_ONE_ITEM_FROM_CONTACTS_MEMBER_CHECK(OBJ_PARAMS);
			} else {
				QIIP_APP_SELECT_ONE_ITEM_FROM_CONTACTS(OBJ_PARAMS);
			}
		}
	});
}

function QIIP_APP_SELECT_ONE_ITEM_FROM_CONTACTS(OBJ_PARAMS) {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE_BASE,
			FILE_TEMPLATE: 'COMMONS/POPUP/SELECT_ONE_ITEM_FROM_CONTACTS.html',
			PHONE_ID: _RS.PHONE_INFO.PHONE_ID,
			PHONE_NO: _RS.PHONE_INFO.PHONE_NO,
			CATEGORY: _RS.PHONE_INFO.APP_NAME,
		},function(STR_RESULT) {
			var OBJ_POPUP = QIIP_JQX_POPUP_WINDOW({
	            showCollapseButton: true, 
	            height: '95%',
	            width: '90%',
	            minHeight: 100,
	            minWidth: 100,
//	            position: [0, TOP_MARGIN_Y],
				},
				'연락처 선택',
				STR_RESULT
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

	QIIP_API_ACCESS({
			REQ: 'post_FilterContacts',
			VARS: OBJ_PARAMS,
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(RESULT);
			QIIP_APP_SELECT_ONE_ITEM_FROM_CONTACTS(JSON_RESULT);
		}
	);
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

    return result;
}

function QIIP_API_ACCESS(API_ACCESS_INFORMATION, ON_RESULT) {

	if (API_ACCESS_INFORMATION == undefined) return;

	var FLAG_ATTACH_VIA_KEY = false;
	var POST_DATAS = new FormData();
	Object.keys(API_ACCESS_INFORMATION).forEach(function (ONE_KEY) {
		if (ONE_KEY == 'ATTACHES') {
			API_ACCESS_INFORMATION[ONE_KEY].forEach(function (ONE_ATTACH) {
				if ('KEY' in ONE_ATTACH) {
					POST_DATAS.append(ONE_ATTACH.KEY, ONE_ATTACH.FILE);
					FLAG_ATTACH_VIA_KEY = true;
				} else {
					POST_DATAS.append(ONE_ATTACH.NAME, ONE_ATTACH.FILE);
				}
			});
		} else {
			if (API_ACCESS_INFORMATION[ONE_KEY] instanceof Object) {
				POST_DATAS.append(ONE_KEY, JSON.stringify(API_ACCESS_INFORMATION[ONE_KEY]));
			} else if (API_ACCESS_INFORMATION[ONE_KEY] instanceof Array) {
				POST_DATAS.append(ONE_KEY, JSON.stringify(API_ACCESS_INFORMATION[ONE_KEY]));
			} else {
				POST_DATAS.append(ONE_KEY, API_ACCESS_INFORMATION[ONE_KEY]);
			}
		}
	});
	
	if (FLAG_ATTACH_VIA_KEY) POST_DATAS.append('ATTACH_VIA_KEY', 'Y');
	
	if (false && (_RS._ACCESS_FROM_APP) && ('PHONE_INFO' in _RS) && ('API_INTERACT' in _RS.PHONE_INFO)) {
		setTimeout(function () {
			QIIP_APPS_NATIVE_ACCESS({
				REQUEST: 'HTTP_ACCESS_VIA_' + _RS.PHONE_INFO.API_INTERACT,
				FULL_CONTENTS: false,
				HttpAccessInformation: API_ACCESS_INFORMATION,
			}, function (result) {
				if (ON_RESULT != undefined) ON_RESULT(result);
			});
		}, 1);
	} else {

		$.ajax({
			url : _API_SERVER_URL,
			type : 'post',
	//		data : JSON.stringify(API_ACCESS_INFORMATION),
			data : POST_DATAS,
			async: true, 
			contentType: false,
			processData: false,
	//		dataType : "text",
	//		contentType:"application/json; charset=UTF-8",
			success : function(result) {
				if (ON_RESULT != undefined) ON_RESULT(result);
			},
			error : function(request,status,error) {
				var str_error_info = "code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error;
	//			console.log(str_error_info);
				if (ON_RESULT != undefined) ON_RESULT(str_error_info);
			}
		});
		
	}

}

function QIIP_APPS_NATIVE_ACCESS(NATIVE_ACCESS_INFORMATION, ON_RESULT) {
	if (NATIVE_ACCESS_INFORMATION == undefined) return;

	var strJSON_Param = JSON.stringify(NATIVE_ACCESS_INFORMATION);
	var RESULT;
	if ('FULL_CONTENTS' in NATIVE_ACCESS_INFORMATION) {
		if (NATIVE_ACCESS_INFORMATION.FULL_CONTENTS) {
			RESULT = JSON.parse(WEB_UI_Interface.NATIVE_CALL(strJSON_Param)).RESULT;
		} else {
			RESULT = JSON.parse(WEB_UI_Interface.NATIVE_CALL(strJSON_Param)).RESULT.RESULT_CONTENTS;
		}
	} else {
		RESULT = JSON.parse(WEB_UI_Interface.NATIVE_CALL(strJSON_Param)).RESULT.RESULT_CONTENTS;
	}
//	if (OBJ_POPUP != undefined) OBJ_POPUP.close();
	if (ON_RESULT != undefined) ON_RESULT(RESULT);
}

function QIIP_APP_GET_PHONE_START_UP_CONFIG() {
	QIIP_APPS_NATIVE_ACCESS({
		REQUEST: 'GET_START_UP_CONFIG',
		FULL_CONTENTS: false,
		STR_KEY: 'API_SERVER_URL',
	}, function (RESULT) {
		alert(JSON.stringify(RESULT, null, '\t'));
	});
}


function QIIP_FX_NATIVE_ACCESS(NATIVE_ACCESS_INFORMATION, ON_RESULT) {
	if (NATIVE_ACCESS_INFORMATION == undefined) return;

	var strJSON_Param = JSON.stringify(NATIVE_ACCESS_INFORMATION);
	var RESULT;
	if ('FULL_CONTENTS' in NATIVE_ACCESS_INFORMATION) {
		RESULT = JSON.parse(WEB_UI_Interface.NATIVE_CALL(strJSON_Param)).RESULT;
	} else {
		RESULT = JSON.parse(WEB_UI_Interface.NATIVE_CALL(strJSON_Param)).RESULT.RESULT_CONTENTS;
	}
	if (ON_RESULT != undefined) ON_RESULT(RESULT);
}

function QIIP_FX_GET_CLIENT_CONFIG(CONFIG_KEY) {
	var object_NativeCommand = {
			"REQUEST" : "GET_CLIENT_CONFIG",
			"CONFIG_KEY" : CONFIG_KEY
		};
	var strJSON_Param = JSON.stringify(object_NativeCommand);
	return WEB_UI_Interface.NATIVE_CALL(strJSON_Param);
}

function QIIP_FX_PUT_CLIENT_CONFIG(CONFIG_KEY, CONFIG_VALUE) {
	var object_NativeCommand = {
			"REQUEST" : "PUT_CLIENT_CONFIG",
			"CONFIG_KEY" : CONFIG_KEY,
			"CONFIG_VALUE" : CONFIG_VALUE,
		};
	var strJSON_Param = JSON.stringify(object_NativeCommand);
	return WEB_UI_Interface.NATIVE_CALL(strJSON_Param);
}

function QIIP_FX_SYSTEM_EXIT() {
	var object_NativeCommand = {
			"REQUEST" : "SYSTEM_EXIT"
		};
	var strJSON_Param = JSON.stringify(object_NativeCommand);
	return WEB_UI_Interface.NATIVE_CALL(strJSON_Param);
}

function QIIP_JQX_CLOSE_WINDOW(args_OBJ_WINDOW) {
	if (args_OBJ_WINDOW != null) {
		args_OBJ_WINDOW.jqxWindow('close');
	}
}

function QIIP_JQX_CHANGE_CONTENTS(args_OBJ_WINDOW, args_HTML) {
	if (args_OBJ_WINDOW != null) {
		args_OBJ_WINDOW.jqxWindow('setContent', args_HTML);
	}
}

var QIIP_JQX_POPUP_WINDOW_ARRAY = [];

function QIIP_JQX_POPUP_WINDOW(args_Properties, HTML_TITLE, HTML_CONTENTS, ON_CLOSE) {
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
			if (ON_CLOSE != undefined) {
				QIIP_JQX_POPUP_WINDOW_ARRAY[i].on('close', function (event) {
					ON_CLOSE(event);
				});
			}
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
		if (ON_CLOSE != undefined) {
			$('#QIIP_POPUP_WINDOW_' + COUNT).on('close', function (event) {
				ON_CLOSE(event);
			});
		}
		RESULT_QIIP_POPUP_WINDOW = $('#QIIP_POPUP_WINDOW_' + COUNT);
		ACTIVE_INDEX = COUNT;
		QIIP_JQX_POPUP_WINDOW_ARRAY.push(RESULT_QIIP_POPUP_WINDOW);
	}
//	console.log('QIIP_JQX_POPUP_WINDOW = QIIP_POPUP_WINDOW_' + ACTIVE_INDEX);
	return RESULT_QIIP_POPUP_WINDOW;
}

function QIIP_JQX_POPUP_WINDOW_OLD(args_Properties, HTML_TITLE, HTML_CONTENTS) {
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

