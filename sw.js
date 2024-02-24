// sw.js
self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open('lecciones').then(function(cache) {
      return cache.addAll([
        // Aquí añades el archivo que se mostrará cuando el usuario esté desconectado
        '/LearnDo/listarCursos?offline=true',
      ]);
    })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    // Intentamos buscar el recurso en la red.
    fetch(event.request).then(function(response) {
      // Si lo encontramos, simplemente lo devolvemos sin almacenarlo en caché.
      return response;
    }).catch(function() {
      // Si no podemos buscarlo en la red, intentamos buscarlo en la caché.
      return caches.match(event.request).then(function(response) {
        if (response) {
          // Si el recurso está en la caché, lo devolvemos directamente.
          return response;
        } else {
          // Si no, mostramos la página offline.
          return caches.match('/LearnDo/listarCursos?offline=true');
        }
      });
    })
  );
});