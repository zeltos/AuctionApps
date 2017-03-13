AuctionApp.service('bidingService', function($http, $rootScope) {

    this.service = true;
    var urlServer = $rootScope.getBaseUrl() + '/backend/api/example/';
    this.submitBid = function (callback, data) {
      $http.post( urlServer + 'submit-bid.json', data).then(function(response) {
          callback(response.data);
      });
    }
});
