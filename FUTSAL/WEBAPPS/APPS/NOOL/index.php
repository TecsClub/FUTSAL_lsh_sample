<?php
	$STR_PORT = ":" . $_SERVER["SERVER_PORT"];
	if ($STR_PORT == 80) $STR_PORT = "";
	if (isset($_SERVER["REQUEST_SCHEME"])) {
		$THIS_SERVER_URL = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"] . $STR_PORT . "/";
	} else {
		$THIS_SERVER_URL = "http://" . $_SERVER["SERVER_NAME"] . $STR_PORT . "/";
	}
//	echo "<xmp>" . print_r($_SERVER, true) . "</xmp>";
?>			
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width, height=device-height" />
		<title>TITLE</title>

	    <!-- jquery script -->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" crossorigin="anonymous">
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

	    <!-- Bootstrap CSS CDN -->
	    <script src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/js/bootstrap.min.js"></script>
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	    <!-- Popper.JS -->
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	    <!-- Our Custom CSS -->
	    <link rel="stylesheet" href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/style_bt_sidemenu.css">

	    <!-- Font Awesome JS -->
	    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
	    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>



 		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>

	    <!-- jqwidgets script -->
	    <link rel="stylesheet" href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/styles/jqx.base.css" type="text/css" />
	    <link rel="stylesheet" href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/styles/jqx.android.css" type="text/css" />
	    <link rel="stylesheet" href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/styles/jqx.mobile.css" type="text/css" />

	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxcore.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxdata.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxbuttons.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxscrollbar.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxlistbox.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxdropdownlist.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxcheckbox.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxslider.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxprogressbar.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxmenu.js"></script>

	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxwindow.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxpanel.js"></script>

	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxdatetimeinput.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxcalendar.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxtooltip.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/globalization/globalize.js"></script>

	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxdraw.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxchart.core.js"></script>

	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.sort.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.pager.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.selection.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.edit.js"></script>

	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/jqw/jqwidgets/jqxmaskedinput.js"></script>
    
	    <!-- lsy.utils script -->
	    <link href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/LSY/QIIP.css" rel="stylesheet">
	    <script src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/LSY/QIIP.js"></script>
	    
	    
	    <!-- dh -->
		<!-- 캘린더 -->
   
	    <link href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/css/plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
	    <link href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

	    <!-- Data picker -->
	    <script src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>

	    <!-- Color picker -->
	    <script src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

	    <!-- Image cropper -->
	    <script src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/js/plugins/cropper/cropper.min.js"></script>


		<link href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/css/loading.css" rel="stylesheet">
		<link href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/css/loading2.css" rel="stylesheet">
		<link href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/css/popup_style.css" rel="stylesheet">
		<link href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/css/join.css" rel="stylesheet">
		<link href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/css/info_data.css" rel="stylesheet">
		<link href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/css/info_data_popup.css" rel="stylesheet">
		
		<!-- 컨텐츠 css -->
		<link href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/css/APP_CONTENTS_HEADER.css" rel="stylesheet">
		<link href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/css/APP_CONTENTS_LEFTCON.css" rel="stylesheet">
		<link href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/css/APP_CONTENTS_RIGHTCON1.css" rel="stylesheet">
		<link href="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/APPS/NOOL/assets/css/APP_CONTENTS_RIGHTCON2.css" rel="stylesheet">
		
	    <script src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/sprintf-js/src/sprintf.js"></script>
	    <script src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/sprintf-js/src/angular-sprintf.js"></script>
	    <script src="<?php echo $THIS_SERVER_URL; ?>WEBAPPS/LIBS/dateformat.js"></script>




		<script>

			QIIP_ANGULAR_INIT({
				ng_app: 'ANGULAR_WEBAPPS',
				ng_app_injects: [],
//				ng_app_injects: ['ionic'],
				ng_controller: 'WEBAPPS_CONTROLLER'
			});

			$(document).ready(function() {
<?php
	echo "_RS.PHONE_INFO = {";
	echo "	APP_NAME: 'NOOL',";
	echo "	PHONE_ID: 'NOT_GRANTED',";
	echo "	PHONE_NO: 'NOT_GRANTED'";
	echo "};";
?>			
				QIIP_APP_INIT();
			});
			
		</script>

	</head>
	<body ng-app="ANGULAR_WEBAPPS" ng-controller="WEBAPPS_CONTROLLER" id="APP_CONTENTS"> 

<?php
//	echo "<xmp>" . print_r($THIS_SERVER_URL, true) . "</xmp>";
?>			

	</body>
</html>
