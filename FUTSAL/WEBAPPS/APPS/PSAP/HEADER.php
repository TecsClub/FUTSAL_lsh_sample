<?php
//	error_log("_SERVER => " . print_r($_SERVER, true));
	if (isset($_SERVER["HTTP_REFERER"])) {
		$INDEX_QUESTION = strpos($_SERVER["HTTP_REFERER"], "?");
		if ($INDEX_QUESTION > 0) {
			$THIS_SERVER_URL = substr($_SERVER["HTTP_REFERER"], 0, $INDEX_QUESTION);
		} else {
			$THIS_SERVER_URL = $_SERVER["HTTP_REFERER"];
		}
	} else {
		if (strpos($_SERVER["SERVER_PROTOCOL"], "HTTPS")) {
			$THIS_SERVER_URL = "https://" . $_SERVER['SERVER_NAME'];
		} else {
			$THIS_SERVER_URL = "http://" . $_SERVER['SERVER_NAME'];
		}
	}
?>			

		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" crossorigin="anonymous">
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

		<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.panzoom/3.2.3/jquery.panzoom.min.js'></script>

		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByu33EoRTNazD2DVCS4jSoVhtUqNxWovo&region=KR&libraries=places"></script>
 		
	    <!-- ionic script -->
	    <link href="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/ionic/css/ionic.min.css" rel="stylesheet">
	    <!-- ionic/angularjs js -->
	    <script src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/ionic/js/ionic.bundle.js"></script>
	    <script src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/ionic/js/angular/angular-resource.min.js"></script>

	    <!-- lsy.utils script -->
	    <link href="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/LSY/QIIP.css" rel="stylesheet">
	    <script src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/LSY/QIIP.js"></script>

	    <script src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/sprintf-js/src/sprintf.js"></script>
	    <script src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/sprintf-js/src/angular-sprintf.js"></script>
	    <script src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/dateformat.js"></script>


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

	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxdraw.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxchart.core.js"></script>

	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.sort.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.pager.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.selection.js"></script>
	    <script type="text/javascript" src="<?php echo $THIS_SERVER_URL; ?>/WEBAPPS/LIBS/jqw/jqwidgets/jqxgrid.edit.js"></script>
    
