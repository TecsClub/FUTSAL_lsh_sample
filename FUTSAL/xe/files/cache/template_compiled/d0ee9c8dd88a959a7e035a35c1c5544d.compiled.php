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
				USER_EMAIL: $('#USER_EMAIL').val()
			});
		} else if (ID == 'BTN_TO_BACK') {
			QIIP_APP_CHECK_IF_LOGIN();
		}
	});
}
function DO_TRY_REGIST(REGIST_DATA) {
//	alert(JSON.stringify(REGIST_DATA, null, '\t'));
	var PHP_CODES  = '';
		PHP_CODES += 'return register_new_user("' + REGIST_DATA.USER_ID + '","' + REGIST_DATA.USER_EMAIL + '");';
	QIIP_API_ACCESS({
			REQ: 'api_WP_ACCESS',
			PHP_CODES_BASE64: Base64.encode(PHP_CODES),
		},function(STR_RESULT) {
			var JSON_RESULT = {};
		    try { JSON_RESULT = JSON.parse(STR_RESULT); } catch(e) { }
			if ((typeof JSON_RESULT === 'object') && ('errors' in JSON_RESULT)) {
				QIIP_APP_ALERT([
					JSON.stringify(JSON_RESULT.errors, null, '\t')
				]);
			} else {
				QIIP_APP_ALERT([
					'다음 정보를 적용하여 회원가입 요청을 완료했습니다.',
					'[' + REGIST_DATA.USER_ID + ', ' + REGIST_DATA.USER_EMAIL + ']',
					'지정하신 E-MAIL [' + REGIST_DATA.USER_EMAIL + ']로 도착한 메일에서 비밀번호를 설정하세요!',
				],function () {
					window.location.replace(window.location.origin + '?S=' + _RS.PHONE_INFO.APP_NAME);
				});
			}
		}
	);
}
</script>
<div class="login_table">
	<div style="height:30%;"></div>
	<table style="height:20%;">
		<col width="20%"/>
		<col width="30%"/>
		<col width="30%"/>
		<tr style="height:33%;">
			<td></td>
			<th colspan="2">
				{{PHONE_INFO.APP_NAME}} 회원가입
			</th>
			<td></td>
		</tr>
		<tr style="height:33%;">
			<td></td>
			<td>
				<input type="text"
					   style="text-align:center;width:100%;height:100%;"
				       placeholder="아이디"
				       id="USER_ID"
				/>
			</td>
			<td>
				<input type="email"
					   style="text-align:center;width:100%;height:100%;"
				       placeholder="비밀번호 설정을 위한 이메일 주소"
				       id="USER_EMAIL"
				/>
			</td>
			<td></td>
		</tr>
		<tr style="height:34%;">
			<td></td>
			<td colspan="2">
				<table>
					<col width="80%" />
					<tr>
						<td>
							<button class="BTN_REGIST_FORM" id="BTN_TO_REGIST">
							가입 정보 제출
							</button>
						</td>
						<td>
							<button class="BTN_REGIST_FORM" id="BTN_TO_BACK">
							뒤로
							</button>
						</td>
					</tr>
				</table>
			</td>
			<td></td>
		</tr>
	</table>
	<div style="height:50%;""></div>
</div>
