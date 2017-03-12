AuctionApp.service('auctionDataService',  function($http, $rootScope) {

  var urlServer = $rootScope.getBaseUrl() + '/backend/api/example/';
  this.getDetailAuction = function (callback) {
    $http.get( urlServer + 'detail.json').then(function(response) {
      callback(response.data);
    });
  }

});
