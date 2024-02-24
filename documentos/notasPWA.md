# Notas sobre PWA
1. ¿Qué es PWA?

PWA son las siglas de Progressive Web Application, o Aplicación Web Progresiva en español. Las PWA son una evolución de las aplicaciones web tradicionales que buscan ofrecer una experiencia de usuario similar a la de una aplicación nativa, pero a través de un navegador web. 

Entre las características más destacadas de las PWA se encuentran:

- **Responsividad:** se adaptan a cualquier formato de pantalla (móvil, tableta, portátil, escritorio).

- **Independencia de la conectividad:** pueden funcionar sin conexión a Internet gracias al uso de service workers, que permiten almacenar en caché ciertos recursos de la aplicación.

- **Actualización progresiva:** se actualizan automáticamente cada vez que el usuario las utiliza, sin necesidad de descargar e instalar actualizaciones.

- **Seguridad:** se sirven a través de HTTPS para prevenir intrusiones y garantizar que el contenido no ha sido manipulado.

- **Instalables:** los usuarios pueden añadir la PWA a su pantalla de inicio, como si fuera una aplicación nativa, sin necesidad de descargarla desde una tienda de aplicaciones.

2. ¿Es una buena idea implementar el modo offline con PWA en un proyecto con Codeigniter4?

Sí, es una buena idea. El hecho de que estés usando Codeigniter4 para tu proyecto no debería ser un impedimento para implementar una PWA. Codeigniter es un framework de PHP utilizado para el desarrollo de aplicaciones web, mientras que las PWA son una técnica que se aplica en el lado del cliente, principalmente utilizando JavaScript. Es posible implementar una PWA en cualquier sitio web, independientemente del lenguaje o el framework que se esté utilizando en el servidor.

3. Consideraciones a tener en cuenta

- **Planificación:** Antes de empezar a convertir tu web en una PWA, es importante que planees qué recursos necesitarás almacenar en caché para su funcionamiento offline. Esto puede incluir archivos HTML, CSS, JavaScript, imágenes, vídeos, y cualquier otro recurso que sea necesario para la funcionalidad de tu sitio.

- **Diseño de la experiencia de usuario:** Debes pensar en cómo se comportará tu aplicación cuando no haya conexión a Internet. ¿Cómo se mostrarán las lecciones descargadas? ¿Cómo se indicará al usuario que está viendo contenido offline?

- **Service Workers:** Son la clave para el funcionamiento offline de las PWA. Te recomiendo que te familiarices con ellos, ya que son los que permiten almacenar en caché los recursos de tu aplicación y gestionar las solicitudes de red cuando no hay conexión.

- **Manifiesto de la aplicación web:** Es un archivo JSON que proporciona información sobre la aplicación (como su nombre, icono, descripción, etc.) y especifica cómo debe comportarse cuando se instala en el dispositivo del usuario.

- **Compatibilidad con navegadores:** Aunque la mayoría de los navegadores modernos soportan PWA, hay diferencias en el nivel de soporte entre ellos. Es importante probar tu PWA en varios navegadores para asegurarte de que ofrece una buena experiencia de usuario en todos ellos.

- **Tamaño de almacenamiento:** Ten en cuenta que los navegadores limitan la cantidad de datos que puedes almacenar en caché. Esto puede ser un problema si los cursos de tu web son muy grandes. Deberías diseñar tu aplicación para que maneje de forma eficiente el almacenamiento en caché y limpie los datos que ya

 no se necesiten.

- **Seguridad:** Las PWA deben ser servidas a través de HTTPS. Si tu sitio aún no está configurado para HTTPS, deberás hacerlo antes de implementar la PWA.

# 
#
#

# Manual para la Implementación de PWA con Modo Offline

Este manual detalla las consideraciones clave para la implementación de una Progressive Web Application (PWA) con una funcionalidad de modo offline.

## 1. Planificación

Antes de iniciar la implementación de la PWA, es crucial determinar qué recursos se necesitan almacenar en caché para permitir el funcionamiento offline. Estos pueden incluir:

- Archivos HTML
- Hojas de estilo CSS
- Archivos JavaScript
- Imágenes
- Vídeos
- Cualquier otro recurso necesario para la funcionalidad del sitio.

## 2. Diseño de la Experiencia de Usuario

El diseño de la experiencia de usuario para el modo offline debe ser cuidadosamente considerado. Algunas preguntas claves a responder son:

- ¿Cómo se mostrarán las lecciones descargadas?
- ¿Cómo se indicará al usuario que está viendo contenido offline?

## 3. Service Workers

Los Service Workers son esenciales para el funcionamiento offline de las PWA. Se utilizan para almacenar en caché los recursos de la aplicación y gestionar las solicitudes de red cuando no hay conexión. Familiarízate con ellos y cómo se usan en el contexto de una PWA.

## 4. Manifiesto de la Aplicación Web

El manifiesto de la aplicación web es un archivo JSON que proporciona información sobre la aplicación (como su nombre, icono, descripción, etc.) y especifica cómo debe comportarse cuando se instala en el dispositivo del usuario.

## 5. Compatibilidad con Navegadores

Asegúrate de probar tu PWA en varios navegadores para garantizar una buena experiencia de usuario en todos ellos. La mayoría de los navegadores modernos soportan PWA, pero el nivel de soporte puede variar.

## 6. Tamaño de Almacenamiento

Los navegadores limitan la cantidad de datos que puedes almacenar en caché. Si los cursos de tu web son muy grandes, debes diseñar tu aplicación para que maneje de forma eficiente el almacenamiento en caché y limpie los datos que ya no se necesiten.

## 7. Seguridad

Las PWA deben ser servidas a través de HTTPS. Si tu sitio aún no está configurado para HTTPS, deberás hacerlo antes de implementar la PWA.

Espero que este manual te sirva como guía en tu proceso de implementación de una PWA con funcionalidad de modo offline. ¡Buena suerte!

#
#
#

# Service Workers en Progressive Web Applications

Los Service Workers son una de las tecnologías clave que permiten a las Progressive Web Applications (PWA) ofrecer características similares a las de las aplicaciones nativas, como la capacidad de trabajar offline y recibir notificaciones push. Este informe detalla el funcionamiento y uso de los Service Workers en el contexto de una PWA.

## ¿Qué es un Service Worker?

Un Service Worker es un tipo de web worker, un script de JavaScript que el navegador ejecuta en segundo plano, independiente de una página web, abriendo la puerta a características que no necesitan una página web o interacción del usuario. Los Service Workers son una tecnología que permite funciones como captura de solicitudes de red, almacenamiento en caché de recursos, notificaciones push y actualizaciones de fondo.

## Ciclo de Vida de un Service Worker

El ciclo de vida de un Service Worker consta de tres fases: instalación, activación y fetch/funcionamiento.

1. **Instalación:** En esta fase, puedes precargar algunos datos y recursos en la caché. Cuando todos los recursos se han descargado y se ha completado la instalación, el Service Worker pasa a la fase de activación.

```javascript
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open('my-cache').then(function(cache) {
            return cache.addAll([
                '/',
                '/index.html',
                '/styles/main.css',
                '/script/main.js'
            ]);
        })
    );
});
```

2. **Activación:** Esta fase ocurre después de la instalación, y es un buen momento para gestionar las actualizaciones de tu Service Worker.

```javascript
self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.filter(function(cacheName) {
                    // Elimina las cachés antiguas
                }).map(function(cacheName) {
                    return caches.delete(cacheName);
                })
            );
        })
    );
});
```

3. **Fetch/Funcionamiento:** Una vez que el Service Worker se activa, puede controlar las solicitudes de red y decidir cómo responder a ellas. Esto es lo que permite a las PWA funcionar offline.

```javascript
self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            // Los caches siempre deben ser actualizados con la última respuesta
            // Además, las respuestas válidas son añadidas a la caché
            fetch(event.request).then(function(response) {
                caches.open('my-cache').then(function(cache) {
                    cache.put(event.request, response.clone());
                });
            });
            return response || fetch(event.request);
        })
    );
});
```

## Seguridad

Los Service Workers sólo pueden ser registrados y utilizados sobre una conexión segura (HTTPS) debido a la gran cantidad de control que tienen sobre las solicitudes y respuestas de red.

## Soporte de Navegadores

Aunque la mayoría de los navegadores modernos soportan Service Workers, debes comprobar la compatibilidad del navegador para asegurarte de que tu PWA funcionará correctamente en todos los navegadores que tu público objetivo pueda utilizar.

Los Service Workers son una parte esencial de las Progressive Web Applications y son fundamentales para ofrecer una experiencia de usuario fluida y eficiente, tanto online como offline. Asegúrate de comprender su funcionamiento y ciclo de vida antes de implementar tu PWA.


#
#
#

# Configurar HTTPS
Para el desarrollo local, los navegadores permiten el uso de Service Workers sobre `http://localhost` para facilitar el desarrollo y las pruebas. Sin embargo, para el despliegue en producción, debes asegurarte de que tu aplicación esté servida a través de HTTPS.

Si estás interesado en configurar HTTPS en tu entorno local para probar características que requieren una conexión segura, puedes generar certificados SSL auto-firmados y configurar tu servidor XAMPP para usar HTTPS. Aquí te dejo un conjunto de pasos básicos para hacerlo:

1. **Generar un certificado SSL auto-firmado**

En la línea de comandos, navega hasta el directorio de certificados de Apache en tu instalación de XAMPP (por ejemplo, `C:\xampp\apache\conf\ssl.crt`) y ejecuta el siguiente comando:

```
openssl req -x509 -out localhost.crt -keyout localhost.key \
  -newkey rsa:2048 -nodes -sha256 \
  -subj '/CN=localhost' -extensions EXT -config <( \
   printf "[dn]\nCN=localhost\n[req]\ndistinguished_name = dn\n[EXT]\nsubjectAltName=DNS:localhost\nkeyUsage=digitalSignature\nextendedKeyUsage=serverAuth")
```

Esto generará un nuevo certificado SSL auto-firmado (`localhost.crt`) y la clave correspondiente (`localhost.key`).

2. **Configurar Apache para usar SSL**

Edita el archivo `httpd-ssl.conf` de Apache (por ejemplo, `C:\xampp\apache\conf\extra\httpd-ssl.conf`) y asegúrate de que las siguientes líneas estén configuradas con las rutas correctas a tus nuevos certificados:

```
SSLCertificateFile "C:/xampp/apache/conf/ssl.crt/localhost.crt"
SSLCertificateKeyFile "C:/xampp/apache/conf/ssl.key/localhost.key"
```

3. **Habilitar HTTPS en Apache**

Edita el archivo `httpd.conf` de Apache (por ejemplo, `C:\xampp\apache\conf\httpd.conf`) y descomenta la siguiente línea (quita el `#` al inicio) para habilitar el módulo SSL:

```
LoadModule ssl_module modules/mod_ssl.so
```

Y agrega la siguiente línea al final del archivo para incluir la configuración SSL:

```
Include conf/extra/httpd-ssl.conf
```

4. **Reiniciar Apache**

Finalmente, reinicia el servidor Apache a través del panel de control de XAMPP para que los cambios surtan efecto.

Ahora deberías poder acceder a tu aplicación a través de `https://localhost`.

Recuerda que estos certificados auto-firmados generarán una advertencia en tu navegador ya que no están firmados por una Autoridad de Certificación reconocida. Para el desarrollo local, puedes añadir una excepción en tu navegador para permitir este certificado. Sin embargo, para la producción, deberás obtener un certificado SSL de una Autoridad de Certificación de confianza.

## Observación

1. El comando `openssl` que proporcioné es para entornos basados en Unix, como Linux o MacOS. Para Windows, `openssl` puede no estar disponible por defecto. Sin embargo, puedes instalarlo utilizando Cygwin o una máquina virtual Linux, o puedes usarlo si tienes instalado Git Bash. Otra opción es usar una herramienta en línea para generar certificados SSL auto-firmados, pero debes tener cuidado y asegurarte de que la herramienta sea confiable y segura.
#
#
#


# Acceder desde LAN

2. Para acceder a tu aplicación desde un dispositivo móvil en la misma red LAN, necesitarás configurar tu servidor para que acepte conexiones desde otras direcciones IP además de `localhost`. En tu archivo de configuración de Apache (por ejemplo, `httpd.conf`), busca la sección que comienza con `<Directory "C:/xampp/htdocs">` y cambia la línea `Require local` a `Require all granted`.

   Sin embargo, para acceder a tu aplicación a través de HTTPS desde tu dispositivo móvil, necesitarás un certificado SSL válido para la dirección IP de tu máquina o un nombre de dominio que resuelva a esa dirección IP. Los certificados SSL auto-firmados normalmente generan advertencias de seguridad en los navegadores, y tendrías que configurar cada dispositivo móvil para que acepte tu certificado SSL auto-firmado, lo que puede no ser práctico.

   Además, ten en cuenta que la dirección que usarías en tu dispositivo móvil sería algo como `https://IP-de-la-máquina-host/mi-app`, no `IP-de-la-máquina-host://mi-app`.

   En resumen, mientras que es técnicamente posible configurar tu servidor de desarrollo local para aceptar conexiones desde dispositivos móviles en la misma red LAN, puede ser más complicado que simplemente desplegar tu aplicación en un servidor con un certificado SSL válido de una Autoridad de Certificación reconocida.



   #
   #
   #

   # Implementación de Modo Offline en un Proyecto CodeIgniter4 Utilizando PWA (Progressive Web Application)

Este documento proporciona una guía paso a paso para implementar un modo offline en un proyecto CodeIgniter4 utilizando PWA. El objetivo es permitir a los usuarios acceder a ciertas funcionalidades de la aplicación, incluso cuando no tienen acceso a Internet.

## Prerrequisitos

Asegúrate de tener lo siguiente antes de comenzar:

- PHP 7.3 o superior
- CodeIgniter 4.1.3 o superior
- Conocimientos básicos de JavaScript y conceptos de PWA

## Paso 1: Crear un Proyecto CodeIgniter

Lo primero que necesitarás hacer es instalar un nuevo proyecto de CodeIgniter4. Puedes hacer esto utilizando Composer con el siguiente comando:

```bash
composer create-project codeigniter4/appstarter
```

## Paso 2: Crear un Service Worker

El siguiente paso es crear un Service Worker, que es un script de JavaScript que tu navegador ejecuta en segundo plano y es la pieza central de cualquier PWA. Esto permitirá que tu aplicación funcione sin conexión.

Crea un nuevo archivo llamado `sw.js` en la carpeta `public` de tu proyecto de CodeIgniter. Aquí tienes un ejemplo básico de cómo debería ser este archivo:

```javascript
var CACHE_NAME = 'mi-cache';
var urlsToCache = [
  '/',
  '/styles/main.css',
  '/script/main.js'
];
self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});
self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        if (response) {
          return response;
        }
        return fetch(event.request);
      }
    )
  );
});
```

Este código básicamente almacena en caché los recursos especificados durante la instalación del Service Worker y luego sirve esos recursos en caché cuando se solicitan.

## Paso 3: Registrar el Service Worker

Ahora necesitamos registrar el Service Worker en nuestra aplicación. Puedes hacerlo agregando el siguiente código a tu archivo JavaScript principal o a tu archivo HTML:

```javascript
if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/sw.js').then(function(registration) {
      console.log('ServiceWorker registration successful with scope: ', registration.scope);
    }, function(err) {
      console.log('ServiceWorker registration failed: ', err);
    });
  });
}
```

Este código verifica si el navegador del usuario admite Service Workers y, si es así, registra el Service Worker que creamos en el paso anterior.

## Paso 4: Prueba tu PWA

Finalmente, puedes probar tu PWA para asegurarte de que se está almacenando en caché y funcionando offline correctamente. Para hacer esto, puedes utilizar las herramientas de desarrollador de Chrome:

1. Ve a la pestaña "Application".
2. En la barra lateral izquierda, haz clic en "Service Workers".
3. Verifica que tu Service Worker esté registrado y que los archivos se estén almacenando en caché.

Además, puedes desconectar tu conexión a Internet para verificar que tu aplicación aún se carga y funciona correctamente.

---

Recuerda que este es un ejemplo básico. Las PWAs pueden ser mucho más complejas, dependiendo de las

 necesidades de tu aplicación. Sin embargo, este ejemplo debería ser suficiente para que entiendas los conceptos básicos de cómo implementar un modo offline en un proyecto CodeIgniter4 utilizando PWA.


 #
 #
 #

 # Añadir un Icono de Aplicación en la Pantalla de Inicio con PWA

Una de las grandes características de las PWA (Progressive Web Applications) es que se pueden instalar en el dispositivo del usuario como si fueran una aplicación nativa. Esto significa que los usuarios pueden ver un ícono de tu aplicación en su pantalla de inicio y acceder a ella directamente desde allí. Aquí te explicaré cómo hacerlo.

## Prerrequisitos

Asegúrate de haber seguido los pasos de la sección anterior para implementar un modo offline en tu proyecto CodeIgniter4 utilizando PWA. Además, necesitarás un ícono para tu aplicación.

## Paso 1: Crear el Archivo Manifest

El primer paso para hacer que tu PWA sea instalable es crear un archivo de manifiesto. El manifiesto es un archivo JSON que le dice al navegador cómo comportarse cuando tu aplicación se instala en el dispositivo del usuario.

Crea un archivo llamado `manifest.json` en tu carpeta `public` con el siguiente contenido:

```json
{
  "short_name": "MiApp",
  "name": "Mi Aplicación",
  "icons": [
    {
      "src": "/images/icons-192.png",
      "type": "image/png",
      "sizes": "192x192"
    },
    {
      "src": "/images/icons-512.png",
      "type": "image/png",
      "sizes": "512x512"
    }
  ],
  "start_url": "/",
  "background_color": "#3367D6",
  "display": "standalone",
  "scope": "/",
  "theme_color": "#3367D6"
}
```

Aquí, `short_name` es el nombre que se mostrará en la pantalla de inicio del usuario. `icons` es una lista de imágenes que el navegador usará como ícono de tu aplicación. Asegúrate de reemplazar las rutas y los nombres de los archivos de los íconos con los tuyos propios.

## Paso 2: Enlazar el Archivo Manifest en tu HTML

Ahora debes vincular el archivo de manifiesto en tu HTML. Para hacer esto, agrega la siguiente línea a la cabecera de tu archivo HTML:

```html
<link rel="manifest" href="/manifest.json">
```

## Paso 3: Registrar el Evento "beforeinstallprompt"

Para permitir que los usuarios instalen tu PWA, debes registrar el evento "beforeinstallprompt". Este evento se dispara antes de que el navegador muestre el mensaje para instalar tu aplicación. Puedes registrar este evento en tu archivo JavaScript principal:

```javascript
let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
  e.preventDefault();
  deferredPrompt = e;
});
// Puedes usar deferredPrompt.prompt() para mostrar el mensaje de instalación cuando quieras, por ejemplo, al hacer clic en un botón.
```

## Paso 4: P rueba tu PWA

Finalmente, puedes probar tu PWA para asegurarte de que se puede instalar correctamente. Para hacer esto, puedes utilizar las herramientas de desarrollador de Chrome:

1. Ve a la pestaña "Application".
2. En la barra lateral izquierda, haz clic en "Manifest".
3. Verifica que tu manifiesto se esté cargando correctamente y que todas las propiedades estén establecidas correctamente.

Además, puedes visitar tu aplicación en un dispositivo móvil y verificar que el navegador te da la opción de instalar

la.

---

De nuevo, este es solo un ejemplo básico. Las PWAs pueden ser mucho más complejas, dependiendo de las necesidades de tu aplicación. Sin embargo, este ejemplo debería ser suficiente para que entiendas los conceptos básicos de cómo hacer que tu PWA sea instalable en un proyecto CodeIgniter4.