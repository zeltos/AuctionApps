AuctionApp.controller('accountController', ['$scope', '$rootScope', '$http', '$location', '$route' ,
function($scope, $rootScope, $http, $location, $route){
  var dataAuth =  JSON.parse(localStorage.getItem("auth"));
  var urlServer = $rootScope.baseUrlApi;
  $scope.account = {};
  $scope.listbidding = [];
  $scope.redirectLogicAuth = function() {
    if (localStorage.getItem("auth")) {
      if ($route.current.routeName == 'registerUser') {
        $location.path('/myaccount/');
      }
    } else {
      if ($route.current.routeName == 'myAccount') {
        $location.path('/');
      }
    }
  }

  $scope.redirectLogicAuth();
  $scope.getDetailAccount = function() {
    $http.get(urlServer + 'user/' + dataAuth.userData[0].user_id ).then(function(response){
      var result = response.data;
      $scope.account = result.data;
    })
  }
  $scope.activationLog = function() {
    $http.get(urlServer + 'list-bidding/' + dataAuth.userData[0].user_id ).then(function(response){
      var result = response.data;
      $scope.listbidding = result;
      console.log($scope.listbidding);
    })
  }

  if ($route.current.module == 'account') {
     $scope.getDetailAccount();
     $scope.activationLog();
  }

}]);

AuctionApp.filter('convertDate', function() {
return function(dateFromPHP) {
  var t =dateFromPHP.split(/[- :]/);
  var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
  return d;
}

});
