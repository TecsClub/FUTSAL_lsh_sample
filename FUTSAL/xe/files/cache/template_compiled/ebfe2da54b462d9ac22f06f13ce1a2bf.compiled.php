<?php if(!defined("__XE__"))exit;
$__Context->JSON_ARGS = json_decode(base64_decode($__Context->ARGS->JSON_ARGS_BASE64));  ?>
#PAGE_ARGS# <!-- <script>var JSON_ARGS=JSON.parse(Base64.decode($ARGS->JSON_ARGS_BASE64));</script> -->
<script>
function INIT_WIDGETS_FOR_LOGIN_FORM() {
    $('#data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
    setTimeout(function() {
        $("#wrap").addClass("dis_none");    
    }, 8000);
    
   
            
	$(window).unbind();
	$(window).keypress(function (EVENT) {
		if ( event.which == 13 ) {
		     event.preventDefault();
			DO_TRY_TO_LOGIN({
				USER_ID: $('#USER_ID').val(),
				USER_PW: $('#USER_PW').val(),
				REMEMBER: $('#CHK_REMEMBER').is(":checked")
			});
		}
	});
	$(".BTN_LOGIN_FORM").on('click', function () {
		var ID = $(this).attr('ID');
		if (ID == 'DUMMY') {
		} else if (ID == 'BTN_TO_LOGIN') {
			DO_TRY_TO_LOGIN({
				USER_ID: $('#USER_ID').val(),
				USER_PW: $('#USER_PW').val(),
				REMEMBER: $('#CHK_REMEMBER').is(":checked")
			});
//			alert('DO_TRY_TO_LOGIN');
		} else if (ID == 'BTN_LOAD_REGIST_FORM') {
			DO_LOAD_REGIST_FORM();
		} else if (ID == 'BTN_LOAD_PW_RESET_FORM') {
			DO_LOAD_PW_RESET_FORM();
		}
	});
	return;
	$("#CHK_REMEMBER").change(function () {
		if ($('#CHK_REMEMBER').is(":checked")) {
			QIIP_POPUP_FOR_ALERT([
				'공용 장소에서는 가능한 한,...',
				'이 기능을 사용하지 않을 것을 권유드립니다.'
			]);
		}
	});
}
function DO_LOAD_PW_RESET_FORM() {
	var JSON_ARGS_BASE64 = Base64.encode(JSON.stringify({}));
	var FILE_TEMPLATE = '';
	if ('LOGIN_IDPW' in _RS.APP_CONFIG) {
		if (_RS.APP_CONFIG.LOGIN_IDPW) {
			FILE_TEMPLATE = 'LOGIN/APP_CONTENTS_IDPW_PW_RESET_FORM.html';
		} else {
			FILE_TEMPLATE = 'LOGIN/APP_CONTENTS_PW_RESET_FORM.html';
		}
	} else {
		FILE_TEMPLATE = 'LOGIN/APP_CONTENTS_PW_RESET_FORM.html';
	}
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: FILE_TEMPLATE,
			JSON_ARGS_BASE64: JSON_ARGS_BASE64,
		},function(STR_RESULT) {
			$('#APP_CONTENTS').html(_AC(STR_RESULT)(_RS)); _RS.$apply();
			INIT_WIDGETS_FOR_PW_RESET_FORM();
		},{
			title: _RS.PHONE_INFO.APP_NAME + ' 안내',
			template: ARR_TO_TABLE_CENTER([
				'화면을 구성하고 있습니다.'
			]),
			cssClass: 'qiip_popup'
		}
	);
}
function DO_LOAD_REGIST_FORM() {
	var JSON_ARGS_BASE64 = Base64.encode(JSON.stringify({}));
	var FILE_TEMPLATE = '';
	if ('LOGIN_IDPW' in _RS.APP_CONFIG) {
		if (_RS.APP_CONFIG.LOGIN_IDPW) {
			FILE_TEMPLATE = 'LOGIN/APP_CONTENTS_IDPW_REGIST_FORM.html';
		} else {
			FILE_TEMPLATE = 'LOGIN/APP_CONTENTS_PW_RESET_FORM.html';
		}
	} else {
		FILE_TEMPLATE = 'LOGIN/APP_CONTENTS_PW_RESET_FORM.html';
	}
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: FILE_TEMPLATE,
			JSON_ARGS_BASE64: JSON_ARGS_BASE64,
		},function(STR_RESULT) {
			$('#APP_CONTENTS').html(_AC(STR_RESULT)(_RS)); _RS.$apply();
			INIT_WIDGETS_FOR_REGIST_FORM();
		},{
			title: _RS.PHONE_INFO.APP_NAME + ' 안내',
			template: ARR_TO_TABLE_CENTER([
				'화면을 구성하고 있습니다.'
			]),
			cssClass: 'qiip_popup'
		}
	);
}
function DO_TRY_TO_LOGIN(LOGIN_DATA) {
	if (LOGIN_DATA.USER_ID.length < 1) {
		QIIP_POPUP_FOR_ALERT(
		"안내",
		[
			'아이디를 입력해주세요.'
		],
		function(){
			
		}
		,
		20,
		16.5
		);
		
		return;
	}
	if (LOGIN_DATA.USER_PW.length < 1) {
		QIIP_POPUP_FOR_ALERT(
		"안내",
		[
			'비밀번호를 입력해주세요.'
		],
		function(){
			
		}
		,
		20,
		16.5
		);
		
		return;
	}
//	alert(JSON.stringify(LOGIN_DATA, null, '\t'));
	
	var PHP_CODES  = '';
		PHP_CODES += '$credentials = array(';
		PHP_CODES += '	"user_login" => "' + LOGIN_DATA.USER_ID + '",';
		PHP_CODES += '	"user_password" => "' + LOGIN_DATA.USER_PW + '",';
		PHP_CODES += '	"remember" => "' + LOGIN_DATA.REMEMBER + '"';
		PHP_CODES += ');';
		PHP_CODES += 'return wp_signon($credentials);';
	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
//			alert(JSON.stringify(STR_RESULT, null, '\t'));
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if ('errors' in JSON_RESULT) {
				var ERROR_KEYS = Object.keys(JSON_RESULT.errors);
				var ERROR_REASON = ERROR_KEYS[0];
				var STR_ERROR_MESSAGE = '';
				if (ERROR_REASON == 'invalid_username') {
					STR_ERROR_MESSAGE = '존재하지 않는 아이디입니다.';
				} else if (ERROR_REASON == 'incorrect_password') {
					STR_ERROR_MESSAGE = '비밀번호가 틀립니다.';
				}
			
				QIIP_POPUP_FOR_ALERT(
				"안내",[
						STR_ERROR_MESSAGE
				],
				function(){
			
				},
				20,
				16.5
				);
			} else {
				window.location.replace(
					sprintf('%s?S=%s', window.location.origin, _RS.PHONE_INFO.APP_NAME)
				);
			}
		}
	);
}
</script>
<div id="wrap" class="scw">
	<div class="main_text">
		<h1>i <em>HEALTH</em></h1>
		<h2>모션 캡쳐 재활치료 시스템</h2>
	</div>
	<div class="logo">
		<img src="/WEBAPPS/APPS/NOOL/assets/img/logo.png">
	</div>
</div>
<div id="wrap_2" class="scw" style="background: url('/WEBAPPS/APPS/NOOL/assets/img/log.jpg') no-repeat 100% 0%;background-size: 100%;">
	<div class="container">
    <div class="log_in_add">
		<h1 class="ph2"><strong>I Health</strong> 모션 캡쳐 재활 치료 시스템</h1>
		<p><strong>I Health Moble</strong> 계정으로 로그인 해주세요
        <br><small>I Health Mobile은 Play Store나 App Store에서 다운로드가 가능합니다.</small></p>
	</div>
    <div class="form-group log_in_compo">
        <input type="text" class="form-control" placeholder="ID를 입력해주세요." id="USER_ID" >
        <input type="password" class="form-control" placeholder="비밀번호를 입력해주세요." id="USER_PW">
        <div class="checkbox">
		    <label>
		      <input type="checkbox"  id="CHK_REMEMBER" ><p>아이디 기억하기</p>
		    </label>
	  	</div>
        <button type="submit" class="btn btn-primary block full-width m-b BTN_LOGIN_FORM" id="BTN_TO_LOGIN" >운동시작</button>
        <div class="sub_btn_group">
            <button type="submit" class="btn btn-primary block full-width m-b BTN_LOGIN_FORM" id="BTN_LOAD_REGIST_FORM">회원가입</button>
			<button type="submit" class="btn btn-primary block full-width m-b BTN_LOGIN_FORM" id="BTN_LOAD_PW_RESET_FORM">비밀번호찾기</button>
    	</div>
    </div>   
</div>
