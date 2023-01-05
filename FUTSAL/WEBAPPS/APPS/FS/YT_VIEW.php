<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width, height=device-height" />
		<title>경기영상</title>

	    <!-- jquery script -->

		<script src="/WEBAPPS/LIBS/ESSENCE/jquery-3.5.1.min.js"></script>
		<link rel="stylesheet" href="/WEBAPPS/LIBS/ESSENCE/jquery-ui.css" />
		<script src="/WEBAPPS/LIBS/ESSENCE/jquery-ui.min.js"></script>

<!--
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
-->

		<link rel="stylesheet" href="/WEBAPPS/LIBS/ESSENCE/bootstrap.min.css">
		<script src="/WEBAPPS/LIBS/ESSENCE/bootstrap.min.js"></script>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />

<!--
 		<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.0/angular.min.js"></script>
-->
 		<script src="/WEBAPPS/LIBS/ESSENCE/angular.min.js"></script>
 		
		<!-- FOR PDF VIEWER -->
<!--
		<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
		<script src="/WEBAPPS/LIBS/ESSENCE/pdf.js"></script>
-->

	    <!-- jqwidgets script -->
	    <link rel="stylesheet" href="/WEBAPPS/LIBS/jqw/jqwidgets/styles/jqx.base.css" type="text/css" />
	    <link rel="stylesheet" href="/WEBAPPS/LIBS/jqw/jqwidgets/styles/jqx.android.css" type="text/css" />
	    <link rel="stylesheet" href="/WEBAPPS/LIBS/jqw/jqwidgets/styles/jqx.mobile.css" type="text/css" />

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxcore.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxdata.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxbuttons.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxscrollbar.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxlistbox.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxdropdownlist.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxcheckbox.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxslider.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxprogressbar.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxmenu.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxwindow.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxpanel.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxdatetimeinput.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxcalendar.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxtooltip.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/globalization/globalize.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxdraw.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxchart.core.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.sort.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.pager.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.selection.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.edit.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxradiobutton.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxtabs.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxtextarea.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxswitchbutton.js"></script>
	    

	    <!-- lsy.utils script -->
	    <link rel="stylesheet" href="/WEBAPPS/LIBS/LSY/QIIP.css" type="text/css" />
	    <script src="/WEBAPPS/LIBS/LSY/QIIP.js"></script>

	    <script src="/WEBAPPS/LIBS/sprintf-js/src/sprintf.js"></script>
	    <script src="/WEBAPPS/LIBS/sprintf-js/src/angular-sprintf.js"></script>
	    <script src="/WEBAPPS/LIBS/formatDate.js"></script>

		<script src='https://www.youtube.com/iframe_api'></script>

		<script>
/*
csv 파일 저장된 링크
https://docs.google.com/spreadsheets/d/1A5ivpUAnU4TjZKHOhEBArQpC2qChFb2EsmflFJ5yRjo/edit#gid=0

*/

			var onYouTubeIframeAPIReady_flag = false;
		    function onYouTubeIframeAPIReady() {
				onYouTubeIframeAPIReady_flag = true;
		    }
			
			document.addEventListener("DOMContentLoaded", function(){
				QIIP_ANGULAR_INIT({
					ng_app: 'ANGULAR_WEBAPPS',
					ng_app_injects: [],
	//				ng_app_injects: ['ionic'],
					ng_controller: 'WEBAPPS_CONTROLLER',
					FORCE_WEB: true,
/*
					PHONE_INFO: {
						APP_NAME: '<?php echo $_REQUEST["APP_NAME"]; ?>',
						PHONE_ID: 'NOT_GRANTED',
						PHONE_NO: 'NOT_GRANTED'
					},
//*/
					QIIP_APP_INIT_FUNC:function(){
						QIIP_API_ACCESS({
								REQ: 'api_GET_WP_ROOT',
							},function(STR_RESULT) {
								var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
								if (JSON_RESULT instanceof Object) {
									_WP_ROOT = JSON_RESULT._WP_ROOT;
									_FLDR_TEMPLATE_BASE = sprintf('%s/WEBAPPS', _WP_ROOT);
								}
//								_FLDR_TEMPLATE = sprintf('%s/WEBAPPS/APPS/%s', _WP_ROOT, _RS.PHONE_INFO.APP_NAME);
								_FLDR_TEMPLATE = sprintf('%s/WEBAPPS/APPS', _WP_ROOT);
								YT_VIDEO_DISP();						
							}
						);						
					}
				});
			});

//			$(document).ready(function() {
//			});
			var ARR_YT_URL_CODE = [];
			var TIME, CAMERA, HASH, DATE, TEAM_NAME;
			
			
			function SEARCH_AND_PLAY_VIEW(YT_START_PLAY){
				HASH = '<?php echo $_REQUEST["hash"]; ?>';
				TIME = '<?php echo $_REQUEST["time"]; ?>';
				CAMERA = '<?php echo $_REQUEST["camera"]; ?>';

				var STR_SQL  = "SELECT * FROM MATCH_LIST WHERE ID > 0 ";
				STR_SQL += sprintf("AND HASH like '%s' ", '%' + HASH + '%');
				STR_SQL += sprintf("ORDER BY ID DESC ");
				STR_SQL += sprintf("LIMIT %d ", 50);
				QIIP_API_ACCESS({
						REQ: 'api_DB_ACCESS',
						STR_SQL_BASE64: Base64.encode(STR_SQL),
					},function(STR_RESULT) {
						_RS.YT_INFO = JSON_PARSE_IF_CAN(STR_RESULT);
						_RS.$apply();
/*
						var KEYS = Object.keys(_RS.YT_INFO[0].YOUTUBE_URLS);
						KEYS.forEach(function (ONE_KEY) {
							ARR_YT_URL_CODE.push(_RS.YT_INFO[0].YOUTUBE_URLS[ONE_KEY]);
						});
//*/
//						YT_START_PLAY(ARR_YT_URL_CODE[0]);
						YT_START_PLAY();
					}
				);
			}


			
			function YT_VIDEO_DISP(){
				SEARCH_AND_PLAY_VIEW(function(){
//					console.log(_RS.YT_INFO);
					var KEYS = Object.keys(_RS.YT_INFO[0].YOUTUBE_URLS);
					KEYS.forEach(function (ONE_KEY) {
						ARR_YT_URL_CODE.push(_RS.YT_INFO[0].YOUTUBE_URLS[ONE_KEY]);
					});
					DATE = _RS.YT_INFO[0].DATE;
					TEAM_NAME = _RS.YT_INFO[0].TEAM;
					var CAM_POS;
					if(KEYS.includes(CAMERA)){
						CAM_POS = _RS.YT_INFO[0].YOUTUBE_URLS[CAMERA];
					} else {
						CAM_POS = ARR_YT_URL_CODE[0];
					}
					if(onYouTubeIframeAPIReady_flag){
					    player = new YT.Player('DIV_YT_VIDEO', {
					        events: {
					            onReady: function() {
					                player.playVideo()
					                player.seekTo(TIME)
									VIDEO_Duration = player.getDuration();
					            }
					        },
							width: '100%',
					        height: '100%',
							videoId: CAM_POS
					    });
					} else {
						setTimeout(function(){
							YT_VIDEO_DISP();
						}, 100);
					}	
					GET_TAG_FILE();
				});
			}

			var ARR_TAG_LIST;
			function GET_TAG_FILE(){
				var _FILE = sprintf("FS/tags/%s/%s.json",DATE, TEAM_NAME);
				QIIP_API_ACCESS({
						REQ: 'api_GET_FILE',
						FLDR: _FLDR_TEMPLATE,
						FILE: _FILE,
					},function(STR_RESULT) {
						_RS.TAG_FILE = JSON_PARSE_IF_CAN(STR_RESULT);
						_RS.$apply();
						
//						console.log(_RS.TAG_FILE);
//						var KEYS = Object.keys(_RS.TAG_FILE);
					}
				);
			}


			function ONCLICK_TIME_LINE(DOM){
				var TAG_MIN = parseInt($(DOM).attr('TAG_MIN'));
				var TAG_SEC = parseInt($(DOM).attr('TAG_SEC'));
				
				var TIME_TO_MOVE = TAG_MIN*60 + TAG_SEC;
				console.log(TIME_TO_MOVE);
				player.seekTo(TIME_TO_MOVE)
			}

			
			function ONCLICK_ANGLE_BTN(DOM){
				var YT_CODE = $(DOM).attr('YT_CODE');
				CAMERA = $(DOM).attr('CUR_CAM');
				player.loadVideoById(YT_CODE);
			}
			
			function PRINT_SEC_TO_HMS(VIDEO_TIME){
				var M = parseInt(VIDEO_TIME / 60);
				if(M > 0){
					VIDEO_TIME -= M * 60;
				}
				var S = VIDEO_TIME;
				alert(M + "분" + S + "초 시점으로 복사 되었습니다.");
			}
			
			function COPY_TO_CLIPBOARD(){
				var VIDEO_TIME = parseInt(player.playerInfo.currentTime);
				var STR_URL = 'http://futsal.tecs.club/WEBAPPS/APPS/FS/YT_VIEW.php';
				STR_URL += '?time=' + VIDEO_TIME;
				STR_URL += '&hash=' + HASH;
				STR_URL += '&camera=' + CAMERA;
				
				$('input[id=CLIP_DATA]').attr('value',STR_URL);
			    $('#CLIP_DATA').attr('type', 'text');
			    
			    $('#CLIP_DATA').select();
			    
			    var copy = document.execCommand('copy');
			    
			    $('#CLIP_DATA').attr('type', 'hidden');
			    
			    if(copy) {
			    	PRINT_SEC_TO_HMS(VIDEO_TIME);
			    }
			}
			
			function TAB_ACTIVE(DOM_OBJ){
				var Children = $(DOM_OBJ).parent().children();
				var PAGE_Children = $(DOM_OBJ).parent().parent().parent().children();
				console.log(PAGE_Children);
				var KEYS = Object.keys(Children);
				KEYS.forEach(function (ONE_KEY) {
					if(Children[ONE_KEY] == DOM_OBJ){
						$(Children[ONE_KEY]).addClass('active');
					} else {
						$(Children[ONE_KEY]).removeClass('active');
					}
				});
				
			}
			
		</script>
		<link rel="stylesheet" href="/WEBAPPS/APPS/FS/MY_assets/YT_VIEW.css" />
		<link rel="stylesheet" href="/WEBAPPS/APPS/FS/MY_assets/customComments.css" />

	</head>
	<body ng-app="ANGULAR_WEBAPPS" ng-controller="WEBAPPS_CONTROLLER" id="APP_CONTENTS"> 


		<div class="body">
		   <div class="main">
		      <div class="logoBar"><img src="/WEBAPPS/APPS/FS/MY_assets/img/logo_vertical blank.f136904b.png" height="100%" alt="refutsalLogo" class="logoImgPor"></div>
		      <div class="shareButtons">
	         
				<div style="align-self: center; display: flex;">
					<button ng-repeat="(KEY, VALUE) in YT_INFO[0].YOUTUBE_URLS" class="cameraButton"
						YT_CODE="{{VALUE}}" CUR_CAM="{{KEY}}" onclick="ONCLICK_ANGLE_BTN(this);">
						{{KEY}}
					</button>
				</div>		         
		         
		         <div class="logoLandWrap">
		         	<img src="/WEBAPPS/APPS/FS/MY_assets/img/logo_vertical blank.f136904b.png" height="100%" alt="refutsalLogo" class="logoImgLand">
		         </div>
		         <div style="display: flex; flex-direction: row;">
		            <button class="fastForwardingController">▼</button>
		            <div class="fastForwardingDropdown" style="flex-direction: column;">
		            	<button class="unactivatedFastForwardingButton">⏩ x2</button>
		            </div>
		            <input type="hidden" id="CLIP_DATA" value=""/> 
		        
		            <button class="shareButton" onclick="COPY_TO_CLIPBOARD();">현재 시점 링크 공유</button>
		         </div>
		      </div>
		      <div class="playerContainer">
		      	  <div style="width:100%;" id="DIV_YT_VIDEO">
		      	  	
		      	  </div>
		      </div>
		   </div>
		   <div class="sideBar">
		      <div class="sideBarTop">
		         <div class="gameTitle">DATE : {{YT_INFO[0].DATE}}   TIME : {{YT_INFO[0].GAME_START_TIME}}   {{YT_INFO[0].ARENA_NAME}} 경기</div>
		      </div>
  			  <div class="wrap">
			     <div class="menuBar">
				     <ul class="tabs">
				         <li class="active" onclick="TAB_ACTIVE(this)">태그</li>
				         <li class="" onclick="TAB_ACTIVE(this)">댓글</li>
				     </ul>
			     </div>

				<div class="contentArea">
					<div class="tags" style="display: block;">			   
				      <div><a href="https://forms.gle/mFC1bsnUncjDsLh29" target="_blank" rel="noopener noreferrer" class="banner1">서비스 후기를 남겨주세요!😍🎁</a><a href="https://forms.gle/BBM7vkBYXyDZNyi19" target="_blank" rel="noopener noreferrer" class="banner2">문의 사항이 있으신가요?🚩</a></div>

 					  <div ng-repeat="(KEY, VALUE) in TAG_FILE">
						  <button ng-if="$index=$odd" class="oneTag" style="background-color: rgb(238, 238, 238);" 
						  	TAG_MIN="{{VALUE.min}}" TAG_SEC="{{VALUE.sec}}" onclick="ONCLICK_TIME_LINE(this);">
				            <div class="tagTitle" style="justify-content: center;">
				               <div class="tagContents">
								  {{VALUE.tag}}
				               </div>
				            </div>
				            <div class="tagTime" style="justify-content: center; color: rgb(170, 170, 170);">{{VALUE.min}}:{{VALUE.sec}}</div>
				            <div class="likeImage">
				               <img src="data:image/png;base64,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" class="likeButton" alt="tagLikeButton">
				               <div class="numLikeBlack">0</div>
				            </div>
						  </button>


						  <button ng-if="$index=$even" class="oneTag" style="background-color: rgb(255, 255, 255);" 
						  	TAG_MIN="{{VALUE.min}}" TAG_SEC="{{VALUE.sec}}" onclick="ONCLICK_TIME_LINE(this);">
				            <div class="tagTitle" style="justify-content: center;">
				               <div class="tagContents">
								  {{VALUE.tag}}
				               </div>
				            </div>
				            <div class="tagTime" style="justify-content: center; color: rgb(170, 170, 170);">{{VALUE.min}}:{{VALUE.sec}}</div>
				            <div class="likeImage">
				               <img src="data:image/png;base64,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" class="likeButton" alt="tagLikeButton">
				               <div class="numLikeBlack">0</div>
				            </div>
						  </button>
					  </div>		



<!--
				      <div>
				         <button class="oneTag" style="background-color: rgb(238, 238, 238);">
				            <div class="tagTitle" style="justify-content: center;">
				               <div class="tagContents">
				                  수차례 골든골 실패 후 결국 홈팀의 마지막 득점!&nbsp;⚽
				               </div>
				            </div>
				            <div class="tagTime" style="color: rgb(170, 170, 170);">126 : 03</div>
				            <div class="likeImage">
				               <img src="data:image/png;base64,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" class="likeButton" alt="tagLikeButton">
				               <div class="numLikeBlack">0</div>
				            </div>
				         </button>
				      </div>
-->


				      <div>
				         <button class="oneTag" style="background-color: white;">
				            <div class="tagTitle" style="justify-content: center;">
				               <div class="tagContents">
				                  ****** 경기 종료 ******
				               </div>
				            </div>
				            <div class="tagTime" style="color: rgb(170, 170, 170);">126 : 05</div>
				            <div class="likeImage">
				               <img src="data:image/png;base64,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" class="likeButton" alt="tagLikeButton">
				               <div class="numLikeBlack">0</div>
				            </div>
				         </button>
				      </div>
				      <button class="oneTag">
				         <div class="tagTitle" style="justify-content: center;">
				            <div class="addTagbutton"> ⨁&nbsp;&nbsp; 태그 추가하기</div>
				         </div>
				      </button>
					</div>
				   
				   <div class="commentSection" style="display: none;">
				      <div class="_12xdX">
				         <div class="_2STY7">
				            <form>
				               <div class="form">
				                  <div class="row">
				                     <img src="/WEBAPPS/APPS/FS/MY_assets/img/user.10a2200b.png" class="profile-img" alt="no_image">
				                     <div class="row">
				                        <div class="arrow-left"></div>
				                        <div class="input-div">
				                           <div><textarea rows="1" class="name-box" type="text" placeholder="이름을 입력해주세요." component="input" style="resize: none; overflow: hidden;"></textarea></div>
				                           <textarea rows="3" class="input-box" type="text" placeholder="내용을 입력해주세요." component="input" style="resize: none;"></textarea>
				                        </div>
				                     </div>
				                  </div>
				                  <div class="btn-div"><button class="post-btn" type="submit" disabled="">댓글달기</button><button class="cancel-btn">취소</button></div>
				               </div>
				            </form>
				         </div>
				         <div class="_1SugS">
				            <div></div>
				         </div>
				      </div>
				   </div>				   
				</div>




  		      </div>
		   </div>
		</div>


	</body>

	
</html>
