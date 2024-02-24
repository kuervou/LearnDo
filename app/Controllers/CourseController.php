<?php


namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\CategoriaModel;
use App\Models\ModuloModel;
use App\Models\PagoModel;
use App\Models\ForoModel;
use App\Models\SeminaryModel;
use App\Models\ValoracionModel;
use App\Models\EvaluacionModel;
use App\Models\PruebaModel;
use App\Models\EstudianteModel;
use App\Models\SugerenciaModel;
use ZipArchive;

class CourseController extends BaseController
{

    public function alCurso()
    {
        $mensaje = session('mensaje');
        $Categorias =  new CategoriaModel();
        $categorias = $Categorias->listarCategorias();

        //Inicializamos el modelo de estudiante
        $EstudianteModel = new EstudianteModel();

        //Traemos todos los estudiantes
        $estudiantes = $EstudianteModel->listarEstudiantes();

        $data = [
            "categorias" => $categorias,
            "mensaje" => $mensaje,
            "estudiantes" => $estudiantes
        ];


        return view('course/altaCurso', $data);
    }

    public function altaCurso()
    {
        //Obtengo los datos del formulario
        $nombre = $this->request->getPost('nombre');
        $descripcion = $this->request->getPost('descripcion');
        $precio = $this->request->getPost('precio');
        $creditos_otorga = $this->request->getPost('creditos');
        $instructores = $this->request->getPost('instructores[]');
        $categorias = $this->request->getPost('categorias[]');
        $colaboradores = $this->request->getPost('colaboradores[]');

        //Nos traemos el nick del organizador en la sesion
        $nick_organizador = session()->get('usuario');

        //Inicializamos los modelos
        $Course = new CourseModel();
        $Categoria = new CategoriaModel();

        //Inicializamos variables de errores
        $errores = array();
        $mensajes = array();

        //Vamos a ver si el curso ya existe
        $datosCurso = $Course->obtenerCurso(['nombre' => $nombre]);
        if (count($datosCurso) > 0) {
            array_push($errores, "El curso ya existe");
            session()->set('errores', $errores);
            return redirect()->to(base_url('/altaCurso'));
        }


        //Vamos a concatenar los instructores en un string
        $instructoresConcatenados = "";
        foreach ($instructores as $instructor) {
            $instructoresConcatenados .= $instructor . ", ";
        }


        //Si no hay errores, vamos a crear el curso
        $datosCurso = array(
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'creditos_otorga' => $creditos_otorga,
            'nick_organizador' => $nick_organizador,

            //Agregamos los instructores al curso
            'instructores' => $instructoresConcatenados
        );

        //Insertamos el curso
        $idCurso = $Course->insertarCurso($datosCurso);

        foreach ($categorias as $categoria) {
            //Agregamos las categorias al curso
            $data_categoria = array(
                'nombre_cat' => $categoria,
                'id_curso' => $idCurso
            );
            $Categoria->agregarCategoria($data_categoria);
        }


        //Agregamos los colaboradores a la base de datos
        if ($colaboradores != null) {
            foreach ($colaboradores as $colaborador) {
                $this->invitarColaborador($colaborador, $nombre, $idCurso);
            }
        }
        //Creamos los foros
        $Foro = new ForoModel();
        $general = array(
            'nombre' => 'General',
            'id_curso' => $idCurso,
            'descripcion' => 'Foro general del curso'
        );
        $Foro->insertarForo($general);

        $consultas = array(
            'nombre' => 'Consultas',
            'id_curso' => $idCurso,
            'descripcion' => 'Foro para consultas sobre el curso'
        );
        $Foro->insertarForo($consultas);

        $avisos = array(
            'nombre' => 'Avisos',
            'id_curso' => $idCurso,
            'descripcion' => 'Foro para avisos relacionados al curso'
        );
        $Foro->insertarForo($avisos);


        //Seteamos el mensaje de éxito
        session()->set('mensaje', "Curso creado con éxito");

        //Seteamos el mensaje en la sesión
        session()->set('mensajes', $mensajes);

        $nick = [

            "nick_organizador" => $nick_organizador
        ];

        $cursos = $Course->obtenerCurso($nick);
        $data = [
            "cursos" => $cursos
        ];

        //Redireccionamos al homeOrganizador
        return redirect()->to(base_url('/consultarCurso?id_curso=' . $idCurso));
    }

    public function consultarCurso()
    {
        //obtener los valores de los parametros
        $id_curso = $this->request->getGet('id_curso');
        $porcentaje = $this->request->getGet('porcentaje');

        //inicializar los modelos
        $Course = new CourseModel();

        //obtener los datos de la base de datos
        $datosCurso = $Course->obtenerCurso(['id_curso' => $id_curso]);

        //Obtenemos los foros del curso
        $Foro = new ForoModel();
        $foros = $Foro->obtenerForo(['id_curso' => $id_curso]);

        $dataId = [
            "id_curso" => $id_curso
        ];

        $Modulo = new ModuloModel();
        $modulos = $Modulo->obtenerModulo($dataId);

        $Valoracion = new ValoracionModel();

        $nick = session('usuario');

        $datosValoracion = $Valoracion->obtenerValoracionCurso($nick, $id_curso);

        //Traemos los colaboradores
        $EstudianteModel = new EstudianteModel();

        //Buscamos los colaboradores
        $colaboradores = $EstudianteModel->obtenerColaborador(['id_curso' => $id_curso]);

        //vamos a ver si el pibe ha comprado el curso
        $Pago = new PagoModel();
        $data = [
            "id_curso" => $id_curso,
            "nick_estudiante" => $nick,
        ];
        $datosPago = $Pago->obtenerPago($data);
        if (count($datosPago) > 0) {
            $datosCurso[0]['comprado'] = true;
        } else {
            $datosCurso[0]['comprado'] = false;
        }


        //pasar los datos a la vista
        $data = [
            "datosCurso" => $datosCurso,
            "modulos" => $modulos,
            "foros" => $foros,
            "valoraciones" => $datosValoracion,
            "porcentaje" => $porcentaje,
            "colaboradores" => $colaboradores,
            
        ];
        //cargar la vista
        return view('course/consultarCurso', $data);
    }

    public function listarCursos()
    {
        //obtener el parametro "offline"
        $offline = $this->request->getGet('offline');

        //Inicializamos la lista de cursos
        $tipo = session('tipoUser');
        $Course = new CourseModel();

        //Inicializamos la lista de seminarios
        $Seminary = new SeminaryModel();

        if ($tipo == "organizador") {
            $nick = [
                "nick_organizador" => session('usuario')
            ];

            $cursos = $Course->obtenerCurso($nick);
            $data = [
                "cursos" => $cursos,
                "offline" => false
            ];
            return view('course/listarCursos', $data);
        } else if ($tipo == "estudiante") {
            //Inicializamos el modelo de evaluaciones
            $Evaluacion = new EvaluacionModel();

            $nick = [
                "nick_estudiante" => session('usuario')
            ];

            $Pago = new PagoModel();
            $pagos = $Pago->listarCursos($nick);

            $porcentajes = array();

            foreach ($pagos as $curso) {
                $Prueba = new PruebaModel();
                $evaluacionesAprobadas = $Prueba->obtenerPruebaNickCurso(['id_curso' => $curso['id_curso']], $nick);

                $Evaluacion = new EvaluacionModel();
                $evaluacionesTotales = $Evaluacion->obtenerEvaluacionCurso(['id_curso' => $curso['id_curso']]);

                if (count($evaluacionesTotales) > 0) {
                    $porcentaje = (count($evaluacionesAprobadas) * 100) / count($evaluacionesTotales);
                    $porcentajes[$curso['id_curso']] = $porcentaje;
                } else {
                    $porcentajes[$curso['id_curso']] = 0;
                }
            }
            if ($offline == true) {
                $nick = [
                    "nick_estudiante" => session('usuario')
                ];

                $Course = new CourseModel();
                $cursos = $Course->obtenerCursosDescargados($nick);

                $data = [
                    "cursos" => $cursos,
                    "offline" => true,
                    "porcentajes" => $porcentajes
                ];
            } else {
                $data = [
                    "cursos" => $pagos,
                    "offline" => false,
                    "porcentajes" => $porcentajes
                ];
            }

            return view('course/listarCursos', $data);
        }
    }


    //función para descargar los cursos en un .zip
    public function descargarCurso()
    {

        //Obtener el id del curso
        $id_curso = $this->request->getGet('id_curso');

        //Inicializamos los modelos
        $Course = new CourseModel();

        //llamar a la función para obtener todas las rutas de las lecciones del curso
        $rutas = $Course->obtenerRutas($id_curso);

        $rutasArchivos = [];  // Inicializamos el array fuera del bucle

        foreach ($rutas as $ruta) {
            // Reemplaza los caracteres no deseados y limita la longitud del nombre del archivo
            $nombreModulo = preg_replace("/[^a-zA-Z0-9]/", "_", substr($ruta['nombre_modulo'], 0, 100));
            $nombreLeccion = preg_replace("/[^a-zA-Z0-9]/", "_", substr($ruta['nombre_leccion'], 0, 100));

            $rutasArchivos[PUBLICPATH . 'uploads/contenidoMultimedia/lecciones/' . $ruta['multimedia']] =
                'modulo_' . $nombreModulo . '_leccion_' . $nombreLeccion . $ruta['multimedia'];
        }


        // Nombre del archivo zip que se descargará
        $zipname = $rutas[0]['nombre_curso'] . '.zip';

        // Crear un nuevo objeto ZipArchive
        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE);

        // Agregar cada archivo a partir de las rutas especificadas
        foreach ($rutasArchivos as $rutaArchivo => $nombrePersonalizado) {
            // Verificar que el archivo existe
            if (file_exists($rutaArchivo)) {
                $zip->addFile($rutaArchivo, $nombrePersonalizado);
            }
        }

        // Cerrar el archivo zip
        $zip->close();

        // Configurar los encabezados para forzar la descarga del archivo zip
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename=' . $zipname);
        header('Content-Length: ' . filesize($zipname));

        // Leer y enviar el archivo al cliente
        readfile($zipname);

        // Eliminar el archivo zip del servidor
        unlink($zipname);
    }

    public function valorarCurso()
    {

        $data = $this->request->getJSON();

        $nota = $data->rating;
        $id_curso = $data->id_curso;
        $opinion = $data->opinion;
        $nick_estudiante = session('usuario');

        $data = [
            'opinion' => $opinion,
            'nota' => $nota,
            'id_curso' => $id_curso,
            'nick_estudiante' => $nick_estudiante
        ];

        $Valoracion = new ValoracionModel();

        $Valoracion->agregarValoracionCurso($data);

        //Retornamos la respuesta
        return $this->response->setJSON($data);
    }

    public function invitarColaborador($nick, $nombre, $id_curso)
    {
        $emailConfig = new \Config\Email();
        $email = \Config\Services::email();
        $email->initialize($emailConfig);

        //Inicializamos los errores y mensajes
        $errores = array();
        $mensajes = array();

        //creación del token

        // Generar un timestamp
        $timestamp = time();

        // Creación del token
        $random = md5(rand(0, 1000));
        $seed = $random . uniqid();
        $hashed_seed = password_hash($seed, PASSWORD_BCRYPT);

        // Agregar el timestamp al token
        $token = $timestamp . $hashed_seed;

        //Inicializamos el modelo del estudiante
        $Estudiante = new EstudianteModel();

        //Traemos al estudiante
        $estudiante = $Estudiante->obtenerEstudiante(['nick' => $nick]);

        //Traemos el mail del formulario
        $userEmail = $estudiante[0]['email'];

        // Almacenar el token en la base de datos

        $user = $Estudiante->where('email', $userEmail)->first();
        if (!$user) {
            // Manejar el caso en que el usuario no exista
            return false;
        }

        // Almacenar el token en la base de datos
        $updated = $Estudiante->actualizar($user['nick'], ['token' => $token]);

        if (!$updated) {
            // Manejar el caso en que la actualización falla
            return false;
        }

        $verificationLink = base_url() . "invitacionColaborador?token={$token}&id_curso={$id_curso}";

        $email->setTo($userEmail);
        $email->setSubject('Invitación a colaborar');
        $email->setMessage("Has sido invitado a ser colaborador del curso {$nombre}, para aceptar o regchazar la invitación haz click en el siguiente enlace: {$verificationLink}");

        if ($email->send()) {
            //Seteamos el mensaje de éxito
            array_push($mensajes, "Solicitud realizada, revisa el correo {$userEmail} para restablecer tu contraseña en los próximos 60 minutos");

            //Seteamos el mensaje en la sesion
            session()->set('mensajes', $mensajes);

            //Redireccionamos a la página de login
            return redirect()->to(base_url('/login'));
        } else {
            return false;
        }
    }

    public function procesarInvitacionColaborador()
    {
        $errores = array();
        $token = $this->request->getGet('token');
        $id_curso = $this->request->getGet('id_curso');

        //Inicializamos el modelo de curso
        $CourseModel = new CourseModel();

        //Buscamos el curso
        $course = $CourseModel->obtenerCurso(['id_curso' => $id_curso]);

        $Estudiante = new EstudianteModel();

        $estudiante = $Estudiante->obtenerEstudiante(['token' => $token]);
        $user = $estudiante[0];

        if ($user) {
            //extraer el timestamp del token
            $timestamp = substr($user['token'], 0, 10); //como usamos time() para crearlo el timestamp tiene 10 caracteres

            //si el token no ha expirado (20 minutos) verificamos que $token sea válido
            if (time() - $timestamp < (60 * 60)) {
                //verificar que el token sea válido
                if ($user['token'] == $token) {
                    //actualizar el estado del usuario a 'activo' y el token a null
                    $ok = $Estudiante->actualizar($user['nick'], ['token' => null]);
                }

                if ($ok) {
                    $data = [
                        'user' => $user['nick'],
                        'curso' => $course,
                    ];
                    return view('course/invitacionColaborador', $data);
                } else {
                    //cargar errores en la vista
                    array_push($errores, "Token inválido, inicie la solicitud nuevamente");
                    $data = [
                        "errores" => $errores
                    ];
                    return view('users/accept/accept_failure', $data);
                }
            } else {
                //cargar errores en la vista
                array_push($errores, "Token expirado, inicie la solicitud nuevamente");
                $ok = $Estudiante->actualizar($user['nick'], ['token' => null]);

                $data = [
                    "errores" => $errores
                ];
                return view('users/accept/accept_failure', $data);
            }
        } else {
            //cargar errores en la vista
            array_push($errores, "Link de verificación inválido");
            $data = [
                "errores" => $errores
            ];
            return view('users/accept/accept_failure', $data);
        }
    }

    public function aceptarInvitacion()
    {
        //Traemos los parametros del form 
        $nick = $nombre = $this->request->getPost('nick');
        $id_curso = $this->request->getPost('id_curso');

        //Hacemos un data con las variables
        $data = [
            'nick_estudiante' => $nick,
            'id_curso' => $id_curso
        ];

        //Traemos el modelo de estudiantes
        $Estudiante = new EstudianteModel();

        //Agregamos el colaborador
        $Estudiante->agregarColaborador($data);

        //Ademas, le regalamos el curso al estudiante
        $PagoModel = new PagoModel();

        //Creamos la data
        $data = [
            'precio' => 0,
            'metodo_pago' => 'cortesía',
            'creditos_usados' => 0,
            'nick_estudiante' => $nick,
            'id_curso' => $id_curso
        ];

        $PagoModel->insertarPago($data);

        //Retornamos a la vista
        return redirect()->to(base_url('/consultarCurso?id_curso=' . $id_curso));
    }
}
