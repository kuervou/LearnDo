<?php

namespace App\Controllers;

//Incluimos los modelos
use App\Models\CategoriaModel;
use App\Models\SeminaryModel;
use App\Models\EstudianteModel;
use App\Models\PagoModel;
use App\Models\ValoracionModel;

class SeminaryController extends BaseController
{

    public function listarSeminarios()
    {
        $Seminario = new SeminaryModel();
        if (session('tipoUser') == "organizador") {

            $nick = [
                "nick_organizador" => session('usuario')
            ];

            $seminarioVirtual = $Seminario->obtenerSeminarioVirtual($nick);
            $seminarioPresencial = $Seminario->obtenerSeminarioPresencial($nick);
            $data = [
                "seminariosV" => $seminarioVirtual,
                "seminariosP" => $seminarioPresencial
            ];
            return view('seminary/listarSeminarios', $data);
        } else {
            if (session('tipoUser') == "estudiante") {
                $Seminario = new PagoModel();
                $estudiante = [
                    "nick_estudiante" => session('usuario')
                ];

                $seminariosPresenciales = $Seminario->listarSeminariosPresencialesEstudiante($estudiante);
                $seminariosVirtuales = $Seminario->listarSeminariosVirtualesEstudiante($estudiante);
                $data = [
                    "seminariosV" => $seminariosVirtuales,
                    "seminariosP" => $seminariosPresenciales
                ];
                return view('seminary/listarSeminarios', $data);
            }
        }
    }

    public function altaSeminario()
    {
        //Traemos las categorias
        $Categoria = new CategoriaModel();
        $categorias = $Categoria->listarCategorias();

        $data = [
            "categorias" => $categorias
        ];
        return view('seminary/altaSeminario', $data);
    }

    public function registrarSeminario()
{
    //Traemos los datos del formulario
    $nombre = $this->request->getPost('nombre');
    $descripcion = $this->request->getPost('descripcion');
    $precio = $this->request->getPost('precio');
    $fecha = $this->request->getPost('fecha');
    $hora = $this->request->getPost('hora');
    $tipo = $this->request->getPost('tipo');
    $categorias = $this->request->getPost('categorias[]');

    //Agregamos validaciones
    $errores = array();

    //Verificamos que la fecha sea mayor a la actual
    if (strtotime($fecha) <= time()) {
        array_push($errores, "La fecha ingresada debe ser mayor a la fecha actual");
    }

    //La hora no debe ser vacía
    if (empty($hora)) {
        array_push($errores, "Debes proveer una hora para el seminario");
    }

    if ($tipo == "virtual") {
        $plataforma = $this->request->getPost('plataforma');
        //Verificamos que se haya proporcionado un link para el seminario virtual
        if (empty($plataforma)) {
            array_push($errores, "Debes proveer un link para el seminario virtual");
        }
    } else if ($tipo == "presencial") {
        $ubicacion = $this->request->getPost('ubicacion_coords');
        $capacidad = $this->request->getPost('capacidad');
        //Verificamos que se haya proporcionado una ubicación y capacidad para el seminario presencial
        if (empty($ubicacion)) {
            array_push($errores, "Debes proveer una ubicación para el seminario presencial");
        }
        if (empty($capacidad)) {
            array_push($errores, "Debes proveer una capacidad para el seminario presencial");
        }
    }

    //Si hay errores, los almacenamos en la sesión y redirigimos al formulario
    if (!empty($errores)) {
        session()->set('errores', $errores);
        return redirect()->to(base_url('/altaSeminario'));
    }

        //Nos traemos el nick del organizador en la sesion
        $nick_organizador = session()->get('usuario');

        //Inicializamos los modelos
        $Categoria = new CategoriaModel();
        $Seminario = new SeminaryModel();

        //Inicializamos variables de errores
        $errores = array();
        $mensajes = array();

        //Vamos a ver si el seminario ya existe (tanto presencial como virtual)
        $datosSeminarioP = $Seminario->obtenerSeminarioPresencial(['nombre' => $nombre]);
        $datosSeminarioV = $Seminario->obtenerSeminarioVirtual(['nombre' => $nombre]);

        if (count($datosSeminarioP) > 0 || count($datosSeminarioV) > 0) {
            array_push($errores, "El seminario ya existe");
            session()->set('errores', $errores);
            return redirect()->to(base_url('/altaSeminario'));
        }

        //Si no hay errores, vamos a crear el seminario
        if ($tipo == "virtual") {
            $plataforma = $this->request->getPost('plataforma');
            $datosSeminario = array(
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'fecha' => $fecha,
                'hora' => $hora,
                'plataforma' => $plataforma,
                'nick_organizador' => $nick_organizador
            );
            $idSeminario = $Seminario->insertarSeminarioVirtual($datosSeminario);

            foreach ($categorias as $categoria) {
                $datosCategoria = array(
                    'id_seminario_virtual' => $idSeminario,
                    'nombre_cat' => $categoria
                );
                $Categoria->insertarCategoriaVirtual($datosCategoria);
            }
        } else if ($tipo == "presencial") {
            $ubicacion = $this->request->getPost('ubicacion_coords');
            $capacidad = $this->request->getPost('capacidad');
            $datosSeminario = array(
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'precio' => $precio,
                'fecha' => $fecha,
                'hora' => $hora,
                'ubicacion' => $ubicacion,
                'capacidad' => $capacidad,
                'nick_organizador' => $nick_organizador
            );
            $idSeminario = $Seminario->insertarSeminarioPresencial($datosSeminario);

            foreach ($categorias as $categoria) {
                $datosCategoria = array(
                    'id_seminario_presencial' => $idSeminario,
                    'nombre_cat' => $categoria
                );
                $Categoria->insertarCategoriaPresencial($datosCategoria);
            }
        }

        //Seteamos el mensaje de éxito
        session()->set('mensaje', "Curso creado con éxito");

        //Seteamos el mensaje en la sesión
        session()->set('mensajes', $mensajes);

        //Redireccionamos al "/"

        if ($tipo == "virtual") {
            return redirect()->to(base_url('/consultarSeminario?id_seminario=' . $idSeminario . '&tipo=' . $tipo));
        } else if ($tipo == "presencial") {
            return redirect()->to(base_url('/consultarSeminario?id_seminario=' . $idSeminario . '&tipo=' . $tipo));
        }
    }

    public function consultarSeminario()
    {
        //obtener los valores de los parametros
        $id_seminario = $this->request->getGet('id_seminario');
        $tipo = $this->request->getGet('tipo');

        //Inicializamos el modelo
        $Seminario = new SeminaryModel();

        //Obtenemos el seminario de la base de datos
        $datosSeminarioP = $Seminario->obtenerSeminarioPresencial(['id_seminario_presencial' => $id_seminario]);
        $datosSeminarioV = $Seminario->obtenerSeminarioVirtual(['id_seminario_virtual' => $id_seminario]);

        $Valoracion =  new ValoracionModel();

        $nick = session('usuario');
        if ($tipo == "virtual" && count($datosSeminarioV) > 0) {
            //vamos a ver si el pibe ha comprado el seminario
            $Pago = new PagoModel();
            $data = [
                "id_seminario_virtual" => $datosSeminarioV[0]['id_seminario_virtual'],
                "nick_estudiante" => $nick,
            ];
            $datosPago = $Pago->obtenerPago($data);
            if (count($datosPago) > 0) {
                $datosSeminarioV[0]['comprado'] = true;
            } else {
                $datosSeminarioV[0]['comprado'] = false;
            }
            if (env('HORA_PERSONALIZADA_ENVIRONMENT')){
                $fecha_hora = env('FECHA_HORA_ENVIRONMENT');
            }
            else{
                $fecha_hora = date("Y-m-d H:i:s");
            }
            //vamos a ver si es la hora de mostrar el chat
            if ($fecha_hora >= $datosSeminarioV[0]['fecha'] . " " . $datosSeminarioV[0]['hora']) {
                $datosSeminarioV[0]['chat'] = true;
            } else {
                $datosSeminarioV[0]['chat'] = false;
            }

            $datosValoracion = $Valoracion->obtenerValoracionSeminarioV($nick, $id_seminario);
            $data = [
                "datosSeminario" => $datosSeminarioV,
                "tipo" => "virtual",
                "valoraciones" => $datosValoracion
            ];

            $datosCalendar = [
                "nombre" => $datosSeminarioV[0]['nombre'],

                "descripcion" => $datosSeminarioV[0]['descripcion'],
                "fecha" => $datosSeminarioV[0]['fecha'],
                "hora" => $datosSeminarioV[0]['hora'],
                "location" => $datosSeminarioV[0]['plataforma'],
            ];

            //setear datosCalendar en la sesion
            session()->set('datosCalendar', $datosCalendar);

            return view('seminary/consultarSeminario', $data);
        } else if ($tipo == "presencial" && count($datosSeminarioP) > 0) {

            //vamos a ver la ubi

            $puntos = $Seminario->obtenerCoordenadasPorId($datosSeminarioP[0]['id_seminario_presencial']);

            // Convertir las coordenadas a un formato que pueda ser interpretado por JavaScript
            $puntosFormateados = [];
            foreach ($puntos as $punto) {
                $coordenadas = explode(',', trim($punto['ubicacion']));
                $puntosFormateados[] = [
                    'lat' => floatval(trim($coordenadas[0])),
                    'lng' => floatval(trim($coordenadas[1])),
                ];
            }
            //vamos a ver si el pibe ha comprado el seminario
            $Pago = new PagoModel();
            $data = [
                "id_seminario_presencial" => $datosSeminarioP[0]['id_seminario_presencial'],
                "nick_estudiante" => $nick,
            ];
            $datosPago = $Pago->obtenerPago($data);
            if (count($datosPago) > 0) {
                $datosSeminarioP[0]['comprado'] = true;
            } else {
                $datosSeminarioP[0]['comprado'] = false;
            }
            $datosValoracion = $Valoracion->obtenerValoracionSeminarioP($nick, $id_seminario);
            $data = [
                "datosSeminario" => $datosSeminarioP,
                "tipo" => "presencial",
                "valoraciones" => $datosValoracion,
                "puntos" => $puntosFormateados
            ];
            //Preparamos los datos para enviar al controlador de calendar
            $datosCalendar = [
                "nombre" => $datosSeminarioP[0]['nombre'],
                "descripcion" => $datosSeminarioP[0]['descripcion'],
                "fecha" => $datosSeminarioP[0]['fecha'],
                "hora" => $datosSeminarioP[0]['hora'],
                "location" => $datosSeminarioP[0]['ubicacion'],
            ];

            //setear datosCalendar en la sesion
            session()->set('datosCalendar', $datosCalendar);

            return view('seminary/consultarSeminario', $data);
        }
    }

    public function enviarRecordatorios()
    {
        // Obtener la fecha actual
        if (env('HORA_PERSONALIZADA_ENVIRONMENT')) {
            //obtener solo Y-m-d de la fecha del entorno
            $hoy = substr(env('FECHA_HORA_ENVIRONMENT'), 0, 10);
        } else {
            $hoy = date("Y-m-d");
        }

        // Obtener la fecha de mañana
        $manana = date('Y-m-d', strtotime($hoy . ' + 1 day'));

        // Obtener todos los seminarios que se realizarán mañana
        $Seminario = new SeminaryModel();
        $seminarios = $Seminario->obtenerSeminariosPorFecha($manana);

        foreach ($seminarios as $seminario) {
            // Obtener todos los usuarios que se han inscrito para el seminario
            $Estudiante = new EstudianteModel();
            $usuarios = $Estudiante->obtenerEstudiantesPorSeminario($seminario['id_seminario_presencial']); //ver de como sacar esto de la bd

            foreach ($usuarios as $usuario) {
                // Enviar un recordatorio por correo electrónico
                $this->enviarCorreo($usuario['email'], $seminario);
            }
        }
    }

    protected function enviarCorreo($emailUsuario, $seminario)
    {
        $emailConfig = new \Config\Email();
        $email = \Config\Services::email();
        $email->initialize($emailConfig);

        $email->setTo($emailUsuario);
        $email->setSubject('Recordatorio de seminario presencial');
        $email->setMessage("Estimado usuario, \n\nEste es un recordatorio de que el seminario virtual titulado '{$seminario['nombre']}' se llevará a cabo mañana. \n\nGracias por registrarte. \n\nSaludos, \nEl equipo de la plataforma.");

        if ($email->send()) {

            log_message('info', "Correo de recordatorio enviado a {$emailUsuario} para el seminario {$seminario['nombre']}");
        } else {

            log_message('error', "Error al enviar el correo de recordatorio a {$emailUsuario} para el seminario {$seminario['nombre']}");
        }
    }

    public function valorarSeminario()
    {

        $data = $this->request->getJSON();


        $nota = $data->rating;
        $idSeminario = $data->idSeminario;
        $opinion = $data->opinion;
        $nick_estudiante = session('usuario');
        $tipo = $data->tipo;

        $Valoracion = new ValoracionModel();

        if ($tipo == "virtual") {

            $data = [
                "nota" => $nota,
                "opinion" => $opinion,
                "id_seminario_virtual" => $idSeminario,
                "nick_estudiante" => $nick_estudiante
            ];

            $Valoracion->agregarValoracionSeminarioV($data);
        } else {
            $data = [
                "nota" => $nota,
                "opinion" => $opinion,
                "id_seminario_presencial" => $idSeminario,
                "nick_estudiante" => $nick_estudiante
            ];

            $Valoracion->agregarValoracionSeminarioV($data);
        }

        //Retornamos la respuesta
        return $this->response->setJSON($data);
    }
}