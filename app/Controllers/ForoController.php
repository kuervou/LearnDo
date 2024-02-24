<?php

namespace App\Controllers;
use App\Models\DiscusionModel;
use App\Models\MensajeModel;

class ForoController extends BaseController
{
   
    public function altaDiscusion(){
        //Traemos la id del foro en la url
        $id_foro = $this->request->getGet('id_foro');

        //creamos un data con la id
        $data = [
            'id_foro' => $id_foro
        ];

        //return view
        return view('foro/altaDiscusion', $data);
    }

    public function listarDiscusiones(){
        //Traemos la id del foro de la url
        $id_foro = $this->request->getGet('id_foro');

        //Creamos un modelo de discusiones
        $Discusion = new DiscusionModel();
        $discusiones = $Discusion->obtenerDiscusion(['id_foro' => $id_foro]);

        //Creamos un data con las discusiones
        $data = [
            'discusiones' => $discusiones,
            'id_foro' => $id_foro
        ];

        //return view
        return view('foro/listarDiscusiones', $data);
    }

    public function consultarDiscusion(){
        //Traemos la id de la discusion de la url
        $id_discusion = $this->request->getGet('id_discusion');

        //Creamos un modelo de discusiones
        $Discusion = new DiscusionModel();
        $discusion = $Discusion->obtenerDiscusion(['id_discusion' => $id_discusion]);

        //Buscamos los mensajes de la discusion
        $Mensaje = new MensajeModel();
        $mensajes = $Mensaje->obtenerMensaje(['id_discusion' => $id_discusion]);

        //Creamos un data con las discusiones
        $data = [
            'data' => $discusion,
            'mensajes' => $mensajes
        ];

        //return view
        return view('foro/consultarDiscusion', $data);
    }

    public function agregarDiscusion(){
        //Traemos los datos del formulario
        $nombre = $this->request->getPost('nombre');
        $descripcion = $this->request->getPost('descripcion');

        //Inicializamos los mensajes de error y exito
        $mensajes = array();
        $errores = array();

        //Vamos a manejar el contenido multimedia
        $file = $this->request->getFile('contenido_multimedia');
        if (!$file || !$file->isValid()) {
            
            array_push($errores, "Hubo un error al cargar el archivo: " . $file->getErrorString());
        } else {
            $newName = $file->getRandomName();
            $originalExtension = $file->getClientExtension();
            $newName = pathinfo($newName, PATHINFO_FILENAME) . '.' . $originalExtension;
            $file->move(PUBLICPATH.'uploads/contenidoMultimedia/discusiones', $newName);
        }

        //Si hay errores, redirigir a la página de altaLeccion
        if(!empty($errores)) {
            session()->set('errores', $errores);
            return redirect()->to(base_url('/altaDiscusion'));
        }

        //Si no hay errores, insertar la leccion en la base de datos
        $Discusion = new DiscusionModel();
        $idDiscusion = $Discusion->agregarDiscusion([
            'nombre' => $nombre,
            'descripcion' => $descripcion,
            'ruta_multimedia' => $newName,
            'id_foro' => $this->request->getPost('id_foro')
        ]);

        $data = [
            "data" => $Discusion->obtenerDiscusion(['id_discusion' => $idDiscusion])
        ];

        //Redirigir a la página de altaLeccion con mensaje de éxito
        array_push($mensajes, "Discusion agregada con éxito");
        session()->set('mensajes', $mensajes);
        return view('foro/consultarDiscusion', $data);
    }

    public function agregarMensaje(){
        //Traemos el mensaje del formulario
        $mensaje = $this->request->getPost('mensaje');
        $id_discusion =$this->request->getPost('id_discusion');
        //Inicializamos los mensajes de error y exito
        $mensajes = array();
        $errores = array();

        //Si hay errores, redirigir a la funcion de consultar discusion


        //Si no hay errores, inicializamos el Modelo de mensajes
        $Mensaje = new MensajeModel(); 

        //Nos fijamos en el entorno si se desea usar una hora personalizada
        if (env('HORA_PERSONALIZADA_ENVIRONMENT')){
            $fecha_hora = env('FECHA_HORA_ENVIRONMENT');
        }
        else{
            $fecha_hora = date("Y-m-d H:i:s");
        }
        
        //Persistimos el mensaje
        if(session('tipoUser') == 'estudiante'){
            $idMensaje = $Mensaje->insertarMensaje([
                'contenido' => $mensaje,
                'id_discusion' => $id_discusion,
                'fecha_hora' => $fecha_hora,
                'nick_emisor_estudiante' => session('usuario'),
            ]);
        }else{
            $idMensaje = $Mensaje->insertarMensaje([
                'contenido' => $mensaje,
                'id_discusion' => $id_discusion,
                'fecha_hora' => $fecha_hora,
                'nick_emisor_organizador' => session('usuario'),
            ]);
        }

        //Traemos todos los mensajes de la discusion
        $mensajes = $Mensaje->obtenerMensaje(['id_discusion' => $id_discusion]);
        
        $Discusion = new DiscusionModel();

        //Creamos un data con los mensajes
        $data = [
            'mensajes' => $mensajes,
            'data' => $Discusion->obtenerDiscusion(['id_discusion' => $id_discusion])
        ];

        //Volvemos a la vista
        return view('foro/consultarDiscusion', $data);
    }

}
