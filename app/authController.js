AuctionApp.controller('authController', ['$scope', '$rootScope', '$http', '$location', '$route' ,
function($scope, $rootScope, $http, $location, $route){
  $rootScope.userData = {};
  $scope.loginData = {};
  $rootScope.token = {};
  $scope.errorLogin = false;
  $scope.loading_login = false;
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
    $scope.errorLogin = false;
    $scope.loading_login = true;
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
            if ($route.current.routeName == 'auction-detail') {
              $rootScope.getDominated();
            }
            jQuery('#modal-login').modal('close');
            if ($location.path() == '/register/') {
              $location.path('/myaccount/');
            }
          }
      } else if (status == 'failed') {
        $scope.errorLogin = true;
        $scope.errorLoginMessage = response.data.response.message;
      }
      $scope.loading_login = false;
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
    if ($route.current.routeName == 'auction-detail') {
        $rootScope.showAgreement();
    }
    console.log('u has logout from apps');
  }

  $scope.errorRegister = false;
  $scope.successRegister = false;
  $scope.loading_register = false;
  $scope.registerData = {};
  $scope.submitRegister = function(isValid) {
    $scope.errorRegister = false;
    $scope.loading_register = true;
    if (isValid) {
      $http.post(urlServer +'userRegister', $scope.registerData).then(function(response){
        $scope.loading_register = false;
        var result = response.data;
        if (result.response.status == 'success') {
          $scope.successRegister = true;
          $scope.RegisterMessage = result.response.message;
           $scope.registerData = {};
        } else {
          $scope.errorRegister = true;
          $scope.RegisterMessage = result.response.message;
        }
      });
    }
  }
$scope.clearState = function(state) {
  if (state == 'login') {
    $scope.errorLogin = false;
  }
}

 $('#modal-login').modal({
  complete: function() {
    $scope.clearState('login');
   } 
 });

}]);
