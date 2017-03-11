AuctionApp.controller('listAuctionController', ['$scope', '$http' , function($scope, $http){
  $scope.auctionItems = [];
  var urlServer = $scope.getBaseUrl() + '/backend/api/';
  $http.get( urlServer + 'product-list.json').then(function(response) {
    $scope.auctionItems = response.data;
  });
}]);
