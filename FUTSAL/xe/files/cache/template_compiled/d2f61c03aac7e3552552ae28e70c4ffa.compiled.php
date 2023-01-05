<?php if(!defined("__XE__"))exit;?><script>
function INIT_WIDGETS_FOR_PAGE(){
	// 캘린더
	
	$(".input-daterange").jqxDateTimeInput({ width: '100%', height: '35px', formatString: 'yyyy-MM-dd'});
	$('#BTN_SAVE').on('click', function () {
		
		var META_DATA = {
			'NOOL_NAME' : $('#NOOL_NAME').val(),
			'NOOL_PHONE' : $('#NOOL_PHONE_1ST').val() + $('#NOOL_PHONE_2ND').val() + $('#NOOL_PHONE_3RD').val(),
			'NOOL_PHONE_1ST' : $('#NOOL_PHONE_1ST').val(),
			'NOOL_PHONE_2ND' : $('#NOOL_PHONE_2ND').val(),
			'NOOL_PHONE_3RD' : $('#NOOL_PHONE_3RD').val(),
			'NOOL_BIRTH' : $('#NOOL_BIRTH').val(),
			'NOOL_REHAB_CODE' : $('#NOOL_REHAB_CODE').val(),
			'NOOL_SELF_INTRO' : $('#NOOL_SELF_INTRO').val(),
			'NOOL_SEX' : $(":input:radio[name=inlineRadioOptions]:checked").val(),
		};
		var STR_ERR_MESSAGE = '';
		var FLAG_ERROR = false;
		
		if (META_DATA.NOOL_NAME.length < 1) {
			STR_ERR_MESSAGE = '이름을 입력하세요.';
			FLAG_ERROR = true;
		}
		if (!FLAG_ERROR && !QIIP_IS_VALID_M_PHONE_NO(META_DATA.NOOL_PHONE)) {
			STR_ERR_MESSAGE = '전화번호 11자리 입력을 확인하세요.';
			FLAG_ERROR = true;
		}
		if (FLAG_ERROR) {
			QIIP_POPUP_FOR_ALERT(
			"안내",
			[
				STR_ERR_MESSAGE
			],
			function(){
				
			}
			,
			20,
			16.5
			);
			return;
		}
		var ARRAY_KEYS = Object.keys(META_DATA);
		
		ARRAY_KEYS.forEach(function (ONE_KEY) {
			UPDATE_USER_META(
				$('#NOOL_ID').val(),
				ONE_KEY,
				META_DATA[ONE_KEY]
			);
		});
		
		QIIP_POPUP_FOR_ALERT(
		"안내",
		[
			'저장되었습니다.'
		],
		function(){
			window.location.replace(
				sprintf('%s?S=%s', window.location.origin, _RS.PHONE_INFO.APP_NAME)
			);
		}
		,
		20,
		16.5
		);
		
		
	});
}
function UPDATE_USER_META(ID, META_KEY, META_VALUE) {
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
</script>
<div id="info_data">
	<div class="info_form">
	  <div class="info_header">
	    <h4>사용자 정보</h4>
	  </div>
	  <div class="info_body">
	    <div class="col-lg-12">
	        <form class="form-horizontal"><input type="hidden" name="error_return_url" value="<?php echo htmlspecialchars(getRequestUriByServerEnviroment(), ENT_COMPAT | ENT_HTML401, 'UTF-8', false) ?>" /><input type="hidden" name="act" value="<?php echo $__Context->act ?>" /><input type="hidden" name="mid" value="<?php echo $__Context->mid ?>" /><input type="hidden" name="vid" value="<?php echo $__Context->vid ?>" />
                 <input type="hidden" value="{{JSON_ARGS.data.ID}}" id="NOOL_ID">
	             <div class="form-group">
	                <label class="col-sm-2 control-label">아이디</label>
	                <div class="col-sm-5">
	                    <input type="text" readonly class="form-control" placeholder="아이디를 입력해주세요." value="{{JSON_ARGS.data.user_login}}" >
	                </div>
	                <p class="text-warning">특수문자나 공백은 입력 불가능합니다.</p>
	            </div>
	            
	            <div class="hr-line-dashed"></div>
<!--
	            <div class="form-group">
	                <label class="col-sm-2 control-label">비밀번호</label>
	                <div class="col-sm-5">
	                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="비밀번호를 입력해주세요.">
	                </div>
	                <p class="text-warning">영문, 숫자, 특수문자를 포함한 8자리 이상</p>
	            </div>
	            <div class="hr-line-dashed"></div>
	            <div class="form-group pw_ch">
	                <label class="col-sm-2 control-label">비밀번호 확인</label>
	                <div class="col-sm-5">
	                    <input type="password" class="form-control" id="exampleInputPassword2" placeholder="비밀번호를 재입력해주세요.">
	                </div>
	            </div>
	       
	            <div class="hr-line-dashed"></div>
-->
	            <div class="form-group">
	                <label class="col-sm-2 control-label">이 름</label>
	                <div class="col-sm-5">
	                    <input type="text" class="form-control" id="NOOL_NAME" placeholder="이름을 입력해주세요.">
	                </div>
	            </div>
	            <div class="hr-line-dashed"></div>
	            <div class="form-group">
	                <label class="col-sm-2 control-label">전화번호</label>
	                <div class="col-sm-8">
	                    <select class="form-control col-sm-3" id="NOOL_PHONE_1ST">
	                        <option>010</option>
	                        <option>011</option>
	                        <option>016</option>
	                        <option>017</option>
	                        <option>019</option>
	                    </select>
	                    <p class="col-sm-1">-</p>
	                    <input type="tel" class="form-control col-sm-3" id="NOOL_PHONE_2ND">
	                    <p class="col-sm-1">-</p>
	                    <input type="tel" class="form-control col-sm-3" id="NOOL_PHONE_3RD">
	                </div>
	            </div>
	            <div class="hr-line-dashed"></div>
	            <div class="form-group">
	                <label class="col-sm-2 control-label">생년월일</label>
	                <div class=" col-sm-5">
	                    <div class="input-daterange" id="NOOL_BIRTH" style="text-align: center; border-radius:4px;">
	                    </div>   
	                </div>
	    
	            </div>
	            <div class="hr-line-dashed"></div>
	            <div class="form-group gender">
	                <label class="col-sm-2 control-label">성 별</label>
	                <div class="col-sm-8">
	                    <label class="radio-inline">
	                      <input type="radio" name="inlineRadioOptions" value="MALE" checked> 남자
	                    </label>
	                    <label class="radio-inline">
	                      <input type="radio" name="inlineRadioOptions" value="FEMALE"> 여자
	                    </label>
	                </div>
	            </div>
	            <div class="hr-line-dashed"></div>
	            <div class="form-group">
	                <label class="col-sm-2 control-label">재활코드</label>
	                <div class="col-sm-8">
	                    <select class="form-control" id="NOOL_REHAB_CODE">
	                        <option>뇌성마비 - Cerebral palsy</option>
	                        <option>유전장애 - Genetic disorder</option>
	                        <option>다운증후군 - Down syndrome</option>
	                        <option>자폐증 - Autism</option>
	                        <option>아스퍼거 증후군 - Asperger's syndrome</option>
	                        <option>아동기 붕괴성 장애 - childhood collapse disorder</option>
	                        <option>레트 증후군 - Rett syndrome</option>
	                        <option>발달지체 - Developmental delay</option>
	                        <option>발달장애 - Developmental disorder</option>
	                        <option>근육퇴행 - Muscle regression</option>
	                        <option>주의력 결핍장애 - Attention deficit disorder</option>
	                        <option>뇌경색 - Cerebral infaction</option>
	                    </select>
	                </div>
	            </div>
	            <div class="hr-line-dashed"></div>
	            <div class="form-group">
	                <label class="col-sm-2 control-label">사 진</label>
	                <div class="col-sm-8">
	                    <p class="text-primary">NOOL Health Mobile에서 사진을 등록 해주세요.</p>
	                </div>
	            </div>
	            <div class="hr-line-dashed"></div>
	            <div class="form-group">
	                <label class="col-sm-2 control-label">자기소개</label>
	                <div class="col-sm-8">
	                	<!--
	                    <input type="text" class="form-control" id="exampleInputintroduction" placeholder="자기소개를 입력해주세요.">
	                    -->
	                    <textarea id="NOOL_SELF_INTRO"></textarea>
	                </div>
	            </div>
	        </form>
		</div>
	</div>
	  <div class="info_footer">
	    <button type="button" class="btn btn-default" id="BTN_SAVE">저장</button>
	  </div>
	</div>
</div>