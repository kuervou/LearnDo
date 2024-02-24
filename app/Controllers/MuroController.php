<?php

namespace App\Controllers;

use App\Models\MuroModel;
use App\Models\CourseModel;
use App\Models\EstudianteModel;
use App\Models\OrganizadorModel;

class MuroController extends BaseController
{

    public function agregarPublicacion()
    {

        $nickEstudiante = null;
        $nickOrganizador = null;
        if (session('tipoUser') == 'organizador') {
            $nickOrganizador = session('usuario');
        } else {
            $nickEstudiante = session('usuario');
        }

        $Muro = new MuroModel();

        //Inicializamos variables de errores
        $errores = array();
        $mensajes = array();


        if (($this->request->getPost('compartir')) !== null) {

            $Curso = new CourseModel();
            $id_curso = $this->request->getPost('id_curso');
            $curso = $Curso->obtenerCurso(['id_curso' => $id_curso]);

            $contenidoTexto = "Me he inscripto al curso:" . $curso[0]['nombre'];
            $contenidoMultimedia = 'compartir.svg';
        } else {

            $contenidoTexto = $this->request->getPost('contenidoTexto');
            $file = $this->request->getFile('contenidoMultimedia');


            if (!$file || !$file->isValid()) {

                array_push($errores, "Hubo un error al cargar el archivo: " . $file->getErrorString());
            } else {
                $contenidoMultimedia = $file->getRandomName();
                $originalExtension = $file->getClientExtension();
                $contenidoMultimedia = pathinfo($contenidoMultimedia, PATHINFO_FILENAME) . '.' . $originalExtension;
                $file->move(PUBLICPATH . 'uploads/contenidoMultimedia/publicaciones', $contenidoMultimedia);
            }
        }
        //Creamos la publicacion
        $dataPublicacion = array(
            'contenido' => $contenidoTexto,
            'ruta_multimedia' => $contenidoMultimedia,
            'nick_estudiante' => $nickEstudiante,
            'nick_organizador' => $nickOrganizador
        );

        $Muro->insertarPublicacion($dataPublicacion);


        return redirect()->to(base_url('muro'));
    }

    public function muro()
    {

        $Muro = new MuroModel();
        $publicaciones = $Muro->listarPublicaciones();
        //traer todos los usuarios del sistema
        $Estudiante = new EstudianteModel();
        $estudiantes = $Estudiante->listarEstudiantes();

        //traer todos los organizadores
        $Organizador = new OrganizadorModel();
        $organizadores = $Organizador->listarOrganizador();
        $data = [
            'publicaciones' => $publicaciones,
            'estudiantes' => $estudiantes,
            'organizadores' => $organizadores
        ];

        return view('muro/muro', $data);
    }
}
