AuctionApp.controller('listAuctionController', ['$scope', '$http', '$routeParams', '$location' , function($scope, $http, $routeParams, $location){
  $scope.sortBy = "all";
  $scope.curPage= '1';
  $scope.currentPath = $location.path();
  if ($scope.currentPath == '/') {
      $scope.sortBy = "live";
  }
  if ($scope.currentPath =='/auction-list/') {$location.path('/auction-list/all');}
  if ($routeParams.sortStatus) {
      $scope.sortBy = $routeParams.sortStatus;
  }
  if ($routeParams.currentPage) {
      $scope.curPage = $routeParams.currentPage;
  }
  $scope.dataPage = {};
  $scope.auctionItems = [];
  $scope.totalPage = [];
  var urlServer = $rootScope.baseUrlApi + '/get-auction-list/';
  var online = navigator.onLine;
  $scope.loading_list = true;
  if ('caches' in window) {
    var url = urlServer + $scope.sortBy + '/' + $scope.curPage;
        caches.match(url).then(function(response) {
          console.log(response);
          if (response) {
            response.json().then(function(json) {
              if (online) {
                  $scope.getNewData();
              } else {
                var results = json;
                $scope.auctionItems = results.data_response.data;
                $scope.dataPage = results.data_response;
                $scope.loading_list = false;
                $scope.generatePage(results.data_response.last_page);
              }
            });
          } else {
            $scope.getNewData();
          }
        });
  } else {
    $scope.getNewData();
  }


  $scope.getNewData = function() {
    console.log('aww');
    $http.get( urlServer + $scope.sortBy + '/' + $scope.curPage).then(function(response) {
      console.log(response.data);
      $scope.auctionItems = response.data.data_response.data;
      $scope.dataPage = response.data.data_response;
      $scope.loading_list = false;
      $scope.generatePage(response.data.data_response.last_page);
    });
  }


  $scope.generatePage = function(totalpage) {
    for (var i = 1; i < totalpage+1; i++) {
      $scope.totalPage.push({'page': i, 'link' : '#!/auction-list/'+$scope.sortBy+ '/' + i});
    }
  }

}]);
