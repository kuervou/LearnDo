<?php

namespace App\Controllers;

use App\Models\LeccionModel;
use App\Models\SugerenciaModel;

class LeccionController extends BaseController
{
    public function altaLeccion()
    {
        $id_modulo = $this->request->getGet('id_modulo');
        $data = [
            "id_modulo" => $id_modulo
        ];
        $mensaje = session('mensaje');
        return view('leccion/altaLeccion', $data);
    }

    public function agregarLeccion()
    {

        //Obtengo los datos del formulario
        $nombre = $this->request->getPost('nombre');
        $duracion = $this->request->getPost('duracion');
        $id_modulo = $this->request->getPost('id_modulo');

        //Inicializamos los modelos
        $Leccion = new LeccionModel();

        //Inicializamos variables de errores
        $errores = array();
        $mensajes = array();

        //Vamos a ver si el Leccion ya existe
        $datosLeccion = $Leccion->obtenerLeccion(['nombre' => $nombre]);
        if (count($datosLeccion) > 0) {
            array_push($errores, "La lección ya existe");
            session()->set('errores', $errores);
            return redirect()->to(base_url('/altaLeccion'));
        }

        //Vamos a manejar el contenido multimedia
        $file = $this->request->getFile('contenido_multimedia');
        if (!$file || !$file->isValid()) {

            array_push($errores, "Hubo un error al cargar el archivo: " . $file->getErrorString());
        } else {
            $newName = $file->getRandomName();
            $originalExtension = $file->getClientExtension();
            $newName = pathinfo($newName, PATHINFO_FILENAME) . '.' . $originalExtension;
            $file->move(PUBLICPATH . 'uploads/contenidoMultimedia/lecciones', $newName);
        }

        //Si hay errores, redirigir a la página de altaLeccion
        if (!empty($errores)) {
            session()->set('errores', $errores);
            return redirect()->to(base_url('/altaLeccion'));
        }

        //Si no hay errores, vamos a crear la leccion
        $datosLeccion = array(
            'nombre' => $nombre,
            'duracion' => $duracion,
            'ruta_multimedia' => $newName,
            'id_modulo' => $id_modulo
        );

        //Guardamos el Leccion
        $id_Leccion = $Leccion->insertarLeccion($datosLeccion);

        //Creamos $data con id_Leccion
        $datosLeccion = $Leccion->obtenerLeccion(['id_Leccion' => $id_Leccion]);
         //obtener el nick del usuario logueado
         $nick = session()->get('usuario');


         $isDownload = $Leccion->isDownload($id_Leccion, $nick);
 
         //agregamos $isDownload a $datosLeccion
         $datosLeccion['isDownload'] = $isDownload;
 

        $data = [
            "datosLeccion" => $datosLeccion
        ];

        //Guardamos el mensaje
        array_push($mensajes, "Lección creada con éxito");

        //Seteamos el mensaje en la sesion
        session()->set('mensajes', $mensajes);

        //Redireccionamos a la página de consultarLeccion
        return view('leccion/consultarLeccion', $data);
    }


    public function consultarLeccion()
    {
        //obtener los valores de los parametros
        $id_Leccion = $this->request->getGet('id_Leccion');

        //inicializar los modelos
        $Leccion = new LeccionModel();

        //obtener los datos de la base de datos
        $datosLeccion = $Leccion->obtenerLeccion(['id_Leccion' => $id_Leccion]);

        //obtener el nick del usuario logueado
        $nick = session()->get('usuario');


        $isDownload = $Leccion->isDownload($id_Leccion, $nick);

        //agregamos $isDownload a $datosLeccion
        $datosLeccion['isDownload'] = $isDownload;

        //pasar los datos a la vista
        $data = [
            "datosLeccion" => $datosLeccion
        ];


        //cargar la vista
        return view('leccion/consultarLeccion', $data);
    }


    public function leccionAnterior()
    {
        // Consultar la base de datos para encontrar la lección anterior
        $id_modulo = $this->request->getGet('id_modulo');
        $id_Leccion = $this->request->getGet('id_Leccion');
        $Leccion = new LeccionModel();
        $idLeccionAnterior = $Leccion->obtenerIdAnterior($id_Leccion, $id_modulo);


        // Si no hay lección anterior, redirigir al usuario de vuelta a la lección actual
        if ($idLeccionAnterior == null) {

            $datosLeccion = $Leccion->obtenerLeccion(['id_Leccion' => $id_Leccion]);

            //obtener el nick del usuario logueado
            $nick = session()->get('usuario');


            $isDownload = $Leccion->isDownload($id_Leccion, $nick);

            //agregamos $isDownload a $datosLeccion
            $datosLeccion['isDownload'] = $isDownload;

            $data = [
                "datosLeccion" => $datosLeccion
            ];

            return view('leccion/consultarLeccion', $data);
        }

        // Redirigir al usuario a la vista de la lección anterior

        $datosLeccion = $Leccion->obtenerLeccion(['id_Leccion' => $idLeccionAnterior]);

        //obtener el nick del usuario logueado
        $nick = session()->get('usuario');

        $isDownload = $Leccion->isDownload($idLeccionAnterior, $nick);

        //agregamos $isDownload a $datosLeccion
        $datosLeccion['isDownload'] = $isDownload;


        $data = [
            "datosLeccion" => $datosLeccion
        ];

        return view('leccion/consultarLeccion', $data);
    }

    public function leccionSiguiente()
    {

        // Consultar la base de datos para encontrar la lección siguiente
        $id_modulo = $this->request->getGet('id_modulo');
        $id_Leccion = $this->request->getGet('id_Leccion');
        $Leccion = new LeccionModel();
        $idLeccionSiguiente = $Leccion->obtenerIdSiguiente($id_Leccion, $id_modulo);

        // Si no hay lección siguiente, redirigir al usuario de vuelta a la lección actual
        if ($idLeccionSiguiente == null) {

            $datosLeccion = $Leccion->obtenerLeccion(['id_Leccion' => $id_Leccion]);

            //obtener el nick del usuario logueado
            $nick = session()->get('usuario');


            $isDownload = $Leccion->isDownload($id_Leccion, $nick);

            //agregamos $isDownload a $datosLeccion
            $datosLeccion['isDownload'] = $isDownload;

            $data = [
                "datosLeccion" => $datosLeccion
            ];

            return view('leccion/consultarLeccion', $data);
        }

        // Redirigir al usuario a la vista de la lección siguiente
        $datosLeccion = $Leccion->obtenerLeccion(['id_Leccion' => $idLeccionSiguiente]);

        //obtener el nick del usuario logueado
        $nick = session()->get('usuario');

        $isDownload = $Leccion->isDownload($idLeccionSiguiente, $nick);
  
        //agregamos $isDownload a $datosLeccion
        $datosLeccion['isDownload'] = $isDownload;

        $data = [
            "datosLeccion" => $datosLeccion
        ];

        return view('leccion/consultarLeccion', $data);
    }

    public function descargarLeccion(){
        //obtener los valores de los parametros
        $id_leccion = $this->request->getGet('id_leccion');
    
        //inicializar los modelos
        $Leccion = new LeccionModel();

        //obtener el nick del usuario actual
        $nick = session()->get('usuario');

        //modificar el estado de la leccion a "descargada" en la bd
        $Leccion->download($id_leccion, $nick);

        //redireccionar a la pagina anterior
        return redirect()->back();

    
    }

    public function lessonsDownloaded(){
        //obtener el nick del usuario actual
        $nick = session()->get('usuario');
        $lecciones = [];
        if($nick != null){
        //inicializar los modelos
        $Leccion = new LeccionModel();
    
        //obtener las lecciones descargadas por el usuario
        $lecciones = $Leccion->lessonsDownloaded($nick);
        }
    
        //devolver las lecciones como una respuesta JSON
        return $this->response->setStatusCode(200) // código HTTP 200 indica que la petición fue exitosa
                            ->setJSON($lecciones); // establecer los datos a devolver como JSON
    }

    public function crearSugerencia(){
        //Traemos los parametros de la url
        $id_curso = $this->request->getGet('id_curso');

        $data = [
            'id_curso' => $id_curso,
        ];

        //retornamos a la vista
        return view('leccion/sugerirLeccion', $data);
    }

    public function sugerirLeccion(){
        //Obtener los datos del formulario
        $id_curso = $this->request->getPost('id_curso'); 

        //Vamos a manejar el contenido multimedia
        $file = $this->request->getFile('contenido_multimedia');
        if (!$file || !$file->isValid()) {

            array_push($errores, "Hubo un error al cargar el archivo: " . $file->getErrorString());
        } else {
            $newName = $file->getRandomName();
            $originalExtension = $file->getClientExtension();
            $newName = pathinfo($newName, PATHINFO_FILENAME) . '.' . $originalExtension;
            $file->move(PUBLICPATH . 'uploads/contenidoMultimedia/lecciones', $newName);
        }

        //Creamos el data 
        $data = [
            'ruta_multimedia' => $newName,
            'fecha' => date("Y-m-d H:i:s"),
            'aprobada' => 0,
            'id_curso' => $id_curso,
            'nick_estudiante' => session()->get('usuario')
        ];

        //Persistimos la sugerencia
        $SugerenciaModel = new SugerenciaModel();

        $SugerenciaModel->agregarSugerencia($data);  

        //Redirigimos al curso
        return redirect()->to(base_url('/consultarCurso?id_curso='.$id_curso));
    }
}
