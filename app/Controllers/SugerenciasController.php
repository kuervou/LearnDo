<?php

namespace App\Controllers;
use App\Models\CourseModel;
use App\Models\ModuloModel;
use App\Models\SugerenciaModel;
use App\Models\LeccionModel;

class SugerenciasController extends BaseController
{

    public function listarSugerencias(){
        //Traemos los parametros de la url
        $id_curso = $this->request->getGet('id_curso');

        //Traemos las sugerencias de la base de datos
        $SugerenciaModel = new SugerenciaModel();

        $sugerencias = $SugerenciaModel->obtenerSugerencias(['id_curso' => $id_curso]);

        $data = [
            'sugerencias' => $sugerencias,
        ];

        return view('sugerencias/listarSugerencias', $data);
    }

    public function consultarSugerencia(){
        //Traemos los parametros de la url
        $id_sugerencia = $this->request->getGet('id_sugerencia');

        //Buscamos la sugerencia en la bd
        $SugerenciaModel = new SugerenciaModel();

        $sugerencia = $SugerenciaModel->obtenerSugerencias(['id_sugerencia' => $id_sugerencia]);

        //Traemos los modulos del curso
        $ModuloModel = new ModuloModel();

        $modulos = $ModuloModel->obtenerModulo(['id_curso' => $sugerencia[0]['id_curso']]);

        //Creamos un data
        $data = [
            'sugerencia' => $sugerencia,
            'modulos' => $modulos,
        ];

        //Retornamos a la vista
        return view('sugerencias/consultarSugerencias', $data);
    }
    
    public function aceptarSugerencia(){
        //Traemos los datos del formulario
        $id_sugerencia = $this->request->getPost('id_sugerencia');
        $nombre = $this->request->getPost('nombre');
        $duracion = $this->request->getPost('duracion');
        $modulo = $this->request->getPost('modulos');

        //Traemos la sugerencia de la bd para sacar la ruta multimedia
        $SugerenciaModel = new SugerenciaModel();
        $sugerencia = $SugerenciaModel->obtenerSugerencias(['id_sugerencia' => $id_sugerencia]);

        //Guardamos la ruta multimedia
        $ruta_multimedia = $sugerencia[0]['ruta_multimedia'];

        //Actualizamos la sugerencia a aprobada
        $SugerenciaModel->actualizar(['id_sugerencia' => $id_sugerencia], ['aprobada' => 1]);

        //Creamos el data
        $data = [
            'nombre' => $nombre,
            'duracion' => $duracion,
            'ruta_multimedia' => $ruta_multimedia,
            'id_modulo' => $modulo[0]
        ];

        //Creamos la leccion
        $LeccionModel = new LeccionModel();
        
        $id_leccion = $LeccionModel->insertarLeccion($data);

        return redirect()->to(base_url('/consultarLeccion?id_Leccion='.$id_leccion));
    }

    public function rechazarSugerencia(){
        //Traemos la id del formulario
        $id_sugerencia = $this->request->getPost('id_sugerencia');

        //Borramos la sugerencia de la bd 
        $SugerenciaModel = new SugerenciaModel();
        $sugerencia = $SugerenciaModel->obtenerSugerencias(['id_sugerencia' => $id_sugerencia]);
        $id_curso = $sugerencia[0]['id_curso'];

        $SugerenciaModel->eliminar($id_sugerencia);

        //Retornamos a listar sugerencias
        return redirect()->to(base_url('/listarSugerencias?id_curso='.$id_curso));
    }

}