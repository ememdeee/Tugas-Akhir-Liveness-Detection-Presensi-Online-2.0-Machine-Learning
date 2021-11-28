var staticCacheName = "pwa-v" + new Date().getTime();
var filesToCache = [
    // '/offline',
    '/css/app.css',
    '/css/style.css',
    "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css",
    // '/js/app.js',
    '/about',
    '/register',
    '/login',
    '/',
    // '/absen',
    // '/dashboard',
    '/images/icons/icon-72x72.png',
    '/images/icons/icon-96x96.png',
    '/images/icons/icon-128x128.png',
    '/images/icons/icon-144x144.png',
    '/images/icons/icon-152x152.png',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-384x384.png',
    '/images/icons/icon-512x512.png',
    // 'favicon.ico'
];

// Cache on install
self.addEventListener("install", event => {
    this.skipWaiting();
    event.waitUntil(
        caches.open(staticCacheName)
            .then(cache => {
                return cache.addAll(filesToCache);
            })
    )
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames
                    .filter(cacheName => (cacheName.startsWith("pwa-")))
                    .filter(cacheName => (cacheName !== staticCacheName))
                    .map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
// self.addEventListener("fetch", event => {
//     event.respondWith(
//         caches.match(event.request)
//             .then(response => {
//                 return response || fetch(event.request);
//             })
//             .catch(() => {
//                 return caches.match('about');
//             })
//     )
// });

//Strategi: Network first falling back on cache and update cache on every request
self.addEventListener('fetch', event => {
    event.respondWith(
        fetch(event.request)
            .then(response=>{
                return caches.open(staticCacheName)
                .then(cache => {
                    // console.log(event.request.url)
                    //jika request ke tile.openstreetmap, maka ignore save cache
                    if (event.request.url.indexOf('tile.openstreetmap') === -1){
                        cache.put(event.request.url, response.clone());
                    }
                    return response;
                });
            })
            .catch(() => {
                return caches.match(event.request);
            })
    )
});