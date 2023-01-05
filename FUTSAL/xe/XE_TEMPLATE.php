<?php
/* Copyright (C) NAVER <http://www.navercorp.com> */
/**
 * @file  index.php
 * @author NAVER (developers@xpressengine.com)
 * @brief Start page
 *
 * @mainpage XpressEngine
 * @section intro introduction
 *
 * "XpressEngine (XE)" is an opensource and being developed in the opensource project.\n
 * For more information, please see the link below.
 * - Official website: http://www.xpressengine.com
 * - Offcial Repository: https://github.com/xpressengine/xe-core
 * \n
 * "XpressEngine (XE)" is free software; you can redistribute it and/or \n
 * modify it under the terms of the GNU Lesser General Public \n
 * License as published by the Free Software Foundation; either \n
 * version 2.1 of the License, or (at your option) any later version. \n
 * \n
 * This software is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * \n
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 **/

/**
 * @brief Declare constants for generic use and for checking to avoid a direct call from the Web
 **/
define('__XE__',   TRUE);
/**
 * @brief Include the necessary configuration files
 **/
require dirname(__FILE__) . '/config/config.inc.php';
//require dirname(__FILE__) . '/classes/context/context/Context.class.php';
//require dirname(__FILE__) . '/classes/context/template/TemplateHandler.class.php';

function ext_func_HTML_TEMPLATE_COMPILE($argsPARAM) {
	$args = clone $argsPARAM;
	if (isset($args->TEMPLATE_FILE_PATH)) {
		$JSON_ARGS = json_decode($args->STR_JSON_ARGS);
		if (is_object($JSON_ARGS)) {
			Context::set('ARGS', $JSON_ARGS);
			$oTemplate = &TemplateHandler::getInstance();
			$result = $oTemplate->compile(dirname($args->TEMPLATE_FILE_PATH), basename($args->TEMPLATE_FILE_PATH));;
//debugPrint(print_r($result, true));
			echo $result;
		}
	}
}

/**
 * @brief Initialize by creating Context object
 * Set all Request Argument/Environment variables
 **/
$oContext = Context::getInstance();
$oContext->init();

	$TEMP_FILENAME = $argv[1];
	$args = json_decode(file_get_contents($TEMP_FILENAME));
//	echo '<xmp>' . print_r($args, true) . '</xmp>';
	if ($args->cmd == "xe_DUMMY") {
	} else if ($args->cmd == "xe_HTML_TEMPLATE_COMPILE") {
		ext_func_HTML_TEMPLATE_COMPILE($args);
	}
	unlink($TEMP_FILENAME);

$oContext->close();


/* End of file index.php */
/* Location: ./index.php */
