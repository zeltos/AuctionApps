AuctionApp.controller('listAuctionController', ['$scope', '$http', '$routeParams' , function($scope, $http, $routeParams){
  $scope.sortBy = "";
  if ($routeParams.sortStatus) {
    console.log($routeParams.sortStatus);
      $scope.sortBy = $routeParams.sortStatus;
  }
  $scope.auctionItems = [];
  var urlServer = $scope.getBaseUrl() + '/backend/api/example/';
  $http.get( urlServer + 'product-list.json').then(function(response) {
    $scope.auctionItems = response.data;
  });
}]);
