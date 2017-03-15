AuctionApp.service('auctionDataService',  function($http, $rootScope) {

  var urlServer = $rootScope.baseUrlApi;
  this.getDetailAuction = function (callback, uniqueKey) {
    $http.get( urlServer + 'get-auction/' + uniqueKey).then(function(response) {
      callback(response.data);
    });
  }

});
