<?php if(!defined("__XE__"))exit;?><script>
function INIT_WIDGETS_FOR_DIV_RIGHTCON2() {
	if (!USER_DATA.allcaps.level_1) {
		$('.BTN_CLASS_MODIFY_MEMO').css('display','none');
	}
	$(".BTN_CLASS_MODIFY_MEMO").on('click', function(){
		var T_ID = $(this).attr('T_ID');
		var CURR_MEMO = $(this).attr('CURR_MEMO');
	/*	alert(T_ID + " : " +  CURR_MEMO); */
		var TEMP_DATA = {
			T_ID: T_ID,
			CURR_MEMO: CURR_MEMO
		};
	
		QIIP_API_ACCESS({
				REQ: 'api_GET_PAGE',
				FLDR_TEMPLATE: _FLDR_TEMPLATE,
				FILE_TEMPLATE: 'PAGES/POPUP_FOR_MEMO_MODIFY.html',
			},function(STR_RESULT) {
				var HTML_COMPILED = QIIP_STATIC_HTML(TEMP_DATA, STR_RESULT);
				var OBJ_POPUP_FOR_ALERT = QIIP_JQX_POPUP_WINDOW({
		            showCollapseButton: true, 
		            height: '18%',
		            width: '18%',
		            minHeight: 100,
		            minWidth: 100,
					},
					'메모수정',
					HTML_COMPILED
				);
				_RS.$apply();
				SET_POPUP_FOR_MEMO_MODIFY(OBJ_POPUP_FOR_ALERT);
			  	INIT_WIDGETS_FOR_MEMO_MODIFY();
			}
		);
		
	});
	
	$("#BTN_MORE_MEMO").on('click', function(){
		LOAD_ALL_MEMO_DATA();
	});
	
}
function LOAD_ALL_MEMO_DATA() {
	var STR_SQL  = '';
		STR_SQL += 'SELECT T_ID, ACTION_DATE, MEMO  FROM T_MOTION_HISTORY ';
		STR_SQL += 'WHERE U_id="' + USER_DATA_FOR_CONTENT.data.ID + '" ';
		STR_SQL += 'ORDER BY ACTION_DATE DESC, ACTION_TIME DESC';
		
	QIIP_API_ACCESS({
			REQ: 'api_DB_ACCESS',
			STR_SQL_BASE64: Base64.encode(STR_SQL),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			USER_DATA_FOR_CONTENT.MOTION_DATA.MEMO_ALL = JSON_RESULT;
			POPUP_VIEW_MORE_MEMO();
//			TT(_RS.MEMO_ALL);
		}
	);
}
function POPUP_VIEW_MORE_MEMO() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'PAGES/MORE_MEMO.html',
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(USER_DATA_FOR_CONTENT, STR_RESULT);
			var OBJ_POPUP = QIIP_JQX_POPUP_WINDOW({
	            showCollapseButton: true, 
	            height: '40%',
	            width: '40%',
	            minHeight: 100,
	            minWidth: 100,
				},
				'메모 리스트',
				HTML_COMPILED
			);
			_RS.$apply();
			
			INIT_WIDGETS_FOR_MORE_MEMO(OBJ_POPUP);
		}
	);
	
}
</script>
<div class="memo">
	<h2>Memo
	    <button type="button" class="btn more_btn" id="BTN_MORE_MEMO">
	        MORE
		</button>
	</h2>
	<div class="col-sm-12">
	    <div class="ibox float-e-margins">
	        <div class="ibox-content">
	    
	            <table class="table table-striped">
	                <colgroup>
	                    <col width="30%">
	                    <col width="70%">
	                  
	                </colgroup>
	                <thead>
	                
	                </thead>
	                <tbody>
	                    <tr ng-repeat="ONE_MEMO in JSON_ARGS.MOTION_DATA.MEMO_LAST_3">
	                        <td>{{ONE_MEMO.ACTION_DATE}}</td>
	                        <td>{{ONE_MEMO.MEMO}}
                        		<button class="BTN_CLASS_MODIFY_MEMO" T_ID="{{ONE_MEMO.T_ID}}" CURR_MEMO="{{ONE_MEMO.MEMO}}">수정</button>
	                        </td>
	                    </tr>
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
</div>
<div class="video_clip">
	<h2>Video Clip
	    <button type="button" class="btn more_btn">
	        MORE
	    </button>
	</h2>
	<div class="row container">
	    <div class="col-sm-6 col-md-4">
	        <a href="#" class="video_click" ondblclick="location.href='#';" target='_blank' style="text-decoration:none;">
	            <div class="thumbnail">
	                <img src="/WEBAPPS/APPS/NOOL/assets/img/thum_off.png">
	                <img src="/WEBAPPS/APPS/NOOL/assets/img/thum.jpg">
	                <div class="caption">
	                	<h4>2018.02.01</h4>
	              	</div>
	            </div>
	        </a>
	    </div>
	    <div class="col-sm-6 col-md-4">
	        <a href="#" class="video_click" ondblclick="location.href='#';" target='_blank' style="text-decoration:none;">
	            <div class="thumbnail">
	                <img src="/WEBAPPS/APPS/NOOL/assets/img/thum_off.png">
	                <img src="/WEBAPPS/APPS/NOOL/assets/img/thum.jpg">
	                <div class="caption">
	                	<h4>2018.01.30</h4>	                
	             	</div>
	            </div>
	        </a>
	    </div>
	    <div class="col-sm-6 col-md-4">
	        <a href="#" class="video_click" ondblclick="location.href='#';" target='_blank' style="text-decoration:none;">
	            <div class="thumbnail">
                <img src="/WEBAPPS/APPS/NOOL/assets/img/thum_off.png">
                <img src="/WEBAPPS/APPS/NOOL/assets/img/thum.jpg">
	              <div class="caption">
	                <h4>2018.01.20</h4>
	              </div>
	            </div>
	        </a>
	    </div>
	</div>
</div>