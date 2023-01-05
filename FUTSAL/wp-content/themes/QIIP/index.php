<?php $PAGE_RE_DIRECT = 'WEBAPPS/APPS'; ?>
<?php
	$APP_BRANCH = '';
	if (isset($_REQUEST['SELECT'])) {
		$APP_BRANCH = $_REQUEST['SELECT'];
	} else if (isset($_REQUEST['S'])) {
		$APP_BRANCH = $_REQUEST['S'];
	} else if (isset($_REQUEST['s'])) {
		$APP_BRANCH = $_REQUEST['s'];
	} else {
//		$APP_BRANCH = 'APPS';
		$APP_BRANCH = 'FS';
	}

//	error_log('LSY => ' . print_r($_REQUEST, true));

	$GET_ARGS = '';
	foreach ($_REQUEST as $ONE_KEY => $ONE_VAL) {
//		error_log(sprintf('%s => %s', $ONE_KEY, $ONE_VAL));
		$GET_ARGS .= sprintf('&%s=%s', $ONE_KEY, $ONE_VAL);
	}
	
	if (strlen($APP_BRANCH) > 0) {
		$PAGE_RE_DIRECT .= "/" . $APP_BRANCH . "?APP_NAME=" . $APP_BRANCH;
		if (strlen($GET_ARGS) > 0) $PAGE_RE_DIRECT .= $GET_ARGS;
?>
		<meta http-equiv="refresh" content="0; url=<?php echo $PAGE_RE_DIRECT; ?>" />
<?php
	} else {
		$URL = $_SERVER['REQUEST_SCHEME'] . "://";
		$URL .= $_SERVER['SERVER_NAME'];
		if ($_SERVER['SERVER_PORT'] != '80') {
			$URL .= $_SERVER['SERVER_PORT'];
		}
//		$URL .= $_SERVER['REQUEST_URI'];
//	echo "<xmp>" . json_encode($_SERVER, JSON_PRETTY_PRINT) . "</xmp>" . "<br/>";
?>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width, height=device-height" />

	<style>
	body						{margin:0; padding:0;}
	.qiip_index 				{width:100%; height:100%;}
	.qiip_index table			{width:100%; height:100%; font-size:100%; border-collapse: separate; border-spacing: 1px; line-height: 100%;}
	.qiip_index table th		{text-decoration:bold; text-align: center; white-space:normal; vertical-align: middle; word-break:break-all; background:#bbb;}
	.qiip_index table td		{text-decoration:none; text-align: left;   white-space:normal; vertical-align: middle;word-break:break-all; background:#ddd;}
	</style>
</head>
<body>
<div class="qiip_index">
	<table>
		<tr>
			<th>
				접속방법
			</th>
		</tr>
		<tr>
			<td>
				<?php echo $URL . "?S=APP_BRANCH"; ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $URL . "?s=APP_BRANCH"; ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $URL . "?SELECT=APP_BRANCH"; ?>
			</td>
		</tr>
	</table>
</div>
</body>
<?php
	}
?>
