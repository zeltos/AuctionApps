var AuctionApp = angular.module('auctionApp', ['ngRoute', 'ngSanitize','angular-loading-bar']);

AuctionApp.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.parentSelector = '#loading-bar';
    cfpLoadingBarProvider.spinnerTemplate = '<div><span class="fa fa-spinner">Custom Loading Message...</div>';
  }]);

// Routing Auction frontend
AuctionApp.config(function($routeProvider, $locationProvider) {
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
        routeName : "registerUser",
        templateUrl : "view/customer/register.html",
        controller : "authController"
    })
    .when("/myaccount/", {
        module : "account",
        routeName : "myAccount",
        templateUrl : "view/customer/account.html",
        controller : "accountController"
    })
    .otherwise({
        templateUrl: "view/page/404.html"
    });
    // $locationProvider.html5Mode(true);
    $locationProvider.html5Mode(true);
    $locationProvider.hashPrefix('!');
});

AuctionApp.controller('appController', ['$scope', '$rootScope' , function($scope, $rootScope){
  // Get Base Url
  // var envi = 'local';
  var envi = 'production';

  $rootScope.getBaseUrl = function() {
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/";
    return baseUrl;
  }
  $rootScope.getMediaUrl = function() {
    return $scope.getBaseUrl() + '/media/';
  }

  if (envi == 'local') {
    $rootScope.baseUrlApi = $rootScope.getBaseUrl()+'backendFrame/public/api/v1/';
  } else if (envi == 'production') {
    $rootScope.baseUrlApi = 'https://api.mezeltos.com/api/v1/';
  }
  console.log($rootScope.baseUrlApi);
  $rootScope.closeModal = function(modal) {
    jQuery('#'+modal).modal('close');
  }

}]);
