AuctionApp.service('bidingService', function() {

    this.service = true;
    this.submitBid = function () {
      var dataAuth = JSON.parse(localStorage.getItem("auth"));
      if (!dataAuth) {
         return 'you need to login to submit a bid!';
      }
      return "successfuly submit a bid!";
    }
});
