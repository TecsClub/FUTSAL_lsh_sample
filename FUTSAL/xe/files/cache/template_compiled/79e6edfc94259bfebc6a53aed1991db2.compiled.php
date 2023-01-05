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
function INIT_WIDGETS_FOR_REGIST_FORM() {
	$(window).unbind();
	$(window).keypress(function (EVENT) {
		if ( event.which == 13 ) {
		     event.preventDefault();
			DO_TRY_REGIST({
				USER_ID: $('#USER_ID').val(),
				USER_PW: $('#USER_PW').val(),
				USER_EMAIL: $('#USER_EMAIL').val()
			});
		}
	});
	$(".BTN_REGIST_FORM").jqxButton({
		width: '100%',
		height: '100%'
	}).on('click', function () {
		var ID = $(this).attr('ID');
		if (ID == 'DUMMY') {
		} else if (ID == 'BTN_TO_REGIST') {
			DO_TRY_REGIST({
				USER_ID: $('#USER_ID').val(),
				USER_PW: $('#USER_PW').val(),
				USER_EMAIL: $('#USER_EMAIL').val()
			});
		} else if (ID == 'BTN_TO_BACK') {
			QIIP_APP_CHECK_IF_LOGIN();
		}
	});
}
function DO_TRY_REGIST(REGIST_DATA) {
//	alert(JSON.stringify(REGIST_DATA, null, '\t'));
//	var PHP_CODES  = '';
//		PHP_CODES += 'return register_new_user("' + REGIST_DATA.USER_ID + '","' + REGIST_DATA.USER_EMAIL + '");';
	
	var STR_ERROR_MESSAGE = '';
	var ERROR_STATE = false;
	if (REGIST_DATA.USER_ID.length < 1) {
		STR_ERROR_MESSAGE = '사용자명을 입력해주세요.';
		ERROR_STATE = true;
	}
	if (!ERROR_STATE && REGIST_DATA.USER_PW.length < 1) {
		STR_ERROR_MESSAGE = '비밀번호를 입력해주세요.';
		ERROR_STATE = true;
	}
	if (!ERROR_STATE && REGIST_DATA.USER_EMAIL.length < 1) {
		STR_ERROR_MESSAGE = '이메일 주소를 넣으세요.';
		ERROR_STATE = true;
	}
	
	if (ERROR_STATE) {
		QIIP_POPUP_FOR_ALERT(
		'안내',
		[
				STR_ERROR_MESSAGE
		],
		function(){
	
		}
		,
		20,
		16.4
		);
		return;
	}
	var PHP_CODES  = "";
		PHP_CODES += "return wp_create_user('" + REGIST_DATA.USER_ID + "','" + REGIST_DATA.USER_PW + "','" + REGIST_DATA.USER_EMAIL + "');";
	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if ((typeof JSON_RESULT === 'object') && ('errors' in JSON_RESULT)) {
				var ERROR_KEYS = Object.keys(JSON_RESULT.errors);
				var ERROR_REASON = ERROR_KEYS[0];
				var STR_ERROR_MESSAGE = '';
				if (ERROR_REASON == 'empty_user_login') {
					STR_ERROR_MESSAGE = '사용자명을 입력해주세요.';
				} else if (ERROR_REASON == 'existing_user_login') {
					STR_ERROR_MESSAGE = '이미 존재하는 사용자명입니다.';
				} else if (ERROR_REASON == 'existing_user_email') {
					STR_ERROR_MESSAGE = '이미 등록된 이메일 주소입니다.';
				} else {
					STR_ERROR_MESSAGE = JSON.stringify(JSON_RESULT);
				}
				QIIP_POPUP_FOR_ALERT(
				'안내',
				[
						STR_ERROR_MESSAGE
				],
				function(){
			
				}
				,
				20,
				16.5
				);
			} else {
				QIIP_POPUP_FOR_ALERT(
				'안내',
				[
					'아래와 같은 회윈정보를 적용하여 회원가입을 처리했습니다.',
					'[ 회원 아이디 : ' + REGIST_DATA.USER_ID + ', 비밀번호 : ' + REGIST_DATA.USER_PW + ', EMAIL 주소 : ' + REGIST_DATA.USER_EMAIL + ']',
				],function () {
					window.location.replace(window.location.origin);
				},
				20,
				20
				);
			}
		}
	);
}
function DO_UPDATE_USER_INFO(UPDATE_INFO) {
	var PHP_CODES  = '';
		PHP_CODES += '$UPDATE_RESULT = wp_update_user(array(';
		PHP_CODES += '"ID" => "' + OBJ_LOGIN_INFO.ID + '",';
		PHP_CODES += '"display_name" => "' + UPDATE_INFO.display_name + '",';
		PHP_CODES += '"description" => "' + UPDATE_INFO.description + '"';
		PHP_CODES += '));';
		PHP_CODES += 'return $UPDATE_RESULT;';
		
	QIIP_WP_ACCESS(
		PHP_CODES,
		function (RESULT) {
			var JSON_RESULT = {};
		    try { JSON_RESULT = JSON.parse(RESULT); } catch(e) { }
//			if ((typeof JSON_RESULT === 'object') && ('errors' in JSON_RESULT)) {
			if ((typeof JSON_RESULT === 'object') && (true)) {
				QIIP_POPUP_FOR_ALERT(
				'안내',
				[
					JSON.stringify(JSON_RESULT, null, '\t')
				],function () {
				});
			} else {
//				UPDATE_ROOT_INFO(UPDATE_INFO);
			}
		}
	);
}
</script>
<div class="login_table">
	<header>
		<div class="container">
			<button class="BTN_REGIST_FORM" id="BTN_TO_BACK"><i class="fa fa-arrow-left" aria-hidden="true"></i> 뒤로</button>
		</div>
	</header>
	<div class="container join_form">
		
		<h2>{{PHONE_INFO.APP_NAME}} 회원가입</h2>
        <div class="form-group join_in">
            <input type="text" class="form-control" placeholder="아이디" id="USER_ID">
    		<input type="password" class="form-control" placeholder="비밀번호 " id="USER_PW">
    		<input type="email" class="form-control" placeholder="이메일 주소" id="USER_EMAIL">
            <button type="submit" class="btn btn-primary block full-width m-b BTN_REGIST_FORM" id="BTN_TO_REGIST">가입 정보 제출</button>
        </div>
    </div>
</div>
