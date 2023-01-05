<?php if(!defined("__XE__"))exit;
$__Context->ARGS = json_decode(base64_decode($__Context->ARGS->JSON_ARGS_BASE64));  ?>
#PAGE_ARGS# <!-- <script>var JSON_ARGS=JSON.parse(Base64.decode($ARGS->JSON_ARGS_BASE64));</script> -->
<script>
var OBJ_POPUP_FOR_ALERT = null;
var OBJ_POPUP_FUNC_OK = undefined;
function INIT_WIDGETS_POPUP_FOR_ALERT(OBJ_DIALOG, FUNC_OK, TIME_TO_CLOSE) {
	OBJ_POPUP_FOR_ALERT = OBJ_DIALOG;
	OBJ_POPUP_FUNC_OK = FUNC_OK;
	if (!JSON_ARGS.FLAG_NO_BUTTON) {
		$(".BTN_POPUP_FOR_ALERT").jqxButton({
			width: '100%',
			height: '100%'
		});
	}
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
<?php if(!$__Context->ARGS->FLAG_NO_BUTTON){ ?>
<div class="qiip_popup" style="width:100%;height:90%;background-color:#c9c9c9;overflow:auto;">
	<table>
		<?php if($__Context->ARGS->ARRAY_FOR_MESSAGE&&count($__Context->ARGS->ARRAY_FOR_MESSAGE))foreach($__Context->ARGS->ARRAY_FOR_MESSAGE as $__Context->KEY=>$__Context->ONE_STRING){ ?><tr >
			<th><?php echo $__Context->ONE_STRING ?></th>
		</tr><?php } ?>
	</table>
</div>
<div class="qiip_popup" style="width:100%;height:10%;padding:0;">
	<table>
		<tr>
			<td>
		      	<button class="BTN_POPUP_FOR_ALERT" onclick="CLOSE_POPUP_FOR_ALERT()">
		        	확인
		    	</button>
			</td>
		</tr>
	</table>
</div>
<?php }else{ ?>
<div class="qiip_popup" style="width:100%;height:100%;background-color:#c9c9c9;overflow:auto;">
	<table>
		<?php if($__Context->ARGS->ARRAY_FOR_MESSAGE&&count($__Context->ARGS->ARRAY_FOR_MESSAGE))foreach($__Context->ARGS->ARRAY_FOR_MESSAGE as $__Context->KEY=>$__Context->ONE_STRING){ ?><tr >
			<th><?php echo $__Context->ONE_STRING ?></th>
		</tr><?php } ?>
	</table>
</div>
<?php } ?>
