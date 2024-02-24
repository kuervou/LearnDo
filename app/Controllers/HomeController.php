<?php

namespace App\Controllers;
use App\Models\EstudianteModel;
use App\Models\OrganizadorModel;
use App\Models\CourseModel;
use App\Models\SeminaryModel;
use App\Models\CategoriaModel;
use App\Models\ValoracionModel;
class HomeController extends BaseController
{
    public function index()
    {
        

        //en función del tipo de usuario que haya logueado redirigiremos al home correspondiente
        if(session('tipoUser') == "estudiante"){
            $Curso = new CourseModel();
            $cursos = $Curso->listarCursoRecomendados();

            $Seminario = new SeminaryModel();
            $seminarios = $Seminario->listarSeminariosVirtualRecomendados();

            $SeminarioPresencial = new SeminaryModel();
            $seminariosPresenciales = $SeminarioPresencial->listarSeminariosPresencialRecomendados();

            //traer todos los usuarios del sistema
            $Estudiante = new EstudianteModel();
            $estudiantes = $Estudiante->listarEstudiantes();

            //traer todos los organizadores
            $Organizador = new OrganizadorModel();
            $organizadores = $Organizador->listarOrganizador();

            //traer valoraciones de los cursos
            $Valoracion = new ValoracionModel();

            foreach($cursos as $key => $curso){
                $valoracionCurso = $Valoracion->obtenerValoracionCursoPorId($curso['id_curso']);
                if($valoracionCurso != null){
                    $cursos[$key]['valoracion'] = $valoracionCurso[0]->nota_promedio;
                }
            }

            foreach($seminarios as $key => $seminarioVirtual){
                $valoracionSemiV = $Valoracion->obtenerValoracionSeminarioVirtualPorId($seminarioVirtual['id_seminario_virtual']);
                
                if($valoracionSemiV != null){
                    $seminarios[$key]['valoracion'] = $valoracionSemiV[0]->nota_promedio;
                }
            }

            foreach($seminariosPresenciales as $key => $seminarioPresencial){
                $valoracionSemiP = $Valoracion->obtenerValoracionSeminarioPresencialPorId($seminarioPresencial['id_seminario_presencial']);
                if($valoracionSemiP != null){
                    $seminariosPresenciales[$key]['valoracion'] = $valoracionSemiP[0]->nota_promedio;
                }
            }

            $data = [
                "cursos" => $cursos,
                "seminarios" => $seminarios,
                "seminariosPresenciales" => $seminariosPresenciales,
                "estudiantes" => $estudiantes,
                "organizadores" => $organizadores
                ];

            //Inicializamos el modelo de categorias
            $Categoria = new CategoriaModel();
            $categorias = $Categoria->listarCategoriasDestacadas();
            session()->set('categorias', $categorias);

            return view('home/homeEstudiante', $data);
        }else if(session('tipoUser') == "organizador"){
            //SUPER ADMIN
            if(session('usuario') == "superAdmin"){
                return redirect()->to(base_url('/dashboard'));
            }
            //traer todos los usuarios del sistema
            $Estudiante = new EstudianteModel();
            $estudiantes = $Estudiante->listarEstudiantes();

            //traer todos los organizadores
            $Organizador = new OrganizadorModel();
            $organizadores = $Organizador->listarOrganizador();
            //Inicializamos la lista de cursos
            $nick = [
                "nick_organizador" => session('usuario')
            ];
            $Course = new CourseModel();
            $cursos = $Course->obtenerCurso($nick);
            $data = [
                "cursos" => $cursos,
                "estudiantes" => $estudiantes,
                "organizadores" => $organizadores
            ];
            //Inicializamos el modelo de categorias
            $Categoria = new CategoriaModel();
            $categorias = $Categoria->listarCategoriasDestacadas();
            session()->set('categorias', $categorias);

            return view('home/homeOrganizador', $data);
        }else{
        $mensaje = session('mensaje');

        //cosas para el mapa
            
            // obtener coordenadas de los seminarios desde la base de datos
            $SeminaryModel = new SeminaryModel();
            $puntos = $SeminaryModel->obtenerCoordenadas();
        
            // Convertir las coordenadas a un formato que pueda ser interpretado por JavaScript
            $puntosFormateados = [];
            foreach ($puntos as $punto) {
                $coordenadas = explode(',', trim($punto['ubicacion']));
                $puntosFormateados[] = [
                    'lat' => floatval(trim($coordenadas[0])),
                    'lng' => floatval(trim($coordenadas[1])),
                ];
            }

            //Inicializamos el modelo de categorias
            $Categoria = new CategoriaModel();
            $categorias = $Categoria->listarCategoriasDestacadas();
            session()->set('categorias', $categorias);


        // cosas para los testimonios
        //modelo de valoraciones
        $Valoracion = new ValoracionModel();
        //obtener valoraciones de cursos
        $valoracionesCursos = $Valoracion->obtenerValoraciones5();
        //obtener los estudiantes del sistema
        $Estudiante = new EstudianteModel();
        $estudiantes = $Estudiante->listarEstudiantes();
        $estudiantesAsociativo = [];
foreach ($estudiantes as $estudiante) {
    $estudiantesAsociativo[$estudiante['nick']] = $estudiante;
}
        
        return view('home/homeGuest', ["mensaje" => $mensaje, "puntos" => $puntosFormateados, "valoracionesCursos" => $valoracionesCursos, "estudiantesAsociativo" => $estudiantesAsociativo]);
        }
    }

    public function pwa()
    {
        return view('notasPWA');
    }

    public function ups(){
        return view('errors/ups');
    }

}
