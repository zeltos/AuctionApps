AuctionApp.controller('auctionDetailController',
['$scope', '$http', '$routeParams','bidingService',
function($scope, $http, $routeParams, bidingService) {

  $scope.auctionData = {};
  $scope.dominated = true;

  var urlServer = $scope.getBaseUrl() + '/backend/api/example/';
  $http.get( urlServer + 'detail.json').then(function(response) {
    $scope.auctionData = response.data.auction_data;
    $scope.dominated = response.data.dominated;
  });

  $scope.submitBidTrigger = function() {
    var responseServiceBid = bidingService.submitBid();
    console.log(responseServiceBid);
  }

}]);
