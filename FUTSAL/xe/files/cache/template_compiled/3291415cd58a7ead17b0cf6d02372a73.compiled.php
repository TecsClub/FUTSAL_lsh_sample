<?php if(!defined("__XE__"))exit;?><style>
	.openapi_accounts 			{width:100%; height:100%;}
	.openapi_accounts table		{width:100%; height:100%; font-size:100%; border-collapse: separate; border-spacing: 1px; line-height: 100%;}
	.openapi_accounts table th	{font-weight:bold; text-align: center; white-space:normal; vertical-align: middle; word-break:break-all; word-wrap:break-all; background:#4789b7; color:white; }
	.openapi_accounts table td	{text-decoration:none; text-align: left;   white-space:normal; vertical-align: middle; word-break:break-all; word-wrap:break-all; background:#eee; padding:0 10px;}
</style>
<script>
var IVR_SERVER_SELECTED		= null;
function REGIST_BUTTON_EVENT() {
	$(".BTN_OPENAPI_ACCOUNTS").jqxButton({
		width: '100%',
		height: '100%'
	}).on('click', function () {
		var ID = $(this).attr('ID');
		if (ID == 'DUMMY') {
		} else if(ID == 'BTN_GET_OPENAPI_ACCOUNTS') {
			QUERY_OPENAPI_ACCOUNTS();
		}
	});
}
function ON_CLICK_BTN_PROCESS_ACCOUNT(OBJ_DOM) {
	var ATTR = QIIP_GET_DOM_ATTRIBUTES(OBJ_DOM);
	var STR_CMD = ATTR.cmd;
	var ROW_DATA = $('#DIV_GRID_ACCOUNT_LIST').jqxGrid('getrowdata', ATTR.row);
//	alert(JSON.stringify(ROW_DATA, null, '\t'));
	var STR_SQL = '';
	if (STR_CMD == 'DUMMY') {
	} else if (STR_CMD == 'UPD') {
		STR_SQL  = "UPDATE T_USER_LIST ";
		STR_SQL += sprintf("SET COMP_ID = '%s', ", ROW_DATA.COMP_ID);
		STR_SQL += sprintf("LOGIN_ID = '%s', ", ROW_DATA.LOGIN_ID);
		STR_SQL += sprintf("LOGIN_PW = '%s', ", ROW_DATA.LOGIN_PW);
		STR_SQL += sprintf("PHONE_ID = '%s', ", ROW_DATA.PHONE_ID);
		STR_SQL += sprintf("PHONE_PW = '%s' ", ROW_DATA.PHONE_PW);
		STR_SQL += sprintf("WHERE ID = '%s' ", ROW_DATA.ID);
	} else if (STR_CMD == 'DEL') {
		STR_SQL  = "DELETE FROM T_USER_LIST ";
		STR_SQL += sprintf("WHERE ID = %s ", ROW_DATA.ID);
	} else if (STR_CMD == 'ADD') {
		if ((ROW_DATA.COMP_ID.length > 0) &&
			(ROW_DATA.LOGIN_ID.length > 0) &&
			(ROW_DATA.LOGIN_PW.length > 0) &&
			(ROW_DATA.PHONE_ID.length > 0) &&
			(ROW_DATA.PHONE_PW.length > 0)) {
			STR_SQL  = "INSERT INTO T_USER_LIST (";
			STR_SQL += sprintf("COMP_ID, ");
			STR_SQL += sprintf("LOGIN_ID, ");
			STR_SQL += sprintf("LOGIN_PW, ");
			STR_SQL += sprintf("PHONE_ID, ");
			STR_SQL += sprintf("PHONE_PW ");
			STR_SQL += sprintf(") VALUES (");
			STR_SQL += sprintf("'%s', '%s', '%s', '%s', '%s')", 
							ROW_DATA.COMP_ID,
							ROW_DATA.LOGIN_ID,
							ROW_DATA.LOGIN_PW,
							ROW_DATA.PHONE_ID,
							ROW_DATA.PHONE_PW
					   );
			
		} else {
			QIIP_POPUP_FOR_ALERT(
			"안내",
			[
				"데이터 중 일부를 입력하지 않았습니"
			],
			function(){
			}
			,
			20,
			16.5
			);
			
		}
	}
	console.log(STR_SQL);
	
	if (STR_SQL.length < 1) return;
	QIIP_API_ACCESS({
			REQ: 'api_DB_ACCESS',
			STR_SQL_BASE64: Base64.encode(STR_SQL),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if (JSON_RESULT instanceof Object) {
				QUERY_OPENAPI_ACCOUNTS();
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
function INIT_WIDGETS_FOR_MENU_CONTENTS() {
	REGIST_BUTTON_EVENT();
	TOGGLE_SIDEMENU(function () {
		setTimeout(function (){
			QUERY_OPENAPI_ACCOUNTS();
		}, 1000);
	});
}
function QUERY_OPENAPI_ACCOUNTS() {
    var STR_COMP_ID = $('#STR_COMP_ID').val();
    var STR_LOGIN_ID = $('#STR_LOGIN_ID').val();
    var STR_PHONE_ID = $('#STR_PHONE_ID').val();
    
    var FLAG_FILTER = false;
    if (STR_COMP_ID.length > 0)  { FLAG_FILTER = true; }
    if (STR_LOGIN_ID.length > 0) { FLAG_FILTER = true; }
    if (STR_PHONE_ID.length > 0) { FLAG_FILTER = true; }
    var MAX_LIST	  = parseInt($('#MAX_LIST').val());
    if (MAX_LIST < 1) {
    	MAX_LIST = 50;
    } else if (MAX_LIST > 1000) {
    	MAX_LIST = 1000;
    }
	var STR_SQL  = "SELECT * FROM T_USER_LIST ";
		if (FLAG_FILTER) {
			STR_SQL += sprintf("WHERE ID > 0 ");
		}
		if (STR_COMP_ID.length > 0) {
			STR_SQL += sprintf("AND COMP_ID like '%s' ", '%' + STR_COMP_ID + '%');
		}
		if (STR_LOGIN_ID.length > 0) {
			STR_SQL += sprintf("AND LOGIN_ID like '%s' ", '%' + STR_LOGIN_ID + '%');
		}
		if (STR_PHONE_ID.length > 0) {
			STR_SQL += sprintf("AND PHONE_ID like '%s' ", '%' + STR_PHONE_ID + '%');
		}
		STR_SQL += sprintf("ORDER BY ID DESC ");
		STR_SQL += sprintf("LIMIT %d ", MAX_LIST);
	
	console.log(STR_SQL);
	QIIP_API_ACCESS({
			REQ: 'api_DB_ACCESS',
			STR_SQL_BASE64: Base64.encode(STR_SQL),
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
			if (JSON_RESULT instanceof Object) {
				REFRESH_GRID_OPENAPI_ACCOUNTS(JSON_RESULT);
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
function REFRESH_GRID_OPENAPI_ACCOUNTS(SQL_RESULT) {
//	$('#DIV_GRID_ACCOUNT_LIST').html(
//		'<pre>' +
//		JSON.stringify(SQL_RESULT, null, '\t') +
//		'</pre>'
//	);
//	return;
	SQL_RESULT.unshift({
		"ID": "NA",
		"COMP_ID": "",
		"LOGIN_ID": "",
		"LOGIN_PW": "",
		"PHONE_ID": "",
		"PHONE_PW": ""
	});
	SQL_RESULT.forEach(function (ONE_ITEM) {
	});
    var source = {
        localdata: SQL_RESULT,
        datatype: "json",
        datafields:[
            { name: 'ID',						type: 'string' },
            { name: 'COMP_ID',					type: 'string' },
            { name: 'LOGIN_ID',					type: 'string' },
            { name: 'LOGIN_PW',					type: 'string' },
            { name: 'PHONE_ID',					type: 'string' },
            { name: 'PHONE_PW',					type: 'string' },
        ]                     
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
	$("#DIV_GRID_ACCOUNT_LIST").jqxGrid({
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
          { text: '버튼', align: 'center',	cellsalign: 'center',
          	cellsrenderer: function (row, column, value) {
                var STR_HTML  = '';
                	STR_HTML += '<div style="width:100%;height:100%;text-align:center;">';
          		if (row > 0) {
                	STR_HTML += '<button style="height:100%;" CMD="UPD" ROW="' + row + '" onclick="ON_CLICK_BTN_PROCESS_ACCOUNT(this);">';
                	STR_HTML += '갱신';
                	STR_HTML += '</button>';
                	STR_HTML += ' ';
                	STR_HTML += '<button style="height:100%;" CMD="DEL" ROW="' + row + '" onclick="ON_CLICK_BTN_PROCESS_ACCOUNT(this);">';
                	STR_HTML += '삭제';
                	STR_HTML += '</button>';
          		} else {
                	STR_HTML += '<button style="height:100%;" CMD="ADD" ROW="' + row + '" onclick="ON_CLICK_BTN_PROCESS_ACCOUNT(this);">';
                	STR_HTML += '추가';
                	STR_HTML += '</button>';
          		}
                	STR_HTML += '</div>';
                return STR_HTML;
            }
          },
          { text: 'ID',			columngroup: 'ACCOUNT_INFO', datafield: 'ID'},
          { text: 'COMP_ID',	columngroup: 'ACCOUNT_INFO', datafield: 'COMP_ID',		align: 'center',	cellsalign: 'center'},
          { text: 'LOGIN_ID',	columngroup: 'ACCOUNT_INFO', datafield: 'LOGIN_ID',		align: 'center',	cellsalign: 'center'},
          { text: 'LOGIN_PW',	columngroup: 'ACCOUNT_INFO', datafield: 'LOGIN_PW',		align: 'center',	cellsalign: 'center'},
          { text: 'PHONE_ID',	columngroup: 'ACCOUNT_INFO', datafield: 'PHONE_ID',		align: 'center',	cellsalign: 'center'},
          { text: 'PHONE_PW',	columngroup: 'ACCOUNT_INFO', datafield: 'PHONE_PW',		align: 'center',	cellsalign: 'center'},
        ],
        columngroups: [
            { text: 'OPENAPI 계정정보', align: 'center', name: 'ACCOUNT_INFO' },
        ]
    });	
    
}
</script>
<div class="openapi_accounts">
	<div style="height:5%; overflow:auto;">
		<table>
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="10%" />
			<col width="20%" />
			<tr>
				<th style="background:#94bbd6; color:#333;">COMP_ID</th>
				<td>
					<input type="text" id="STR_COMP_ID" style="width:100%;height:100%" />
				</td>
				<th style="background:#94bbd6; color:#333;">LOGIN_ID</th>
				<td>
					<input type="text" id="STR_LOGIN_ID" style="width:100%;height:100%" />
				</td>
				<th style="background:#94bbd6; color:#333;">PHONE_ID</th>
				<td>
					<input type="text" id="STR_PHONE_ID" style="width:100%;height:100%" />
				</td>
				<th style="background:#94bbd6; color:#333;">LIMIT</th>
				<td>
					<input type="text" id="MAX_LIST" style="width:100%;height:100%;text-align:center;" value="50"/>
				</td>
				<td>
					<button class="BTN_OPENAPI_ACCOUNTS" id="BTN_GET_OPENAPI_ACCOUNTS">
						목록갱신
					</button>
				</td>
			</tr>
		</table>
	</div>
	<div style="height:95%;">
		<div id="DIV_GRID_ACCOUNT_LIST">
		</div>
	</div>
</div>
