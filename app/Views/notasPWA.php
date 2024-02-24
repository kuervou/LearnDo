<!-- Incluimos el head -->
<?= view('template/head') ?>
<style>
               .table-container {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(8.5px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        table {
            color: #fff;
        }
        th {
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
        }
        td {
            text-shadow: 0.5px 0.5px 1px rgba(0, 0, 0, 0.2);
        }
    </style>
<body>
<div class="table-container text-white">
        <table class="table table-hover text-white">
        <thead class="thead-dark text-white">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Controlador</th>
            <th scope="col">Responsabilidades</th>
        </tr>
        </thead>
        <tbody>
<tr>
    <th scope="row">1</th>
    <td>HomeController</td>
    <td>Manejar las operaciones de la página de inicio.</td>
</tr>
<tr>
    <th scope="row">2</th>
    <td>EstudianteController</td>
    <td>Administrar el registro y la verificación de los estudiantes.</td>
</tr>
<tr>
    <th scope="row">3</th>
    <td>OrganizadorController</td>
    <td>Gestionar la creación y eliminación de organizadores.</td>
</tr>
<tr>
    <th scope="row">4</th>
    <td>UsuarioController</td>
    <td>Manejar inicio de sesión, cierre de sesión, gestión de perfiles y listas de usuarios, actualizaciones de perfiles.</td>
</tr>
<tr>
    <th scope="row">5</th>
    <td>ChatController</td>
    <td>Manejar operaciones de chat, como cargar chats, escribir mensajes y obtener mensajes.</td>
</tr>
<tr>
    <th scope="row">6</th>
    <td>CourseController</td>
    <td>Administrar la creación, consulta, listado, descarga y valoración de cursos, y gestionar la invitación a colaboradores.</td>
</tr>
<tr>
    <th scope="row">7</th>
    <td>SugerenciasController</td>
    <td>Manejar la lista, consulta y aprobación o rechazo de sugerencias.</td>
</tr>
<tr>
    <th scope="row">8</th>
    <td>ForoController</td>
    <td>Manejar la creación, consulta y listado de discusiones, y también añadir mensajes a las discusiones.</td>
</tr>
<tr>
    <th scope="row">9</th>
    <td>ModuleController</td>
    <td>Manejar la creación y consulta de módulos.</td>
</tr>
<tr>
    <th scope="row">10</th>
    <td>LeccionController</td>
    <td>Manejar la creación, consulta, descarga y sugerencia de lecciones, y también navegar entre lecciones.</td>
</tr>
<tr>
    <th scope="row">11</th>
    <td>SeminaryController</td>
    <td>Manejar la creación, consulta, listado, registro y valoración de seminarios, y enviar recordatorios.</td>
</tr>
<tr>
    <th scope="row">12</th>
    <td>EvaluacionController</td>
    <td>Administrar la creación, edición, realización y consulta de evaluaciones, y manejar la creación de preguntas.</td>
</tr>
<tr>
    <th scope="row">13</th>
    <td>PagoController</td>
    <td>Manejar los pagos, historial de pagos y la compra de créditos.</td>
</tr>
<tr>
    <th scope="row">14</th>
    <td>PaypalController</td>
    <td>Manejar las transacciones de PayPal.</td>
</tr>
<tr>
    <th scope="row">15</th>
    <td>TiendaController</td>
    <td>Administrar la tienda.</td>
</tr>
<tr>
    <th scope="row">16</th>
    <td>SearchController</td>
    <td>Gestionar las operaciones de búsqueda.</td>
</tr>
<tr>
    <th scope="row">17</th>
    <td>AuthLinkedInController</td>
    <td>Manejar la autenticación de LinkedIn.</td>
</tr>
<tr>
    <th scope="row">18</th>
    <td>MapaController</td>
    <td>Mostrar el mapa.</td>
</tr>
<tr>
    <th scope="row">19</th>
    <td>CalendarController</td>
    <td>Manejar la adición de eventos al calendario de Google.</td>
</tr>
<tr>
    <th scope="row">20</th>
    <td>StatController</td>
    <td>Manejar las estadísticas.</td>
</tr>
<tr>
    <th scope="row">21</th>
    <td>PdfController</td>
    <td>Generar PDFs.</td>
</tr>
<tr>
    <th scope="row">22</th>
    <td>MuroController</td>
    <td>Manejar la creación de publicaciones en el muro.</td>
</tr>
<tr>
    <th scope="row">23</th>
    <td>SuperadminController</td>
    <td>Manejar el tablero del superadministrador.</td>
</tr>
<tr>
    <th scope="row">24</th>
    <td>CategoriaController</td>
    <td>Gestionar la creación, modificación, listado y eliminación de categorías.</td>
</tr>
</tbody>
        </table>
    </div>

   <div class="container text-white">
    <br>
   <h1 id="notas-sobre-pwa">Notas sobre PWA</h1>
<ol>
<strong><li>¿Qué es PWA?</li></strong>
</ol>
<p>PWA son las siglas de Progressive Web Application, o Aplicación Web Progresiva en español. Las PWA son una evolución de las aplicaciones web tradicionales que buscan ofrecer una experiencia de usuario similar a la de una aplicación nativa, pero a través de un navegador web. </p>
<p>Entre las características más destacadas de las PWA se encuentran:</p>
<ul>
<li><p><strong>Responsividad:</strong> se adaptan a cualquier formato de pantalla (móvil, tableta, portátil, escritorio).</p>
</li>
<li><p><strong>Independencia de la conectividad:</strong> pueden funcionar sin conexión a Internet gracias al uso de service workers, que permiten almacenar en caché ciertos recursos de la aplicación.</p>
</li>
<li><p><strong>Actualización progresiva:</strong> se actualizan automáticamente cada vez que el usuario las utiliza, sin necesidad de descargar e instalar actualizaciones.</p>
</li>
<li><p><strong>Seguridad:</strong> se sirven a través de HTTPS para prevenir intrusiones y garantizar que el contenido no ha sido manipulado.</p>
</li>
<li><p><strong>Instalables:</strong> los usuarios pueden añadir la PWA a su pantalla de inicio, como si fuera una aplicación nativa, sin necesidad de descargarla desde una tienda de aplicaciones.</p>
</li>
</ul>
<br>
<strong><ol start="2">
<li>¿Es una buena idea implementar el modo offline con PWA en un proyecto con Codeigniter4?</li></strong>
</ol>
<p>Sí, es una buena idea. El hecho de que estés usando Codeigniter4 para tu proyecto no debería ser un impedimento para implementar una PWA. Codeigniter es un framework de PHP utilizado para el desarrollo de aplicaciones web, mientras que las PWA son una técnica que se aplica en el lado del cliente, principalmente utilizando JavaScript. Es posible implementar una PWA en cualquier sitio web, independientemente del lenguaje o el framework que se esté utilizando en el servidor.</p>

<br>
<strong><ol start="3">
<li>Consideraciones a tener en cuenta</li></strong>
</ol>
<ul>
<li><p><strong>Planificación:</strong> Antes de empezar a convertir tu web en una PWA, es importante que planees qué recursos necesitarás almacenar en caché para su funcionamiento offline. Esto puede incluir archivos HTML, CSS, JavaScript, imágenes, vídeos, y cualquier otro recurso que sea necesario para la funcionalidad de tu sitio.</p>
</li>
<li><p><strong>Diseño de la experiencia de usuario:</strong> Debes pensar en cómo se comportará tu aplicación cuando no haya conexión a Internet. ¿Cómo se mostrarán las lecciones descargadas? ¿Cómo se indicará al usuario que está viendo contenido offline?</p>
</li>
<li><p><strong>Service Workers:</strong> Son la clave para el funcionamiento offline de las PWA. Te recomiendo que te familiarices con ellos, ya que son los que permiten almacenar en caché los recursos de tu aplicación y gestionar las solicitudes de red cuando no hay conexión.</p>
</li>
<li><p><strong>Manifiesto de la aplicación web:</strong> Es un archivo JSON que proporciona información sobre la aplicación (como su nombre, icono, descripción, etc.) y especifica cómo debe comportarse cuando se instala en el dispositivo del usuario.</p>
</li>
<li><p><strong>Compatibilidad con navegadores:</strong> Aunque la mayoría de los navegadores modernos soportan PWA, hay diferencias en el nivel de soporte entre ellos. Es importante probar tu PWA en varios navegadores para asegurarte de que ofrece una buena experiencia de usuario en todos ellos.</p>
</li>
<li><p><strong>Tamaño de almacenamiento:</strong> Ten en cuenta que los navegadores limitan la cantidad de datos que puedes almacenar en caché. Esto puede ser un problema si los cursos de tu web son muy grandes. Deberías diseñar tu aplicación para que maneje de forma eficiente el almacenamiento en caché y limpie los datos que ya</p>
</li>
</ul>
<p> no se necesiten.</p>
<ul>
<li><strong>Seguridad:</strong> Las PWA deben ser servidas a través de HTTPS. Si tu sitio aún no está configurado para HTTPS, deberás hacerlo antes de implementar la PWA.</li>
</ul>
<br>
<br>
<br>
<h1 id="manual-para-la-implementación-de-pwa-con-modo-offline">Manual para la Implementación de PWA con Modo Offline</h1>
<p>Este manual detalla las consideraciones clave para la implementación de una Progressive Web Application (PWA) con una funcionalidad de modo offline.</p>
<h2 id="1-planificación">1. Planificación</h2>
<p>Antes de iniciar la implementación de la PWA, es crucial determinar qué recursos se necesitan almacenar en caché para permitir el funcionamiento offline. Estos pueden incluir:</p>
<ul>
<li>Archivos HTML</li>
<li>Hojas de estilo CSS</li>
<li>Archivos JavaScript</li>
<li>Imágenes</li>
<li>Vídeos</li>
<li>Cualquier otro recurso necesario para la funcionalidad del sitio.</li>
</ul>
<h2 id="2-diseño-de-la-experiencia-de-usuario">2. Diseño de la Experiencia de Usuario</h2>
<p>El diseño de la experiencia de usuario para el modo offline debe ser cuidadosamente considerado. Algunas preguntas claves a responder son:</p>
<ul>
<li>¿Cómo se mostrarán las lecciones descargadas?</li>
<li>¿Cómo se indicará al usuario que está viendo contenido offline?</li>
</ul>
<h2 id="3-service-workers">3. Service Workers</h2>
<p>Los Service Workers son esenciales para el funcionamiento offline de las PWA. Se utilizan para almacenar en caché los recursos de la aplicación y gestionar las solicitudes de red cuando no hay conexión. Familiarízate con ellos y cómo se usan en el contexto de una PWA.</p>
<h2 id="4-manifiesto-de-la-aplicación-web">4. Manifiesto de la Aplicación Web</h2>
<p>El manifiesto de la aplicación web es un archivo JSON que proporciona información sobre la aplicación (como su nombre, icono, descripción, etc.) y especifica cómo debe comportarse cuando se instala en el dispositivo del usuario.</p>
<h2 id="5-compatibilidad-con-navegadores">5. Compatibilidad con Navegadores</h2>
<p>Asegúrate de probar tu PWA en varios navegadores para garantizar una buena experiencia de usuario en todos ellos. La mayoría de los navegadores modernos soportan PWA, pero el nivel de soporte puede variar.</p>
<h2 id="6-tamaño-de-almacenamiento">6. Tamaño de Almacenamiento</h2>
<p>Los navegadores limitan la cantidad de datos que puedes almacenar en caché. Si los cursos de tu web son muy grandes, debes diseñar tu aplicación para que maneje de forma eficiente el almacenamiento en caché y limpie los datos que ya no se necesiten.</p>
<h2 id="7-seguridad">7. Seguridad</h2>
<p>Las PWA deben ser servidas a través de HTTPS. Si tu sitio aún no está configurado para HTTPS, deberás hacerlo antes de implementar la PWA.</p>
<p>Espero que este manual te sirva como guía en tu proceso de implementación de una PWA con funcionalidad de modo offline. ¡Buena suerte!</p>
<br>
<br>
<br>
<h1 id="service-workers-en-progressive-web-applications">Service Workers en Progressive Web Applications</h1>
<p>Los Service Workers son una de las tecnologías clave que permiten a las Progressive Web Applications (PWA) ofrecer características similares a las de las aplicaciones nativas, como la capacidad de trabajar offline y recibir notificaciones push. Este informe detalla el funcionamiento y uso de los Service Workers en el contexto de una PWA.</p>
<h2 id="¿qué-es-un-service-worker">¿Qué es un Service Worker?</h2>
<p>Un Service Worker es un tipo de web worker, un script de JavaScript que el navegador ejecuta en segundo plano, independiente de una página web, abriendo la puerta a características que no necesitan una página web o interacción del usuario. Los Service Workers son una tecnología que permite funciones como captura de solicitudes de red, almacenamiento en caché de recursos, notificaciones push y actualizaciones de fondo.</p>
<h2 id="ciclo-de-vida-de-un-service-worker">Ciclo de Vida de un Service Worker</h2>
<p>El ciclo de vida de un Service Worker consta de tres fases: instalación, activación y fetch/funcionamiento.</p>
<ol>
<li><strong>Instalación:</strong> En esta fase, puedes precargar algunos datos y recursos en la caché. Cuando todos los recursos se han descargado y se ha completado la instalación, el Service Worker pasa a la fase de activación.</li>
</ol>
<pre><code class="language-javascript">self.addEventListener(&#39;install&#39;, function(event) {
    event.waitUntil(
        caches.open(&#39;my-cache&#39;).then(function(cache) {
            return cache.addAll([
                &#39;/&#39;,
                &#39;/index.html&#39;,
                &#39;/styles/main.css&#39;,
                &#39;/script/main.js&#39;
            ]);
        })
    );
});
</code></pre>
<ol start="2">
<li><strong>Activación:</strong> Esta fase ocurre después de la instalación, y es un buen momento para gestionar las actualizaciones de tu Service Worker.</li>
</ol>
<pre><code class="language-javascript">self.addEventListener(&#39;activate&#39;, function(event) {
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
</code></pre>
<ol start="3">
<li><strong>Fetch/Funcionamiento:</strong> Una vez que el Service Worker se activa, puede controlar las solicitudes de red y decidir cómo responder a ellas. Esto es lo que permite a las PWA funcionar offline.</li>
</ol>
<pre><code class="language-javascript">self.addEventListener(&#39;fetch&#39;, function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            // Los caches siempre deben ser actualizados con la última respuesta
            // Además, las respuestas válidas son añadidas a la caché
            fetch(event.request).then(function(response) {
                caches.open(&#39;my-cache&#39;).then(function(cache) {
                    cache.put(event.request, response.clone());
                });
            });
            return response || fetch(event.request);
        })
    );
});
</code></pre>
<h2 id="seguridad">Seguridad</h2>
<p>Los Service Workers sólo pueden ser registrados y utilizados sobre una conexión segura (HTTPS) debido a la gran cantidad de control que tienen sobre las solicitudes y respuestas de red.</p>
<h2 id="soporte-de-navegadores">Soporte de Navegadores</h2>
<p>Aunque la mayoría de los navegadores modernos soportan Service Workers, debes comprobar la compatibilidad del navegador para asegurarte de que tu PWA funcionará correctamente en todos los navegadores que tu público objetivo pueda utilizar.</p>
<p>Los Service Workers son una parte esencial de las Progressive Web Applications y son fundamentales para ofrecer una experiencia de usuario fluida y eficiente, tanto online como offline. Asegúrate de comprender su funcionamiento y ciclo de vida antes de implementar tu PWA.</p>
<br>
<br>
<br>

<h1 id="configurar-https">Configurar HTTPS</h1>
<p>Para el desarrollo local, los navegadores permiten el uso de Service Workers sobre <code>http://localhost</code> para facilitar el desarrollo y las pruebas. Sin embargo, para el despliegue en producción, debes asegurarte de que tu aplicación esté servida a través de HTTPS.</p>
<p>Si estás interesado en configurar HTTPS en tu entorno local para probar características que requieren una conexión segura, puedes generar certificados SSL auto-firmados y configurar tu servidor XAMPP para usar HTTPS. Aquí te dejo un conjunto de pasos básicos para hacerlo:</p>
<ol>
<li><strong>Generar un certificado SSL auto-firmado</strong></li>
</ol>
<p>En la línea de comandos, navega hasta el directorio de certificados de Apache en tu instalación de XAMPP (por ejemplo, <code>C:\xampp\apache\conf\ssl.crt</code>) y ejecuta el siguiente comando:</p>
<pre><code>openssl req -x509 -out localhost.crt -keyout localhost.key \
  -newkey rsa:2048 -nodes -sha256 \
  -subj &#39;/CN=localhost&#39; -extensions EXT -config &lt;( \
   printf &quot;[dn]\nCN=localhost\n[req]\ndistinguished_name = dn\n[EXT]\nsubjectAltName=DNS:localhost\nkeyUsage=digitalSignature\nextendedKeyUsage=serverAuth&quot;)
</code></pre>
<p>Esto generará un nuevo certificado SSL auto-firmado (<code>localhost.crt</code>) y la clave correspondiente (<code>localhost.key</code>).</p>
<ol start="2">
<li><strong>Configurar Apache para usar SSL</strong></li>
</ol>
<p>Edita el archivo <code>httpd-ssl.conf</code> de Apache (por ejemplo, <code>C:\xampp\apache\conf\extra\httpd-ssl.conf</code>) y asegúrate de que las siguientes líneas estén configuradas con las rutas correctas a tus nuevos certificados:</p>
<pre><code>SSLCertificateFile &quot;C:/xampp/apache/conf/ssl.crt/localhost.crt&quot;
SSLCertificateKeyFile &quot;C:/xampp/apache/conf/ssl.key/localhost.key&quot;
</code></pre>
<ol start="3">
<li><strong>Habilitar HTTPS en Apache</strong></li>
</ol>
<p>Edita el archivo <code>httpd.conf</code> de Apache (por ejemplo, <code>C:\xampp\apache\conf\httpd.conf</code>) y descomenta la siguiente línea (quita el <code>#</code> al inicio) para habilitar el módulo SSL:</p>
<pre><code>LoadModule ssl_module modules/mod_ssl.so
</code></pre>
<p>Y agrega la siguiente línea al final del archivo para incluir la configuración SSL:</p>
<pre><code>Include conf/extra/httpd-ssl.conf
</code></pre>
<ol start="4">
<li><strong>Reiniciar Apache</strong></li>
</ol>
<p>Finalmente, reinicia el servidor Apache a través del panel de control de XAMPP para que los cambios surtan efecto.</p>
<p>Ahora deberías poder acceder a tu aplicación a través de <code>https://localhost</code>.</p>
<p>Recuerda que estos certificados auto-firmados generarán una advertencia en tu navegador ya que no están firmados por una Autoridad de Certificación reconocida. Para el desarrollo local, puedes añadir una excepción en tu navegador para permitir este certificado. Sin embargo, para la producción, deberás obtener un certificado SSL de una Autoridad de Certificación de confianza.</p>
<h2 id="observación">Observación</h2>
<ol>
<li>El comando <code>openssl</code> que proporcioné es para entornos basados en Unix, como Linux o MacOS. Para Windows, <code>openssl</code> puede no estar disponible por defecto. Sin embargo, puedes instalarlo utilizando Cygwin o una máquina virtual Linux, o puedes usarlo si tienes instalado Git Bash. Otra opción es usar una herramienta en línea para generar certificados SSL auto-firmados, pero debes tener cuidado y asegurarte de que la herramienta sea confiable y segura.</li>
</ol>
<br>
<br>
<br>

<h1 id="acceder-desde-lan">Acceder desde LAN</h1>
<ol start="2">
<li><p>Para acceder a tu aplicación desde un dispositivo móvil en la misma red LAN, necesitarás configurar tu servidor para que acepte conexiones desde otras direcciones IP además de <code>localhost</code>. En tu archivo de configuración de Apache (por ejemplo, <code>httpd.conf</code>), busca la sección que comienza con <code>&lt;Directory &quot;C:/xampp/htdocs&quot;&gt;</code> y cambia la línea <code>Require local</code> a <code>Require all granted</code>.</p>
<p>Sin embargo, para acceder a tu aplicación a través de HTTPS desde tu dispositivo móvil, necesitarás un certificado SSL válido para la dirección IP de tu máquina o un nombre de dominio que resuelva a esa dirección IP. Los certificados SSL auto-firmados normalmente generan advertencias de seguridad en los navegadores, y tendrías que configurar cada dispositivo móvil para que acepte tu certificado SSL auto-firmado, lo que puede no ser práctico.</p>
<p>Además, ten en cuenta que la dirección que usarías en tu dispositivo móvil sería algo como <code>https://IP-de-la-máquina-host/mi-app</code>, no <code>IP-de-la-máquina-host://mi-app</code>.</p>
<p>En resumen, mientras que es técnicamente posible configurar tu servidor de desarrollo local para aceptar conexiones desde dispositivos móviles en la misma red LAN, puede ser más complicado que simplemente desplegar tu aplicación en un servidor con un certificado SSL válido de una Autoridad de Certificación reconocida.</p>
<br>
<br>
<br>
<h1 id="implementación-de-modo-offline-en-un-proyecto-codeigniter4-utilizando-pwa-progressive-web-application">Implementación de Modo Offline en un Proyecto CodeIgniter4 Utilizando PWA (Progressive Web Application)</h1>
</li>
</ol>
<p>Este documento proporciona una guía paso a paso para implementar un modo offline en un proyecto CodeIgniter4 utilizando PWA. El objetivo es permitir a los usuarios acceder a ciertas funcionalidades de la aplicación, incluso cuando no tienen acceso a Internet.</p>
<h2 id="prerrequisitos">Prerrequisitos</h2>
<p>Asegúrate de tener lo siguiente antes de comenzar:</p>
<ul>
<li>PHP 7.3 o superior</li>
<li>CodeIgniter 4.1.3 o superior</li>
<li>Conocimientos básicos de JavaScript y conceptos de PWA</li>
</ul>
<h2 id="paso-1-crear-un-proyecto-codeigniter">Paso 1: Crear un Proyecto CodeIgniter</h2>
<p>Lo primero que necesitarás hacer es instalar un nuevo proyecto de CodeIgniter4. Puedes hacer esto utilizando Composer con el siguiente comando:</p>
<pre><code class="language-bash">composer create-project codeigniter4/appstarter
</code></pre>
<h2 id="paso-2-crear-un-service-worker">Paso 2: Crear un Service Worker</h2>
<p>El siguiente paso es crear un Service Worker, que es un script de JavaScript que tu navegador ejecuta en segundo plano y es la pieza central de cualquier PWA. Esto permitirá que tu aplicación funcione sin conexión.</p>
<p>Crea un nuevo archivo llamado <code>sw.js</code> en la carpeta <code>public</code> de tu proyecto de CodeIgniter. Aquí tienes un ejemplo básico de cómo debería ser este archivo:</p>
<pre><code class="language-javascript">var CACHE_NAME = &#39;mi-cache&#39;;
var urlsToCache = [
  &#39;/&#39;,
  &#39;/styles/main.css&#39;,
  &#39;/script/main.js&#39;
];

self.addEventListener(&#39;install&#39;, function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log(&#39;Opened cache&#39;);
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener(&#39;fetch&#39;, function(event) {
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
</code></pre>
<p>Este código básicamente almacena en caché los recursos especificados durante la instalación del Service Worker y luego sirve esos recursos en caché cuando se solicitan.</p>
<h2 id="paso-3-registrar-el-service-worker">Paso 3: Registrar el Service Worker</h2>
<p>Ahora necesitamos registrar el Service Worker en nuestra aplicación. Puedes hacerlo agregando el siguiente código a tu archivo JavaScript principal o a tu archivo HTML:</p>
<pre><code class="language-javascript">if (&#39;serviceWorker&#39; in navigator) {
  window.addEventListener(&#39;load&#39;, function() {
    navigator.serviceWorker.register(&#39;/sw.js&#39;).then(function(registration) {
      console.log(&#39;ServiceWorker registration successful with scope: &#39;, registration.scope);
    }, function(err) {
      console.log(&#39;ServiceWorker registration failed: &#39;, err);
    });
  });
}
</code></pre>
<p>Este código verifica si el navegador del usuario admite Service Workers y, si es así, registra el Service Worker que creamos en el paso anterior.</p>
<h2 id="paso-4-prueba-tu-pwa">Paso 4: Prueba tu PWA</h2>
<p>Finalmente, puedes probar tu PWA para asegurarte de que se está almacenando en caché y funcionando offline correctamente. Para hacer esto, puedes utilizar las herramientas de desarrollador de Chrome:</p>
<ol>
<li>Ve a la pestaña &quot;Application&quot;.</li>
<li>En la barra lateral izquierda, haz clic en &quot;Service Workers&quot;.</li>
<li>Verifica que tu Service Worker esté registrado y que los archivos se estén almacenando en caché.</li>
</ol>
<p>Además, puedes desconectar tu conexión a Internet para verificar que tu aplicación aún se carga y funciona correctamente.</p>
<hr>
<p>Recuerda que este es un ejemplo básico. Las PWAs pueden ser mucho más complejas, dependiendo de las</p>
<p> necesidades de tu aplicación. Sin embargo, este ejemplo debería ser suficiente para que entiendas los conceptos básicos de cómo implementar un modo offline en un proyecto CodeIgniter4 utilizando PWA.</p>

<br>
<br>
<br>

<h1 id="añadir-un-icono-de-aplicación-en-la-pantalla-de-inicio-con-pwa">Añadir un Icono de Aplicación en la Pantalla de Inicio con PWA</h1>
<p>Una de las grandes características de las PWA (Progressive Web Applications) es que se pueden instalar en el dispositivo del usuario como si fueran una aplicación nativa. Esto significa que los usuarios pueden ver un ícono de tu aplicación en su pantalla de inicio y acceder a ella directamente desde allí. Aquí te explicaré cómo hacerlo.</p>
<h2 id="prerrequisitos">Prerrequisitos</h2>
<p>Asegúrate de haber seguido los pasos de la sección anterior para implementar un modo offline en tu proyecto CodeIgniter4 utilizando PWA. Además, necesitarás un ícono para tu aplicación.</p>
<h2 id="paso-1-crear-el-archivo-manifest">Paso 1: Crear el Archivo Manifest</h2>
<p>El primer paso para hacer que tu PWA sea instalable es crear un archivo de manifiesto. El manifiesto es un archivo JSON que le dice al navegador cómo comportarse cuando tu aplicación se instala en el dispositivo del usuario.</p>
<p>Crea un archivo llamado <code>manifest.json</code> en tu carpeta <code>public</code> con el siguiente contenido:</p>
<pre><code class="language-json">{
  &quot;short_name&quot;: &quot;MiApp&quot;,
  &quot;name&quot;: &quot;Mi Aplicación&quot;,
  &quot;icons&quot;: [
    {
      &quot;src&quot;: &quot;/images/icons-192.png&quot;,
      &quot;type&quot;: &quot;image/png&quot;,
      &quot;sizes&quot;: &quot;192x192&quot;
    },
    {
      &quot;src&quot;: &quot;/images/icons-512.png&quot;,
      &quot;type&quot;: &quot;image/png&quot;,
      &quot;sizes&quot;: &quot;512x512&quot;
    }
  ],
  &quot;start_url&quot;: &quot;/&quot;,
  &quot;background_color&quot;: &quot;#3367D6&quot;,
  &quot;display&quot;: &quot;standalone&quot;,
  &quot;scope&quot;: &quot;/&quot;,
  &quot;theme_color&quot;: &quot;#3367D6&quot;
}
</code></pre>
<p>Aquí, <code>short_name</code> es el nombre que se mostrará en la pantalla de inicio del usuario. <code>icons</code> es una lista de imágenes que el navegador usará como ícono de tu aplicación. Asegúrate de reemplazar las rutas y los nombres de los archivos de los íconos con los tuyos propios.</p>
<h2 id="paso-2-enlazar-el-archivo-manifest-en-tu-html">Paso 2: Enlazar el Archivo Manifest en tu HTML</h2>
<p>Ahora debes vincular el archivo de manifiesto en tu HTML. Para hacer esto, agrega la siguiente línea a la cabecera de tu archivo HTML:</p>
<pre><code class="language-html">&lt;link rel=&quot;manifest&quot; href=&quot;/manifest.json&quot;&gt;
</code></pre>
<h2 id="paso-3-registrar-el-evento-beforeinstallprompt">Paso 3: Registrar el Evento &quot;beforeinstallprompt&quot;</h2>
<p>Para permitir que los usuarios instalen tu PWA, debes registrar el evento &quot;beforeinstallprompt&quot;. Este evento se dispara antes de que el navegador muestre el mensaje para instalar tu aplicación. Puedes registrar este evento en tu archivo JavaScript principal:</p>
<pre><code class="language-javascript">let deferredPrompt;

window.addEventListener(&#39;beforeinstallprompt&#39;, (e) =&gt; {
  e.preventDefault();
  deferredPrompt = e;
});

// Puedes usar deferredPrompt.prompt() para mostrar el mensaje de instalación cuando quieras, por ejemplo, al hacer clic en un botón.
</code></pre>
<h2 id="paso-4-prueba-tu-pwa">Paso 4: Prueba tu PWA</h2>
<p>Finalmente, puedes probar tu PWA para asegurarte de que se puede instalar correctamente. Para hacer esto, puedes utilizar las herramientas de desarrollador de Chrome:</p>
<ol>
<li>Ve a la pestaña &quot;Application&quot;.</li>
<li>En la barra lateral izquierda, haz clic en &quot;Manifest&quot;.</li>
<li>Verifica que tu manifiesto se esté cargando correctamente y que todas las propiedades estén establecidas correctamente.</li>
</ol>
<p>Además, puedes visitar tu aplicación en un dispositivo móvil y verificar que el navegador te da la opción de instalar</p>
<p>la.</p>
<hr>
<p>De nuevo, este es solo un ejemplo básico. Las PWAs pueden ser mucho más complejas, dependiendo de las necesidades de tu aplicación. Sin embargo, este ejemplo debería ser suficiente para que entiendas los conceptos básicos de cómo hacer que tu PWA sea instalable en un proyecto CodeIgniter4.</p>


<br>
<br>
<br>


   </div>
<!-- Incluimos el footer -->
<?= view('template/footer') ?> 