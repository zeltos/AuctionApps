var cacheName = 'Auction-v2';
var filesToCache = [
  'index.html',
  // 'server.js',
  '/',
  './app/app.js',
  './app/listAuctionController.js',
  './app/auctionDetailController.js',
  './app/service/auctionDataService.js',
  './media/frontend/images/auction_logo_white.png',
  './media/frontend/',
  './media/catalog/',
  './view/',
  './lib/css/materialize.min.css',
  './lib/css/owl.carousel.min.css',
  './lib/css/jquery.countdown.css',
  './lib/css/owl.theme.default.min.css',
  './lib/css/materialize-icon.css',
  './lib/js/jquery.min.js',
  './lib/js/jquery.lazyLoad.js',
  './lib/js/jquery.maskMoney.js',
  './lib/js/jquery.countdown.min.js',
  './lib/js/materialize.min.js',
  './lib/js/owl.carousel.min.js',
  './lib/js/angular/angular.min.js',
  './lib/js/angular/angular-route.min.js',
  './lib/js/angular/angular-sanitize.min.js',
  './lib/js/angular/angular-locale_id-id.js',
  './lib/js/angular/angular-animate.min.js',
];

var dataCacheName = 'Auction-Data-v1';

// SW Install
self.addEventListener('install', function(e) {
  console.log('[ServiceWorker] Install');
  e.waitUntil(
    caches.open(cacheName).then(function(cache) {
      console.log('[ServiceWorker] Caching app shell');
      return cache.addAll(filesToCache);
    })
  );
});




self.addEventListener('fetch', function(e) {
  // console.log('[Service Worker] Fetch', e.request.url);
  var dataUrl = '/backendFrame/public/api/v1/';
  if (e.request.url.indexOf(dataUrl) > -1) {
    /*
     * When the request URL contains dataUrl, the app is asking for fresh
     * weather data. In this case, the service worker always goes to the
     * network and then caches the response. This is called the "Cache then
     * network" strategy:
     * https://jakearchibald.com/2014/offline-cookbook/#cache-then-network
     */
    e.respondWith(
      caches.open(dataCacheName).then(function(cache) {
        return fetch(e.request).then(function(response){
          // console.log('url to cache =' + e.request.url);
          cache.put(e.request.url, response.clone());
          return response;
        });
      })
    );
  } else {
    /*
     * The app is asking for app shell files. In this scenario the app uses the
     * "Cache, falling back to the network" offline strategy:
     * https://jakearchibald.com/2014/offline-cookbook/#cache-falling-back-to-network
     */
    e.respondWith(
      caches.match(e.request).then(function(response) {
        return response || fetch(e.request);
      })
    );
  }
});

// SW Activate
self.addEventListener('activate', function(e) {
  console.log('[ServiceWorker] Activate');
  e.waitUntil(
    caches.keys().then(function(keyList) {
      return Promise.all(keyList.map(function(key) {
        if (key !== cacheName  && key !== dataCacheName) {
          console.log('[ServiceWorker] Removing old cache', key);
          return caches.delete(key);
        }
      }));
    })
  );
  return self.clients.claim();
});
