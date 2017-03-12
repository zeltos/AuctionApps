AuctionApp.controller('auctionDetailController',
['$scope', '$http', '$routeParams','bidingService', 'auctionDataService',
function($scope, $http, $routeParams, bidingService, auctionDataService) {

  auctionDataService.getDetailAuction(function(data) {
    $scope.auctionData = data.auction_data;
    $scope.dominated  = data.dominated;
  })

  $scope.submitBidTrigger = function() {
    var responseServiceBid = bidingService.submitBid();
    alert(responseServiceBid);
  }

}]);
