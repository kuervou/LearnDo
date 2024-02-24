<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//Rutas para Home
$routes->get('/', 'HomeController::index');


//Rutas para Estudiante
 //MOVER A UN CONTROLADOR DE USUARIOS GENERAL
$routes->get('/register','EstudianteController::register');
$routes->post('/registro','EstudianteController::registro');
$routes->get('/register/verify', 'EstudianteController::verify');
$routes->get('register/verification_success', 'EstudianteController::verificationSuccess');
$routes->get('register/verification_failure', 'EstudianteController::verificationFailure');
$routes->get('register/verification_unfinished', 'EstudianteController::verificationUnfinished');

//Rutas para Organizador
$routes->get('/gestionOrganizador','OrganizadorController::gestionOrganizador');
$routes->post('/altaOrganizador','OrganizadorController::altaOrganizador');
$routes->get('/eliminarOrganizador','OrganizadorController::eliminarOrganizador');

//Rutas para Usuarios 
$routes->get('/logout','UsuarioController::logout');
$routes->post('/login','UsuarioController::login');
$routes->get('/login','UsuarioController::iniciarSesion');
$routes->get('/profile','UsuarioController::profile');
$routes->get('/listarUsuarios','UsuarioController::listarUsuarios');
$routes->post('/actualizarPerfil','UsuarioController::actualizarPerfil');
$routes->post('/actualizarContrasena','UsuarioController::actualizarContrasena');
$routes->post('/actualizarImagen','UsuarioController::actualizarImagen');
$routes->get('/forgotPassword','UsuarioController::processForgotPassword');
$routes->post('/forgotPassword','UsuarioController::forgotPassword');
$routes->post('/restablecerContrasena','UsuarioController::restablecerContrasena');


//Rutas para chats
$routes->get('/cargarChats','ChatController::cargarChats');
$routes->post('/escribirMensaje','ChatController::escribirMensaje'); 
$routes->get('/liveChat','ChatController::chat');
$routes->post('/chat/insertMessage','ChatController::insertMessage');
$routes->post('/chat/getMessages','ChatController::getMessages');

//Rutas para Cursos 
$routes->get('/altaCurso','CourseController::alCurso');
$routes->post('/altaCurso','CourseController::altaCurso');
$routes->get('/consultarCurso','CourseController::consultarCurso');
$routes->get('/listarCursos','CourseController::listarCursos');
$routes->get('/descargarCurso','CourseController::descargarCurso');
$routes->post('/valorarCurso','CourseController::valorarCurso');
$routes->post('/invitacionColaborador','CourseController::invitacionColaborador');
$routes->get('/invitacionColaborador','CourseController::procesarInvitacionColaborador');
$routes->post('/aceptarInvitacion','CourseController::aceptarInvitacion');

//Rutas para Sugerencias
$routes->get('/listarSugerencias','SugerenciasController::listarSugerencias');
$routes->get('/consultarSugerencia','SugerenciasController::consultarSugerencia');
$routes->post('/aceptarSugerencia','SugerenciasController::aceptarSugerencia');
$routes->post('/rechazarSugerencia','SugerenciasController::rechazarSugerencia');

//Rutas para foros
$routes->get('/altaDiscusion','ForoController::altaDiscusion');
$routes->get('/listarDiscusiones','ForoController::listarDiscusiones');
$routes->get('/consultarDiscusion','ForoController::consultarDiscusion');
$routes->post('/agregarDiscusion','ForoController::agregarDiscusion');
$routes->post('/agregarMensaje','ForoController::agregarMensaje');

//Rutas para Modulos
$routes->get('/altaModulo','ModuleController::altaModulo');
$routes->post('/agregarModulo','ModuleController::agregarModulo');
$routes->get('/consultarModulo','ModuleController::consultarModulo');

//Rutas para Lecciones
$routes->get('/altaLeccion','LeccionController::altaLeccion');
$routes->post('/agregarLeccion','LeccionController::agregarLeccion');
$routes->get('/consultarLeccion','LeccionController::consultarLeccion');
$routes->get('/leccionAnterior','LeccionController::leccionAnterior');
$routes->get('/leccionSiguiente','LeccionController::leccionSiguiente');    
$routes->get('/descargarLeccion', 'LeccionController::descargarLeccion');
$routes->get('/lessonsDownloaded', 'LeccionController::lessonsDownloaded');
$routes->get('/sugerirLeccion','LeccionController::crearSugerencia');
$routes->post('/sugerirLeccion','LeccionController::sugerirLeccion');

//Rutas para Seminarios
$routes->get('/altaSeminario','SeminaryController::altaSeminario');
$routes->get('/listarSeminarios','SeminaryController::listarSeminarios');
$routes->post('/registrarSeminario','SeminaryController::registrarSeminario');
$routes->get('/consultarSeminario','SeminaryController::consultarSeminario');
$routes->get('/enviarRecordatorios', 'SeminaryController::enviarRecordatorios');
$routes->post('/valorarSeminario','SeminaryController::valorarSeminario');

//Rutas para Evaluaciones
$routes->get('/altaEvaluacion','EvaluacionController::altaEvaluacion');
$routes->post('/agregarEvaluacion','EvaluacionController::agregarEvaluacion');
$routes->get('/editarEvaluacion','EvaluacionController::editarEvaluacion');
$routes->post('/crearPreguntas','EvaluacionController::crearPreguntas');
$routes->post('/realizarEvaluacion','EvaluacionController::realizarEvaluacion');
$routes->get('/consultarIntento','EvaluacionController::consultarIntento');

//Rutas para Pagos
$routes->get('/realizarPago','PagoController::realizarPago');
$routes->post('/historialPagos','PagoController::historialPagos');
$routes->post('/pagarCreditos','PagoController::pagarCreditos');

//paypal
$routes->get('/PaypalController/paymentStatus', 'PaypalController::paymentStatus');
$routes->get('/PaypalController/payWithPaypal', 'PaypalController::payWithPaypal');

//Rutas para Tienda
$routes->get('/tienda','TiendaController::tienda');

//Rutas para SearchBar
$routes->post('/buscar','SearchController::buscar');
$routes->get('/buscarXCategoria','SearchController::buscarXCategoria');

//Rutas Linkedin
$routes->get('/auth/linkedin', 'AuthLinkedInController::index');

//Mapa provisorio
$routes->add('/mapa', 'MapaController::mostrarMapa');

//Calendar 
$routes->get('/add-to-google-calendar', 'CalendarController::addEvent');
$routes->match(['get', 'post'], '/add-to-google-calendar', 'CalendarController::addEvent');

//PWA 
$routes->get('/pwa', 'HomeController::pwa');

//Estadisticas 
$routes->get('/estadisticas', 'StatController::estadisticas');

//Ruta para pdfs
$routes->get('/generate-pdf','PdfController::generatePdf');

//Rutas para muro
$routes->get('/muro','MuroController::muro');
$routes->post('/agregarPublicacion','MuroController::agregarPublicacion');

$routes->get('/ups','HomeController::ups');

//Rutas para superadmin
$routes->get('/dashboard','SuperadminController::dashboard');

//Rutas para categorias
$routes->get('/gestionCategorias','CategoriaController::listarCategorias');
$routes->get('/altaCategoria','CategoriaController::altaCategoria');
$routes->post('/altaCategoria','CategoriaController::crearCategoria');
$routes->get('/modificarCategoria','CategoriaController::modifyCategory');
$routes->post('/modificarCategoria','CategoriaController::modificarCategoria');
$routes->get('/eliminarCategoria','CategoriaController::eliminarCategoria');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
