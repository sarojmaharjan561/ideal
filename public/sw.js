const CACHE_NAME = "ideas-cache-v1";
const OFFLINE_URL = "/ideas";

self.addEventListener("install", (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.add(OFFLINE_URL);
        }),
    );
    self.skipWaiting();
});

self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches
            .keys()
            .then((names) =>
                Promise.all(
                    names
                        .filter((n) => n !== CACHE_NAME)
                        .map((n) => caches.delete(n)),
                ),
            ),
    );
    self.clients.claim();
});

self.addEventListener("fetch", (event) => {
    const url = new URL(event.request.url);

    if (event.request.method !== "GET") {
        return;
    }

    if (
        url.pathname.startsWith("/build/") ||
        event.request.destination === "image"
    ) {
        // Cache-first for build assets AND images
        event.respondWith(
            caches.match(event.request).then((cached) => {
                return (
                    cached ||
                    fetch(event.request).then((response) => {
                        const clone = response.clone();
                        caches
                            .open(CACHE_NAME)
                            .then((cache) => cache.put(event.request, clone));
                        return response;
                    })
                );
            }),
        );
    } else if (event.request.mode === "navigate") {
        event.respondWith(
            fetch(event.request)
                .then((response) => {
                    const clone = response.clone();
                    caches
                        .open(CACHE_NAME)
                        .then((cache) => cache.put(event.request, clone));
                    return response;
                })
                .catch(() =>
                    caches
                        .match(event.request)
                        .then((cached) => cached || caches.match(OFFLINE_URL)),
                ),
        );
    } else {
        event.respondWith(
            fetch(event.request).catch(() => caches.match(event.request)),
        );
    }
});
