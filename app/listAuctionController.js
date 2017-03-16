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
  // var urlServer = $scope.getBaseUrl() + '/backend/api/example/';
  $scope.loading_list = true;
  var urlServer = $scope.getBaseUrl() + '/backendFrame/public/api/v1/get-auction-list/';
  $http.get( urlServer + $scope.sortBy + '/' + $scope.curPage).then(function(response) {
    console.log(response.data);
    $scope.auctionItems = response.data.data_response.data;
    $scope.dataPage = response.data.data_response;
    $scope.loading_list = false;
    $scope.generatePage(response.data.data_response.last_page);
  });

  $scope.generatePage = function(totalpage) {
    for (var i = 1; i < totalpage+1; i++) {
      $scope.totalPage.push({'page': i, 'link' : '#!/auction-list/'+$scope.sortBy+ '/' + i});
    }
  }

}]);
