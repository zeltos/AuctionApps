AuctionApp.controller('authController', ['$scope', '$rootScope', '$http', '$location' , function($scope, $rootScope, $http, $location){
  $scope.userData = {};
  $scope.loginData = {};
  $scope.token = {};
  $scope.errorLogin = false;
  var urlServer = $scope.getBaseUrl() + '/backend/api/example/';



  $scope.redirectLogicAuth = function() {
    if (localStorage.getItem("auth")) {
      if ($location.path() == '/register/') {
        $location.path('/myaccount/');
      }
    } else {
      if ($location.path() == '/myaccount/') {
        $location.path('/');
      }
    }
  }

  $scope.redirectLogicAuth();

  $scope.login = function(isValid) {
    if ($scope.checkWasLogin()) {
      console.log('u has already log in');
      return;
    }
    $http.post( urlServer + 'login.json', $scope.loginData).then(function(response) {
      var status = response.data.result.status;
      if (status == 'success') {
          $scope.token = response.data.token;
          $scope.userData = response.data.user_data;
          if ($scope.checkSupportStorage()) {
            var dataAuth =  { isAuth:true, token: $scope.token, userData: $scope.userData };
            localStorage.setItem("auth", JSON.stringify(dataAuth));
            var dataAuth = JSON.parse(localStorage.getItem("auth"));
            $scope.loginData = {};
            jQuery('#modal-login').modal('close');
            if ($location.path() == '/register/') {
              $location.path('/myaccount/');
            }
          }
      } else if (status == 'failed') {
        $scope.errorLogin = true;
        $scope.errorLoginMessage = response.data.result.message;
      }
    });
  }

  $scope.checkSupportStorage = function() {
    if (typeof(Storage) !== "undefined") {
        return true;
    } return false;
  }

  $scope.checkWasLogin = function() {
    var isAuth = localStorage.getItem("auth");
    if (isAuth) {
        return true;
    } return false;
  }

  $scope.logout = function() {
    localStorage.removeItem('auth');
    console.log('u has logout from apps');
  }

  $scope.errorRegister = false;
  $scope.registerData = {};
  $scope.submitRegister = function(isValid) {
    if (isValid) {
      console.log($scope.registerData);
    }
  }

}]);
