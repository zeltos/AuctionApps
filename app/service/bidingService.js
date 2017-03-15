AuctionApp.service('bidingService', function($http, $rootScope) {

    this.service = true;
    var urlServer = $rootScope.baseUrlApi;
    this.submitBid = function (callback, data) {
      $http.post( urlServer + 'submitbid', data).then(function(response) {
          callback(response.data);
      });
    }
});
