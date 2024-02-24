<?php

namespace App\Controllers;
use App\Models\ModuloModel;
use App\Models\LeccionModel;
use App\Models\EvaluacionModel;
use App\Models\PruebaModel;
use App\Models\PreguntaModel;
use App\Models\CourseModel;

class ModuleController extends BaseController
{
    public function altaModulo()
    {   
        $id_curso = $this->request->getGet('id_curso');
        $data = [
            'id_curso' => $id_curso
        ];
        $mensaje = session('mensaje');
        return view('modulos/altaModulo', $data);
    }

    public function agregarModulo(){

        //Obtengo los datos del formulario
        $nombre = $this->request->getPost('nombre');
        $id_curso = $this->request->getPost('id_curso');


        //Inicializamos los modelos
        $Modulo = new ModuloModel();

        //Inicializamos variables de errores
        $errores = array();
        $mensajes = array();

        //Vamos a ver si el modulo ya existe
        $datosModulo = $Modulo->obtenerModulo(['nombre' => $nombre, 'id_curso' => $id_curso]);
        if (count($datosModulo) > 0) {
            array_push($errores, "El modulo ya existe");
            session()->set('errores', $errores);
            return redirect()->to(base_url('/altaModulo'));
        }

        //Si no hay errores, vamos a crear el curso
        $datosModulo = array(
            'nombre' => $nombre,
            'id_curso' => $id_curso
        );


        //Guardamos el modulo
        $id_modulo = $Modulo->insertarModulo($datosModulo);

        //Creamos $data con id_modulo
        $datosModulo = $Modulo->obtenerModulo(['id_modulo' => $id_modulo]);


        $Leccion = new LeccionModel();
        $lecciones = $Leccion->obtenerLeccion(['id_modulo' => $id_modulo]);

        $data = [
            "datosModulo" => $datosModulo,
            "lecciones" => $lecciones
        ];

        //Guardamos el mensaje
        $mensaje = "El modulo se ha creado correctamente";

         //Seteamos el mensaje en la sesion
         session()->set('mensajes', $mensajes);
        
         //Redireccionamos a la página de login
         return redirect()->to(base_url('/consultarModulo?id_modulo=' . $id_modulo));

    }

    public function consultarModulo(){
        //obtener los valores de los parametros
        $id_modulo = $this->request->getGet('id_modulo');
    
        //inicializar los modelos
        $Modulo = new ModuloModel();
    
        //obtener los datos de la base de datos
        $datosModulo = $Modulo->obtenerModulo(['id_modulo' => $id_modulo]);

        //con $datosmodulo['id_curso] vamos a buscar los datos del curso
        $Curso = new CourseModel();
        $datosCurso = $Curso->obtenerCurso(['id_curso' => $datosModulo[0]['id_curso']]);
        //obtenemos el nick organizador
        $nick_organizador = $datosCurso[0]['nick_organizador'];
        //agregamos el nick organizador a los datos del modulo
        $datosModulo[0]['nick_organizador'] = $nick_organizador;


        $Leccion = new LeccionModel();
        $lecciones = $Leccion->obtenerLeccion(['id_modulo' => $id_modulo]);

        $Evaluacion = new EvaluacionModel();
        $evaluaciones = $Evaluacion->obtenerEvaluacion(['id_modulo' => $id_modulo]);

        if(session('tipoUser') == "estudiante" && count($evaluaciones) > 0){
            $PruebaModel = new PruebaModel();
            $prueba = $PruebaModel->ultimaPrueba(['nick_estudiante' => session('usuario')], ['id_evaluacion'=>$evaluaciones[0]['id_evaluacion']]);
            
            $data = [
                "datosModulo" => $datosModulo,
                "lecciones" => $lecciones,
                "evaluaciones" => $evaluaciones,
                "prueba" => $prueba,
                
            ];
        }else{
            //pasar los datos a la vista
            $data = [
                "datosModulo" => $datosModulo,
                "lecciones" => $lecciones,
                "evaluaciones" => $evaluaciones
            ];
        }

        //cargar la vista
        return view('modulos/consultarModulo', $data);
    }
    


}
