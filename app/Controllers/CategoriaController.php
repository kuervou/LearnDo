<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\CourseModel;
use App\Models\SeminaryModel;


class CategoriaController extends BaseController
{

    public function listarCategorias()
    {
        //Inicializamos el modelo de categorias
        $categoriaModel = new CategoriaModel();

        //Obtenemos todas las categorias
        $categorias = $categoriaModel->listarCategorias();

        //Enviamos las categorias al template
        $data = [
            'categorias' => $categorias
        ];

        //Retornamos la vista con el data
        return view('categorias/gestionCategorias', $data);
    }

    public function altaCategoria()
    {
        return view('categorias/altaCategoria');
    }

    public function crearCategoria()
    {
        //Obtengo los datos del formulario
        $nombre = $this->request->getPost('nombre');

        //Inicializamos los modelos
        $categoriaModel = new CategoriaModel();

        //Inicializamos variables de errores
        $errores = array();
        $mensajes = array();

        //Vamos a ver si la categoria ya existe
        $datosCategoria = $categoriaModel->obtenerCategoria(['nombre' => $nombre]);
        if (count($datosCategoria) > 0) {
            array_push($errores, "La categoría ya existe");
            session()->set('errores', $errores);
            return redirect()->to(base_url('/gestionCategorias'));
        }

        //Si no hay errores, vamos a crear la categoria
        $datosCat = array(
            'nombre' => $nombre
        );

        //Insertamos el curso
        $idCat = $categoriaModel->crearCategoria($datosCat);

        //Seteamos el mensaje de éxito
        session()->set('mensaje', "Categoria creada con éxito");

        //Seteamos el mensaje en la sesión
        session()->set('mensajes', $mensajes);

        //Redireccionamos al homeOrganizador
        return redirect()->to(base_url('/gestionCategorias'));
    }

    public function modifyCategory()
    {
        //obtenemos los datos de la url
        $cat = $this->request->getGet('cat');

        $data = [
            'cat' => $cat
        ];

        return view('categorias/modificarCategoria', $data);
    }

    public function modificarCategoria()
    {
        //Obtengo los datos del formulario
        $nombre = $this->request->getPost('nombre');
        $cat = $this->request->getPost('nombreCat');

        //Inicializamos los modelos
        $categoriaModel = new CategoriaModel();

        //Inicializamos variables de errores
        $errores = array();
        $mensajes = array();

        //Vamos a ver si la categoria ya existe
        $datosCategoria = $categoriaModel->obtenerCategoria(['nombre' => $nombre]);
        if (count($datosCategoria) > 0) {
            array_push($errores, "La categoría ya existe");
            session()->set('errores', $errores);
            return redirect()->to(base_url('/gestionCategorias'));
        }

        //Si no hay errores, vamos a actualizar la categoria
        $datosCat = array(
            'nombre' => $nombre
        );

        //Insertamos el curso
        $idCat = $categoriaModel->actualizar($cat, $datosCat);

        //Seteamos el mensaje de éxito
        session()->set('mensaje', "Categoría modificada con éxito");

        //Seteamos el mensaje en la sesión
        session()->set('mensajes', $mensajes);

        //Redireccionamos al homeOrganizador
        return redirect()->to(base_url('/gestionCategorias'));
    }

    public function eliminarCategoria()
    {
        //obtenemos los datos de la url
        $cat = $this->request->getGet('cat');

        //Inicializamos variables de errores
        $errores = array();
        $mensajes = array();

        //Inicializamos los modelos
        $courseModel = new CourseModel();
        $seminaryModel = new SeminaryModel();

        //Buscamos si algun curso o seminario tiene esta categoria
        $cursos = $courseModel->buscarXCategoria($cat);
        $seminariosV = $seminaryModel->buscarSeminarioVirtualXCategoria($cat);
        $seminariosP = $seminaryModel->buscarSeminarioPresencialXCategoria($cat);

        //Verificamos si hay algun resultado

        if (count($cursos) > 0 || count($seminariosV) > 0 || count($seminariosP) > 0) {
            array_push($errores, "La categoría tiene cursos creados");
            session()->set('errores', $errores);
            return redirect()->to(base_url('/gestionCategorias'));
        } else {
            //Inicializamos el modelo de categorias
            $categoriaModel = new CategoriaModel();

            //Eliminamos la categoria
            $categoriaModel->eliminar($cat);

            //Seteamos el mensaje de éxito
            session()->set('mensaje', "Categoría eliminada con éxito");

            //Seteamos el mensaje en la sesión
            session()->set('mensajes', $mensajes);

            //Redirigimos al gestionCategorias
            return redirect()->to(base_url('/gestionCategorias'));
        }
    }
}
