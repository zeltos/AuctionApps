AuctionApp.controller('navigationController', ['$scope' , function($scope){
  $scope.openLoginDialog = function() {
    jQuery('#modal-login').modal('open');
  }
}]);
