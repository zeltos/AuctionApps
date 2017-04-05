var express = require('express');
var app = express();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var cors = require('cors');


const {ServiceWorker} = require('node-service-worker');

const sw = new ServiceWorker({
    scriptURL: '/service-worker.js',
    scope: '/', // Primarily to resolve relative URLs
    contents: 'console.log("hi");', // The JS of the service worker
    importScript: function(url) {

        return fs.readFileSync(path.join(__dirname, url));

    }
});


app.use(cors());
app.use(express.static(__dirname + '/'));

app.use(function(req, res, next){
  res.header('Access-Control-Allow-Origin', '*');
  res.header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE');
  res.header('Access-Control-Allow-Headers', 'Content-Type');
  next();
});


io.on('connection', function(socket) {
  console.log('new connection');

  socket.on('afterBid', function(data) {
    io.emit('bcCurrentBid', {
      current_bidding: data.auction_current_bidding,
      user_id_dominated: data.user_id_dominated
    });
  });

});

server.listen(9991, function() {
  console.log('server up and running at 2205 port');
});
