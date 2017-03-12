AuctionApp.controller('authController', ['$scope', '$http' , function($scope, $http){
  $scope.userData = {};
  $scope.token = {};
  var urlServer = $scope.getBaseUrl() + '/backend/api/example/';
  $scope.login = function(email, password) {
    if ($scope.checkWasLogin()) {
      console.log('u has already log in');
      return;
    }
    $http.post( urlServer + 'login.json', { email: email, password:password }).then(function(response) {
      $scope.token = response.data.token;
      $scope.userData = response.data.user_data;
      if ($scope.checkSupportStorage()) {
        var dataAuth =  { isAuth:true, token: $scope.token, userData: $scope.userData };
        localStorage.setItem("auth", JSON.stringify(dataAuth));
        var dataAuth = JSON.parse(localStorage.getItem("auth"));
        console.log(dataAuth);
        jQuery('#modal-login').modal('close');
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

}]);
