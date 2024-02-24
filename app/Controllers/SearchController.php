<?php

namespace App\Controllers;
use App\Models\CourseModel;
use App\Models\SeminaryModel;

class SearchController extends BaseController
{

    public function buscar(){
        //Traemos los datos del formulario
        $busqueda = $this->request->getPost('busqueda');

        //Creamos los modelos
        $courseModel = new CourseModel();
        $seminaryModel = new SeminaryModel();

        //Buscamos los cursos y seminarios
        $curso = $courseModel->searchCourses($busqueda);
        $seminarioV = $seminaryModel->searchSeminarioVirtual($busqueda);
        $seminarioP = $seminaryModel->searchSeminarioPresencial($busqueda);

        $data = [
            'cursos' => $curso,
            'seminariosV' => $seminarioV,
            "seminariosP" => $seminarioP,
        ];

        //Vamos a la vista consultar curso
        return view('tienda/tienda', $data);
    }
    

    public function buscarXCategoria(){

        $nomCategoria = $this->request->getGet('nombreCategoria');

        //Creamos los modelos
        $courseModel = new CourseModel();
        $seminaryModel = new SeminaryModel();

         //Buscamos los cursos y seminarios
         $curso = $courseModel->buscarXCategoria($nomCategoria);
         $seminarioV = $seminaryModel->buscarSeminarioVirtualXCategoria($nomCategoria);
         $seminarioP = $seminaryModel->buscarSeminarioPresencialXCategoria($nomCategoria);

         $data = [
            'cursos' => $curso,
            'seminariosV' => $seminarioV,
            "seminariosP" => $seminarioP,
        ];

        

        //Vamos a la vista consultar curso
        return view('tienda/tienda', $data);   
    }

}
