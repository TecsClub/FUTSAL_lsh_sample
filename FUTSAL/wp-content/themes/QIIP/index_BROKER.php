<?php
	$THIS_SERVER_URL = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"];
?>			
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width, height=device-height" />
		<title><?php bloginfo('name'); ?> <?php wp_title('|'); ?></title>

	    <!-- jquery script -->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" crossorigin="anonymous">
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

	    <!-- BOOTSTRAP CSS -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<link rel="stylesheet" href="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/COMMONS/WAE/main.css">
		<script src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/COMMONS/WAE/NAUTES_SoundVisualizer.js"></script>

	    <!-- ionic script -->
	    <link href="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/ionic/css/ionic.css" rel="stylesheet">
	    <!-- ionic/angularjs js -->
	    <script src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/ionic/js/ionic.bundle.js"></script>
	    <script src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/ionic/js/angular/angular-resource.min.js"></script>

	    <!-- jqwidgets script -->
	    <link rel="stylesheet" href="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/styles/jqx.base.css" type="text/css" />
	    <link rel="stylesheet" href="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/styles/jqx.android.css" type="text/css" />
	    <link rel="stylesheet" href="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/styles/jqx.mobile.css" type="text/css" />

	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxcore.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxdata.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxbuttons.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxscrollbar.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxlistbox.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxdropdownlist.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxcheckbox.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxslider.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxprogressbar.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxmenu.js"></script>

	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxwindow.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxpanel.js"></script>

	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxdatetimeinput.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxcalendar.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxtooltip.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/globalization/globalize.js"></script>

	    <!-- lsy.utils script -->
	    <link href="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/LSY/QIIP.css" rel="stylesheet">
	    <script src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/LSY/QIIP.js"></script>

		<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">

	    <script src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/sprintf-js/src/sprintf.js"></script>
	    <script src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/sprintf-js/src/angular-sprintf.js"></script>
	    <script src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/dateformat.js"></script>

		<script>

			QIIP_ANGULAR_INIT({
				ng_app: 'ANGULAR_WEBAPPS',
				ng_app_injects: ['ionic'],
				ng_controller: 'WEBAPPS_CONTROLLER'
			});

			$(document).ready(function() {
<?php
if (isset($_REQUEST['SELECT'])) {
	echo "_RS.PHONE_INFO = {";
	echo "	APP_NAME: '" . $_REQUEST['SELECT'] . "',";
	echo "	PHONE_ID: 'NOT_GRANTED',";
	echo "	PHONE_NO: 'NOT_GRANTED'";
	echo "};";
} else {
	echo "_RS.PHONE_INFO = {";
	echo "	APP_NAME: 'COMMISSION',";
	echo "	PHONE_ID: 'NOT_GRANTED',";
	echo "	PHONE_NO: 'NOT_GRANTED'";
	echo "};";
}
?>			
				QIIP_APP_INIT();
			});
			
		</script>

	</head>
	<body <?php body_class(); ?> ng-app="ANGULAR_WEBAPPS" ng-controller="WEBAPPS_CONTROLLER"> 
		<div class="qiip_index" id="APP_CONTENTS">

<?php
	echo "<xmp>" . print_r($THIS_SERVER_URL, true) . "</xmp>";
?>			

		</div>
	</body>
</html>
