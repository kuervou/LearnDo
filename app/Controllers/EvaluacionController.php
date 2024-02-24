<?php

namespace App\Controllers;
use App\Models\EvaluacionModel;
use App\Models\PreguntaModel;
use App\Models\OpcionModel;
use App\Models\PruebaModel;
use App\Models\RespuestaModel;
use App\Models\ModuloModel;
use App\Models\CourseModel;
class EvaluacionController extends BaseController{

    public function altaEvaluacion()
    {
        $mensaje = session('mensaje');
        $id_modulo =  $this->request->getGet('id_modulo');

        $data= [
            "id_modulo" => $id_modulo
        ];

        return view('evaluacion/altaEvaluacion', $data);
    }

    public function editarEvaluacion(){
        $id_evaluacion =  $this->request->getGet('id_evaluacion');
        $Evaluacion = new EvaluacionModel();
        $evaluacion = $Evaluacion->obtenerEvaluacion(['id_evaluacion' => $id_evaluacion]);

        //Hacemos un dataEvaluacion con los datos de la evaluacion
        $dataEvaluacion = [
            'id_evaluacion' => $evaluacion[0]['id_evaluacion'],
            'titulo' => $evaluacion[0]['titulo'],
            'nota_aprobacion' => $evaluacion[0]['nota_aprobacion'],
            'id_modulo' => $evaluacion[0]['id_modulo']
            ];

        //Traemos las preguntas de la evaluacion
        $Pregunta = new PreguntaModel();
        $preguntas = $Pregunta->obtenerPreguntas(['id_evaluacion' => $id_evaluacion]);

        //Traemos las opciones de las preguntas
        $Opcion = new OpcionModel();
        $opciones = array();
        foreach ($preguntas as $pregunta) {
            $opciones[$pregunta['id_pregunta']] = $Opcion->obtenerOpciones(['id_pregunta' => $pregunta['id_pregunta']]);
        }

        $data = [
            'datosEvaluacion' => $dataEvaluacion,
            'preguntas' => $preguntas,
            'opciones' => $opciones
        ];

        //obtenemos el modulo a partir del id_modulo
        $id_modulo = $evaluacion[0]['id_modulo'];
        $Modulo = new ModuloModel();
        $modulo = $Modulo->obtenerModulo(['id_modulo' => $id_modulo]);
        //obtenemos el curso a partir de id_curso
        $id_curso = $modulo[0]['id_curso'];
        //obtenemos el nick_organizador a partir de id_curso
        $Curso = new CourseModel();
        $curso = $Curso->obtenerCurso(['id_curso' => $id_curso]);
        $nick_organizador = $curso[0]['nick_organizador'];
        
        


        if(session('tipoUser') == 'organizador' && session('usuario') == $nick_organizador)
            return view('evaluacion/editarEvaluacion', $data);
        else
        if(session('tipoUser') == 'organizador' && session('usuario') != $nick_organizador)
            return view('errors/ups');
        else
        return view('evaluacion/hacerEvaluacion', $data);
    }

    public function agregarEvaluacion(){

        //Obtengo los datos del formulario
        $titulo = $this->request->getPost('titulo');
        $notaAprobacion = $this->request->getPost('notaAprobacion');
        $id_modulo = $this->request->getPost('id_modulo');
        $id_evaluacion = $this->request->getGet('id_evaluacion');
        
        //Inicializamos los modelos
        $Evaluacion =  new EvaluacionModel();

        //Inicializamos variables de errores
        $errores = array();
        $mensajes = array();

        //Checkeo si la evaluacion ya existe
        $datosEvaluacion = $Evaluacion->obtenerEvaluacion(['titulo' => $titulo]);
            if (count($datosEvaluacion) > 0) {
                array_push($errores, "La evaluacion ya existe");
                session()->set('errores', $errores);
                return redirect()->to(base_url('/altaEvaluacion'));
            }

        //Ahora creamos la evaluacion
        $datosEvaluacion = [
            'titulo' => $titulo,
            'nota_aprobacion' => $notaAprobacion,
            'id_modulo' => $id_modulo,
            'id_evaluacion' => $id_evaluacion
        ];

        //Guardamos la evaluacion
        $idEvaluacion = $Evaluacion->agregarEvaluacion($datosEvaluacion);

        //Guardamos mensaje
        $mensaje = "La evaluacion se ha creado correctamente";

        //Seteamos el mensaje en la sesion
        session()->set('mensajes', $mensajes);

        $data = [
            'datosEvaluacion' => $datosEvaluacion
            ];

        //Redireccionamos a la página de login
        return redirect()->to(base_url('/editarEvaluacion?id_evaluacion=' . $idEvaluacion));

    }

    public function crearPreguntas()
    {
        $data = $this->request->getJSON();
        $id_evaluacion = $data->id_evaluacion;
        $preguntas = $data->preguntas;

        $preguntaModel = new PreguntaModel();
        $opcionModel = new OpcionModel();

        foreach ($preguntas as $pregunta) {
            // Validar los datos aquí. Por ejemplo:
            if (!isset($pregunta->puntuacion) || !isset($pregunta->contenido)) {
                return $this->response->setStatusCode(400, 'Datos de pregunta no válidos');
            }

            //Recorremos las opciones para obtener cual es la correcta
            foreach ($pregunta->opciones as $opcion) {
                if (property_exists($opcion, 'correcta') && $opcion->correcta) {
                    $pregunta->correcta = $opcion->texto;
                    break;
                }
            }
            // Insertar pregunta en la base de datos
            $preguntaId = $preguntaModel->agregarPregunta([
                'nota_maxima' => $pregunta->puntuacion,
                'contenido' => $pregunta->contenido,
                'correcta' => $pregunta->correcta,
                'id_evaluacion' => $id_evaluacion
            ]);

            foreach ($pregunta->opciones as $opcion) {
                // Validar los datos de opción aquí. Por ejemplo:
                if (!isset($opcion->texto)) {
                    return $this->response->setStatusCode(400, 'Datos de opción no válidos');
                }

                // Insertar opción en la base de datos
                $opcionModel->agregarOpcion([
                    'id_pregunta' => $preguntaId,
                    'contenido' => $opcion->texto,
                ]);
            }
        }

        return $this->response->setStatusCode(200, 'Preguntas creadas con éxito');
    }

    public function obtenerPuntajeCorrecta($data){
        //Inicializamos el modelo de preguntas
        $Pregunta = new PreguntaModel();

        //Traemos la pregunta que corresponde al id
        $pregunta = $Pregunta->obtenerPreguntas(['id_pregunta' => $data['id_pregunta']]);

        //Retornamos el puntaje de la pregunta
        return $pregunta[0]['nota_maxima'];
    }

    public function obtenerRespuestaCorrecta($data){
        //Inicializamos el modelo de preguntas
        $preguntaModel = new PreguntaModel();

        //Traemos todas las preguntas de la evaluacion
        $preguntas = $preguntaModel->obtenerPreguntas(['id_pregunta'=>$data]);

        //Retornamos la opcion correcta
        return $preguntas[0]['correcta'];
    }

    public function realizarEvaluacion(){
    $respuestas = $this->request->getPost('respuestas');
    $id_evaluacion = $this->request->getPost('id_evaluacion');
    $puntaje = 0;

    //Inicializamos una matriz respuestas para guardar la respuestas y su puntuacion
    $res = array();

    // Recorrer las respuestas
    foreach ($respuestas as $pregunta_id => $respuestas_seleccionadas) {

        foreach ($respuestas_seleccionadas as $respuesta_id) {
            if ($respuesta_id == $this->obtenerRespuestaCorrecta(['pregunta_id'=> $pregunta_id])){ 
                // La respuesta seleccionada es correcta entonces sumamos el puntaje
                $puntaje += $this->obtenerPuntajeCorrecta(['id_pregunta' => $pregunta_id]);
                array_push($res, [$respuesta_id, $this->obtenerPuntajeCorrecta(['id_pregunta' => $pregunta_id]), $pregunta_id]);
            }else{
                array_push($res, [$respuesta_id, 0, $pregunta_id]); 
            }
            
        }

    }  
    //Obtenemos la evaluacion
    $Evaluacion = new EvaluacionModel();
    $evaluacion = $Evaluacion->obtenerEvaluacion(['id_evaluacion' => $id_evaluacion]);

    //Persistir la prueba en la base de datos
    $Prueba = new PruebaModel();

    $nick = session('usuario');

    $PreguntaModel = new PreguntaModel();
    $pregunta = $PreguntaModel->obtenerPreguntas(['id_evaluacion' => $id_evaluacion]);

    $nota_total = 0;

    foreach($pregunta as $preg){
        $nota_total += $preg['nota_maxima'];
    }

    $porcentajeObtenido = ($puntaje * 100) / $nota_total;

    if($porcentajeObtenido >= $evaluacion[0]['nota_aprobacion']){
        $estado = true;
    }else{
        $estado = false;
    }

    $dataPrueba = [
        'nota_obtenida' => $puntaje,
        'id_evaluacion' => $id_evaluacion,
        'nick_estudiante' => $nick,
        "aprobado" => $estado
    ];
    $id_prueba = $Prueba->agregarPrueba($dataPrueba);

    //Inicializamos el modelo de respuesta
    $Respuesta = new RespuestaModel();

    //Persistimos las respuestas en la base de datos
    foreach ($res as $respuesta) {
        //Hacemos un data de respuestas
        $dataRespuesta = [
            'id_prueba' => $id_prueba,
            'contenido' => $respuesta[0],
            'nota_obtenida' => $respuesta[1],
            'id_pregunta' => $respuesta[2]
        ];
        //Persistimos la respuesta en la base de datos
        $Respuesta->agregarRespuesta($dataRespuesta);
    }

    // Redirigir a otra página o mostrar un mensaje de éxito
    return redirect()->to(base_url('/consultarIntento?id_prueba=' . $id_prueba));
     
    }

    public function consultarIntento(){
        // Traemos la id de la prueba de la URL
        $id_prueba = $this->request->getGet('id_prueba');

        // Inicializamos el modelo de prueba
        $PruebaModel = new PruebaModel();

        // Traemos la prueba
        $prueba = $PruebaModel->obtenerPrueba(['id_prueba' => $id_prueba]);

        // Ahora vamos a buscar las respuestas de la prueba
        $RespuestaModel = new RespuestaModel();

        // Traemos todas las respuestas del usuario para la prueba
        $respuestas = $RespuestaModel->obtenerRespuesta(['id_prueba' => $id_prueba]);

        //Inicializamos el modelo de preguntas
        $PreguntaModel = new PreguntaModel();

        //Traemos todas las preguntas de la eval
        $preguntas = $PreguntaModel->obtenerPreguntas(['id_evaluacion'=>$prueba[0]['id_evaluacion']]);

        //Inicializamos el modelo de evaluacion
        $EvaluacionModel = new EvaluacionModel();

        //Traemos la evaluacion
        $evaluacion = $EvaluacionModel->obtenerEvaluacion(['id_evaluacion'=>$prueba[0]['id_evaluacion']]);

        //sumar cada una de las notas de las preguntas
        $nota_maxima = 0;
            
        foreach($preguntas as $preg){
            $nota_maxima += $preg['nota_maxima'];
        }

        //Creamos un data
        $data = [
            'prueba' => $prueba[0],
            'respuestas' => $respuestas,
            'preguntas' => $preguntas,
            'evaluacion' => $evaluacion[0],
            "nota_total" => $prueba[0]['nota_obtenida'],
            "aprobado" => $prueba[0]['aprobado'],
            "nota_maxima" => $nota_maxima
        ];

        //retornamos la vista
        return view('evaluacion/consultarIntento', $data);
    }
    
}