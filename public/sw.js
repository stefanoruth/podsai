var cacheName = "podsai";

self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(cacheName).then(function (cache) {
            return cache.addAll([
                '/app.css',
                '/app.js',
            ]);
        })
    );
});

self.addEventListener('fetch', function (event) {
    event.respondWith(
        fetch(event.request).catch(function () {
            return caches.match(event.request);
        })
    );
});