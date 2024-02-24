<?php

namespace App\Controllers;

use App\Models\EstudianteModel;
use App\Models\MensajeModel;
use App\Models\OrganizadorModel;

class ChatController extends BaseController
{

    public function cargarChats()
    {
        //Traemos los datos del usuario logueado
        $emisor = session('usuario');

        //Traemos el receptor de la url
        $receptor = $this->request->getGet('receptor');
        $Estudiante = new EstudianteModel();
        $Organizador = new OrganizadorModel();
        $datoEstudiante = $Estudiante->obtenerEstudiante(["nick" => $receptor]);
        $datoOrganizador = $Organizador->obtenerorganizador(["nick" => $receptor]);

        //Cargamos el modelo de mensajes
        $Mensaje = new MensajeModel();



        //Traemos los mensajes del chat
        if (session('tipoUser') == "organizador" && count($datoEstudiante) > 0) {
            $datos1 = $Mensaje->obtenerChats(["nick_emisor_organizador" => $emisor], ["nick_destinatario_estudiante" => $receptor]);
            $datos2 = $Mensaje->obtenerChats(["nick_emisor_estudiante" => $receptor], ["nick_destinatario_organizador" => $emisor]);
            //Merge datos y datos2
            $datos = array_merge($datos1, $datos2);
            // Ordenar el array combinado por id
            asort($datos);
            $tipoReceptor = "estudiante";
        } elseif (session('tipoUser') == "estudiante" && count($datoEstudiante) > 0) {
            $datos1 = $Mensaje->obtenerChats(["nick_emisor_estudiante" => $emisor], ["nick_destinatario_estudiante" => $receptor]);
            $datos2 = $Mensaje->obtenerChats(["nick_emisor_estudiante" => $receptor], ["nick_destinatario_estudiante" => $emisor]);
            $datos = array_merge($datos1, $datos2);
            // Ordenar el array combinado por id
            asort($datos);
            $tipoReceptor = "estudiante";
        } elseif (session('tipoUser') == "estudiante" && count($datoOrganizador) > 0) {
            $datos1 = $Mensaje->obtenerChats(["nick_emisor_estudiante" => $emisor], ["nick_destinatario_organizador" => $receptor]);
            $datos2 = $Mensaje->obtenerChats(["nick_emisor_organizador" => $receptor], ["nick_destinatario_estudiante" => $emisor]);
            $datos = array_merge($datos1, $datos2);
            // Ordenar el array combinado por id
            asort($datos);
            $tipoReceptor = "organizador";
        } elseif (session('tipoUser') == "organizador" && count($datoOrganizador) > 0) {
            $datos1 = $Mensaje->obtenerChats(["nick_emisor_organizador" => $emisor], ["nick_destinatario_organizador" => $receptor]);
            $datos2 = $Mensaje->obtenerChats(["nick_emisor_organizador" => $receptor], ["nick_destinatario_organizador" => $emisor]);
            $datos = array_merge($datos1, $datos2);
            // Ordenar el array combinado por id
            asort($datos);
            $tipoReceptor = "organizador";
        }





        //Cargamos la vista de chats
        $data = [
            "datos" => $datos,
            "receptor" => $receptor,
            "tipoReceptor" => $tipoReceptor
        ];



        return view('chats/chats', $data);
    }

    public function escribirMensaje()
    {

        $mensaje = $this->request->getPost('mensaje');
        $receptor = $this->request->getPost('nickReceptor');
        $tipoReceptor = $this->request->getPost('tipoReceptor');



        $emisor = session('usuario');

        $Mensaje = new MensajeModel();

        if (session('tipoUser') == "organizador" && $tipoReceptor == "estudiante") {
            $datosMensaje = [
                "nick_emisor_organizador" => $emisor,
                "nick_destinatario_estudiante" => $receptor,
                "contenido" => $mensaje,
                "fecha_hora" => date("Y-m-d H:i:s")
            ];
        } elseif (session('tipoUser') == "estudiante" && $tipoReceptor == "estudiante") {
            $datosMensaje = [
                "nick_emisor_estudiante" => $emisor,
                "nick_destinatario_estudiante" => $receptor,
                "contenido" => $mensaje,
                "fecha_hora" => date("Y-m-d H:i:s")
            ];
        } elseif (session('tipoUser') == "estudiante" && $tipoReceptor == "organizador") {
            $datosMensaje = [
                "nick_emisor_estudiante" => $emisor,
                "nick_destinatario_organizador" => $receptor,
                "contenido" => $mensaje,
                "fecha_hora" => date("Y-m-d H:i:s")
            ];
        } elseif (session('tipoUser') == "organizador" && $tipoReceptor == "organizador") {
            $datosMensaje = [
                "nick_emisor_organizador" => $emisor,
                "nick_destinatario_organizador" => $receptor,
                "contenido" => $mensaje,
                "fecha_hora" => date("Y-m-d H:i:s")
            ];
        }

        //Guardamos el mensaje
        $Mensaje->insertarMensaje($datosMensaje);


        return redirect()->to(base_url('cargarChats?receptor=' . $receptor));
    }

    function compararPorId($a, $b)
    {
        return $a['id_mensaje'] - $b['id_mensaje'];
    }

    public function chat()
    {
        //obtener el id y el nombre del seminario
        $id_seminario = $this->request->getGet('id_seminario');
        $nombre = $this->request->getGet('nombre');
        $fecha = $this->request->getGet('fecha');
        $hora = $this->request->getGet('hora');
        $data = [
            'id_seminario' => $id_seminario,
            'nombre' => $nombre,
            'fecha' => $fecha,
            'hora' => $hora
        ];
        return view('chats/liveChat', $data);
    }


    public function insertMessage()
    {
        $model = new MensajeModel();
        $data = $this->request->getJSON(true);
        log_message('debug', 'insertMessage: ' . json_encode($data));
        if ($model->insertMessage($data)) {
            return $this->response->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(500);
        }
    }

    public function getMessages()
    {

        $model = new MensajeModel();
        $data = $this->request->getJSON();
        $id_seminario = $data->id_seminario;
        log_message('debug', 'getMessages: ' . json_encode($data));


        $messages = $model->getMessages($id_seminario);
        log_message('debug', 'getMessages: ' . json_encode($messages));
        return $this->response->setJSON($messages);
    }
}
