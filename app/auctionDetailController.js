AuctionApp.controller('auctionDetailController',
['$scope', '$http','$rootScope', '$routeParams','bidingService', 'auctionDataService',
function($scope, $http, $rootScope, $routeParams, bidingService, auctionDataService) {

  auctionDataService.getDetailAuction(function(data) {
    $scope.auctionData = data.auction_data;
    $scope.dominated  = data.dominated;
  })

  $scope.cancelAgreement = function() {
    $scope.formBidData.agreement_check = false;
  }

  $scope.formBidData = {};
  $scope.submitBidTrigger = function() {
    var dataAuth = JSON.parse(localStorage.getItem("auth"));
    if (!dataAuth) {
       alert('you need to login to submit a bid!');
       jQuery('#modal-login').modal('open');
       return;
    }
    if ($scope.checkValidationBid($scope.formBidData.bid_value)) {
      alert($scope.checkValidationBid($scope.formBidData.bid_value));
      return;
    }
    if (!$scope.formBidData.agreement_check) {
      alert('you must agree the term and condition!');
      return;
    }
    if ($scope.dominated) {
      alert('you just dominated this auction!');
      return;
    }
    console.log($scope.formBidData);
    bidingService.submitBid(function(data) {
      alert(data);
      $scope.formBidData = {};
    }, $scope.formBidData);
  }

  $scope.checkValidationBid = function(bid_value) {
      var difference = bid_value-$scope.auctionData.auction_current_bidding;
     if (bid_value < $scope.auctionData.auction_current_bidding) {
        return 'your bid must be biger than the current bid!';
     } else if (difference > $scope.auctionData.auction_max_perbid) {
        return 'max bid at once biding is' +  $scope.auctionData.auction_max_perbid + 'from the current bid!';
     }
  }

}]);
