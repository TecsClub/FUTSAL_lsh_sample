<?php if(!defined("__XE__"))exit;?><style>
	.ivr_call_list 			{width:100%; height:100%;}
	.ivr_call_list table		{width:100%; height:100%; font-size:100%; border-collapse: separate; border-spacing: 1px; line-height: 100%;}
	.ivr_call_list table th	{font-weight:bold; text-align: center; white-space:normal; vertical-align: middle; word-break:break-all; word-wrap:break-all; background:#4789b7; color:white; }
	.ivr_call_list table td	{text-decoration:none; text-align: left;   white-space:normal; vertical-align: middle; word-break:break-all; word-wrap:break-all; background:#eee; padding:0 10px;}
	
	.ivr_call_status 			{width:100%; height:100%; background:white;}
	.ivr_call_status table		{width:100%; height:100%; font-size:100%; border: 0px;  line-height: 100%;}
	.ivr_call_status table th	{border: 0px; text-align: center;   }
	.ivr_call_status table td	{border: 0px; }
</style>
<script>
var IVR_SERVER_SELECTED		= null;
function REGIST_BUTTON_EVENT() {
	$(".BTN_IVR_CALL_LIST").jqxButton({
		width: '100%',
		height: '100%'
	}).on('click', function () {
		var ID = $(this).attr('ID');
		if (ID == 'DUMMY') {
		} else if(ID == 'BTN_GET_IVR_CALL_LIST') {
			QUERY_IVR_CALL_LIST();
		}
	});
}
function ON_CLICK_BTN_LOAD_RECORD_FILE(OBJ_DOM) {
	var REC_FILE = $(OBJ_DOM).attr('REC_FILE');
	EXEC_LOAD_RECORD_FILE(REC_FILE);
}
function EXEC_LOAD_RECORD_FILE(REC_FILE) {
	var URL_DOWNLOAD_ARGS = {
		METHOD: 'FILE_DOWNLOAD',
		FILE_PATH: REC_FILE
	};
	var URL_DOWNLOAD = sprintf('http://%s/api.php', IVR_SERVER_SELECTED.SERVER_IP) + '?JSON_REQUEST=' + JSON.stringify(URL_DOWNLOAD_ARGS);
	var REC_FILE_URL_ARGS = {
		REQ: 'api_HTTP_DOWNLOAD',
		URL_DOWNLOAD: URL_DOWNLOAD,
	};
	var REC_FILE_URL = window.location.origin + '?JSON=' + JSON.stringify(REC_FILE_URL_ARGS);
	_NAUTES_SoundVisualizer.WAE_EE.emit("automaticscroll", false);
	_NAUTES_SoundVisualizer.WAE_EE.emit("clear");
	$('#BTN_NAUTES_WAE_EXEC_PLAY_TOGGLE').html('<i class="fa fa-play">');
	
	_NAUTES_SoundVisualizer.WAE_PLAYLIST.load([{
			src: REC_FILE_URL
	}]).then(function() {
		_NAUTES_SoundVisualizer.WAE_EE.emit("automaticscroll", true);
		_NAUTES_SoundVisualizer.WAE_EE.emit("play");
		$('#BTN_NAUTES_WAE_EXEC_PLAY_TOGGLE').html('<i class="fa fa-pause">');
	});
}
function INIT_WIDGETS_FOR_MENU_CONTENTS() {
	REGIST_BUTTON_EVENT();
	INIT_WIDGETS_FOR_SELECT_IVR_SERVER(_RS.APP_CONFIG.IVR_SERVER_IPS);
	INIT_NAUTES_SoundVisualizer();
	TOGGLE_SIDEMENU();
}
function QUERY_IVR_CALL_LIST() {
	var DATE_RANGE = $("#DATE_RANGE").jqxDateTimeInput('getRange');
    var STR_DATE_FROM = dateFormat(DATE_RANGE.from, 'yyyy-mm-dd');
    var STR_DATE_TO   = dateFormat(DATE_RANGE.to, 'yyyy-mm-dd');
    var STR_CALL_FROM = $('#STR_CALL_FROM').val();
    var STR_CALL_TO	  = $('#STR_CALL_TO').val();
    var MAX_LIST	  = parseInt($('#MAX_LIST').val());
    if (MAX_LIST < 1) {
    	MAX_LIST = 50;
    } else if (MAX_LIST > 1000) {
    	MAX_LIST = 1000;
    }
	var DATE_APPLY = 'TIME_REGIST';
	var STR_SQL  = "SELECT * FROM arsauth_list ";
		STR_SQL += sprintf("WHERE CALL_TIME_REGIST >= '%s' AND CALL_TIME_REGIST <= '%s' ", STR_DATE_FROM, STR_DATE_TO);
		if (STR_CALL_FROM.length > 0) {
			STR_SQL += sprintf("AND CALL_FROM like '%s' ", '%' + STR_CALL_FROM + '%');
		}
		if (STR_CALL_TO.length > 0) {
			STR_SQL += sprintf("AND CALL_TO like '%s' ", '%' + STR_CALL_TO + '%');
		}
		STR_SQL += "ORDER by CALL_TIME_REGIST DESC ";
		STR_SQL += sprintf("LIMIT %d ", MAX_LIST);
	
	console.log(STR_SQL);
	QIIP_API_ACCESS({
			REQ: 'api_HTTP_ACCESS',
			CURLOPT_URL: sprintf('http://%s/api.php', IVR_SERVER_SELECTED.SERVER_IP),
			CURLOPT_POSTFIELDS: {
				METHOD: 'ASTERISK_DB',
				SQL: STR_SQL
			}
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if (JSON_RESULT instanceof Object) {
				REFRESH_GRID_IVR_CALL_LIST(JSON_RESULT.JSON_RESULT.SQL_RESULT);
			}
		},{
			title: _RS.PHONE_INFO.APP_NAME + ' 안내',
			template: ARR_TO_TABLE_CENTER([
				'화면을 구성하고 있습니다.'
			]),
			cssClass: 'qiip_popup'
		}
	);
}
function REFRESH_GRID_IVR_CALL_LIST(SQL_RESULT) {
/*
	$('#DIV_GRID_CALL_LIST').html(
		'<pre>' +
		JSON.stringify(SQL_RESULT, null, '\t') +
		'</pre>'
	);
*/
//	return;
	SQL_RESULT.forEach(function (ONE_ITEM) {
		ONE_ITEM.DTMF_INPUTS = JSON.stringify(ONE_ITEM.DTMF_INPUTS);
		ONE_ITEM.REC_FILE	 = sprintf('%s/%s.wav', ONE_ITEM.STR_JSON_STATUS_ALL.CALL_STATUS.REC_FOLDER, ONE_ITEM.STR_JSON_STATUS_ALL.CALL_STATUS.REC_FILE_PREFIX);
		ONE_ITEM.SCENARIO_HISTORY = JSON.stringify(ONE_ITEM.STR_JSON_STATUS_ALL.SCENARIO_HISTORY, null, '\t');
	});
    var source = {
        localdata: SQL_RESULT,
        datatype: "json",
        datafields:[
            { name: 'ID',						type: 'string' },
            { name: 'UNIQUE_ID',				type: 'string' },
            { name: 'APIKEY',					type: 'string' },
            { name: 'CALL_FROM',				type: 'string' },
            { name: 'CALL_TO',					type: 'string' },
            { name: 'CALL_TIME_REGIST',			type: 'string' },
            { name: 'CALL_TIME_CONNECT',		type: 'string' },
            { name: 'CALL_TIME_END',			type: 'string' },
            { name: 'CALL_TIME_AUTH_DURATION',	type: 'int'	},
            { name: 'CALL_TIME_CALL_DURATION',	type: 'int' },
            { name: 'DTMF_INPUTS',				type: 'string' },
            { name: 'REC_FILE',					type: 'string' },
            { name: 'SCENARIO_HISTORY',			type: 'string' },
        ]                     
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
	$("#DIV_GRID_CALL_LIST").jqxGrid({
        width: '100%',
        height: '100%',
        source: dataAdapter,                
//        pageable: true,
//        autoheight: true,
        sortable: true,
        altrows: true,
        enabletooltips: true,
        editable: true,
        pagesize: 15,
        selectionmode: 'multiplecellsadvanced',
        columns: [
          { text: '고유번호',	columngroup: 'CALL_INFO', datafield: 'UNIQUE_ID'},
          { text: 'APIKEY',	columngroup: 'CALL_INFO', datafield: 'APIKEY',					align: 'center',	cellsalign: 'center'},
          { text: '발신번호',	columngroup: 'CALL_INFO', datafield: 'CALL_FROM',				align: 'center',	cellsalign: 'center'},
          { text: '수신번호',	columngroup: 'CALL_INFO', datafield: 'CALL_TO',					align: 'center',	cellsalign: 'center'},
          { text: '히스토리',	columngroup: 'CALL_INFO', datafield: 'SCENARIO_HISTORY',		align: 'center',	cellsalign: 'center'},
          { text: '통화요청',	columngroup: 'CALL_INFO', datafield: 'CALL_TIME_REGIST',		align: 'center',	cellsalign: 'center'},
          { text: '통화연결',	columngroup: 'CALL_INFO', datafield: 'CALL_TIME_CONNECT',		align: 'center',	cellsalign: 'center'},
          { text: '통화종료',	columngroup: 'CALL_INFO', datafield: 'CALL_TIME_END',			align: 'center',	cellsalign: 'center'},
          { text: '전체시간',	columngroup: 'CALL_INFO', datafield: 'CALL_TIME_AUTH_DURATION', align: 'center',	cellsalign: 'center'},
          { text: '연결시간',	columngroup: 'CALL_INFO', datafield: 'CALL_TIME_CALL_DURATION', align: 'center',	cellsalign: 'center'},
          { text: 'DTMF',	columngroup: 'CALL_INFO', datafield: 'DTMF_INPUTS',				align: 'center',	cellsalign: 'center'},
          { text: '녹취',	datafield: 'REC_FILE',	align: 'center',	cellsalign: 'center',
          	cellsrenderer: function (row, column, value) {
                var STR_HTML  = '';
                	STR_HTML += '<button style="width:100%;height:100%;" REC_FILE="' + value + '" onclick="ON_CLICK_BTN_LOAD_RECORD_FILE(this);">';
                	STR_HTML += '들어보기';
                	STR_HTML += '</button>';
                return STR_HTML;
            }
          },
        ],
        columngroups: [
            { text: '통화정보', align: 'center', name: 'CALL_INFO' }
        ]
    });	
    
}
function INIT_WIDGETS_FOR_SELECT_IVR_SERVER(ARRAY_IVR_SERVER) {
	$("#SELECT_IVR_SERVER").jqxDropDownList({
		width: '100%',
		source: ARRAY_IVR_SERVER,
		displayMember: 'SERVER_NAME',
		valueMember: 'SERVER_IP',
		selectedIndex: 0
	}).on('change', function (event) {
		var args = event.args;
		if (args) {
			// index represents the item's index.                      
			var index = args.index;
			var item = args.item;
			// get item's label and value.
			var label = item.label;
			var value = item.value;
			var type = args.type;
			IVR_SERVER_SELECTED = item.originalItem;
		}
	});
	$("#DATE_RANGE").jqxDateTimeInput({
		width: '100%',
		height: '100%',
		selectionMode: 'range',
		formatString: 'yyyy-MM-dd'
	});
	var TODAY = new Date();
//	console.log(TODAY.getTime());
	var DATE_FROM	= TODAY;
	var DATE_TO		= new Date(TODAY.getTime() + 1000 * 60 * 60 * 24);
	$("#DATE_RANGE").jqxDateTimeInput('setRange', DATE_FROM, DATE_TO);
	IVR_SERVER_SELECTED = _RS.APP_CONFIG.IVR_SERVER_IPS[0];
}
var _NAUTES_SoundVisualizer = undefined;
function INIT_NAUTES_SoundVisualizer() {
	_NAUTES_SoundVisualizer = new NAUTES_SoundVisualizer({
		DOM_ID_FOR_RENDERING: 'DIV_NAUTES_SoundVisualizer',
		DOWNLOAD_DISABLE: true,
		WAVE_DISPLAY_ONLY: false,
	});
/*
	_NAUTES_SoundVisualizer.WAE_PLAYLIST.load([{
			src: 'http://ask-regard.call-save.biz?PASS=1&cmd=api_YOUTUBE_MP3&YOUTUBE_videoId=yQxB1M0VZLU&EXT=.mp3'
	}]).then(function() {
	});
*/
}
</script>
<div class="ivr_call_list">
	<div style="height:25%;" id="DIV_NAUTES_SoundVisualizer">
	</div>
	<div style="height:5%; overflow:auto;">
		<table>
			<col width="10%" />
			<col width="10%" />
			<col width="5%" />
			<col width="15%" />
			<col width="5%" />
			<col width="10%" />
			<col width="5%" />
			<col width="10%" />
			<col width="10" />
			<col width="10%" />
			<col width="10%" />
			<tr>
				<th style="background:#94bbd6; color:#333;">SELECT IVR</th>
				<td>
					<div id="SELECT_IVR_SERVER" />
				</td>
				<th style="background:#94bbd6; color:#333;">날짜구간</th>
				<td>
					<div id="DATE_RANGE" />
				</td>
				<th style="background:#94bbd6; color:#333;">발신번호</th>
				<td>
					<input type="text" id="STR_CALL_FROM" style="width:100%;height:100%" />
				</td>
				<th style="background:#94bbd6; color:#333;">수신번호</th>
				<td>
					<input type="text" id="STR_CALL_TO" style="width:100%;height:100%" />
				</td>
				<th style="background:#94bbd6; color:#333;">최대갯수</th>
				<td>
					<input type="text" id="MAX_LIST" style="width:100%;height:100%;text-align:center;" value="50"/>
				</td>
				<td>
					<button class="BTN_IVR_CALL_LIST" id="BTN_GET_IVR_CALL_LIST">
						목록구하기
					</button>
				</td>
			</tr>
		</table>
	</div>
	<div style="height:70%;">
		<div id="DIV_GRID_CALL_LIST">
		</div>
	</div>
</div>
