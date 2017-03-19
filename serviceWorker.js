this.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open('v1').then(function(cache) {
      return cache.addAll([
        'app/',
        'lib/css/materialize.min.css',
        'lib/css/owl.carousel.min.css',
        'lib/css/jquery.countdown.css',
        'lib/js/',
        'lib/js/jquery.min.js',
        'lib/js/angular/angular.min.js',
      ]);
      cache.delete('lib/js').then(function(response) {
      console.log('success delete shit!');
      });
    })
  );
});

this.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
  );
});
