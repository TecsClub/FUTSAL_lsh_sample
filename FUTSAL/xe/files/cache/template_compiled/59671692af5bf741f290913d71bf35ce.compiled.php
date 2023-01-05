<?php if(!defined("__XE__"))exit;
$__Context->ARGS = json_decode(base64_decode($__Context->ARGS->JSON_ARGS_BASE64));  ?>
<script>
	function ON_MENU_CLICK(JSON_MENU) {
//		alert(JSON.stringify(JSON_MENU, null, '\t'));
		QIIP_API_ACCESS({
				REQ: 'api_GET_PAGE',
				FLDR_TEMPLATE: _FLDR_TEMPLATE,
				FILE_TEMPLATE: JSON_MENU.MENU_CONTENTS,
				XE_COMPILE: 'YES'
			},function(STR_RESULT) {
				$('#MENU_HEADER').html(JSON_MENU.MENU_STRING);
				$('#APPS_CONTENTS').html(_AC(STR_RESULT)(_RS)); _RS.$apply();
				if ('MENU_INIT_FUNC' in JSON_MENU) {
					eval(JSON_MENU.MENU_INIT_FUNC);
				}
			},{
				title: '안내',
				template: ARR_TO_TABLE_CENTER([
					JSON_MENU.MENU_STRING,
					'화면을 구성하고 있습니다.'
				]),
				cssClass: 'qiip_popup'
			}
		);
	}
</script>
<ion-side-menus enable-menu-with-back-views="false">
	<ion-side-menu side="left">
		<ion-header-bar class="bar-stable">
			<h1 class="title">{{PHONE_INFO.APP_NAME}} {{APP_CONFIG.SIDEMENU.HEADER}}</h1>
		</ion-header-bar>
		<ion-content>
			<ion-list>
				<?php if(!$__Context->ARGS->_ACCESS_FROM_APP){ ?>
					<ion-item ng-repeat="MENU_ITEM in APP_CONFIG.SIDEMENU.MENUITEMS" menu-close ng-click="ON_MENU_CLICK(MENU_ITEM)">
					{{MENU_ITEM.MENU_STRING}}
					</ion-item>
					<ion-item menu-close ng-click="QIIP_APP_LOGOUT()">
					로그아웃
					</ion-item>
				<?php }else{ ?>
					<ion-item ng-repeat="MENU_ITEM in APP_CONFIG.SIDEMENU.MENUITEMS" menu-close ng-click="ON_MENU_CLICK(MENU_ITEM)">
					{{MENU_ITEM.MENU_STRING}}
					</ion-item>
				<?php } ?>
			</ion-list>
		</ion-content>
	</ion-side-menu>
	<ion-side-menu-content>
		<ion-nav-bar class="bar-stable">
<!--
			<ion-nav-back-button>
			</ion-nav-back-button>
-->			 
			<ion-nav-buttons side="left">
				<button class="button button-icon button-clear ion-navicon" menu-toggle="left">
				</button>
			</ion-nav-buttons>
			<div class="nav-bar-block" nav-bar="active">
				<ion-header-bar class="bar-stable bar bar-header" align-title="center">
			      <div class="title title-center header-item" id="MENU_HEADER">
			      </div>
			  	</ion-header-bar>
			</div>
			
		</ion-nav-bar>
		<ion-nav-view>
			<ion-view >
				<ion-content id="APPS_CONTENTS" class="scroll-content ionic-scroll  has-header">
				</ion-content>
			</ion-view>
		</ion-nav-view>
	</ion-side-menu-content>
</ion-side-menus>
