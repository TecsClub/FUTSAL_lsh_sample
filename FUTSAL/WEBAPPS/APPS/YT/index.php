<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width, height=device-height" />
		<title><?php echo $_REQUEST["APP_NAME"]; ?></title>

	    <!-- jquery script -->

		<script src="/WEBAPPS/LIBS/ESSENCE/jquery-3.5.1.min.js"></script>
		<link rel="stylesheet" href="/WEBAPPS/LIBS/ESSENCE/jquery-ui.css" />
		<script src="/WEBAPPS/LIBS/ESSENCE/jquery-ui.min.js"></script>

		<link rel="stylesheet" href="/WEBAPPS/LIBS/ESSENCE/bootstrap.min.css">
		<script src="/WEBAPPS/LIBS/ESSENCE/bootstrap.min.js"></script>
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />


		<script src="/WEBAPPS/LIBS/ESSENCE/angular.min.js"></script>
 		
		<!-- FOR PDF VIEWER -->
<!--
		<script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
		<script src="/WEBAPPS/LIBS/ESSENCE/pdf.js"></script>
-->




	    <link rel="stylesheet" href="/WEBAPPS/LIBS/JQWIDGET/jqwidgets/styles/jqx.base.css" type="text/css" />
	    <link rel="stylesheet" href="/WEBAPPS/LIBS/JQWIDGET/jqwidgets/styles/jqx.dark.css" type="text/css" />
	    <script type="text/javascript" src="/WEBAPPS/LIBS/JQWIDGET/jqwidgets/jqxcore.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/JQWIDGET/jqwidgets/jqxdata.js"></script> 
	    <script type="text/javascript" src="/WEBAPPS/LIBS/JQWIDGET/jqwidgets/jqxdata.export.js"></script> 
	    <script type="text/javascript" src="/WEBAPPS/LIBS/JQWIDGET/jqwidgets/jqxbuttons.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/JQWIDGET/jqwidgets/jqxscrollbar.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/JQWIDGET/jqwidgets/jqxmenu.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/JQWIDGET/jqwidgets/jqxgrid.js"></script>
	    <script type="text/javascript" src="/WEBAPPS/LIBS/JQWIDGET/jqwidgets/jqxgrid.edit.js"></script>  
	    <script type="text/javascript" src="/WEBAPPS/LIBS/JQWIDGET/jqwidgets/jqxgrid.selection.js"></script> 
	    <script type="text/javascript" src="/WEBAPPS/LIBS/JQWIDGET/jqwidgets/jqxgrid.columnsresize.js"></script> 
	    <script type="text/javascript" src="/WEBAPPS/LIBS/JQWIDGET/jqwidgets/jqxgrid.export.js"></script> 
	    <script type="text/javascript" src="/WEBAPPS/LIBS/JQWIDGET/scripts/demos.js"></script>			








	    <!-- lsy.utils script -->
	    <script src="/WEBAPPS/LIBS/LSY/QIIP.js"></script>

	    <script src="/WEBAPPS/LIBS/sprintf-js/src/sprintf.js"></script>
	    <script src="/WEBAPPS/LIBS/sprintf-js/src/angular-sprintf.js"></script>
	    <script src="/WEBAPPS/LIBS/formatDate.js"></script>
		<script src='https://www.youtube.com/iframe_api'></script>

		<script>
			var onYouTubeIframeAPIReady_flag = false;
		    function onYouTubeIframeAPIReady() {
				onYouTubeIframeAPIReady_flag = true;
		    }

			document.addEventListener("DOMContentLoaded", function(){
				QIIP_ANGULAR_INIT({
					ng_app: 'ANGULAR_WEBAPPS',
					ng_app_injects: [],
	//				ng_app_injects: ['ionic'],
					ng_controller: 'WEBAPPS_CONTROLLER',
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
