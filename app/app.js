var AuctionApp = angular.module('auctionApp', ['ngRoute', 'ngSanitize','angular-loading-bar']);

AuctionApp.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.parentSelector = '#loading-bar';
    cfpLoadingBarProvider.spinnerTemplate = '<div><span class="fa fa-spinner">Custom Loading Message...</div>';
  }]);

// Routing Auction frontend
AuctionApp.config(function($routeProvider) {
    $routeProvider
    .when("/", {
        templateUrl : "view/page/home.html"
    })
    .when("/auction-list/", {
        templateUrl : "view/page/auction-list.html"
    })
    .when("/auction-list/:sortStatus/", {
        templateUrl : "view/page/auction-list.html"
    })
    .when("/auction-list/:sortStatus/:currentPage", {
        templateUrl : "view/page/auction-list.html"
    })
    .when("/auction/:uniqueKey/", {
        routeName : "auction-detail",
        templateUrl : "view/page/auction.html",
        controller : "auctionDetailController"
    })
    .when("/register/", {
        templateUrl : "view/customer/register.html",
        controller : "authController"
    })
    .otherwise({
        templateUrl: "view/page/404.html"
    });
});

AuctionApp.controller('appController', ['$scope', '$rootScope' , function($scope, $rootScope){
  // Get Base Url
  $rootScope.getBaseUrl = function() {
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    return baseUrl;
  }
  $rootScope.getMediaUrl = function() {
    return $scope.getBaseUrl() + '/media/';
  }
  $rootScope.baseUrlApi = $rootScope.getBaseUrl()+'/backendFrame/public/api/v1/';
  $rootScope.closeModal = function(modal) {
    jQuery('#'+modal).modal('close');
  }

}]);
