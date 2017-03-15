AuctionApp.controller('listAuctionController', ['$scope', '$http', '$routeParams' , function($scope, $http, $routeParams){
  $scope.sortBy = "all";
  if ($routeParams.sortStatus) {
    console.log($routeParams.sortStatus);
      $scope.sortBy = $routeParams.sortStatus;
  }
  $scope.dataPage = {};
  $scope.auctionItems = [];
  // var urlServer = $scope.getBaseUrl() + '/backend/api/example/';
  var urlServer = $scope.getBaseUrl() + '/backendFrame/public/api/v1/get-auction-list/';
  $http.get( urlServer + $scope.sortBy +'/1').then(function(response) {
    console.log(response.data);
    $scope.auctionItems = response.data.data_response.data;
    $scope.dataPage = response.data.data_response;
  });
}]);
