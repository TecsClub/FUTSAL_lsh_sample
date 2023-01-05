<?php if(!defined("__XE__"))exit;?><script>
var OBJ_POPUP_FOR_ALERT = null;
var OBJ_POPUP_FUNC_OK = undefined;
function INIT_WIDGETS_POPUP_FOR_ALERT(OBJ_DIALOG, FUNC_OK, TIME_TO_CLOSE) {
	OBJ_POPUP_FOR_ALERT = OBJ_DIALOG;
	OBJ_POPUP_FUNC_OK = FUNC_OK;
/*
	if (!JSON_ARGS.FLAG_NO_BUTTON) {
		$(".BTN_POPUP_FOR_ALERT").jqxButton({
			width: '100%',
			height: '100%'
		});
	}
*/
	if (TIME_TO_CLOSE != undefined) {
		setTimeout(CLOSE_POPUP_FOR_ALERT, TIME_TO_CLOSE);
	}
}
function CLOSE_POPUP_FOR_ALERT() {
	if (OBJ_POPUP_FOR_ALERT != null) {
		QIIP_JQX_CLOSE_WINDOW(OBJ_POPUP_FOR_ALERT);
		if (OBJ_POPUP_FUNC_OK != undefined) OBJ_POPUP_FUNC_OK();
	}
}
</script>
<div class="pop_i">
		<img src="/WEBAPPS/APPS/NOOL/assets/img/flat_q.png">
</div>
<div ng-show="!JSON_ARGS.FLAG_NO_BUTTON" class="qiip_popup pop_inner" style="width:100%;overflow:auto;">
   	<span ng-repeat="ONE_MESSAGE in JSON_ARGS.ARRAY_FOR_MESSAGE" >
		{{ONE_MESSAGE}}
	</span>
</div>
<div ng-show="!JSON_ARGS.FLAG_NO_BUTTON" class="qiip_popup pop_button" style="width:100%;padding:0;">
  	<button class="BTN_POPUP_FOR_ALERT" onclick="CLOSE_POPUP_FOR_ALERT()">
    	확인
	</button>
</div>
<div ng-show="JSON_ARGS.FLAG_NO_BUTTON" class="qiip_popup pop_inner" style="width:100%;height:100%;overflow:auto;">
   	<p ng-repeat="ONE_MESSAGE in JSON_ARGS.ARRAY_FOR_MESSAGE" >
		{{ONE_MESSAGE}}
	</p>
</div>
