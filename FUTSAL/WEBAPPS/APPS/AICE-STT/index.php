<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width, height=device-height" />
		<title><?php echo $_REQUEST["APP_NAME"]; ?></title>

	    <!-- jquery script -->

		<script src="/WEBAPPS/LIBS/ESSENCE/jquery-3.5.1.min.js"></script>
		<link rel="stylesheet" href="/WEBAPPS/LIBS/ESSENCE/jquery-ui.css" />
		<script src="/WEBAPPS/LIBS/ESSENCE/jquery-ui.min.js"></script>

<!--
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
-->

		<link rel="stylesheet" href="/WEBAPPS/LIBS/ESSENCE/bootstrap.min.css">
		<script src="/WEBAPPS/LIBS/ESSENCE/bootstrap.min.js"></script>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />

		<link rel="stylesheet" href="/WEBAPPS/COMMONS/WAE/main.css">
		<script src="/WEBAPPS/COMMONS/WAE/NAUTES_SoundVisualizer.js"></script>




<!--
 		<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.0/angular.min.js"></script>
-->
 		<script src="/WEBAPPS/LIBS/ESSENCE/angular.min.js"></script>
 		
		<!-- FOR PDF VIEWER -->
<!--
		<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
		<script src="/WEBAPPS/LIBS/ESSENCE/pdf.js"></script>
-->

	    <!-- jqwidgets script -->
	    <link rel="stylesheet" href="/WEBAPPS/LIBS/jqw/jqwidgets/styles/jqx.base.css" type="text/css" />
	    <link rel="stylesheet" href="/WEBAPPS/LIBS/jqw/jqwidgets/styles/jqx.android.css" type="text/css" />
	    <link rel="stylesheet" href="/WEBAPPS/LIBS/jqw/jqwidgets/styles/jqx.mobile.css" type="text/css" />

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxcore.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxdata.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxbuttons.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxscrollbar.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxlistbox.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxdropdownlist.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxcheckbox.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxslider.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxprogressbar.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxmenu.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxwindow.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxpanel.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxdatetimeinput.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxcalendar.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxtooltip.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/globalization/globalize.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxdraw.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxchart.core.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.sort.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.pager.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.selection.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.edit.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxradiobutton.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxtabs.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxtextarea.js"></script>

	    <script type="text/javascript" src="/WEBAPPS/LIBS/jqw/jqwidgets/jqxswitchbutton.js"></script>
	    

	    <!-- lsy.utils script -->
	    <link rel="stylesheet" href="/WEBAPPS/LIBS/LSY/QIIP.css" type="text/css" />
	    <script src="/WEBAPPS/LIBS/LSY/QIIP.js"></script>

	    <script src="/WEBAPPS/LIBS/sprintf-js/src/sprintf.js"></script>
	    <script src="/WEBAPPS/LIBS/sprintf-js/src/angular-sprintf.js"></script>
	    <script src="/WEBAPPS/LIBS/formatDate.js"></script>

		<script>

			function VIEW_MAIN_FINISH() {
				QIIP_APP_ALERT({
					TITLE: _RS.PHONE_INFO.APP_NAME + ' ?????? ??????!',
					MESSAGES: [
						_RS.PHONE_INFO.APP_NAME + ' ??? ?????? ???????????????????'
					],
					FILE_TEMPLATE: 'POPUP/YES_NO.html',
				},function () {
					QIIP_FX_NATIVE_ACCESS({
		    			REQUEST	: "SYSTEM_EXIT",
		    		},function (STR_RESULT) {
					});
				}, function () {
				});
			}
			
			document.addEventListener("DOMContentLoaded", function(){
				QIIP_ANGULAR_INIT({
					ng_app: 'ANGULAR_WEBAPPS',
					ng_app_injects: [],
	//				ng_app_injects: ['ionic'],
					ng_controller: 'WEBAPPS_CONTROLLER',
					FORCE_WEB: true,
					PHONE_INFO: {
						APP_NAME: '<?php echo $_REQUEST["APP_NAME"]; ?>',
						PHONE_ID: 'NOT_GRANTED',
						PHONE_NO: 'NOT_GRANTED'
					}
				});
			});

//			$(document).ready(function() {
//			});

		</script>

	</head>
	<body ng-app="ANGULAR_WEBAPPS" ng-controller="WEBAPPS_CONTROLLER" id="APP_CONTENTS"> 
	</body>
</html>
