<?php if(!defined("__XE__"))exit;?><style>
	.ars_config 			{width:100%; height:100%; box-sizing:border-box;}
	.ars_config_BAK table	{width:100%; height:100%; font-size:100%; border-collapse: separate; border-spacing: 1px; line-height: 100%;}
	.ars_config table		{width:100%; border-collapse: separate; border-spacing: 1px; line-height: 100%;}
	.ars_config table th	{font-weight:bold; text-align: center; white-space:normal; vertical-align: middle; word-break:break-all; word-wrap:break-all; background:#bbb; }
	.ars_config table td	{text-decoration:none; text-align: left;   white-space:normal; vertical-align: middle; word-break:break-all; word-wrap:break-all; background:#eee;}
</style>
<script>
function GET_ARS_CONFIG_INFORMATION(FUNC_AFTER) {
	QIIP_API_ACCESS({
			REQ: 'post_GET_ROOT_INFO',
			PHONE_NO: _RS.PHONE_INFO.APP_NAME,
			PHONE_ID: _RS.PHONE_INFO.APP_NAME,
			CATEGORY: _RS.PHONE_INFO.APP_NAME,
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if (JSON_RESULT instanceof Object) {
				_RS.ARS_CONFIG = JSON_RESULT;
			} else {
				if ('INITIAL_POST_INFORMATION' in _RS.APP_CONFIG) {
					_RS.ARS_CONFIG = _RS.APP_CONFIG.INITIAL_POST_INFORMATION;
					_RS.ARS_CONFIG.PHONE_NO = _RS.PHONE_INFO.APP_NAME;
					_RS.ARS_CONFIG.PHONE_ID = _RS.PHONE_INFO.APP_NAME;
					PUT_ARS_CONFIG_INFORMATION();
				} else {
					_RS.ARS_CONFIG = {};
				}
			}
			if (FUNC_AFTER != undefined) FUNC_AFTER();
		}
	);
}
function PUT_ARS_CONFIG_INFORMATION(FUNC_AFTER) {
	QIIP_API_ACCESS({
			REQ: 'post_PUT_ROOT_INFO',
			PHONE_NO: _RS.PHONE_INFO.APP_NAME,
			PHONE_ID: _RS.PHONE_INFO.APP_NAME,
			CATEGORY: _RS.PHONE_INFO.APP_NAME,
			JSON_UPDATE: _RS.ARS_CONFIG,
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if (FUNC_AFTER != undefined) FUNC_AFTER();
		}
	);
}
function DD() {
	QIIP_API_ACCESS({
			REQ: 'api_GET_WORK_CONDITION',
			JSON_CONFIG: _RS.ARS_CONFIG.WORK_INFORMATION
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			var STR_LOG = '';
			if (JSON_RESULT instanceof Object) {
				STR_LOG = sprintf('<pre>%s</pre>', JSON.stringify(JSON_RESULT, null, '\t'));
			} else {
				STR_LOG = sprintf('<pre>%s</pre>', STR_RESULT);
			}
			QIIP_APP_ALERT([
				STR_LOG
			]);
			
/*
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		'DIV_LOG',
	    		STR_LOG,
	    		'me',
	    		'70%'
	    	);
*/
		}
	);
}
	
function INIT_WIDGETS_FOR_MENU_CONTENTS() {
	$('#TABS_ARS_CONFIG').jqxTabs({
		width: '100%',
		height: '90%',
		position: 'top'
	});
	$('.BTN_ARS_CONFIG').on('click', function () {
		var ID = $(this).attr('ID');
		if (ID == 'DUMMY') {
		} else if (ID == 'BTN_SAVE_CUSTOM_WORKS') {
			SAVE_CUSTOM_WORK_INFORMATION();
		} else if (ID == 'BTN_ADD_GROUP') {
			EXEC_ADD_GROUP();
		} else if (ID == 'BTN_DEL_GROUP') {
			EXEC_DEL_GROUP();
		} else if (ID == 'BTN_ADD_NUMBER') {
			EXEC_ADD_NUMBER();
		} else if (ID == 'BTN_DEL_NUMBER') {
			EXEC_DEL_NUMBER();
		} else if (ID == 'BTN_ADD_BANK') {
			EXEC_ADD_BANK();
		} else if (ID == 'BTN_DEL_BANK') {
			EXEC_DEL_BANK();
		} else if (ID == 'BTN_ADD_CARD') {
			EXEC_ADD_CARD();
		} else if (ID == 'BTN_DEL_CARD') {
			EXEC_DEL_CARD();
		}
	});
	TOGGLE_SIDEMENU(function () {
		GET_ARS_CONFIG_INFORMATION(function () {
			var STR_LOG = sprintf('<pre>%s</pre>', JSON.stringify(_RS.ARS_CONFIG, null, '\t'));
	    	QIIP_APP_LOG_CONSOLE.CHAT_LOG(
	    		'DIV_LOG',
	    		STR_LOG,
	    		'me',
	    		'70%'
	    	);
	    	_RS.$apply();
	    	
	    	SET_DOM_EVENT();
	    	
//	   		DD();
		});
	});
}
function SET_DOM_EVENT() {
	$('.ITS_WORK_DAY').on('click', function () {
		var ID = $(this).attr('ID');
		if (ID == 'DUMMY') {
		} else if (ID == 'ITS_WORK_DAY_ADD') {
			var STR_TEXT = $(this).is(':checked') ? '??????' : '????????????';
			$('.LABEL_ITS_WORK_DAY_ADD').html(STR_TEXT);
		} else if (ID == 'ITS_WORK_DAY') {
			var STR_TEXT = $(this).is(':checked') ? '??????' : '????????????';
			var STR_INDEX = $(this).attr('INDEX');
			$('.LABEL_ITS_WORK_DAY_'+STR_INDEX).each(function () {
				$(this).html(STR_TEXT);
			});
		}
	});
	
	$('.CUSTOM_WORK_DATE').jqxDateTimeInput({
		formatString: 'yyyy-MM-dd'
	});
	SET_LIST_STAFF_GROUPS();
	
	$('#LIST_BANKS').jqxListBox({
		width: '100%',
		height: '100%',
		source: _RS.ARS_CONFIG.LIST_BANKS,
		allowDrop: true,
		allowDrag: true,
		renderer: function (index, label, value) {
		    return '<center>' + value + '</center>';
		}
	}).on('dragEnd', function (event) {
		var BANKS_REMAIN = [];
		$(this).jqxListBox('getItems').forEach(function (ONE_ITEM) {
			BANKS_REMAIN.push(ONE_ITEM.value);
		});
		_RS.ARS_CONFIG.LIST_BANKS = BANKS_REMAIN;
	});
	$('#LIST_CARDS').jqxListBox({
		width: '100%',
		height: '100%',
		source: _RS.ARS_CONFIG.LIST_CARDS,
		allowDrop: true,
		allowDrag: true,
		renderer: function (index, label, value) {
		    return '<center>' + value + '</center>';
		}
	}).on('dragEnd', function (event) {
		var CARDS_REMAIN = [];
		$(this).jqxListBox('getItems').forEach(function (ONE_ITEM) {
			CARDS_REMAIN.push(ONE_ITEM.value);
		});
		_RS.ARS_CONFIG.LIST_CARDS = CARDS_REMAIN;
	});
}
function SET_LIST_STAFF_GROUPS() {
	$('#LIST_STAFF_GROUPS').jqxListBox({
		width: '100%',
		height: '100%',
		source: Object.keys(_RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS),
		allowDrop: true,
		allowDrag: true,
		renderer: function (index, label, value) {
			var STR_HTML  = "";
				STR_HTML += "<center>";
				STR_HTML += sprintf("%s - %s", value, _RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS[value].CALL_ASSIGN);
				STR_HTML += "</center>";
		    return STR_HTML;
		}
	}).on('select', function (event) {
		var args = event.args;
	    if (args) {
	        var index = args.index;
	        if (index >= 0) {
		        var item = args.item;
		        var originalEvent = args.originalEvent;
		        // get item's label and value.
		        var label = item.label;
		        var value = item.value;
		        var type = args.type; // keyboard, mouse or null depending on how the item was selected.
		        SET_LIST_STAFF_NUMBERS(value);
		        SET_SELECT_CALL_ASSIGN(_RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS[value].CALL_ASSIGN);
	        } else {
	        	SET_LIST_STAFF_NUMBERS('DUMMY');
	        }
	    }
	}).on('dragEnd', function (event) {
		var WORKER_GROUPS_REORDER = {};
		$(this).jqxListBox('getItems').forEach(function (ONE_ITEM) {
			console.log(ONE_ITEM);
			var ONE_KEY = ONE_ITEM.value;
			console.log(ONE_KEY);
			WORKER_GROUPS_REORDER[ONE_KEY] = _RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS[ONE_KEY];
		});
//		console.log(WORKER_GROUPS_REORDER);
		_RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS = WORKER_GROUPS_REORDER;
		SET_LIST_STAFF_GROUPS();
	});
	$('#LIST_STAFF_GROUPS').jqxListBox('selectIndex', 0);
}
var ARRAY_SELECT_CALL_ASSIGN = [
	"?????? ???????????? ????????????",
	"?????? ???????????? ????????????",
	"?????? ???????????? ????????????",
	"?????? ???????????? ????????????"
];
var FLAG_INIT_SELECT_CALL_ASSIGN = false;
function SET_SELECT_CALL_ASSIGN(SELECT_VALUE) {
//	console.log('SET_SELECT_CALL_ASSIGN  ' + SELECT_VALUE);
	var INDEX_SELECTED = -1;
	var INDEX_COUNT = 0;
	ARRAY_SELECT_CALL_ASSIGN.forEach(function (ONE_ITEM) {
		if (SELECT_VALUE == ONE_ITEM) {
			INDEX_SELECTED = INDEX_COUNT;
		}
		INDEX_COUNT += 1;
	});
	
	if (FLAG_INIT_SELECT_CALL_ASSIGN) {
		$("#SELECT_CALL_ASSIGN").jqxDropDownList('selectIndex', INDEX_SELECTED);
		return;
	}
	
	$("#SELECT_CALL_ASSIGN").jqxDropDownList({
		width: '100%',
//		height:'100%',
		source: ARRAY_SELECT_CALL_ASSIGN,
		selectedIndex: INDEX_SELECTED
	}).on('change', function (event) {
		var args = event.args;
	    if (args) {
	        var index = args.index;
	        if (index >= 0) {
		        var item = args.item;
		        var originalEvent = args.originalEvent;
		        // get item's label and value.
		        var label = item.label;
		        var value = item.value;
		        var type = args.type; // keyboard, mouse or null depending on how the item was selected.
				var OBJ_SEL_GROUP = $('#LIST_STAFF_GROUPS').jqxListBox('getSelectedItem');
				if (OBJ_SEL_GROUP != undefined) {
//console.log(OBJ_SEL_GROUP);
					var TXT_SEL_GROUP = OBJ_SEL_GROUP.value;
//console.log(TXT_SEL_GROUP);
					_RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS[TXT_SEL_GROUP].CALL_ASSIGN = value;
		        
			        $('#LIST_STAFF_GROUPS').jqxListBox('refresh');
				}
	        }
	    }		
	});
	FLAG_INIT_SELECT_CALL_ASSIGN = true;
}
function EXEC_ADD_GROUP() {
	var TXT_ADD_GROUP = $('#TXT_ADD_GROUP').val(); 
	if (TXT_ADD_GROUP.length <= 0) {
		QIIP_APP_ALERT([
			'????????? ???????????? ???????????????!'
		]);
		return;
	}
	var FLAG_EXIST = false;
	Object.keys(_RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS).forEach(function (ONE_GROUP) {
		if(ONE_GROUP == TXT_ADD_GROUP) {
			FLAG_EXIST = true;
		}
	});
	if (FLAG_EXIST) {
		QIIP_APP_ALERT([
			sprintf('%s ??? ?????? ???????????? ????????? ?????????.', TXT_ADD_GROUP)
		]);
		return;
	}
	$('#TXT_ADD_GROUP').val('');
//	_RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS[TXT_ADD_GROUP] = [];
	_RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS[TXT_ADD_GROUP] = {
		CALL_ASSIGN: "??????????????????",
		CALL_NUMBERS: []
	};
	SET_LIST_STAFF_GROUPS();
//	$('#LIST_STAFF_GROUPS').jqxListBox('addItem', TXT_ADD_GROUP);
//	$('#LIST_STAFF_GROUPS').jqxListBox('refresh');
//	$('#LIST_STAFF_GROUPS').jqxListBox('selectItem', TXT_ADD_GROUP);
}
function EXEC_DEL_GROUP() {
	if ($('#LIST_STAFF_GROUPS').jqxListBox('getSelectedIndex') >= 0) {
		var TXT_SEL_GROUP = $('#LIST_STAFF_GROUPS').jqxListBox('getSelectedItem').value;
		delete(_RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS[TXT_SEL_GROUP])
		$('#LIST_STAFF_GROUPS').jqxListBox('removeItem', TXT_SEL_GROUP);
		$('#LIST_STAFF_GROUPS').jqxListBox('selectIndex', -1);
		SET_LIST_STAFF_NUMBERS('DUMMY');
	}
}
function EXEC_ADD_NUMBER() {
	var TXT_ADD_NUMBER = $('#TXT_ADD_NUMBER').val();
	if (TXT_ADD_NUMBER.length <= 0) {
		QIIP_APP_ALERT([
			'????????? ??????????????? ???????????????!'
		]);
		return;
	}
	
	var TXT_SEL_GROUP = $('#LIST_STAFF_GROUPS').jqxListBox('getSelectedItem').value;
	var FLAG_EXIST = false;
	_RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS[TXT_SEL_GROUP].CALL_NUMBERS.forEach(function (ONE_NUMBER) {
		if(ONE_NUMBER == TXT_ADD_NUMBER) {
			FLAG_EXIST = true;
		}
	});
	if (FLAG_EXIST) {
		QIIP_APP_ALERT([
			sprintf('%s ??? ?????? ???????????? ???????????? ?????????.', TXT_ADD_NUMBER)
		]);
		return;
	}
	$('#TXT_ADD_NUMBER').val('');
	_RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS[TXT_SEL_GROUP].CALL_NUMBERS.push(TXT_ADD_NUMBER);
	$('#LIST_STAFF_NUMBERS').jqxListBox('addItem', TXT_ADD_NUMBER);
	$('#LIST_STAFF_NUMBERS').jqxListBox('selectItem', TXT_ADD_NUMBER);
}
function EXEC_DEL_NUMBER() {
	var SEL_INDEX = $('#LIST_STAFF_NUMBERS').jqxListBox('getSelectedIndex');
	if (SEL_INDEX >= 0) {
		$('#LIST_STAFF_NUMBERS').jqxListBox('removeAt', SEL_INDEX);
		var TXT_SEL_GROUP = $('#LIST_STAFF_GROUPS').jqxListBox('getSelectedItem').value;
		var NUMBERS_REMAIN = [];
		$('#LIST_STAFF_NUMBERS').jqxListBox('getItems').forEach(function (ONE_ITEM) {
			NUMBERS_REMAIN.push(ONE_ITEM.value);
		});
//		console.log(NUMBERS_REMAIN);
		_RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS[TXT_SEL_GROUP].CALL_NUMBERS = NUMBERS_REMAIN;
	}
}
function SET_LIST_STAFF_NUMBERS(STR_KEY) {
//	console.log('SET_LIST_STAFF_NUMBERS ' + STR_KEY);
	var	ARRAY_SOURCE = [];
	if (STR_KEY != 'DUMMY') {
		ARRAY_SOURCE = _RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS[STR_KEY].CALL_NUMBERS;
	}
	$('#LIST_STAFF_NUMBERS').jqxListBox({
		width: '100%',
		height: '100%',
		source: ARRAY_SOURCE,
		allowDrop: true,
		allowDrag: true,
		renderer: function (index, label, value) {
		    return '<center>' + value + '</center>';
		}
	}).on('select', function (event) {
		console.log($(this).jqxListBox('getSelectedItem').originalItem);
	}).on('dragEnd', function (event) {
		var NUMBERS_REMAIN = [];
		$(this).jqxListBox('getItems').forEach(function (ONE_ITEM) {
			NUMBERS_REMAIN.push(ONE_ITEM.value);
		});
		console.log(NUMBERS_REMAIN);
		var TXT_SEL_GROUP = $('#LIST_STAFF_GROUPS').jqxListBox('getSelectedItem').value;
		_RS.ARS_CONFIG.WORK_INFORMATION.WORKER_GROUPS[TXT_SEL_GROUP].CALL_NUMBERS = NUMBERS_REMAIN;
	});
}
function EXEC_ADD_BANK() {
	var TXT_ADD_BANK = $('#TXT_ADD_BANK').val(); 
	if (TXT_ADD_BANK.length <= 0) {
		QIIP_APP_ALERT([
			'????????? ???????????? ???????????????!'
		]);
		return;
	}
	if (!Array.isArray(_RS.ARS_CONFIG.LIST_BANKS)) {
		_RS.ARS_CONFIG.LIST_BANKS = [];
	}
	var FLAG_EXIST = false;
	_RS.ARS_CONFIG.LIST_BANKS.forEach(function (ONE_BANK) {
		if(ONE_BANK == TXT_ADD_BANK) {
			FLAG_EXIST = true;
		}
	});
	if (FLAG_EXIST) {
		QIIP_APP_ALERT([
			sprintf('%s ??? ?????? ???????????? ????????? ?????????.', TXT_ADD_BANK)
		]);
		return;
	}
	$('#TXT_ADD_BANK').val('');
	_RS.ARS_CONFIG.LIST_BANKS.push(TXT_ADD_BANK);
	$('#LIST_BANKS').jqxListBox('addItem', TXT_ADD_BANK);
	$('#LIST_BANKS').jqxListBox('selectItem', TXT_ADD_BANK);
}
function EXEC_DEL_BANK() {
	var SEL_INDEX = $('#LIST_BANKS').jqxListBox('getSelectedIndex');
	if (SEL_INDEX >= 0) {
		$('#LIST_BANKS').jqxListBox('removeAt', SEL_INDEX);
		var BANKS_REMAIN = [];
		$('#LIST_BANKS').jqxListBox('getItems').forEach(function (ONE_ITEM) {
			BANKS_REMAIN.push(ONE_ITEM.value);
		});
//		console.log(BANKS_REMAIN);
		_RS.ARS_CONFIG.LIST_BANKS = BANKS_REMAIN;
	}
}
function EXEC_ADD_CARD() {
	var TXT_ADD_CARD = $('#TXT_ADD_CARD').val(); 
	if (TXT_ADD_CARD.length <= 0) {
		QIIP_APP_ALERT([
			'????????? ??????????????? ???????????????!'
		]);
		return;
	}
	if (!Array.isArray(_RS.ARS_CONFIG.LIST_CARDS)) {
		_RS.ARS_CONFIG.LIST_CARDS = [];
	}
	var FLAG_EXIST = false;
	_RS.ARS_CONFIG.LIST_CARDS.forEach(function (ONE_CARD) {
		if(ONE_CARD == TXT_ADD_CARD) {
			FLAG_EXIST = true;
		}
	});
	if (FLAG_EXIST) {
		QIIP_APP_ALERT([
			sprintf('%s ??? ?????? ???????????? ???????????? ?????????.', TXT_ADD_CARD)
		]);
		return;
	}
	$('#TXT_ADD_CARD').val('');
	_RS.ARS_CONFIG.LIST_CARDS.push(TXT_ADD_CARD);
	$('#LIST_CARDS').jqxListBox('addItem', TXT_ADD_CARD);
	$('#LIST_CARDS').jqxListBox('selectItem', TXT_ADD_CARD);
}
function EXEC_DEL_CARD() {
	var SEL_INDEX = $('#LIST_CARDS').jqxListBox('getSelectedIndex');
	if (SEL_INDEX >= 0) {
		$('#LIST_CARDS').jqxListBox('removeAt', SEL_INDEX);
		var CARDS_REMAIN = [];
		$('#LIST_CARDS').jqxListBox('getItems').forEach(function (ONE_ITEM) {
			CARDS_REMAIN.push(ONE_ITEM.value);
		});
		_RS.ARS_CONFIG.LIST_CARDS = CARDS_REMAIN;
	}
}
function SAVE_CUSTOM_WORK_INFORMATION() {
	var CUSTOM_WORK_INFORMATION = [];
	$('.CUSTOM_WORKS').each(function () {
		var CUSTOM_WORK_CHECKBOX = $(this).find('.CUSTOM_WORK_CHECKBOX').is(':checked')
		if (CUSTOM_WORK_CHECKBOX) {
			var ONE_CUSTOM_WORK_INFORMATION = {
				DATE: $(this).find('.CUSTOM_WORK_DATE').jqxDateTimeInput('getText'),
				ITS_WORK_DAY: $(this).find('.ITS_WORK_DAY').is(':checked'),
				LUNCH_TIME_START: $(this).find('.CUSTOM_WORK_LUNCH_START').val(),
				LUNCH_TIME_END: $(this).find('.CUSTOM_WORK_LUNCH_END').val(),
				WORK_TIMES: []
			};
			var CUSTOM_WORK_TIMES = $(this).find('.CUSTOM_WORK_TIMES');
			$(CUSTOM_WORK_TIMES).each(function () {
				var TMP_TIME_START = $(this).find('.CUSTOM_WORK_TIME_START').val();
				var TMP_TIME_END = $(this).find('.CUSTOM_WORK_TIME_END').val();
				if ((TMP_TIME_START.length > 0) && 
					(TMP_TIME_END.length > 0) && 
					(TMP_TIME_START.localeCompare(TMP_TIME_END) < 0)
					) {
					ONE_CUSTOM_WORK_INFORMATION.WORK_TIMES.push({
						START: TMP_TIME_START,
						END: TMP_TIME_END
					});
				}
			});
			CUSTOM_WORK_INFORMATION.push(ONE_CUSTOM_WORK_INFORMATION);
		}
	});
	_RS.ARS_CONFIG.WORK_INFORMATION.CUSTOM_WORK_INFORMATION = CUSTOM_WORK_INFORMATION;
	var ORDINARY_WORK_INFORMATION = {};
	$('.ORDINARY_WORK_INFORMATION').each(function () {
		ORDINARY_WORK_INFORMATION = {
			LUNCH_TIME_START: $(this).find('.ORDINARY_WORK_LUNCH_START').val(),
			LUNCH_TIME_END: $(this).find('.ORDINARY_WORK_LUNCH_END').val(),
			WORK_TIMES: []
		};
		var ORDINARY_WORK_TIMES = $(this).find('.ORDINARY_WORK_TIMES');
		$(ORDINARY_WORK_TIMES).each(function () {
			var TMP_TIME_START = $(this).find('.ORDINARY_WORK_TIME_START').val();
			var TMP_TIME_END = $(this).find('.ORDINARY_WORK_TIME_END').val();
			if ((TMP_TIME_START.length > 0) && 
				(TMP_TIME_END.length > 0) && 
				(TMP_TIME_START.localeCompare(TMP_TIME_END) < 0)
				) {
				ORDINARY_WORK_INFORMATION.WORK_TIMES.push({
					START: TMP_TIME_START,
					END: TMP_TIME_END
				});
			}
		});
	});
	_RS.ARS_CONFIG.WORK_INFORMATION.WORK_TIME_INFORMATION = ORDINARY_WORK_INFORMATION;
	_RS.ARS_CONFIG.WORK_INFORMATION.BUSY_RETRY_MAX = parseInt($('#BUSY_RETRY_MAX').val());
	PUT_ARS_CONFIG_INFORMATION();
	_RS.$apply();
	SET_DOM_EVENT();
	
}
</script>
<div class="ars_config">
	<div style="height:100%; width:100%;">
		<div style="width:100%;height:10%;">
			<input class="BTN_ARS_CONFIG" style="width:100%;height:100%;" type="button" value="???????????? ??????" id="BTN_SAVE_CUSTOM_WORKS"/>
		</div>
		<div id="TABS_ARS_CONFIG">
			<ul>
				<li>???????????? ??????</li>
				<li>?????? ??? ????????? ??????</li>
			</ul>
			<div style="width:100%;height:100%;">
				<div style="width:50%;height:100%;float:left;">
					<div style="width:100%;height:10%;">
						<table style="height:100%;">
							<tr>
								<th>?????? ????????????</th>
							</tr>
						</table>
					</div>
					<div style="width:100%;height:40%;">
						<table style="width:100%;height:100%;" class="ORDINARY_WORK_INFORMATION">
							<tr>
								<th>????????????</th>
								<td>
									<input style="text-align:center;" size="5" type="text" class="ORDINARY_WORK_LUNCH_START" value="{{ARS_CONFIG.WORK_INFORMATION.WORK_TIME_INFORMATION.LUNCH_TIME_START}}" />
									 ~ 
									<input style="text-align:center;" size="5" type="text" class="ORDINARY_WORK_LUNCH_END" value="{{ARS_CONFIG.WORK_INFORMATION.WORK_TIME_INFORMATION.LUNCH_TIME_END}}" />
								</td>
							</tr>
							<tr class="ORDINARY_WORK_TIMES" ng-repeat="ONE_WORK_TIME in ARS_CONFIG.WORK_INFORMATION.WORK_TIME_INFORMATION.WORK_TIMES">
								<th>???????????? - {<?php echo $__Context->index + 1 ?>}</th>
								<td>
									<input style="text-align:center;" size="5" type="text" class="ORDINARY_WORK_TIME_START" value="{{ONE_WORK_TIME.START}}" />
									 ~ 
									<input style="text-align:center;" size="5" type="text" class="ORDINARY_WORK_TIME_END" value="{{ONE_WORK_TIME.END}}" />
								</td>
							</tr>
							<tr class="ORDINARY_WORK_TIMES">
								<th>???????????? ??????</th>
								<td>
									<input style="text-align:center;" size="5" type="text" class="ORDINARY_WORK_TIME_START" value="00:00" />
									 ~ 
									<input style="text-align:center;" size="5" type="text" class="ORDINARY_WORK_TIME_END" value="00:00" />
								</td>
							</tr>
						</table>
					</div>
					<div style="width:100%;height:10%;">
						<table style="height:100%;">
							<tr>
								<th>????????? ???????????? ??????</th>
							</tr>
						</table>
					</div>
					<div style="width:100%;height:35%;" >
						<div style="width:50%;height:100%;float:left;">
							<div style="width:100%;height:25%;">
								<table style="height:100%;">
									<col width="33%" />
									<col width="33%" />
									<col width="34%" />
									<tr>
										<td colspan="3">
											<input type="text" style="width:100%;height:100%;text-align:center;" id="TXT_ADD_GROUP" placeholder="????????? ????????? ??????"/>
										</td>
									</tr>
									<tr>
										<td>
											<div id="SELECT_CALL_ASSIGN" ></div>
										</td>
										<td>
											<input class="BTN_ARS_CONFIG" type="button" style="width:100%;height:100%;" id="BTN_ADD_GROUP" value="??????"/>
										</td>
										<td>
											<input class="BTN_ARS_CONFIG" type="button" style="width:100%;height:100%;" id="BTN_DEL_GROUP" value="??????"/>
										</td>
									</tr>
								</table>
							</div>
							<div style="width:100%;height:75%;">
								<div id="LIST_STAFF_GROUPS" ></div>
							</div>
						</div>
						<div style="width:50%;height:100%;float:left;">
							<div style="width:100%;height:25%;">
								<table style="height:100%;">
									<tr>
										<td colspan="2">
											<input type="number" style="width:100%;height:100%;text-align:center;" id="TXT_ADD_NUMBER" placeholder="????????? ???????????? ??????"/>
										</td>
									</tr>
									<tr>
										<td>
											<input class="BTN_ARS_CONFIG" type="button" style="width:100%;height:100%;" id="BTN_ADD_NUMBER"  value="??????"/>
										</td>
										<td>
											<input class="BTN_ARS_CONFIG" type="button" style="width:100%;height:100%;" id="BTN_DEL_NUMBER" value="??????"/>
										</td>
									</tr>
								</table>
							</div>
							<div style="width:100%;height:75%;">
								<div id="LIST_STAFF_NUMBERS" ></div>
							</div>
						</div>
					</div>
					<div style="width:100%;height:5%;" >
						<table>
							<tr>
								<th>
									????????? ????????? ??????
								</th>
								<td>
									<input type="number" style="width:100%;height:100%;text-align:center;" id="BUSY_RETRY_MAX" value="{{ARS_CONFIG.WORK_INFORMATION.BUSY_RETRY_MAX}}"/>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div style="width:50%;height:100%;float:left;">
					<div style="width:100%;height:10%;">
						<table style="height:100%;">
							<tr>
								<th>???????????? / ?????? ????????????</th>
							</tr>
						</table>
					</div>
					<div style="width:100%;height:90%;overflow:auto;">
						<table>
							<!--
							<tr class="CUSTOM_WORKS" ng-repeat="ONE_WORK in ARS_CONFIG.WORK_INFORMATION.CUSTOM_WORK_INFORMATION | limitTo:3">
							-->
							<tr class="CUSTOM_WORKS" >
								<td>
									<table>
										<tr>
											<th>??????</th>
											<td>
												<input class="CUSTOM_WORK_CHECKBOX" type="checkbox" />
											</td>
										</tr>
										<tr>
											<th>??????</th>
											<td><div class="CUSTOM_WORK_DATE"></div></td>
										</tr>
										<tr>
											<th class="LABEL_ITS_WORK_DAY_ADD">??????</th>
											<td>
												<input class="ITS_WORK_DAY" id="ITS_WORK_DAY_ADD" type="checkbox" checked />
											</td>
										</tr>
										<tr>
											<th>????????????</th>
											<td>
												<input style="text-align:center;" size="5" type="text" class="CUSTOM_WORK_LUNCH_START" value="00:00" />
												 ~ 
												<input style="text-align:center;" size="5" type="text" class="CUSTOM_WORK_LUNCH_END" value="00:00" />
											</td>
										</tr>
										<tr class="CUSTOM_WORK_TIMES">
											<th>???????????? ??????</th>
											<td>
												<input style="text-align:center;" size="5" type="text" class="CUSTOM_WORK_TIME_START" value="00:00" />
												 ~ 
												<input style="text-align:center;" size="5" type="text" class="CUSTOM_WORK_TIME_END" value="00:00" />
											</td>
										</tr>
									</table>
									<hr/>
								</td>
							</tr>
							<tr class="CUSTOM_WORKS" ng-repeat="ONE_WORK in ARS_CONFIG.WORK_INFORMATION.CUSTOM_WORK_INFORMATION">
								<td>
									<table>
										<tr>
											<th>??????</th>
											<td>
												<input class="CUSTOM_WORK_CHECKBOX" type="checkbox" checked />
											</td>
										</tr>
										<tr>
											<th>?????? - {<?php echo $__Context->index + 1 ?>}</th>
											<td><div class="CUSTOM_WORK_DATE" value="{{ONE_WORK.DATE}}"></div></td>
										</tr>
										<tr>
											<th class="LABEL_ITS_WORK_DAY_{<?php echo $__Context->index + 1 ?>}" ng-show="!ONE_WORK.ITS_WORK_DAY">????????????</th>
											<th class="LABEL_ITS_WORK_DAY_{<?php echo $__Context->index + 1 ?>}" ng-show="ONE_WORK.ITS_WORK_DAY">??????</th>
											<td>
												<input class="ITS_WORK_DAY" type="checkbox" id="ITS_WORK_DAY" INDEX="{<?php echo $__Context->index + 1 ?>}" ng-checked="ONE_WORK.ITS_WORK_DAY"/>
											</td>
										</tr>
										<tr>
											<th>????????????</th>
											<td>
												<input style="text-align:center;" size="5" type="text" class="CUSTOM_WORK_LUNCH_START" value="{{ONE_WORK.LUNCH_TIME_START}}" />
												 ~ 
												<input style="text-align:center;" size="5" type="text" class="CUSTOM_WORK_LUNCH_END" value="{{ONE_WORK.LUNCH_TIME_END}}" />
											</td>
										</tr>
										<!--
										<tr class="CUSTOM_WORK_TIMES" ng-repeat="ONE_WORK_TIME in ONE_WORK.WORK_TIMES | limitTo:3">
										-->
										<tr class="CUSTOM_WORK_TIMES" ng-repeat="ONE_WORK_TIME in ONE_WORK.WORK_TIMES">
											<th>???????????? - {<?php echo $__Context->index + 1 ?>}</th>
											<td>
												<input style="text-align:center;" size="5" type="text" class="CUSTOM_WORK_TIME_START" value="{{ONE_WORK_TIME.START}}" />
												 ~ 
												<input style="text-align:center;" size="5" type="text" class="CUSTOM_WORK_TIME_END" value="{{ONE_WORK_TIME.END}}" />
											</td>
										</tr>
										<tr class="CUSTOM_WORK_TIMES">
											<th>???????????? ??????</th>
											<td>
												<input style="text-align:center;" size="5" type="text" class="CUSTOM_WORK_TIME_START" value="00:00" />
												 ~ 
												<input style="text-align:center;" size="5" type="text" class="CUSTOM_WORK_TIME_END" value="00:00" />
											</td>
										</tr>
									</table>
									<hr/>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div style="width:100%;height:100%;">
				<div style="width:50%;height:100%;float:left;">
					<div style="width:100%;height:10%;">
						<table style="height:100%;">
							<tr>
								<th>?????? ??????</th>
							</tr>
						</table>
					</div>
					<div style="width:100%;height:90%;">
						<div style="width:100%;height:25%;">
							<table style="height:100%;">
								<tr>
									<td colspan="2">
										<input type="text" style="width:100%;height:100%;text-align:center;" id="TXT_ADD_BANK" placeholder="????????? ????????? ??????"/>
									</td>
								</tr>
								<tr>
									<td>
										<input class="BTN_ARS_CONFIG" type="button" style="width:100%;height:100%;" id="BTN_ADD_BANK" value="??????"/>
									</td>
									<td>
										<input class="BTN_ARS_CONFIG" type="button" style="width:100%;height:100%;" id="BTN_DEL_BANK" value="??????"/>
									</td>
								</tr>
							</table>
						</div>
						<div style="width:100%;height:75%;">
							<div id="LIST_BANKS" ></div>
						</div>
					</div>
				</div>
				<div style="width:50%;height:100%;float:left;">
					<div style="width:100%;height:10%;">
						<table style="height:100%;">
							<tr>
								<th>????????? ??????</th>
							</tr>
						</table>
					</div>
					<div style="width:100%;height:90%;">
						<div style="width:100%;height:25%;">
							<table style="height:100%;">
								<tr>
									<td colspan="2">
										<input type="text" style="width:100%;height:100%;text-align:center;" id="TXT_ADD_CARD" placeholder="????????? ????????? ??????"/>
									</td>
								</tr>
								<tr>
									<td>
										<input class="BTN_ARS_CONFIG" type="button" style="width:100%;height:100%;" id="BTN_ADD_CARD" value="??????"/>
									</td>
									<td>
										<input class="BTN_ARS_CONFIG" type="button" style="width:100%;height:100%;" id="BTN_DEL_CARD" value="??????"/>
									</td>
								</tr>
							</table>
						</div>
						<div style="width:100%;height:75%;">
							<div id="LIST_CARDS" ></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div style="height:0%; width:100%; overflow:auto;" id="DIV_LOG">
	</div>
</div>
