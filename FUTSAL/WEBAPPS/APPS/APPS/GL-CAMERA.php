#!/usr/bin/env php
<?php

	set_time_limit(0);
	error_reporting(0);
	date_default_timezone_set('Asia/Seoul');

	function remove_unicode_escape_sequence($string) {
		return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
		    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
		}, $string);
	}
	
class GL_CAMERA {
	var $CONFIG				= NULL;
	var $LOG_DIR			= "LOG";
	var $CAM_DIR			= "CAM";
	var $LOG_PREFIX			= "GL_CAMERA";
	var $TASK_MONITOR_EVERY	= 30; // Seconds

    function __construct() {
		$this->CONFIG = $this->F_GET_CONFIG();
    	if (isset($this->CONFIG->LOG_DIR)) {
    		$this->LOG_DIR = $this->CONFIG->LOG_DIR;
    	}
    	if (isset($this->CONFIG->CAM_DIR)) {
    		$this->CAM_DIR = $this->CONFIG->CAM_DIR;
    	}
    	if (isset($this->CONFIG->LOG_PREFIX)) {
    		$this->LOG_PREFIX = $this->CONFIG->LOG_PREFIX;
    	}
    }

	public function F_GET_CONFIG() {
		$CONFIG_FILE = dirname(__FILE__) . "/CONFIG.JSON";
		if (!file_exists($CONFIG_FILE)) {
			$this->LOG(sprintf("CONFIG_FILE [%s] IS NOT FOUND!" . PHP_EOL, $CONFIG_FILE));
			return NULL;
		}

		$JSON_CONFIG = json_decode(file_get_contents($CONFIG_FILE));
		if (!is_object($JSON_CONFIG)) {
			$this->LOG(sprintf("CONFIG_FILE [%s] IS IS CORRUPTED!" . PHP_EOL, $CONFIG_FILE));
			return NULL;
		}
		return $JSON_CONFIG;
	}	

	public function LOG($STR_LOG) {
		$LOG_FILE = sprintf(
			"%s/%s/%s/%s/%s_%s.LOG",
			dirname(__FILE__),
			$this->LOG_DIR,
			date("Y"),
			date("m"),
			$this->LOG_PREFIX,
			date("Y-m-d")
		);
		if(!file_exists($LOG_FILE)) mkdir(dirname($LOG_FILE),0777,true);
		
		$fp = fopen($LOG_FILE, 'a');
		fwrite($fp, sprintf("%s : %s : %s\n", date("Y-m-d H:i:s.").gettimeofday()["usec"], $this->CID, $STR_LOG));
		fclose($fp);
	}

	

	public function exec_ECHO($args) {
		echo remove_unicode_escape_sequence(json_encode($args, JSON_PRETTY_PRINT));
	}

	public function CAMERA_LOOP($JSON_CAMERA) {
//*
		while (true) {
//		for($i = 0; $i < 1; $i++) {
			$ONE_HOUR_BEFORE = strtotime('-1 hours', time());
			$LS_FILE_COMMAND = sprintf('ls %s/%s/%s*', dirname(__FILE__), $this->CAM_DIR, $JSON_CAMERA->TITLE);
			$arr_output_lines = array();
			$SHELL_RESULT  = exec($LS_FILE_COMMAND, $arr_output_lines);
			$EXEC_OUTPUT_TEXTS = implode("\n", $arr_output_lines);
			foreach($arr_output_lines as $ONE_FILE) {
				$STR_DATE_PART = substr(strstr($ONE_FILE, $JSON_CAMERA->TITLE), strlen($JSON_CAMERA->TITLE) + 1, -4);
//				$this->LOG(sprintf('CAMERA_LOOP STR_DATE_PART : %s', $STR_DATE_PART));
				$DATE_FROM_FILE = DateTime::createFromFormat('Y-m-d_H:i:s', $STR_DATE_PART);
//				$this->LOG(sprintf('CAMERA_LOOP DATE_FROM_FILE : %s', $DATE_FROM_FILE->format('Y-m-d H:i:s')));
//				$this->LOG(sprintf('%d vs %d', $DATE_FROM_FILE->getTimestamp(), $ONE_HOUR_BEFORE));
				if ($DATE_FROM_FILE->getTimestamp() < $ONE_HOUR_BEFORE) {
					$this->LOG(sprintf('UNLINK %s', $ONE_FILE));
					unlink($ONE_FILE);
				}
			}
			$CAM_FILE = sprintf('%s/%s/%s_%s.mp4', dirname(__FILE__), $this->CAM_DIR, $JSON_CAMERA->TITLE, date('Y-m-d_H:i:s'));
			if(!file_exists($CAM_FILE)) mkdir(dirname($CAM_FILE),0777,true);
			$SHELL_COMMAND = sprintf(
				'ffmpeg -i %s -t %d -preset ultrafast -threads 0 -acodec copy -vcodec libx264 -loglevel error %s', 
				$JSON_CAMERA->URL,
				$JSON_CAMERA->DURATION,
				$CAM_FILE
			);
			$this->LOG(sprintf('CAMERA_LOOP : %s', $SHELL_COMMAND));
			$SHELL_RESULT  = exec($SHELL_COMMAND);
		}
//*/
	}
	

	public function DO_JOB_OLD($argc, $argv) {
//		$this->LOG(sprintf('DO_JOB : %d %s', $argc, json_encode($argv, JSON_PRETTY_PRINT)));
		if ($argc > 1) {
			$TEMP_FILENAME = $argv[1];
			if (file_exists($TEMP_FILENAME)) {
				$args = json_decode(file_get_contents($TEMP_FILENAME));
			//	echo '<xmp>' . print_r($args, true) . '</xmp>';
				if ($args->REQ == "exec_DUMMY") {
				} else if ($args->REQ == "exec_ECHO") {
					$this->exec_ECHO($args);
				}
				unlink($TEMP_FILENAME);
			} else {
				$STR_MSG = sprintf("File %s Not Exists!", $TEMP_FILENAME);
				echo $STR_MSG . "\n";
				$this->LOG($STR_MSG);
			}
		} else {
			$STR_MSG = sprintf("Usage: %s '<filename.json>'", $argv[0]);
			echo $STR_MSG . "\n";
			$this->LOG($STR_MSG);
		}
		
	}

	function CHECK_ALIVE($url, $timeout = 10, $successOn = array(200, 301, 400)) {
		$ch = curl_init($url);

		// Set request options
		curl_setopt_array($ch, array(
			CURLOPT_FOLLOWLOCATION => false,
			CURLOPT_NOBODY => true,
			CURLOPT_TIMEOUT => $timeout,
			CURLOPT_USERAGENT => "CHECK_ALIVE_PAGE/1.0"
		));

		// Execute request
		curl_exec($ch);

		// Check if an error occurred
		if(curl_errno($ch)) {
			curl_close($ch);
			return false;
		}

		// Get HTTP response code
		$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		// Page is alive if 200 OK is received
		//return $code;
//		$this->LOG(sprintf('HTTP CODE = %d', $code));
		return in_array( $code, $successOn );
	}
	
	public function TASK_MONITOR() {
		while (true) {
			foreach($this->CONFIG->GreenLine_CAMS as $ONE_CAM) {
				$PS_COMMAND = sprintf('ps -ef | grep ffmpeg | grep %s', $ONE_CAM->TITLE);
				$arr_output_lines = array();
				$SHELL_RESULT  = exec($PS_COMMAND, $arr_output_lines);
				$EXEC_OUTPUT_TEXTS = implode("\n", $arr_output_lines);
				foreach($arr_output_lines as $ONE_LINE) {
					if (strpos($ONE_LINE, '-i') !== false) {
						if ($this->CHECK_ALIVE($ONE_CAM->URL)) {
							$this->LOG(sprintf('%s IS ALIVE : %s', $ONE_CAM->URL, $ONE_LINE));
						} else {
							$this->LOG(sprintf('%s IS DEAD  : %s', $ONE_CAM->URL, $ONE_LINE));
							$ARRAY_ONE_LINE =  preg_split('/\s+/', $ONE_LINE);
							$KILL_COMMAND = sprintf('kill -9 %s', $ARRAY_ONE_LINE[1]);
							$this->LOG(sprintf('KILL_COMMAND : %s', $KILL_COMMAND));
							$SHELL_RESULT  = exec($KILL_COMMAND, $arr_output_lines);
						}
					}
				}
			}
			sleep($this->TASK_MONITOR_EVERY);
		}
	}

	public function TASK_ASSIGN() {
		foreach($this->CONFIG->GreenLine_CAMS as $ONE_CAM) {
			$SHELL_COMMAND = sprintf('%s %s > /dev/null &', __FILE__, $ONE_CAM->TITLE );
			$SHELL_RESULT  = exec($SHELL_COMMAND);
		}
		$SHELL_COMMAND = sprintf('%s %s > /dev/null &', __FILE__, 'TASK_MONITOR' );
		$SHELL_RESULT  = exec($SHELL_COMMAND);
	}
	

	public function DO_JOB($argc, $argv) {
//		$this->LOG(sprintf('DO_JOB : %d %s', $argc, json_encode($argv, JSON_PRETTY_PRINT)));
		if ($argc > 1) {
			if ($argv[1] == 'TASK_MONITOR') {
				$this->TASK_MONITOR();
			} else {
				foreach($this->CONFIG->GreenLine_CAMS as $ONE_CAM) {
					if ($ONE_CAM->TITLE == $argv[1]) {
						$this->CAMERA_LOOP($ONE_CAM);
					}
				}
			}
		} else {
			$this->TASK_ASSIGN();
		}
		
	}
	
};

$GLC = new GL_CAMERA(); $GLC->DO_JOB($argc, $argv);

?>
