angular.module('app.controllers', [])

.controller('iServerCtrl', ['$scope', '$stateParams', '$http', '$ionicLoading', '$ionicPopup', // The following is the constructor function for this page's controller. See https://docs.angularjs.org/guide/controller
// You can include any angular dependencies as parameters for this function
// TIP: Access Route Parameters for your page via $stateParams.parameterName
function ($scope, $stateParams, $http, $ionicLoading, $ionicPopup) {
  var $server = "192.168.33.41";
  var $port   = "3000";
  var user = "a1dc88939bc6ef29442f7e540389c351c56991eb";

  $ionicLoading.show({template: "Chargement ..."});

  var getSerial = function() {
    $http.get("http://" + $server + ":" + $port + "/get/json/all").success(function(data) {

      if (data.a_status === 1) {
        data.alarm = "On";
      } else {
        data.alarm = "Off";
      }

      if (data.response.blue == 1) {
        $scope.blue = {blue: true};
      } else {
        $scope.blue = {blue: false};
      }

      if (data.response.white == 1) {
        $scope.white = {white: true};
      } else {
        $scope.white = {white: false};
      }

      if (data.response.green == 1) {
        $scope.green = {green: true};
      } else {
        $scope.green = {green: false};
      }

      if (data.response.red == 1) {
        $scope.red = {red: true};
      } else {
        $scope.red = {red: false};
      }

      if (data.response.alarm == 1) {
        $scope.alarm = {alarm: true};
      } else {
        $scope.alarm = {alarm: false};
      }

      $scope.data = {
        degrees: data.response.degrees,
        intdegrees: data.response.intdegrees,
        light: data.response.light,
        tension: data.response.tension,
        door: data.response.door,
        a_status: data.alarm
      }

      $ionicLoading.hide();
    })
  }
  getSerial();

  $scope.switchOff = function () {
    console.log("fzef");
    $http.get("http://" + $server + ":" + $port + "/post/data/" + user + "/0").success(function(){});
        $ionicPopup.alert({
          title: 'Alarme',
          template: 'L\'alarme est maintenant éteinte !'
        });
  }

  $scope.switchBlue = function() {
    $http.get("http://" + $server + ":" + $port + "/post/data/" + user + "/4").success(function(){});
  }

  $scope.switchWhite = function() {
    $http.get("http://" + $server + ":" + $port + "/post/data/" + user + "/5").success(function(){});
  }

  $scope.switchGreen = function() {
    $http.get("http://" + $server + ":" + $port + "/post/data/" + user + "/7").success(function(){});
  }

  $scope.switchRed = function() {
    $http.get("http://" + $server + ":" + $port + "/post/data/" + user + "/6").success(function(){});
  }

  $scope.switchAlarm = function() {
    if ($scope.alarm.alarm === true) {
      $http.get("http://" + $server + ":" + $port + "/post/data/" + user + "/2").success(function(){});
    } else {
      $http.get("http://" + $server + ":" + $port + "/post/data/" + user + "/1").success(function(){});
    }
  }

  window.setInterval(function() { getSerial() }, 1000);
}])
