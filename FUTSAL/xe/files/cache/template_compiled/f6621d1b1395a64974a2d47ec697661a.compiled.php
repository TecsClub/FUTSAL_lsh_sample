<?php if(!defined("__XE__"))exit;?><script>
var ARRAY_REALTIME_KEYWORDS = new Array();
var SCROLL_RATIO_PREV = 0.0;
var SCROLL_RATIO = 0.0;
var FIRST_IMAGE_SEARCH = true;
var REALTIME_KEYWORD_REFRESH_ONLY = false;
	function INIT_WIDGETS_FOR_MENU_CONTENTS() {
		$('#SELECT_REALTIME_KEYWORDS').jqxDropDownList({
	//	    selectedIndex: sel_index, autoDropDownHeight: true, // source: dataAdapter,
			autoDropDownHeight: true,
	//		    displayMember: "KEYWORD", valueMember: "KEYWORD",
		    width: '100%',
		    renderer: function (index, label, value) {
		        var STR_HTML_TABLE = '<table width="100%"><tr><td>' + label + '</td></tr></table>';
		        return STR_HTML_TABLE;
		    }
		}).on('select', function (event) {     
		    var args = event.args;
		    if (args) {
		    	ON_CHANGE_REALTIME_KEYWORDS_SEL(args.index);
			} 
		});
		$("#CONTAINER_TABLE_IMAGES").bind("scroll", function () {
			var scrollBottom = $(this).scrollTop() + $(this).height();
			SCROLL_RATIO = $(this).scrollTop() * 100 / this.scrollHeight;
	//		$("#SCROLL_STATUS").html(sprintf("%4.1f", SCROLL_RATIO)+ " %");
			_RS.SCROLL_STATUS = sprintf("%4.1f", SCROLL_RATIO)+ " %";
			_RS.$apply();
	        if(scrollBottom + 10 >= this.scrollHeight) {
	//        if($(this).scrollTop() + $(this).innerHeight() + 10 >= this.scrollHeight) {
	        	ADD_SEARCH_IMAGES();
	        	$(this).scrollTop($(this).scrollTop() - $(window).height()/2);
	        }
	        if (Math.abs(SCROLL_RATIO - SCROLL_RATIO_PREV) > 20.0) {
	        	SHOW_POPUP_TIMER({
	        		title: '안내',
	        		template: TO_TABLE_CENTER('사진을 터치하면 인쇄할 수 있습니다.')
	        	}, 1000);
				SCROLL_RATIO_PREV = SCROLL_RATIO;
	        }
		});
		$('#chk_VIEW_MODE').on('click', function () {
			SET_VIEW_FORMAT();
			SET_SEARCH_IMAGES(true);
		});
		SET_VIEW_FORMAT();
	 	REFRESH_REALTIME_KEYWORDS();
//		LOAD_CLOUD_PRINT_HELP();
	}
  _RS.REFRESH_ONLY_REALTIME_KEYWORDS = function () {
		REALTIME_KEYWORD_REFRESH_ONLY = true;
		REFRESH_REALTIME_KEYWORDS();
  }
  
  _RS.BY_INPUTS = {
  	KEYWORD: ''
  };
  _RS.SEARCH_IMAGE_BY_INPUT = function() {
  	var OBJ_POPUP = $ionicPopup.show({
  		cssClass: 'SEARCH_BY_INPUT_POPUP',
		title:'검색어를 입력하세요!',
		template: '<input type="text" ng-model="BY_INPUTS.KEYWORD">',
		scope: _RS,
	    buttons: [
	      { text: '취소' },
	      {
	        text: '검색',
	        type: 'button-positive',
	        onTap: function(e) {
/*
	          if (!_RS.BY_INPUTS.KEYWORD) {
	            //don't allow the user to close unless he enters wifi password
	            e.preventDefault();
	          } else {
	            return _RS.BY_INPUTS.KEYWORD;
	          }
*/
	        	return _RS.BY_INPUTS.KEYWORD;
	        }
	      }
	    ]
	}).then(function(res) {
		if (_RS.BY_INPUTS.KEYWORD.length > 0) {
			page_LAST = 1;
			page_CURRENT = 1;
			page_RESET = true;
			ARRAY_REALTIME_KEYWORDS.push(_RS.BY_INPUTS.KEYWORD);
			$('#SELECT_REALTIME_KEYWORDS').jqxDropDownList('addItem', _RS.BY_INPUTS.KEYWORD);
			$('#SELECT_REALTIME_KEYWORDS').jqxDropDownList('selectIndex', ARRAY_REALTIME_KEYWORDS.length - 1);
		}
	});
  	
  }
  function REFRESH_REALTIME_KEYWORDS() {
	QIIP_API_ACCESS({
			REQ: 'api_get_daum_keywords',
		},function(STR_RESULT) {
			var JSON_RESULT = JSON_PARSE_IF_CAN(STR_RESULT);
//			ARRAY_REALTIME_KEYWORDS = JSON_RESULT;
			UPDATE_ARRAY_REALTIME_KEYWORDS(JSON_RESULT);
			$('#SELECT_REALTIME_KEYWORDS').jqxDropDownList('clear');
			for (var i=0; i<ARRAY_REALTIME_KEYWORDS.length; i++) {
				$('#SELECT_REALTIME_KEYWORDS').jqxDropDownList('addItem', ARRAY_REALTIME_KEYWORDS[i]);
			}
			$('#SELECT_REALTIME_KEYWORDS').jqxDropDownList('selectIndex', Math.floor((Math.random() * 10)));
		}
	);
  	
  }
  
	function UPDATE_ARRAY_REALTIME_KEYWORDS(ARGS_REALTIME_KEYWORDS) {
		for (var i=0; i<ARRAY_REALTIME_KEYWORDS.length; i++) {
			if (!ARGS_REALTIME_KEYWORDS.includes(ARRAY_REALTIME_KEYWORDS[i])) {
				 ARGS_REALTIME_KEYWORDS.push(ARRAY_REALTIME_KEYWORDS[i]);
//				 alert('순위에서 밀려난 [' + ARRAY_REALTIME_KEYWORDS[i] + '] 추가함');
			}
		}
		ARRAY_REALTIME_KEYWORDS = ARGS_REALTIME_KEYWORDS;
	}
	function ON_CHANGE_REALTIME_KEYWORDS_SEL(INDEX) {
//		alert('ON_CHANGE_REALTIME_KEYWORDS_SEL ' + REALTIME_KEYWORD_REFRESH_ONLY);
		if (!REALTIME_KEYWORD_REFRESH_ONLY) {
//			alert('REALTIME_KEYWORD_REFRESH_ONLY 아니 라서 이미지 갱신');
			SRCH_KEYWORD = ARRAY_REALTIME_KEYWORDS[INDEX];
			page_LAST = 1;
			page_CURRENT = 1;
			SET_SEARCH_IMAGES(false);
		} else {
//			alert('REALTIME_KEYWORD_REFRESH_ONLY 라서 이미지 갱신 안함');
			REALTIME_KEYWORD_REFRESH_ONLY = false;
		}
	}
var fmt;
function SET_VIEW_FORMAT() {
	if ($("input:checkbox[id='chk_VIEW_MODE']").is(":checked")) {
		fmt = "TABLE_FULL";
	} else {
		fmt = "TABLE_SMALL";
	}
}
	
var SRCH_KEYWORD = "";
var page_LAST = 1;
var page_CURRENT = 1;
var page_RESET = true;
	
	function SET_SEARCH_IMAGES(FLAG_SKIP) {
		var MODE_SKIP = 'NO';
		if (FLAG_SKIP) {
			MODE_SKIP = 'YES';
			page_RESET = false;
		} else {
			page_RESET = true;
		}
		var STR_MESSAGE_TEMPLATE = '';
		if (page_CURRENT < 2) {
			STR_MESSAGE_TEMPLATE = TO_TABLE_CENTER(
				"<h3>" +
				"검색어" + 
				" [" + SRCH_KEYWORD + "] " +
				"에 대하여...<br/><br/>" +
				"이미지를 검색 합니다." +
				"</h3>"
			);
		} else {
			STR_MESSAGE_TEMPLATE = TO_TABLE_CENTER(
				"<h3>" +
				"검색어" + 
				" [" + SRCH_KEYWORD + "] " +
				"에 대하여...<br/><br/>" +
				(page_CURRENT - 1) * parseInt($('#IMAGES_PER_PAGE').html()) + 
				" 번째 부터 " +
				(page_CURRENT - 0) * parseInt($('#IMAGES_PER_PAGE').html()) + 
				" 번째 까지<br/><br/>" +
				"이미지를 검색 합니다." +
				"</h3>"
			);
		}
		QIIP_API_ACCESS({
				REQ: 'api_srch_images',
				pageNumber: page_CURRENT,
				srchKeyword: SRCH_KEYWORD,
				fmt: fmt,
				SKIP: MODE_SKIP
			},function(STR_RESULT) {
				$('#TABLE_IMAGES').html(STR_RESULT);
				RESET_IMAGES_COUNTS();
//				alert(JSON.stringify(RESULT.RESULT_CONTENTS, null, '\t'));
			}
		);
	}
	function ADD_SEARCH_IMAGES() {
		if (page_CURRENT >= page_LAST) return;
		page_CURRENT++;
		QIIP_API_ACCESS({
				REQ: 'api_srch_images',
				pageNumber: page_CURRENT,
				srchKeyword: SRCH_KEYWORD,
				fmt: fmt,
				SKIP: MODE_SKIP
			},function(STR_RESULT) {
				ADD_IMAGE_RESULTS(RESULT);
//				alert(JSON.stringify(RESULT.RESULT_CONTENTS, null, '\t'));
			}
		);
	}
	function ADD_IMAGE_RESULTS(STR_HTML) {
		var mContens_Prev = $("#TABLE_IMAGES").html();
		$("#TABLE_IMAGES").html(mContens_Prev + STR_HTML);
		$("#CONTAINER_TABLE_IMAGES").scrollTop($("#CONTAINER_TABLE_IMAGES").scrollTop()-100);
		DISP_COUNT_STATUS();
	}
	function RESET_IMAGES_COUNTS() {
		if (page_RESET) {
			page_CURRENT = 1;
			page_LAST = Math.ceil(parseInt($('#IMAGES_TOTAL').html()) / parseInt($('#IMAGES_PER_PAGE').html())) + 0;
			if (page_LAST > 10) page_LAST = 10;
			_RS.page_CURRENT_FOR_DISPLAY = page_CURRENT + " / " + page_LAST;
			$('#slider_PAGE').jqxSlider({ width: "94%", height: 40, sliderButtonSize: 15, min: 1, max: page_LAST, value: page_CURRENT, step: 1});
			$('#slider_PAGE').on('change', function (event) {
				page_CURRENT = Math.round($(this).jqxSlider('value'));
				_RS.page_CURRENT_FOR_DISPLAY = page_CURRENT + " / " + page_LAST;
				_RS.$apply();			
				SET_SEARCH_IMAGES(true);
			});
		}
		$("#CONTAINER_TABLE_IMAGES").scrollTop(0);
		DISP_COUNT_STATUS();
	}
	function DISP_COUNT_STATUS() {
		$('.NAVER_IMAGE').on('click', function () {
			POPUP_SELECTED_IMAGE($(this));
		});
		_RS.COUNT_STATUS		= page_CURRENT * parseInt($('#IMAGES_PER_PAGE').html()) + "/" + $('#IMAGES_TOTAL').html();
		_RS.SCROLL_STATUS	= sprintf("%5.2f", $("#CONTAINER_TABLE_IMAGES").scrollTop() * 100 / $("#CONTAINER_TABLE_IMAGES").height()) + " %";
		_RS.$apply();
		
	}
	function POPUP_SELECTED_IMAGE(obj_IMAGE) {
		var JSON_ARGS = {
				SRC: obj_IMAGE.attr("src"),
				CAPTION: obj_IMAGE.attr("CAPTION")
			};
		
		var JSON_ARGS_BASE64 = Base64.encode(JSON.stringify(JSON_ARGS));
		QIIP_HTTP_ACCESS(
			$ionicPopup,{
				title:'안내',
				template: TO_TABLE_CENTER("선택하신 [" + obj_IMAGE.attr("CAPTION") + "]에 대한 인쇄설정 화면을 구성하고 있습니다.")
			},{
				"SERVER_URL" : API_SERVER_URL,
				"PARAMS" : [
					QIIP_APP_OBJ_KEY_VALUE("cmd", "api_GetPage"),
					QIIP_APP_OBJ_KEY_VALUE("FLDR_TEMPLATE", "IONIC/APPS/APP_PSAP/PAGES"),
					QIIP_APP_OBJ_KEY_VALUE("FILE_TEMPLATE", "POPUP_SELECTED_IMAGE.html"),
					QIIP_APP_OBJ_KEY_VALUE("XE_COMPILE", "NO"),
					QIIP_APP_OBJ_KEY_VALUE("JSON_ARGS_BASE64", JSON_ARGS_BASE64),
				]
			}, function (RESULT) {
				OBJ_POPUP = QIIP_JQX_POPUP_WINDOW({
		            showCollapseButton: true, 
		            height: '95%',
		            width: '90%',
		            minHeight: 100,
		            minWidth: 100,
					},
					JSON_ARGS.CAPTION,
					RESULT
				);
			  	INIT_WIDGETS_FOR_POPUP_SELECTED_IMAGE(OBJ_POPUP);
			}
		);
		
	}
	_RS.GET_PHONE_GALLERY_FOLDER_FILELIST = function () {
		var NATIVE_ACCESS_INFORMATION = {
				"REQUEST" : "GET_PHONE_GALLERY_FOLDER_FILELIST",
			};
		var result = JSON.parse(QIIP_APP_NATIVE_ACCESS(NATIVE_ACCESS_INFORMATION));
	}
var LOAD_CLOUD_PRINT_HELP_COMPLETED = false;
	function LOAD_CLOUD_PRINT_HELP() {
		if (LOAD_CLOUD_PRINT_HELP_COMPLETED) {
			NC(
				{
				  CMD: 'PAGE_SELECT',
				  PAGE_NO: 1,
				}
			);
		} else {
			NC(
				{
				  CMD: 'PAGE_REPLACE',
				  PAGE_NO: 1,
				  FLDR_TEMPLATE: 'IONIC/APPS/APP_PSAP/PAGES',
				  FILE_TEMPLATE: 'CLOUD_PRINT_HELP.html',
				  XE_COMPILE: 'NO',
				  SELECT_PAGE: false,
				},
				$ionicPopup,
				function(RESULT) {
					LOAD_CLOUD_PRINT_HELP_COMPLETED = true;
				}
			);
		}
	}
</script>
<div class="qiip_box">
	<div style="width:100%;height:5%;">
		<table>
			<col width="30%" />
			<col width="5%" />
			<col width="35%" />
			<col width="30%" />
			<tr>
				<td>
					<div class="button button-small button-positive" style="width:100%;" ng-click="REFRESH_ONLY_REALTIME_KEYWORDS()">
					키워드 갱신
					</div>
				</td>
				<td style="text-align:center;">
					<input type="checkbox" id="chk_VIEW_MODE" checked>
				</td>
				<td>
					<div style="width:100%;" id="SELECT_REALTIME_KEYWORDS"></div>
				</td>
				<td>
		          <div class="button button-small button-positive" style="width:100%;" ng-click="SEARCH_IMAGE_BY_INPUT()">
		            입력 & 검색
		          </div>
				</td>
			</tr>
		</table>
	</div>
	<div style="width:100%;height:5%;">
		<table>
			<col width="30%" />
			<col width="40%" />
			<col width="30%" />
			<tr>
				<td style="text-align:center;">
					{{SCROLL_STATUS}}
				</td>
				<td style="text-align:center;">
					{{COUNT_STATUS}}
				</td>
				<td>
		          <div class="button button-small button-positive" style="width:100%;" ng-click="GET_PHONE_GALLERY_FOLDER_FILELIST()">
		            폰 겔러리 목록 선택
		          </div>
				</td>
			</tr>
		</table>
	</div>
	<div style="width:100%;height:5%;">
		<table>
			<col width="25%" />
			<col width="75%" />
			<tr>
				<td style="text-align:center;">
					{{page_CURRENT_FOR_DISPLAY}}
				</td>
				<td style="text-align:center;">
					<div id='slider_PAGE' style="margin-left: 3%;"></div>
				</td>
			</tr>
		</table>
	</div>
	<div id="CONTAINER_TABLE_IMAGES" style="width:100%; height:85%; box-sizing:border-box; border: solid gray 1px; overflow-y: auto;">
		<table id="TABLE_IMAGES">
		</table>
	</div>
</div>