<?php

namespace App\Controllers;

use App\Models\PagoModel;
use App\Models\EstudianteModel;
use App\Models\CourseModel;
use App\Models\SeminaryModel;

class PagoController extends BaseController
{
    public function realizarPago()
    {
        $id_curso =  $this->request->getGet('id_curso');
        $id_seminario_virtual = $this->request->getGet('id_seminario_virtual');
        $id_seminario_presencial = $this->request->getGet('id_seminario_presencial');
        $nick_estudiante = $this->request->getGet('nick_estudiante');

        if ($id_curso != null) {
            $data = [
                'id_curso' => $id_curso,
                'nick_estudiante' => $nick_estudiante
            ];
        } else if ($id_seminario_virtual != null) {
            $data = [
                'id_seminario_virtual' => $id_seminario_virtual,
                'nick_estudiante' => $nick_estudiante
            ];
        } else {
            $data = [
                'id_seminario_presencial' => $id_seminario_presencial,
                'nick_estudiante' => $nick_estudiante
            ];
        }



        return view('pago/realizarPago', $data);
    }



    public function pagarCreditos()
    {
        $errores = array();
        $mensajes = array();
        //Traemos los datos del formulario
        $id_curso =  $this->request->getPost('id_curso');
        $id_seminario_virtual = $this->request->getPost('id_seminario_virtual');
        $id_seminario_presencial = $this->request->getPost('id_seminario_presencial');

        //Traemos el usuario de la sesion
        $user = session()->get('usuario');

        //Traemos el modelo Estudiante
        $Estudiante = new EstudianteModel();

        //Traemos los datos del estudiante de la base de datos
        $datosEstudiante = $Estudiante->obtenerEstudiante(['nick' => $user]);

        //Traemos el modelo Pago
        $PagoModel = new PagoModel();
        if ($id_curso != null) {
            //Traemos los datos del curso de la base de datos
            $Curso = new CourseModel();
            $curso = $Curso->obtenerCurso(['id_curso' => $id_curso]);


            //Verificamos que el estudiante tenga los creditos necesarios para la compra
            if ($datosEstudiante[0]['creditos'] >= $curso[0]['precio']) {

                $data = [
                    'precio' => $curso[0]['precio'],
                    'metodo_pago' => "creditos",
                    'creditos_usados' => $curso[0]['precio'],
                    'nick_estudiante' => $user,
                    'id_curso' => $id_curso
                ];
                $PagoModel->insertarPago($data);

                //Actualizamos los creditos del estudiante
                $creditos = $datosEstudiante[0]['creditos'] - $curso[0]['precio'];
                $Estudiante->actualizar($user, ["creditos" => $creditos]);
                //cargar mensajes en array mensajes
                array_push($mensajes, "Se ha realizado la compra con exito");
                session()->set('mensajes', $mensajes);
                return redirect()->to(base_url('/listarCursos'));
            } else {
                //cargar error en array errores
                array_push($errores, "No tienes creditos suficientes para realizar esta transacción ");
                session()->set('errores', $errores);
                return redirect()->to(base_url('/listarCursos'));
            }
        } else if ($id_seminario_virtual != null) {
            //Traemos los datos del seminario virtual de la base de datos
            $SeminarioVirtual = new SeminaryModel();
            $seminario = $SeminarioVirtual->obtenerSeminarioVirtual(['id_seminario_virtual' => $id_seminario_virtual]);
            //Verificamos que el estudiante tenga los creditos necesarios para la compra
            if ($datosEstudiante[0]['creditos'] >= $seminario[0]['precio']) {
                $data = [
                    'precio' => $seminario[0]['precio'],
                    'metodo_pago' => "creditos",
                    'creditos_usados' => $seminario[0]['precio'],
                    'nick_estudiante' => $user,
                    'id_seminario_virtual' => $id_seminario_virtual

                ];
                $PagoModel->insertarPago($data);

                //Actualizamos los creditos del estudiante
                $creditos = $datosEstudiante[0]['creditos'] - $seminario[0]['precio'];
                $Estudiante->actualizar($user, ["creditos" => $creditos]);
                //cargar mensajes en array mensajes
                array_push($mensajes, "Se ha realizado la compra con exito");
                session()->set('mensajes', $mensajes);
                return redirect()->to(base_url('/listarSeminarios'));
            } else {
                //cargar error en array errores
                array_push($errores, "No tienes creditos suficientes para realizar esta transacción ");
                session()->set('errores', $errores);
                return redirect()->to(base_url('/listarSeminarios'));
            }
        } else if ($id_seminario_presencial != null) {
            //Traemos los datos del seminario virtual de la base de datos
            $SeminarioPresencial = new SeminaryModel();
            $seminario = $SeminarioPresencial->obtenerSeminarioPresencial(['id_seminario_presencial' => $id_seminario_presencial]);
            //Verificamos que el estudiante tenga los creditos necesarios para la compra
            if ($datosEstudiante[0]['creditos'] >= $seminario[0]['precio']) {
                $data = [
                    'precio' => $seminario[0]['precio'],
                    'metodo_pago' => "creditos",
                    'creditos_usados' => $seminario[0]['precio'],
                    'nick_estudiante' => $user,
                    'id_seminario_presencial' => $id_seminario_presencial
                ];
                $PagoModel->insertarPago($data);

                //Actualizamos los creditos del estudiante
                $creditos = $datosEstudiante[0]['creditos'] - $seminario[0]['precio'];
                $Estudiante->actualizar($user, ["creditos" => $creditos]);
                //Actualizar capacidad del seminario
                $capacidad = $seminario[0]['capacidad'] - 1;
                $SeminarioPresencial->actualizar($id_seminario_presencial, ["capacidad" => $capacidad]);
                //cargar mensajes en array mensajes
                array_push($mensajes, "Se ha realizado la compra con exito");
                session()->set('mensajes', $mensajes);
                return redirect()->to(base_url('/listarSeminarios'));
            } else {
                //cargar error en array errores
                array_push($errores, "No tienes creditos suficientes para realizar esta transacción ");
                session()->set('errores', $errores);
                return redirect()->to(base_url('/listarSeminarios'));
            }
        }
    }

    public function procesarPago()
    {
        // Lógica para procesar el pago
        $paymentModel = new PagoModel();
        $paymentResult = $paymentModel->processPayment();

        if ($paymentResult) {
            // Pago exitoso, redirigir a la página de éxito
            return redirect()->to('payment/success');
        } else {
            // Pago fallido, redirigir a la página de fallo
            return redirect()->to('payment/failure');
        }
    }

    public function success()
    {
        // Lógica para mostrar la página de éxito de pago
        return view('payment/success');
    }

    public function failure()
    {
        // Lógica para mostrar la página de fallo de pago
        return view('payment/failure');
    }

    public function historialPagos()
    {
        //Traemos el usuario de la sesion
        $user = session("usuario");

        //Inicializamos el modelo de pagos
        $PagoModel = new PagoModel();

        //Buscamos los cursos en el modelo de pagos
        $cursos = $PagoModel->listarCursos(["nick_estudiante" => $user]);

        //Buscamos seminarios en el modelo de pagos
        $seminarioV = $PagoModel->listarSeminariosVirtualesEstudiante(["estudiante" => $user]);
        $seminarioP = $PagoModel->listarSeminariosPresencialesEstudiante(["estudiante" => $user]);

        //Creamos un data con los cursos y seminarios
        $data = [
            'cursos' => $cursos,
            'seminariosV' => $seminarioV,
            'seminariosP' => $seminarioP
        ];

        //Retornamos la vista historial
        return view('pago/historial', $data);
    }
}