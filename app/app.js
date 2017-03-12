var AuctionApp = angular.module('auctionApp', ['ngRoute', 'ngSanitize','angular-loading-bar']);

AuctionApp.config(function(cfpLoadingBarProvider) {
  cfpLoadingBarProvider.parentSelector = '#loading-bar-container';
  cfpLoadingBarProvider.spinnerTemplate = '<div><span class="fa fa-spinner">Custom Loading Message...</div>';
  cfpLoadingBarProvider.includeSpinner = true;
  cfpLoadingBarProvider.latencyThreshold = 3500;
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
    .when("/auction/:uniqueKey", {
        templateUrl : "view/page/auction.html",
        controller : "auctionDetailController"
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
