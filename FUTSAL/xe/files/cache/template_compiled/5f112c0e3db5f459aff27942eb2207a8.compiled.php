<?php if(!defined("__XE__"))exit;?><script>
	var POPUP_FOR_ALL_MEMO_MODIFY = null;
	function SET_POPUP_FOR_ALL_MEMO_MODIFY(args_POPUP){
		POPUP_FOR_ALL_MEMO_MODIFY = args_POPUP;
	}
	var POPUP_FOR_ALL_MEMO_MODIFY_PARENT = null;
	function SET_POPUP_FOR_ALL_MEMO_MODIFY_PARENT(args_POPUP){
		POPUP_FOR_ALL_MEMO_MODIFY_PARENT = args_POPUP;
	}
	
	function INIT_WIDGETS_FOR_ALL_MEMO_MODIFY(){
		
		//메모 수정 취소 버튼
		$('#BTN_ALL_MEMO_MODIFY_CANCLE').on('click', function () {
		if (POPUP_FOR_ALL_MEMO_MODIFY != null) {
			QIIP_JQX_CLOSE_WINDOW(POPUP_FOR_ALL_MEMO_MODIFY);
			}
		});
		//메모 수정 저장 버튼
		$('#BTN_ALL_MEMO_MODIFY_SAVE').on('click', function () {
		
			var STR_ERR_MESSAGE = '';
			var FLAG_ERROR = false;
			
			if ($('#ALL_MEMO_MODIFY_TEXT').val().length < 1) {
				STR_ERR_MESSAGE = '메모를 작성해주세요.';
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
				
			} else {
				UPDATE_ALL_MEMO_DATA(
					$('#ALL_T_ID').val(),
					$('#ALL_MEMO_MODIFY_TEXT').val()
				);
			}
			
		});
	}	
function UPDATE_ALL_MEMO_DATA(args_T_ID, args_MEMO) {
	
	var STR_SQL  = '';
		STR_SQL += 'UPDATE T_MOTION_HISTORY ';
		STR_SQL += 'SET MEMO="' + args_MEMO + '" ';
		STR_SQL += 'WHERE T_ID="' + args_T_ID + '"';
		
	QIIP_API_ACCESS({
			REQ: 'api_DB_ACCESS',
			STR_SQL_BASE64: Base64.encode(STR_SQL),
		},function(STR_RESULT) {
			QIIP_POPUP_FOR_ALERT(
				"안내",
				[
					'저장되었습니다.'
				],
				function(){
					if (POPUP_FOR_ALL_MEMO_MODIFY != null) {
						QIIP_JQX_CLOSE_WINDOW(POPUP_FOR_ALL_MEMO_MODIFY);
						
						LOAD_ALL_MEMO_DATA_AFTER_MODIFY();
						
					}
				}
				,
				20,
				16.5
				);
		}
	);
}
function LOAD_ALL_MEMO_DATA_AFTER_MODIFY() {
	var STR_SQL  = '';
		STR_SQL += 'SELECT T_ID, ACTION_DATE, MEMO  FROM T_MOTION_HISTORY ';
		STR_SQL += 'WHERE U_id="' +  USER_DATA_FOR_CONTENT.ID + '" ';
		STR_SQL += 'ORDER BY ACTION_DATE DESC, ACTION_TIME DESC';
	
	QIIP_API_ACCESS({
			REQ: 'api_DB_ACCESS',
			STR_SQL_BASE64: Base64.encode(STR_SQL),
		},function(STR_RESULT) {
		
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			
			USER_DATA_FOR_CONTENT.MOTION_DATA.MEMO_ALL = JSON_RESULT;
			CHANGE_POPUP_CONTENT_FOR_MORE_MEMO(POPUP_FOR_ALL_MEMO_MODIFY_PARENT);
			
			LOAD_3_MEMO_DATA();
		}
	);
}
</script>
<div id="DIV_MEMO_MODIFY">
	<input type="hidden" id="ALL_T_ID" value="{{JSON_ARGS.T_ID}}" />
	<textarea id="ALL_MEMO_MODIFY_TEXT" style="width: 100%;height: 60%;resize: none;">{{JSON_ARGS.CURR_MEMO}}</textarea>
	<div class="memo_modify_footer" style="height: 28%;">
	    <button type="button" class="btn btn-default BTN_POPUP" id="BTN_ALL_MEMO_MODIFY_CANCLE" >취소</button>
	    <button type="button" class="btn btn-default BTN_POPUP" id="BTN_ALL_MEMO_MODIFY_SAVE">수정</button>
	  </div>
</div>