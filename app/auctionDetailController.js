AuctionApp.controller('auctionDetailController',
['$scope', '$http','$rootScope', '$routeParams','bidingService', 'auctionDataService',
function($scope, $http, $rootScope, $routeParams, bidingService, auctionDataService) {
  $scope.image_gallery = [];
  auctionDataService.getDetailAuction(function(data) {
    $scope.auctionData = data.data_response[0];
    $scope.image_gallery = data.image_gallery;
    $rootScope.getDominated();
    if (data.data_response[0].status == 'live') {
      setCountdown(data.data_response[0].auction_end_date);
    } else if (data.data_response[0].status == 'cooming'){
      setCountdown(data.data_response[0].auction_start_date);
    }

    setTimeout(function () {
        loadCarousel();
    }, 100);
  }, $routeParams.uniqueKey)

  $rootScope.wasBid = false;
  $rootScope.showAgreement = function() {
      $rootScope.wasBid = false;
      $scope.formBidData.agreement_check = false;
  }
  function setCountdown(date) {
    jQuery("#product-coundown")
    .countdown(date, function(event) {
      var $this = jQuery(this).html(event.strftime(''
         + "<div class='timer-wrapper'><span>%w</span> weeks  </div>"
         + "<div class='timer-wrapper'><span>%d</span> days  </div>"
         + "<div class='timer-wrapper'><span>%H</span> hour  </div>"
         + "<div class='timer-wrapper'><span>%M</span> min  </div>"
         + "<div class='timer-wrapper'><span>%S</span> sec </div>"));
       });
  }

  var urlServer = $rootScope.baseUrlApi;
  $scope.load_dominated = true;
  $rootScope.getDominated = function() {
      var auth =  JSON.parse(localStorage.getItem("auth"));
      var user_id = '';
      if (auth) {
        user_id = auth.userData[0].user_id;
        $http.get(urlServer + 'get-dominated/'+ user_id + '/' + $scope.auctionData.auction_id ).then(function(response) {
          if (!response.data.message) {
            $scope.dominated = response.data.dominated;
            $scope.auctionData.auction_current_bidding = response.data.auction_current_bidding;
            $rootScope.wasBid = response.data.was_bid;
            if($rootScope.wasBid) {
              $scope.formBidData.agreement_check = true;
            }
          }
            $scope.load_dominated = false;
        });
      } else {
          $scope.dominated = false;
          $scope.load_dominated = false;
      }
  }

  // set auto update dominated
  // setInterval(function(){ $rootScope.getDominated() }, 1000);

  $scope.cancelAgreement = function() {
    $scope.formBidData.agreement_check = false;
  }

  $scope.formBidData = {};
  // $scope.formBidData.bid_value = 0;
  $scope.bidError = false;
  $scope.success_modal = false;
  $scope.load_submidbid = false;
  $scope.submitBidTrigger = function() {
    var dataAuth =  JSON.parse(localStorage.getItem("auth"));
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
    $scope.load_submidbid = true;
    console.log($scope.formBidData);
    bidingService.submitBid(function(data) {
      var status = data.response.status;
      if (status == 'success') {
        $rootScope.getDominated();
        $scope.bidMessage = data.response.message;
        $scope.load_submidbid = false;
        $scope.success_modal = true;
        setTimeout(function () {
          jQuery('#modal-success').modal('open');
        }, 50);
      }
      $scope.formBidData = {};
    }, $scope.formBidData, dataAuth.userData[0], $scope.auctionData.auction_id );
  }

  $scope.checkValidationBid = function(bid_value) {
      var difference = bid_value-$scope.auctionData.auction_current_bidding;
     if (bid_value < $scope.auctionData.auction_current_bidding) {
        return 'your bid must be biger than the current bid!';
     } else if (difference > $scope.auctionData.auction_max_bid) {
        return 'max bid at once biding is :' +  $scope.auctionData.auction_max_bid + ' from the current bid!';
     }
  }

}]);
