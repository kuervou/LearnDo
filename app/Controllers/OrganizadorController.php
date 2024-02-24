<?php

namespace App\Controllers;
use App\Models\OrganizadorModel;
use App\Models\EstudianteModel;
class OrganizadorController extends BaseController
{
    public function gestionOrganizador()
    {
        //traer los organizadores de la bd
        $organizadorModel = new OrganizadorModel();
        $organizadores = $organizadorModel->listarOrganizador();
        $data = [
            "organizadores" => $organizadores
        ];
        return view('users/organizador/gestionOrganizador', $data);
    }

    public function eliminarOrganizador(){
        //traer el nick del organizador a eliminar
        $nick = $this->request->getGet('nick');

        //inicializar el modelo
        $Organizador = new OrganizadorModel();

        //eliminar el organizador de la bd
        $Organizador->eliminar($nick);

        //Seteamos el mensaje de éxito
        $mensajes = array();
        array_push($mensajes, "Organizador eliminado exitosamente");

        //Seteamos el mensaje en la sesion
        session()->set('mensajes', $mensajes);

        
        //redirigir a la vista de gestion de organizadores
        return redirect()->to(base_url('/gestionOrganizador'));
    }

    public function altaOrganizador(){
        //traer del form los datos 
        $nick = $this->request->getPost('nick');
        $email = $this->request->getPost('email');
        $telefono = $this->request->getPost('telefono');
        $nombre = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');

        //crear contraseña random
        $random = md5(rand(0, 1000));
        $seed = $random . uniqid();
        $random_pass = password_hash($seed, PASSWORD_BCRYPT);
        //recortar a 12 caracteres
        $random_pass = substr($random_pass, 0, 12);

        
         //Inicializamos el modelo
         $Estudiante = new EstudianteModel();   
            $Organizador = new OrganizadorModel(); 

         //Inicializamos variables de errores
         $errores = array();
         $mensajes = array();
        
         //verificamos en los modelos estudiante y organizador que el nick y el user no esten en uso 
            $datosUsuario = $Estudiante->obtenerEstudiante(['nick' => $nick]);
            if (count($datosUsuario) > 0) {
                array_push($errores, "El usuario ya existe");
                session()->set('errores', $errores);
                return redirect()->to(base_url('/register'));
            }
            $datosUsuario = $Organizador->obtenerorganizador(['nick' => $nick]);
            if (count($datosUsuario) > 0) {
                array_push($errores, "El usuario ya existe");
                session()->set('errores', $errores);
                return redirect()->to(base_url('/register'));
            }
            $datosUsuario = $Estudiante->obtenerEstudiante(['email' => $email]);
            if (count($datosUsuario) > 0) {
                array_push($errores, "El email ya existe");
                session()->set('errores', $errores);
                return redirect()->to(base_url('/register'));   
            }
            $datosUsuario = $Organizador->obtenerorganizador(['email' => $email]);
            if (count($datosUsuario) > 0) {
                array_push($errores, "El email ya existe");
                session()->set('errores', $errores);
                return redirect()->to(base_url('/register'));   
            }


        //armar el data para insertar en la bd con los datos 

        $data = [
            'nick' => $nick,
            'email' => $email,
            "password" => password_hash($random_pass, PASSWORD_BCRYPT),
            'telefono' => $telefono,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'ruta_multimedia' => 'public/assets/images/user.png',
            'biografia' => '',
            'activo' => 1,      
        ];

        //insertar en la bd
        $Organizador->insertarorganizador($data);

        //enviar email con la contraseña random
        $this->sendNotificationEmail($nick, $email, $random_pass);


        //Seteamos el mensaje de éxito
        array_push($mensajes, "Usuario creado exitosamente");
        
        //Seteamos el mensaje en la sesion
        session()->set('mensajes', $mensajes);
        

        //redirigir a la vista de gestion de organizadores
        return redirect()->to(base_url('/gestionOrganizador'));

    }


    protected function sendNotificationEmail($nick, $userEmail, $password)
    {
        $emailConfig = new \Config\Email();
        $email = \Config\Services::email();
        $email->initialize($emailConfig);

       
        $email->setTo($userEmail);
        $email->setSubject('Bienvenido a LearnDo!, tu cuenta ha sido creada');
        $email->setMessage("Hola $nick, tu cuenta ha sido creada exitosamente. Por favor, cambia tu contraseña en tu perfil. \n\n
        A continuacion tienes los datos para ingresar al sistema: \n
        Usuario: $nick \n\n
        Contraseña: $password \n\n
        URL: http://localhost/LearnDo/login \n\n
        Saludos! \n\n
        El Equipo de LearnDo");

        if ($email->send()) {
            return true;
        } else {
            return false;
        }
    }


}
