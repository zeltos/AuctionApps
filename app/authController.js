AuctionApp.controller('authController', ['$scope', '$rootScope', '$http', '$location' , function($scope, $rootScope, $http, $location){
  $rootScope.userData = {};
  $scope.loginData = {};
  $rootScope.token = {};
  $scope.errorLogin = false;
  var urlServer = $rootScope.baseUrlApi;

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
    $http.post( urlServer + 'loginPost', $scope.loginData).then(function(response) {
      var status = response.data.response.status;
      if (status == 'success') {
          $rootScope.token = response.data.user_data.token;
          $rootScope.userData = response.data.user_data;
          if ($scope.checkSupportStorage()) {
            var dataAuth =  { isAuth:true, token: $rootScope.token, userData: $rootScope.userData };
            localStorage.setItem("auth", JSON.stringify(dataAuth));
            var dataAuth = JSON.parse(localStorage.getItem("auth"));
            $scope.loginData = {};
            $scope.errorLogin = false;
            $rootScope.getDominated();
            jQuery('#modal-login').modal('close');
            if ($location.path() == '/register/') {
              $location.path('/myaccount/');
            }
          }
      } else if (status == 'failed') {
        $scope.errorLogin = true;
        $scope.errorLoginMessage = response.data.response.message;
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
