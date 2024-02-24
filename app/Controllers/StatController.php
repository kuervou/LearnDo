<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\StatModel;

class StatController extends BaseController
{

    public function estadisticas(){

        $nick = session('usuario');


        $Curso = new CourseModel();
        $cursos = $Curso->obtenerCurso(['nick_organizador'=>$nick]);



        $Stat = new StatModel();

        foreach($cursos as $key => $curso){
            $statsCurso = $Stat->obtenerEstadisticasVentas($curso['id_curso']);
            if($statsCurso != null){
                $cursos[$key]['ventasTotales'] = $statsCurso->cantidad_ventas;
                $cursos[$key]['paypal'] = $statsCurso->paypal;
                $cursos[$key]['creditos'] = $statsCurso->creditos;
                $cursos[$key]['recaudacion'] = $statsCurso->recaudacion;
            }
            else{

                $cursos[$key]['ventasTotales'] = 0;
                $cursos[$key]['paypal'] = 0;
                $cursos[$key]['creditos'] = 0;
                $cursos[$key]['recaudacion'] = 0;
            }
        }

        foreach($cursos as $key => $curso){
            $aprobadosCurso = $Stat->cantidadAprobados($curso['id_curso']);
            if($aprobadosCurso != null){
                $cursos[$key]['cantAprobados'] = $aprobadosCurso;
                
            }
            else{
                $cursos[$key]['cantAprobados'] = 0;     
            }
        }

        

        $data = [
            'cursos' => $cursos
            ];


        return view('stats/estadisticas',$data);

    }
}
