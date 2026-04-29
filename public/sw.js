// ============================================================
//  DIGIDAS Service Worker
//  Cache strategy: Network-first untuk halaman, Cache-first untuk aset
// ============================================================

const CACHE_NAME    = 'digidas-v1';
const OFFLINE_URL   = '/offline';

// Aset statis yang selalu di-cache
const STATIC_ASSETS = [
    '/',
    '/offline',
    '/manifest.json',
    '/images/icon-192.png',
    '/images/icon-512.png',
    '/images/logo1.png',
];

// ── Install: cache aset statis ──
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(STATIC_ASSETS))
            .then(() => self.skipWaiting())
            .catch(err => console.warn('[SW] Install cache error:', err))
    );
});

// ── Activate: hapus cache lama ──
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(
                keys
                    .filter(key => key !== CACHE_NAME)
                    .map(key => {
                        console.log('[SW] Deleting old cache:', key);
                        return caches.delete(key);
                    })
            )
        ).then(() => self.clients.claim())
    );
});

// ── Fetch: Network-first, fallback ke cache ──
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    // Skip non-GET dan request ke API/CSRF
    if (request.method !== 'GET') return;
    if (url.pathname.startsWith('/api/')) return;
    if (url.pathname.includes('sanctum') || url.pathname.includes('_debugbar')) return;

    // Aset statis (css, js, images, fonts) → Cache-first
    if (
        url.pathname.match(/\.(css|js|png|jpg|jpeg|svg|ico|woff2?|ttf)$/)
    ) {
        event.respondWith(
            caches.match(request).then(cached => {
                if (cached) return cached;
                return fetch(request).then(response => {
                    if (!response || response.status !== 200) return response;
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(request, clone));
                    return response;
                });
            })
        );
        return;
    }

    // Halaman (HTML) → Network-first, fallback ke cache atau /offline
    event.respondWith(
        fetch(request)
            .then(response => {
                if (!response || response.status !== 200 || response.type !== 'basic') {
                    return response;
                }
                const clone = response.clone();
                caches.open(CACHE_NAME).then(cache => cache.put(request, clone));
                return response;
            })
            .catch(() =>
                caches.match(request).then(cached => {
                    if (cached) return cached;
                    return caches.match(OFFLINE_URL);
                })
            )
    );
});

// ── Background sync (opsional, untuk kirim data saat offline) ──
self.addEventListener('sync', event => {
    if (event.tag === 'sync-absensi') {
        event.waitUntil(syncAbsensi());
    }
});

async function syncAbsensi() {
    // Implementasi sync data absensi yang pending saat offline
    console.log('[SW] Syncing pending absensi...');
}