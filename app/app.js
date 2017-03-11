var AuctionApp = angular.module('auctionApp', ['ngRoute']);

AuctionApp.config(function() {
	// Config Auction
});

// Routing Auction frontend
AuctionApp.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "view/page/home.html"
    })
    .when("/auction-list/", {
        templateUrl : "view/page/auction-list.html"
    })
    .when("/green", {
        templateUrl : "green.htm"
    })
    .when("/blue", {
        templateUrl : "blue.htm"
    });
});

AuctionApp.controller('appController', ['$scope' , function($scope){
  // Get Base Url
  $scope.getBaseUrl = function() {
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    return baseUrl;
  }
  $scope.getMediaUrl = function() {
    return $scope.getBaseUrl() + '/media/';
  }
}]);
