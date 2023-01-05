<?php if(!defined("__XE__"))exit;
$__Context->JSON_ARGS = json_decode(base64_decode($__Context->ARGS->JSON_ARGS_BASE64));  ?>
#PAGE_ARGS# <!-- <script>var JSON_ARGS=JSON.parse(Base64.decode($ARGS->JSON_ARGS_BASE64));</script> -->
<style>
	.login_table 			{width:100%; height:100%;}
	.login_table table		{width:100%; height:100%; font-size:100%; border-collapse: separate; border-spacing: 1px; line-height: 100%;}
	.login_table table th	{text-decoration:bold; text-align: center; white-space:normal; vertical-align: middle; word-break:break-all; background:#ccc;}
	.login_table table td	{text-decoration:none; text-align: left;   white-space:normal; vertical-align: middle;word-break:break-all;}
</style>
<script>
function INIT_WIDGETS_FOR_LOGIN_FORM() {
	$(document).unbind('keypress');
	$(document).keypress(function (EVENT) {
		if ( event.which == 13 ) {
		     event.preventDefault();
			DO_TRY_LOGIN({
				USER_ID: $('#USER_ID').val(),
				REMEMBER: $('#CHK_REMEMBER').is(":checked")
			});
		}
	});
	$(".BTN_LOGIN_FORM").jqxButton({
		width: '100%',
		height: '100%'
	}).on('click', function (event) {
//		event.preventDefault();
//    	event.stopPropagation();
//    	event.stopImmediatePropagation();
		var ID = $(this).attr('ID');
//console.log('CLICK_FUNC_ON_BTN_LOGIN_FORM CLICK : ' + ID);
		if (ID == 'DUMMY') {
		} else if (ID == 'BTN_TO_LOGIN') {
			DO_TRY_LOGIN({
				USER_ID: $('#USER_ID').val(),
				REMEMBER: $('#CHK_REMEMBER').is(":checked")
			});
		} else if (ID == 'BTN_LOAD_REGIST_FORM') {
			DO_LOAD_REGIST_FORM();
		} else if (ID == 'BTN_LOAD_PW_RESET_FORM') {
			DO_LOAD_PW_RESET_FORM();
		}
	});
	$("#CHK_REMEMBER").change(function () {
		if ($(this).is(":checked")) {
			QIIP_APP_ALERT([
				'공용 장소에서는 가능한 한,...',
				'이 기능을 사용하지 않을 것을 권유드립니다.'
			]);
		}
	});
}
function DO_LOAD_PW_RESET_FORM() {
	if (FLAG_PREVENT_TWICE_CLICK) return; else FLAG_PREVENT_TWICE_CLICK = true;
	var JSON_ARGS_BASE64 = Base64.encode(JSON.stringify({
			IS_MOBILE: QIIP_IS_MOBILE()
		}));
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'LOGIN/APP_CONTENTS_PW_RESET_FORM.html',
			JSON_ARGS_BASE64: JSON_ARGS_BASE64,
		},function(STR_RESULT) {
			var HTML_COMPILED = _AC(STR_RESULT)(_RS);
			$('#APP_CONTENTS').html(HTML_COMPILED); _RS.$apply();
			INIT_WIDGETS_FOR_PW_RESET_FORM();
			FLAG_PREVENT_TWICE_CLICK = false;
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
	if (FLAG_PREVENT_TWICE_CLICK) return; else FLAG_PREVENT_TWICE_CLICK = true;
	var JSON_ARGS_BASE64 = Base64.encode(JSON.stringify({
			IS_MOBILE: QIIP_IS_MOBILE()
		}));
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'LOGIN/APP_CONTENTS_REGIST_FORM.html',
			JSON_ARGS_BASE64: JSON_ARGS_BASE64,
		},function(STR_RESULT) {
			var HTML_COMPILED = _AC(STR_RESULT)(_RS);
			$('#APP_CONTENTS').html(HTML_COMPILED); _RS.$apply();
			INIT_WIDGETS_FOR_REGIST_FORM();
			FLAG_PREVENT_TWICE_CLICK = false;
		},{
			title: _RS.PHONE_INFO.APP_NAME + ' 안내',
			template: ARR_TO_TABLE_CENTER([
				'화면을 구성하고 있습니다.'
			]),
			cssClass: 'qiip_popup'
		}
	);
}
function DO_TRY_LOGIN(LOGIN_DATA) {
	if (FLAG_PREVENT_TWICE_CLICK) return; else FLAG_PREVENT_TWICE_CLICK = true;
	if (!QIIP_IS_VALID_M_PHONE_NO(LOGIN_DATA.USER_ID)) {
		QIIP_APP_ALERT([
			'[' + LOGIN_DATA.USER_ID + '] 는 적절한 핸드폰 번호가 아닙니다!',
		],function () {
			FLAG_PREVENT_TWICE_CLICK = false;
		});
		return;
	}
	var PHP_CODES  = "";
		PHP_CODES += "return username_exists('" + LOGIN_DATA.USER_ID + "');";
	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
		    var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
/*		    
				QIIP_APP_ALERT([
					'<xmp>' + JSON.stringify(JSON_RESULT, null, '\t') + '</xmp>',
				],function () {
				});
*/
			if (STR_RESULT.indexOf('false') >= 0) {
				QIIP_APP_ALERT([
					'핸드폰 번호,...',
					'[' + LOGIN_DATA.USER_ID + '] 는',
					'아직 회원으로 가입되지 않았습니다!',
				],function () {
				});
			} else {
				POPUP_FOR_EXEC_IVR_SCENARIO({
					APIKEY:				IVR_APIKEY,
					CMD:				'ARSAUTH_WAIT',
					TITLE:				'[' + LOGIN_DATA.USER_ID + '] 님 - ARS 인증을 통한 로그인',
					CALL_SCENARIO:		'ARS_USER_INPUT',
        			CALL_IN_ANSWER:		true,
					
					STR_SCENARIO_HELP:	ARR_TO_TABLE_CENTER([
						'[다음 단계] 버튼을 클릭하신 후,...',
						'아래와 같이 전화를 걸어, ARS 안내 음성에 따라 비밀번호를 입력 하시면,...',
						'로그인 절차가 완료됩니다.',
					]),
					MENT_INTRO:			'로그인 하시려면 인증번호 여섯자리를 입력해주세요.',
					MENT_NO_INPUT:		'아무 입력도 없었습니다.',
					MENT_SOME_INPUT:	'입력하신 인증번호를 적용하여 로그인을 시도합니다.',
					MENT_LACK_INPUT:	'입력하신 인증번호의 갯수가 부족합니다.',
					MENT_RETRY:			'인증번호 여섯자리를 다시 입력해 주십시오.',
					MENT_RETRY_EXAUST:	'허용된 재시도 횟수를 초과하여 인증을 실패하셨습니다.',
					CALL_TO:			IVR_NUMBER,
					CALL_FROM:			LOGIN_DATA.USER_ID,
					AUTH_NUMBER:		'??????',
					AUTH_RETRY:			3,
					FUNC_CALLBACK:		'ARS_PW_INPUT_RESULT',
					LOGIN_DATA:			LOGIN_DATA
				});
			}
			FLAG_PREVENT_TWICE_CLICK = false;
		}
	);
}
function ARS_PW_INPUT_RESULT(STR_JSON_BASE64) {
	var JSON_ARS_AUTH_RESULT = JSON.parse(Base64.decode(STR_JSON_BASE64));
	console.log(JSON.stringify(JSON_ARS_AUTH_RESULT, null, '\t'));
	if (('CALL_ARGS' in JSON_ARS_AUTH_RESULT) && 
		('CALL_STATUS' in JSON_ARS_AUTH_RESULT) && 
		('USER_DTMF_INPUTS' in JSON_ARS_AUTH_RESULT)) {
//		if ((JSON_ARS_AUTH_RESULT.USER_DTMF_INPUTS.length >= 1) && 
//			(JSON_ARS_AUTH_RESULT.CALL_STATUS.CODE == 201) && 
//			(JSON_ARS_AUTH_RESULT.CALL_STATUS.CODE_STR == 'AUTH_USER_INPUT')) {
				
		if (JSON_ARS_AUTH_RESULT.USER_DTMF_INPUTS.length >= 1) {
			var USER_AUTH = JSON_ARS_AUTH_RESULT.USER_DTMF_INPUTS.pop();
			JSON_ARS_AUTH_RESULT.CALL_ARGS.LOGIN_DATA.USER_PW = USER_AUTH;
			DO_LOGIN(
				JSON_ARS_AUTH_RESULT.CALL_ARGS.LOGIN_DATA
			);
		} else {
			QIIP_APP_ALERT([
				'아래와 같이 ARS 시나리오가 전개되어, 로그인을 할 수 없습니다.',
				'<table style="width:100%;text-align:left;">' + 
				'<tr>' + 
				'<td>' + 
				'<pre>' + 
					JSON.stringify(JSON_ARS_AUTH_RESULT.SCENARIO_HISTORY, null, '\t') + 
				'</pre>' +
				'</tr>' + 
				'</td>' + 
				'</table>'
			],function () {
			});
		}
	}
}
function POPUP_FOR_EXEC_IVR_SCENARIO(SCENARIO_PARAM) {
	var JSON_ARGS_BASE64 = Base64.encode(JSON.stringify(SCENARIO_PARAM));
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'POPUP/POPUP_FOR_EXEC_IVR_SCENARIO.html',
			JSON_ARGS_BASE64: JSON_ARGS_BASE64,
		},function(STR_RESULT) {
			var OBJ_POPUP = QIIP_JQX_POPUP_WINDOW({
	            showCollapseButton: true, 
	            height: '95%',
	            width: '90%',
	            minHeight: 100,
	            minWidth: 100,
				},
				SCENARIO_PARAM.TITLE,
				STR_RESULT
			);
		  	INIT_WIDGETS_POPUP_FOR_EXEC_IVR_SCENARIO(OBJ_POPUP);
		},{
			title: _RS.PHONE_INFO.APP_NAME + ' 안내',
			template: ARR_TO_TABLE_CENTER([
				'화면을 구성하고 있습니다.'
			]),
			cssClass: 'qiip_popup'
		}
	);
}
function DO_LOGOUT() {
	var PHP_CODES  = '';
		PHP_CODES += 'return wp_logout();';
	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
			window.location.replace(window.location.origin + '?S=' + _RS.PHONE_INFO.APP_NAME);
		}
	);
	
}
function DO_LOGIN(LOGIN_DATA) {
//	alert(JSON.stringify(LOGIN_DATA, null, '\t'));
	
	var PHP_CODES  = "";
		PHP_CODES += "$credentials = array(";
		PHP_CODES += "  'user_login' => '" + LOGIN_DATA.USER_ID + "',";
		PHP_CODES += "  'user_password' => '" + LOGIN_DATA.USER_PW + "',";
		PHP_CODES += "  'remember' => " + LOGIN_DATA.REMEMBER + "";
		PHP_CODES += ");";
		PHP_CODES += "return wp_signon($credentials);";
	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
//			alert(JSON.stringify(STR_RESULT, null, '\t'));
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if ('errors' in JSON_RESULT) {
				QIIP_APP_ALERT([
					'아래와 같은 원인으로, 로그인을 할 수 없습니다.',
					'<table style="width:100%;text-align:left;">' + 
					'<tr>' + 
					'<td>' + 
					'<pre>' + 
						JSON.stringify(JSON_RESULT.errors, null, '\t') +
					'</pre>' +
					'</tr>' + 
					'</td>' + 
					'</table>'
				]);
			} else {
				window.location.replace(window.location.origin + '?SELECT=' + _RS.PHONE_INFO.APP_NAME);
			}
		}
	);
}
</script>
<div class="login_table">
	<?php if($__Context->JSON_ARGS->IS_MOBILE){ ?>
	<table style="height:150px;">
		<col width="30%"/>
		<col width="30%"/>
	<?php }else{ ?>
	<div style="height:30%;"></div>
	<table style="height:20%;">
		<col width="20%"/>
		<col width="30%"/>
		<col width="30%"/>
		<col width="20%"/>
	<?php } ?>
		<tr style="height:33%;">
			<?php if(!$__Context->JSON_ARGS->IS_MOBILE){ ?>
			<td></td>
			<?php } ?>
			<th colspan="2">
				{{PHONE_INFO.APP_NAME}} 서비스 로그인 
			</th>
			<?php if(!$__Context->JSON_ARGS->IS_MOBILE){ ?>
			<td></td>
			<?php } ?>
		</tr>
		<tr style="height:33%;">
			<?php if(!$__Context->JSON_ARGS->IS_MOBILE){ ?>
			<td></td>
			<?php } ?>
			<td colspan="2">
				<label class="item item-input">
					<input type="number"
						   style="text-align:center"
					       placeholder="핸드폰 번호 입력 후 [로그인] 버튼을 누르면 ARS 인증 후 자동 로그인 됩니다."
					       id="USER_ID"
					/>
				</label>
			</td>
			<?php if(!$__Context->JSON_ARGS->IS_MOBILE){ ?>
			<td></td>
			<?php } ?>
		</tr>
		<tr style="height:34%;">
			<?php if(!$__Context->JSON_ARGS->IS_MOBILE){ ?>
			<td></td>
			<?php } ?>
			<td colspan="2">
				<table>
					<col width="25%"/>
					<col width="15%"/>
					<col width="40%"/>
					<tr>
						<td>
							<button class="BTN_LOGIN_FORM" id="BTN_LOAD_PW_RESET_FORM">
							비밀번호 찾기
							</button>
						</td>
						<td style="text-align:center; box-sizing:border-box; border: solid gray 1px;">
							<input type="checkbox" id="CHK_REMEMBER" /> 기억
						</td>
						<td>
							<button class="BTN_LOGIN_FORM" id="BTN_TO_LOGIN">
							로그인
							</button>
						</td>
						<?php if($__Context->JSON_ARGS->USERS_CAN_REGISTER){ ?><td>
							<button class="BTN_LOGIN_FORM" id="BTN_LOAD_REGIST_FORM">
							회원가입
							</button>
						</td><?php } ?>
					</tr>
				</table>
			</td>
			<?php if(!$__Context->JSON_ARGS->IS_MOBILE){ ?>
			<td></td>
			<?php } ?>
		</tr>
	</table>
	<?php if(!$__Context->JSON_ARGS->IS_MOBILE){ ?>
	<div style="height:50%;""></div>
	<?php } ?>
</div>
