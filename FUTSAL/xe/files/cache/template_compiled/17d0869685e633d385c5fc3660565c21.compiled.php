<?php if(!defined("__XE__"))exit;?><script>
var POPUP_FOR_USER_META_DATA = null;
function SET_POPUP_FOR_USER_META_DATA(args_POPUP){
	POPUP_FOR_USER_META_DATA = args_POPUP;
}
function INIT_WIDGETS_FOR_PAGE(){
	
	$("#dropdownlistContentNOOL_REHAB_CODE").css("margin","0");
	
	/* 전화번호 */
   	$("#NOOL_PHONE").jqxMaskedInput({
	     width: '250px',
	     height: '35px',
	     mask:'###-####-####'
	 });
    
   
    /* 재활코드 */
	var source = [
            { REHAB_INDEX: 0, html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'>뇌성마비 - Cerebral palsy</span></div>", title: '뇌성마비 - Cerebral palsy' },
            { REHAB_INDEX: 1, html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'>유전장애 - Genetic disorder</span></div>", title: '유전장애 - Genetic disorder' },
            { REHAB_INDEX: 2, html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'>다운증후군 - Down syndrome</span></div>", title: '다운증후군 - Down syndrome' },
      		{ REHAB_INDEX: 3, html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'>자폐증 - Autism</span></div>", title: '자폐증 - Autism' },
            { REHAB_INDEX: 4, html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'>아스퍼거 증후군 - Asperger's syndrome</span></div>", title: "아스퍼거 증후군 - Asperger's syndrome" },
            { REHAB_INDEX: 5, html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'>아동기 붕괴성 장애 - childhood collapse disorder</span></div>", title: '아동기 붕괴성 장애 - childhood collapse disorder' },
            { REHAB_INDEX: 6, html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'>레트 증후군 - Rett syndrome</span></div>", title: '레트 증후군 - Rett syndrome' },
            { REHAB_INDEX: 7, html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'>발달지체 - Developmental delay</span></div>", title: '발달지체 - Developmental delay' },
      		{ REHAB_INDEX: 8, html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'>발달장애 - Developmental disorder</span></div>", title: '발달장애 - Developmental disorder' },
			{ REHAB_INDEX: 9, html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'>근육퇴행 - Muscle regression</span></div>", title: '근육퇴행 - Muscle regression' },
			{ REHAB_INDEX:10, html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'>주의력 결핍장애 - Attention deficit disorder</span></div>", title: '주의력 결핍장애 - Attention deficit disorder' },
			{ REHAB_INDEX:11, html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'>뇌경색 - Cerebral infaction</span></div>", title: '뇌경색 - Cerebral infaction' }
        ];
   		// Create a jqxDropDownList
   		
   		
        $("#NOOL_REHAB_CODE").jqxDropDownList({
        	 source: source, width: '100%', height: 35,
        	 selectedIndex: $("#NOOL_REHAB_CODE_PREV").val()
        });
        
        
   		 
	// 캘린더
	
	$(".input-daterange").jqxDateTimeInput({ width: '100%', height: '35px', formatString: 'yyyy-MM-dd'});
	$('#BTN_CANCLE').on('click', function () {
		if (POPUP_FOR_USER_META_DATA != null) {
			QIIP_JQX_CLOSE_WINDOW(POPUP_FOR_USER_META_DATA);
		}
	});
	
	$('#BTN_SAVE').on('click', function () {
		
		var META_DATA = {
			'NOOL_NAME' : $('#NOOL_NAME').val(),
			'NOOL_PHONE' : $('#NOOL_PHONE').val(),
			'NOOL_BIRTH' : $('#NOOL_BIRTH').val(),
			'NOOL_REHAB_CODE' : $('#NOOL_REHAB_CODE').val(),
			'REHAB_INDEX' : $('#NOOL_REHAB_CODE').jqxDropDownList('getSelectedIndex'),
			'NOOL_SELF_INTRO' : $('#NOOL_SELF_INTRO').val(),
			'NOOL_SEX' : $(":input:radio[name=inlineRadioOptions]:checked").val()
		};
		
//		alert(JSON.stringify(META_DATA, null, '\t'));
		var STR_ERR_MESSAGE = '';
		var FLAG_ERROR = false;
		
		if (META_DATA.NOOL_NAME.length < 1) {
			STR_ERR_MESSAGE = '이름을 입력하세요.';
			FLAG_ERROR = true;
		}
		if (!FLAG_ERROR && !QIIP_IS_VALID_M_PHONE_NO(META_DATA.NOOL_PHONE.split('-').join(''))) {
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
			if (POPUP_FOR_USER_META_DATA != null) {
				QIIP_JQX_CLOSE_WINDOW(POPUP_FOR_USER_META_DATA);
				UPDATE_USER_META_FOR_POPUP();
			}
		}
		,
		20,
		16.5
		);
		
		
	});
	function UPDATE_USER_META_FOR_POPUP() {
		var PHP_CODES  = '';
			PHP_CODES += '$META_RESULT = json_encode(get_user_meta(';
			PHP_CODES += USER_DATA.ID;
			PHP_CODES += '));';
			PHP_CODES += 'return $META_RESULT;';
			
		QIIP_API_ACCESS({
				REQ: 'api_WP_ACCESS',
				PHP_CODES_BASE64: Base64.encode(PHP_CODES),
			},function(STR_RESULT) {
				var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
				USER_DATA.META = JSON_RESULT;
				LOAD_DIV_LEFTCON();
			}
		);
		
	}
	
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
	                    <input type="text" class="form-control" id="NOOL_NAME" placeholder="이름을 입력해주세요." value="{{JSON_ARGS.data.META.NOOL_NAME[0]}}">
	                </div>
	            </div>
	            <div class="hr-line-dashed"></div>
	            <div class="form-group">
	                <label class="col-sm-2 control-label">전화번호</label>
	                <div class="col-sm-8">
	                    <!--
	                    <div type="tel" class="form-control col-sm-3 jqxWidget_phone_num" id="NOOL_PHONE_1ST" value="{{JSON_ARGS.META.NOOL_PHONE_1ST[0]}}" ></div>
	                    <p class="col-sm-1">-</p>
	                    <input type="tel" class="form-control col-sm-3" id="NOOL_PHONE_2ND" value="{{JSON_ARGS.META.NOOL_PHONE_2ND[0]}}" >
	                    <p class="col-sm-1">-</p>
	                    <input type="tel" class="form-control col-sm-3" id="NOOL_PHONE_3RD"  value="{{JSON_ARGS.META.NOOL_PHONE_3RD[0]}}" >
	                    -->
	                    <input id='NOOL_PHONE' value="{{JSON_ARGS.data.META.NOOL_PHONE[0].split('-').join('')}}" style="padding: .375rem .75rem;"/>
	                </div>
	            </div>
	            <div class="hr-line-dashed"></div>
	            <div class="form-group">
	                <label class="col-sm-2 control-label">생년월일</label>
	                <div class=" col-sm-5">
	                    <div class="input-daterange" id="NOOL_BIRTH" style="text-align: center; border-radius:4px;" value="{{JSON_ARGS.data.META.NOOL_BIRTH[0]}}">
	                    </div>   
	                </div>
	    
	            </div>
	            <div class="hr-line-dashed"></div>
	            <div class="form-group gender">
	                <label class="col-sm-2 control-label">성 별</label>
	                <div class="col-sm-8">
	                    <label class="radio-inline">
	                      <input type="radio" name="inlineRadioOptions" value="MALE" checked > 남자
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
                    	<input type="hidden" id="NOOL_REHAB_CODE_PREV" value="{{JSON_ARGS.data.META.REHAB_INDEX[0]}}" />
	                    <div class="form-control" id="NOOL_REHAB_CODE" style="margin-bottom: 20px;">
	                    </div>
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
	                    <textarea id="NOOL_SELF_INTRO">{{JSON_ARGS.data.META.NOOL_SELF_INTRO[0]}}</textarea>
	                </div>
	            </div>
	        </form>
		</div>
	</div>
	  <div class="info_footer">
	    <button type="button" class="btn btn-default BTN_POPUP" id="BTN_CANCLE">취소</button>
	    <button type="button" class="btn btn-default BTN_POPUP" id="BTN_SAVE">저장</button>
	  </div>
	</div>
</div>