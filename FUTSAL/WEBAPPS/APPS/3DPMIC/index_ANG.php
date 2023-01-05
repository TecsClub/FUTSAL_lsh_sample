<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width, height=device-height" />
		<title><?php echo $APP_NAME; ?></title>

	    <!-- jquery script -->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" crossorigin="anonymous">
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

 		<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.0/angular.min.js"></script>
 		
<style>
*{
	box-sizing: border-box;
}
QIIP_MENU {
	position:fixed;
	top: 0px;
	left: 0px;
	height:70px;
	width:100%;
	background:#eee;
	transition: all 1s;


}
QIIP_MENU DIV_LEFT {
	height:100%;
	width:10%;
	background:#0ee;
	float:left;
	text-align: center;
	font-size: 44px;
	line-height: 70px;
}

QIIP_MENU  DIV_CENTER{
position: absolute;
left: 10%;
right: 10%;
	
}
QIIP_MENU DIV_RIGHT {
	height:100%;
	width:10%;
	background:#0ee;
	float:right;
	text-align: center;
	font-size: 38px;
	line-height: 70px;
}

QIIP_MENU MENU_1ST_TEXT {
	float: left;
	position: relative;
}

QIIP_MENU MENU_1ST_TEXT:first-child:nth-last-child(1) {
	width: 100%;
}

QIIP_MENU MENU_1ST_TEXT:first-child:nth-last-child(2),  QIIP_MENU MENU_1ST_TEXT:first-child:nth-last-child(2) ~ MENU_1ST_TEXT {
	width: 50%;
}

QIIP_MENU MENU_1ST_TEXT:first-child:nth-last-child(3),  QIIP_MENU MENU_1ST_TEXT:first-child:nth-last-child(3) ~ MENU_1ST_TEXT {
	width: 33.33%;
}

QIIP_MENU MENU_1ST_TEXT:first-child:nth-last-child(4),  QIIP_MENU MENU_1ST_TEXT:first-child:nth-last-child(4) ~ MENU_1ST_TEXT {
	width: 25%;
}

QIIP_MENU MENU_1ST_TEXT:first-child:nth-last-child(5),  QIIP_MENU MENU_1ST_TEXT:first-child:nth-last-child(5) ~ MENU_1ST_TEXT {
	width: 20%;
}

QIIP_MENU MENU_1ST_TEXT:first-child:nth-last-child(6),  QIIP_MENU MENU_1ST_TEXT:first-child:nth-last-child(6) ~ MENU_1ST_TEXT {
	width: 16.66%;
}

QIIP_MENU MENU_1ST_TEXT:first-child:nth-last-child(7),  QIIP_MENU MENU_1ST_TEXT:first-child:nth-last-child(7) ~ MENU_1ST_TEXT {
	width: 14.285%;
}

QIIP_MENU MENU_1ST_TEXT {
	display: inline-block;
	text-align: center;
	font-size: 22px;
	line-height: 70px;

	color: rgba(255,255,255,0.85);
	text-decoration: none;
	display: block;
	border-left: 1px solid rgba(0,0,0,0.15);
	border-right: 1px solid rgba(0,0,0,0.15);
	border-bottom: 1px solid rgba(0,0,0,0.15);
	text-shadow: 1px 1px 1px rgba(0,0,0,0.2);
}
QIIP_MENU MENU_3RD_TEXT{
	display: block;
}
QIIP_MENU MENU_2ND_TEXT{
	display: block;
}
QIIP_MENU MENU_1ST_SUB{
	display: block;
	background-color: #eee;
 	max-height: 0;
    transition: max-height 0.26s ease-out;
    overflow: hidden;
    background: #d5d5d5;
    display: block;
}

QIIP_MENU MENU_1ST_TEXT:hover MENU_1ST_SUB{
max-height: 1000px;
    transition: max-height 0.26s ease-in;
}
QIIP_MENU MENU_2ND_SUB{
	max-height: 0;
    transition: max-height 0.26s ease-out;
    overflow: hidden;
    background: #d5d5d5;
    display: block;
}
QIIP_MENU MENU_2ND_TEXT:hover MENU_2ND_SUB{
	max-height: 1000px;
    transition: max-height 0.26s ease-in;
}
</style>

		<script>
			var ANGULAR_WEBAPPS;
			var _RS = {};
			var _AC = {};
			var _FT = {};

			document.addEventListener("DOMContentLoaded", function(){
				var ANGULAR_WEBAPPS = angular.module('ANGULAR_WEBAPPS', []);
				ANGULAR_WEBAPPS.controller('WEBAPPS_CONTROLLER', function ($scope, $compile, $filter) {
					_RS = $scope;
					_AC = $compile;
					_FT = $filter;
					
					SAVE_DATA();
				});
			});
			
			function SAVE_DATA() {
				_RS.JSON_ARGS = [
				{
					"MENU_TEXT" : "Menu_A",
					"MENU_SUB" : [
						{
							"MENU_TEXT" : "Menu_A_A"
						},
						{
							"MENU_TEXT" : "Menu_A_B",
							"MENU_SUB" : [
								{
									"MENU_TEXT" : "Menu_A_B_A",
									"MENU_SUB" : [
										{
											"MENU_TEXT" : "Menu_A_B_A_A"
										},
										{
											"MENU_TEXT" : "Menu_A_B_A_B"
										}
									]
								},
								{
									"MENU_TEXT" : "Menu_A_B_B"
								},
								{
									"MENU_TEXT" : "Menu_A_B_C"
								},
								{
									"MENU_TEXT" : "Menu_A_B_D"
								}
							]
						},
						{
							"MENU_TEXT" : "Menu_A_C"
						},
						{
							"MENU_TEXT" : "Menu_A_D"
						}
					]
				},
				{
					"MENU_TEXT" : "Menu_B",
					"MENU_SUB" : [
						{
							"MENU_TEXT" : "Menu_B_A"
						},
						{
							"MENU_TEXT" : "Menu_B_B",
							"MENU_SUB" : [
								{
									"MENU_TEXT" : "Menu_B_B_A"
								}
							]
						},
						{
							"MENU_TEXT" : "Menu_B_C"
						},
						{
							"MENU_TEXT" : "Menu_B_D"
						}
					]
				},
				{
					"MENU_TEXT" : "Menu_C",
					"MENU_SUB" : [
						{
							"MENU_TEXT" : "Menu_C_A"
						},
						{
							"MENU_TEXT" : "Menu_C_B"
						},
						{
							"MENU_TEXT" : "Menu_C_C",
							"MENU_SUB" : [
								{
									"MENU_TEXT" : "Menu_C_C_A",
									"MENU_SUB" : [
										{
											"MENU_TEXT" : "Menu_C_C_A_A"
										},
										{
											"MENU_TEXT" : "Menu_C_C_A_B"
										}
									]
								},
								{
									"MENU_TEXT" : "Menu_C_C_B"
								},
								{
									"MENU_TEXT" : "Menu_C_C_C"
								},
								{
									"MENU_TEXT" : "Menu_C_C_D"
								}
							]
						},
						{
							"MENU_TEXT" : "Menu_C_D"
						}
					]
				},
				{
					"MENU_TEXT" : "Menu_D"
				},
				{
					"MENU_TEXT" : "Menu_E",
					"MENU_SUB" : [
						{
							"MENU_TEXT" : "Menu_E_A",
							"MENU_SUB" : [
								{
									"MENU_TEXT" : "Menu_E_A_A"
								},
								{
									"MENU_TEXT" : "Menu_E_A_B"
								},
								{
									"MENU_TEXT" : "Menu_E_A_C"
								}
							]
						},
						{
							"MENU_TEXT" : "Menu_E_B"
						},
						{
							"MENU_TEXT" : "Menu_E_C"
						},
						{
							"MENU_TEXT" : "Menu_E_D"
						}
					]
				},
				{
					"MENU_TEXT" : "Menu_F"
				}
			];
				
			}
			
		</script>

	</head>
	<body ng-app="ANGULAR_WEBAPPS" ng-controller="WEBAPPS_CONTROLLER" id="APP_CONTENTS"> 
		<DIV_MENU>

<QIIP_MENU>
	<DIV_LEFT>
		LOGO
	</DIV_LEFT>

	<DIV_CENTER>
		<MENU_1ST>
			<MENU_1ST_TEXT ng-repeat="MENU_ITEM_1ST in JSON_ARGS">
				{{MENU_ITEM_1ST.MENU_TEXT}}
				<MENU_1ST_SUB ng-if="MENU_ITEM_1ST.MENU_SUB">
					<MENU_2ND ng-repeat="MENU_ITEM_2ND in MENU_ITEM_1ST.MENU_SUB" >
						<MENU_2ND_TEXT>
							{{MENU_ITEM_2ND.MENU_TEXT}}
							<span class="caret" ng-if="MENU_ITEM_2ND.MENU_SUB"></span>
							<MENU_2ND_SUB ng-if="MENU_ITEM_2ND.MENU_SUB">
								<MENU_3RD ng-repeat="MENU_ITEM_3RD in MENU_ITEM_2ND.MENU_SUB">
									<MENU_3RD_TEXT>{{MENU_ITEM_3RD.MENU_TEXT}}</MENU_3RD_TEXT>
								</MENU_3RD>
							</MENU_2ND_SUB>
						</MENU_2ND_TEXT>
					</MENU_2ND>
				</MENU_1ST_SUB>
			</MENU_1ST_TEXT>
		</MENU_1ST>
	</DIV_CENTER>

	<DIV_RIGHT>
		<button><span class="glyphicon glyphicon-menu-hamburger"></span></button>
	</DIV_RIGHT>
</QIIP_MENU>
<QIIP_MENU_ALL>
	<MENU_1ST>
		<MENU_1ST_TEXT ng-repeat="MENU_ITEM_1ST in JSON_ARGS">
			{{MENU_ITEM_1ST.MENU_TEXT}}
			<MENU_1ST_SUB ng-if="MENU_ITEM_1ST.MENU_SUB">
				<MENU_2ND ng-repeat="MENU_ITEM_2ND in MENU_ITEM_1ST.MENU_SUB" >
					<MENU_2ND_TEXT>
						{{MENU_ITEM_2ND.MENU_TEXT}}
						<span class="caret" ng-if="MENU_ITEM_2ND.MENU_SUB"></span>
						<MENU_2ND_SUB ng-if="MENU_ITEM_2ND.MENU_SUB">
							<MENU_3RD ng-repeat="MENU_ITEM_3RD in MENU_ITEM_2ND.MENU_SUB">
								<MENU_3RD_TEXT>{{MENU_ITEM_3RD.MENU_TEXT}}</MENU_3RD_TEXT>
							</MENU_3RD>
						</MENU_2ND_SUB>
					</MENU_2ND_TEXT>
				</MENU_2ND>
			</MENU_1ST_SUB>
		</MENU_1ST_TEXT>
	</MENU_1ST>
</QIIP_MENU_ALL>
			
		</DIV_MENU>

		<DIV_CONTENTS>
		</DIV_CONTENTS>
	</body>
</html>
