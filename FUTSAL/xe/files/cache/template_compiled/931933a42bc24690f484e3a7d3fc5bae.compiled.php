<?php if(!defined("__XE__"))exit;?><script>
	function INIT_WIDGETS_FOR_DIV_HEADER() {
		if (!USER_DATA.allcaps.level_1) {
			$('#BTN_SHOW_OTHERS').css('display','none');
		}
	
		$(".BTN_CLASS_HEADER").on('click', function () {
			var ID = $(this).attr('ID');
			if (ID == 'DUMMY') {
			} else if (ID == 'BTN_LOGOUT') {
				QIIP_APP_LOGOUT();
			} else if (ID == 'BTN_SHOW_RESULT') {
			} else if (ID == 'BTN_SHOW_OTHERS') {
				QIIP_API_ACCESS({
					REQ: 'api_GET_PAGE',
					FLDR_TEMPLATE: _FLDR_TEMPLATE,
					FILE_TEMPLATE: 'PAGES/POPUP_USER_SELECT.html',
				},function(STR_RESULT) {
					var HTML_COMPILED = QIIP_STATIC_HTML(ALL_USER_DATA, STR_RESULT);
					var OBJ_POPUP_FOR_ALERT = QIIP_JQX_POPUP_WINDOW({
			            showCollapseButton: true, 
			            height: '13.5%',
	            		width: '20%',
			            minHeight: 100,
			            minWidth: 100,
						},
						'사용자 선택',
						HTML_COMPILED
					);
					_RS.$apply();
					INIT_WIDGETS_FOR_POPUP_USER_SELECT(OBJ_POPUP_FOR_ALERT);
				});
			}
		});
		
		/* 자료단위 */
		/* var source = [
            { DATA_UNIT: 'BY_DATE', html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'><strong style='font-weight: 900;color: #ff7e00; font-size: 15px; width: 30%; display: inline-block; text-align: center;'>D </strong>일별선택</span></div>", title: '일별선택' },
            { DATA_UNIT: 'BY_WEEK', html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'><strong style='font-weight: 900;color: #ff7e00; font-size: 15px; width: 30%; display: inline-block; text-align: center;'>W </strong>주별선택</span></div>", title: '주별선택' },
            { DATA_UNIT: 'BY_MONTH', html: "<div style='height: 20px; float: left;'><span style='float: left; font-size: 13px; font-family: Verdana Arial; color: #333;'><strong style='font-weight: 900;color: #ff7e00; font-size: 15px; width: 30%; display: inline-block; text-align: center;'>M </strong>월별선택</span></div>", title: '월별선택' }
        ];
        // Create a jqxDropDownList
        $("#jqxWidget_library_unit").jqxDropDownList({
        	source: source, selectedIndex: 0, width: '70%', height: '30px', dropDownHeight: '99px'
        	
        }).on('change', function (event) {     
        	UPDATE_ALL_VIEWS();
		});
		*/
		/* 자료범위 */
		// create jqxcalendar.
        $("#jqxWidget_library_range").jqxDateTimeInput({
        	width: '50%', height: '35px',  selectionMode: 'range',
        	formatString: 'yyyy-MM-dd'
        }).on('change', function (event) {
        	UPDATE_ALL_VIEWS();
        });
         
        var date1 = new Date();
        var date2 = new Date();
        $("#jqxWidget_library_range").jqxDateTimeInput('setRange', date1, date2);
        
	
		
	}
	
	function UPDATE_ALL_VIEWS() {
		var DATA_UNIT = $("#jqxWidget_library_unit").jqxDropDownList('getSelectedItem'); 
        var DATE_RANGE = $("#jqxWidget_library_range").jqxDateTimeInput('getText');
        var DATE_FROM =  DATE_RANGE.substring(0,10);
        var DATE_TO =  DATE_RANGE.substring(13);
        var SELECTED_DATA = {
        	DATA_UNIT: DATA_UNIT.originalItem.DATA_UNIT,
        	DATE_FROM: DATE_RANGE.substring(0,10),
        	DATE_TO: DATE_RANGE.substring(13)
        }
		QIIP_API_ACCESS({
				REQ: 'api_GET_PAGE',
				FLDR_TEMPLATE: _FLDR_TEMPLATE,
				FILE_TEMPLATE: 'PAGES/APP_CONTENTS_LEFTCON.html',
				TTT: SELECTED_DATA
			},function(STR_RESULT) {
				USER_DATA.SELECTED_DATA = STR_RESULT;
				LOAD_ALL_CONTENTS();
			}
		);
//		alert(JSON.stringify(SELECTED_DATA, null, '\t'));
	}
	
</script>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">NOOL <em>HEALTH </em><small>모션 캡쳐 재활치료 시스템</small></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <div class="nav navbar-nav">
                <span class="block m-t-xs"> <strong class="font-bold">{{JSON_ARGS.data.META.NOOL_NAME[0]}}</strong><small>님 환영합니다.</small></span>
            </div>
            <div class="nav navbar_middle">
            <!--<div class="select1" style="width:49%;">	
	            	<h3>자료단위</h3>
	            	<div id='jqxWidget_library_unit'></div>
            	</div> -->
            	<div class="select2"  style="width: 100%;">
	            	<h3>자료범위</h3>
	            	<div id='jqxWidget_library_range'></div>
	            </div>
            </div>
            <div class="nav navbar-nav navbar-right">
                <button type="button" class="logout_btn BTN_CLASS_HEADER" id="BTN_LOGOUT">
                	<i class="fas fa-sign-out-alt"></i> 로그아웃</button>
                <div class="btn-group btn-group-lg" role="group" aria-label="button">
                  	<button type="button" class="btn btn-default BTN_CLASS_HEADER" id="BTN_SHOW_OTHERS">타사용자 보기</button>
                </div>
            </div>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>