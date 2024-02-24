function obtenerLeccionesDescargadas() {
    console.log("Obteniendo lecciones descargadas...");
    var xhttp = new XMLHttpRequest();

    xhttp.open("GET", "/LearnDo/lessonsDownloaded", true);

    xhttp.setRequestHeader("Content-type", "application/json");

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Comprobar si el tipo de contenido de la respuesta es JSON antes de intentar parsearla
            var contentType = this.getResponseHeader("Content-Type");
            if (contentType && contentType.indexOf("application/json") !== -1) {
                var data = JSON.parse(this.responseText);

                // Comprobar si hay lecciones descargadas
                if (data.length == 0) {
                    // Si no hay lecciones descargadas, limpiamos la caché
                    caches.keys().then(function (names) {
                        for (let name of names) caches.delete(name);
                    });
                } else {
                    var cachePromise = caches.open("lecciones");
                    for (var i = 0; i < data.length; i++) {
                        var lessonPath = "/LearnDo/consultarLeccion?id_Leccion=" + data[i].id_leccion;
                        var modulePath = "/LearnDo/consultarModulo?id_modulo=" + data[i].id_modulo;
                        var coursePath = "/LearnDo/consultarCurso?id_curso=" + data[i].id_curso;

                        fetchLessonModuleCourse(lessonPath, modulePath, coursePath, cachePromise);
                    }
                    
                }
            } else {
                console.error("Expected JSON, but received: " + this.responseText);
            }
        }
    };

    xhttp.send();
}

function fetchLessonModuleCourse(lessonPath, modulePath, coursePath, cachePromise) {
    fetch(lessonPath, { redirect: "follow" }).then(function (response) {
        processFetchResponse(response, lessonPath, cachePromise);
    });

    fetch(modulePath, { redirect: "follow" }).then(function (response) {
        processFetchResponse(response, modulePath, cachePromise);
    });

    fetch(coursePath, { redirect: "follow" }).then(function (response) {
        processFetchResponse(response, coursePath, cachePromise);
    });

    fetch('/LearnDo/listarCursos?offline=true', { redirect: "follow" }).then(function (response) {
        processFetchResponse(response, '/LearnDo/listarCursos?offline=true', cachePromise);
    });
}

function processFetchResponse(response, path, cachePromise) {
    if (!response.ok) {
        throw new TypeError("Bad response status");
    }

    // Leer y registrar la respuesta
    response.clone().text().then(function (text) {
        console.log(text);
    });

    cachePromise.then(function (cache) {
        // Guardamos la respuesta en la cache con la clave de la ruta
        cache.put(path, response);
    });
}

// Llamada a la función
obtenerLeccionesDescargadas();