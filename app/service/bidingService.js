AuctionApp.service('bidingService', function($http, $rootScope) {

    this.service = true;
    var urlServer = $rootScope.baseUrlApi;
    this.submitBid = function (callback, data, user_data, auction_id) {
      auction_id = {'auction_id' :auction_id };
      var newData = Object.assign(data, user_data,auction_id);

      console.log(newData);
      $http.post( urlServer + 'submitbid', data).then(function(response) {
          callback(response.data);
      });
    }
});
