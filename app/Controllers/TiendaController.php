<?php

namespace App\Controllers;
use App\Models\CourseModel;
use App\Models\SeminaryModel;

class TiendaController extends BaseController
{
   
    public function tienda(){
        //Inicializamos el modelo de cursos y seminarios
        $Cursos = new CourseModel();
        $Seminarios = new SeminaryModel();

        //Traemos los cursos y seminarios de la base de datos
        $cursos = $Cursos->listarCurso();
        $seminariosV = $Seminarios->listarSeminarioVirtual();
        $seminariosP = $Seminarios->listarSeminarioPresencial();

        //Creamos un data con los cursos y seminarios
        $data = [
            'cursos' => $cursos,
            'seminariosV' => $seminariosV,
            'seminariosP' => $seminariosP
        ];

        //Cargamos la vista de la tienda
        return view('tienda/tienda', $data);
    }

}
