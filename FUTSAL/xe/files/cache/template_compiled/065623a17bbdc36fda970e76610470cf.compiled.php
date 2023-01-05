<?php if(!defined("__XE__"))exit;?><script>
var POPUP_FOR_MORE_MEMO = null;
function INIT_WIDGETS_FOR_MORE_MEMO(args_POPUP) {
	POPUP_FOR_MORE_MEMO = args_POPUP;
	
	$(".BTN_CLASS_MODIFY_ALL_MEMO").on('click', function(){
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
				FILE_TEMPLATE: 'PAGES/POPUP_FOR_ALL_MEMO_MODIFY.html',
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
				SET_POPUP_FOR_ALL_MEMO_MODIFY_PARENT(POPUP_FOR_MORE_MEMO);
				SET_POPUP_FOR_ALL_MEMO_MODIFY(OBJ_POPUP_FOR_ALERT);
			  	INIT_WIDGETS_FOR_ALL_MEMO_MODIFY();
			}
		);
		
	});
	
}
function CHANGE_POPUP_CONTENT_FOR_MORE_MEMO(args_POPUP) {
	QIIP_API_ACCESS({
			REQ: 'api_GET_PAGE',
			FLDR_TEMPLATE: _FLDR_TEMPLATE,
			FILE_TEMPLATE: 'PAGES/MORE_MEMO.html',
		},function(STR_RESULT) {
			var HTML_COMPILED = QIIP_STATIC_HTML(USER_DATA_FOR_CONTENT, STR_RESULT);
			
			
//			alert('BEFORE CHANGE');
//			alert(POPUP_FOR_MORE_MEMO);
			QIIP_JQX_CHANGE_CONTENTS(args_POPUP, HTML_COMPILED);
//			alert('AFTER CHANGE');
			
			INIT_WIDGETS_FOR_MORE_MEMO(args_POPUP);
		}
	);
	
}
	
</script>
<div class="col-sm-12" style=" padding: 5%;padding-top: 2%; padding-bottom: 2%;">
    <div class="ibox float-e-margins">
        <div class="ibox-content">
    
            <table class="table table-striped table-hover">
                <colgroup>
                    <col width="30%">
                    <col width="70%">
                  
                </colgroup>
				<thead>
				</thead>
				<tbody>
                    <tr ng-repeat="ONE_MEMO in JSON_ARGS.MOTION_DATA.MEMO_ALL">
                        <td style="font-size: 14px; text-align: center; color: #555;">20{{ONE_MEMO.ACTION_DATE}}</td>
                        <td>
                        	<a data-toggle="popover" data-content="{{ONE_MEMO.MEMO}}" data-placement="bottom" data-original-title="" title="" class=""  style="font-size: 14px; color: #555;">
	                        {{ONE_MEMO.MEMO}}
	                        </a>
	                        <button class="BTN_CLASS_MODIFY_ALL_MEMO" T_ID="{{ONE_MEMO.T_ID}}" CURR_MEMO="{{ONE_MEMO.MEMO}}">수정</button>
                        	<button type="button" class="delete_btn" data-toggle="modal" data-target="#delete_modal" style="float:right;"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                
                </tbody>
        	</table>
        </div>
    </div>
</div>