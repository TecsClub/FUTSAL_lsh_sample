<?php if(!defined("__XE__"))exit;?><script>
	function INIT_WIDGETS_FOR_DIV_LEFTCON() {
		$("#BTN_INFO_MODIFY").on('click', function(){
			if (USER_DATA.ID == USER_DATA_FOR_CONTENT.ID) {
				DISPLAY_POPUP();
			} else {
				QIIP_POPUP_FOR_ALERT(
				"안내",
				[
					'다른 이용자의 개인정보를 수정할 수 없습니다.'
				],
				function(){
					
				}
				,
				20,
				16.5
				);
				
			}
		});
	}
	function DISPLAY_POPUP() {
		QIIP_API_ACCESS({
				REQ: 'api_GET_PAGE',
				FLDR_TEMPLATE: _FLDR_TEMPLATE,
				FILE_TEMPLATE: 'PAGES/POPUP_FOR_INPUT_USER_META_DATA.html',
			},function(STR_RESULT) {
				var HTML_COMPILED = QIIP_STATIC_HTML(USER_DATA, STR_RESULT);
				var OBJ_POPUP_FOR_ALERT = QIIP_JQX_POPUP_WINDOW({
		            showCollapseButton: true, 
		            height: '80%',
		            width: '33%',
		            minHeight: 100,
		            minWidth: 100,
					},
					'정보수정',
					HTML_COMPILED
				);
				_RS.$apply();
				
			  	SET_POPUP_FOR_USER_META_DATA(OBJ_POPUP_FOR_ALERT);
			  	INIT_WIDGETS_FOR_PAGE();
			}
		);
		
	}
</script>
<style>
	.left_con{
		background-color: #fff !important;
	}
</style>
<!-- left_con 영역 -->
<!-- 사용자 정보 영역 -->
<div class="info" style="height:10.5%;     overflow: hidden;">
	<div style="width: 85%; float:left;">
		<ul>
		   <li style="height: 64%;">Name<span>{{JSON_ARGS.data.META.NOOL_NAME[0]}}</span></li>
		   <li style="height: 64%;">Age<span>{{JSON_ARGS.data.META.LAST_LOGIN[0].substring(0,4) - JSON_ARGS.data.META.NOOL_BIRTH[0].substring(0,4) + 1}}</span></li>
		   <li style="height: 64%;">Gender<span>{{JSON_ARGS.data.META.NOOL_SEX[0]}}</span></li>
		   <li style="height: 36%;">R Code</li>
		   <li style="height: 36%;"><span>{{JSON_ARGS.data.META.NOOL_REHAB_CODE[0]}}</span></li>
		</ul>
	</div>
	<div style="width: 15%; float:left;">
		<button id="BTN_INFO_MODIFY">정보수정</button>
	</div>
</div>
<!-- 모션 데이터 영역 -->
<div class="motion_data">
	<h2>Motion Data (Average)</h2>
	<div role="tabpanel">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
	    <li role="presentation" class="active"><a href="#motion_1" aria-controls="home" role="tab" data-toggle="tab">활동범위</a></li>
	    <li role="presentation"><a href="#motion_2" aria-controls="profile" role="tab" data-toggle="tab">정확도</a></li>
	    <li role="presentation"><a href="#motion_3" aria-controls="messages" role="tab" data-toggle="tab">손목활동량</a></li>
	    <li role="presentation"><a href="#motion_4" aria-controls="settings" role="tab" data-toggle="tab">근력활동량</a></li>
	    <li role="presentation"><a href="#motion_5" aria-controls="settings" role="tab" data-toggle="tab">활동량</a></li>
	  </ul>
	  <!-- Tab panes -->
	    <div class="tab-content">
	        <div role="tabpanel" class="tab-pane active" id="motion_1">
	            <p>- 부위별 평균 활동범위를 표시합니다.</p>
	            <img src="/WEBAPPS/APPS/NOOL/assets/img/pic1.png">
	            <ul>
	               <li>L / H<span>{{JSON_ARGS.MOTION_DATA.ACTION_LH}}º</span></li>
	               <li>R / H<span>{{JSON_ARGS.MOTION_DATA.ACTION_RH}}º</span></li> 
	               <li>L / F<span>{{JSON_ARGS.MOTION_DATA.ACTION_LF}}º</span></li> 
	               <li>R / F<span>{{JSON_ARGS.MOTION_DATA.ACTION_RF}}º</span></li>  
	            </ul>
	        </div>
	        <div role="tabpanel" class="tab-pane" id="motion_2">
	            <p>- 부위별 도형 그리기의 전체난이도 평균 성공갯수를 표시합니다.</p>
	            <img src="/WEBAPPS/APPS/NOOL/assets/img/pic2.png">
	            <ul>
	               <li>L / H<span>{{JSON_ARGS.MOTION_DATA.AVE_ANGLE_LH}}개</span></li>
	               <li>R / H<span>{{JSON_ARGS.MOTION_DATA.AVE_ANGLE_RH}}개</span></li> 
	             
	            </ul>
	        </div>
	        <div role="tabpanel" class="tab-pane" id="motion_3">
	            <p>- 부위별 평균 손목활동량 표시합니다.</p>
	            <img src="/WEBAPPS/APPS/NOOL/assets/img/pic3.png">
	            <ul>
	               <li>L / H<span>{{JSON_ARGS.MOTION_DATA.MAX_ANGLE_LH}}</span></li>
	               <li>R / H<span>{{JSON_ARGS.MOTION_DATA.MAX_ANGLE_RH}}</span></li> 
	             
	            </ul>
	        </div>
	        <div role="tabpanel" class="tab-pane" id="motion_4">
	            <p>- 부위별 평균 근력활동량 표시합니다.</p>
	            <img src="/WEBAPPS/APPS/NOOL/assets/img/pic4.png">
	            <ul>
	               <li>L / H<span>{{JSON_ARGS.MOTION_DATA.ACTION_STL}}</span></li>
	               <li>R / H<span>{{JSON_ARGS.MOTION_DATA.ACTION_STR}}</span></li>
	            </ul>
	        </div>
	        <div role="tabpanel" class="tab-pane" id="motion_5">
	            <p>- 부위별 평균 활동량을 표시합니다.</p>
	            <img src="/WEBAPPS/APPS/NOOL/assets/img/pic5.png">
	            <ul>
	               <li>L / H<span>{{JSON_ARGS.MOTION_DATA.ACTION_LA}}</span></li>
	               <li>R / H<span>{{JSON_ARGS.MOTION_DATA.ACTION_RA}}</span></li> 
	               <li>L / F<span>{{JSON_ARGS.MOTION_DATA.ACTION_LPO}}</span></li> 
	               <li>R / F<span>{{JSON_ARGS.MOTION_DATA.ACTION_RPO}}</span></li>  
	            </ul>
	        </div>
	    </div>
	</div>
</div>
<!-- 유저데이터 영역 -->
<div class="user_data">
	<h2>User Data</h2>
	<ul>
	    <li>총 운동 횟수<span>{{JSON_ARGS.MOTION_DATA.TRAINNING_COUNT}} cycle</span></li>
	    <li>누적 운동 시간<span>{{JSON_ARGS.MOTION_DATA.TRAINNING_MINUTES}} 분</span></li>
	    <li>최근 방문일<span>{{JSON_ARGS.data.META.LAST_LOGIN[0]}}</span></li>
	</ul>
</div>