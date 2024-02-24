<?php

namespace App\Controllers;
use App\Models\EstudianteModel;
class EstudianteController extends BaseController
{
    public function register()
    {
        $mensaje = session('mensaje');
        return view('users/register', ["mensaje" => $mensaje]);
    }


    public function registro()
    {
        //Obtenemos los datos del estudiante del formulario
        $nombre = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');
        $nick = $this->request->getPost('nick');
        $telefono = $this->request->getPost('tel');
        $password = $this->request->getPost('pass');
        $email = $this->request->getPost('email');

        //Inicializamos el modelo
        $Estudiante = new EstudianteModel();    

        //Inicializamos variables de errores
        $errores = array();
        $mensajes = array();

        //Vamos a ver si el estudiante existe
        $datosUsuario = $Estudiante->obtenerEstudiante(['nick' => $nick]);
        if (count($datosUsuario) > 0) {
            array_push($errores, "El usuario ya existe");
            session()->set('errores', $errores);
            return redirect()->to(base_url('/register'));
        }

        //Validamos que el emai sea único
        $datosUsuario = $Estudiante->obtenerEstudiante(['email' => $email]);
        if (count($datosUsuario) > 0) {
            array_push($errores, "El email ya existe");
            session()->set('errores', $errores);
            return redirect()->to(base_url('/register'));   
        }
        
        // Descargar la imagen a una cadena binaria
        $imagenPath= base_url('public/assets/images/user.png');

       
        //Si no hay errores, vamos a crear el estudiante
        $datosEstudiante = array(
            "nombre" => $nombre,
            "apellido" => $apellido,
            "nick" => $nick,
            "telefono" => $telefono,
            "password" => password_hash($password, PASSWORD_BCRYPT),
            "email" => $email,
            "ruta_multimedia" => $imagenPath
            );
            
        //Guardamos el estudiante
        $Estudiante->insertarEstudiante($datosEstudiante);

        // Envía el correo de verificación 
        $this->sendVerificationEmail($email);

        //Seteamos el mensaje de éxito
        array_push($mensajes, "Registro exitoso, revisa el correo {$email} para verificar tu cuenta en los próximos 60 minutos");
        
        //Seteamos el mensaje en la sesion
        session()->set('mensajes', $mensajes);
        
        //Redireccionamos a la página de login
        return view('users/login');

    }

    protected function sendVerificationEmail($userEmail)
    {
        $emailConfig = new \Config\Email();
        $email = \Config\Services::email();
        $email->initialize($emailConfig);

        //creación del token

        // Generar un timestamp
        $timestamp = time();

       // Creación del token
        $random = md5(rand(0, 1000));
        $seed = $random . uniqid();
        $hashed_seed = password_hash($seed, PASSWORD_BCRYPT);

        // Agregar el timestamp al token
        $token = $timestamp . $hashed_seed;

        // Almacenar el token en la base de datos
        $Estudiante = new EstudianteModel();
        $user = $Estudiante->where('email', $userEmail)->first();
        if (!$user) {
            // Manejar el caso en que el usuario no exista
            return false;
        }
         // Almacenar el token en la base de datos
        $updated = $Estudiante->actualizar($user['nick'], ['token' => $token]);

        if (!$updated) {
            // Manejar el caso en que la actualización falla
            return false;
        }

        $verificationLink = base_url() . "register/verify?token={$token}";

        $email->setTo($userEmail);
        $email->setSubject('Verificación de cuenta');
        $email->setMessage("Por favor, verifica tu cuenta haciendo clic en el siguiente enlace: {$verificationLink}");

        if ($email->send()) {
            return true;
        } else {
            return false;
        }
    }



    
    public function verify()
    {
        $errores = array();
        $token = $this->request->getGet('token');

        $Estudiante = new EstudianteModel();  
        $user = $Estudiante->where('token', $token)->first();

        if ($user) {
            //extraer el timestamp del token
            $timestamp = substr($user['token'], 0, 10); //como usamos time() para crearlo el timestamp tiene 10 caracteres

            //si el token no ha expirado (20 minutos) verificamos que $token sea válido
            if (time() - $timestamp < (60*60)) {
                //verificar que el token sea válido
                if ($user['token'] == $token) {
                    //actualizar el estado del usuario a 'activo' y el token a null
                   $ok = $Estudiante->actualizar($user['nick'], ['activo' => 1, 'token' => null]);
                   if($ok){
                    return redirect()->to('/register/verification_success');
                   } 
                   else{
                    //si el estudiante no está activo eliminamos los datos del usuario de la bd
                    if($user['activo'] == 0){
                        $Estudiante->eliminar($user['nick']);
                    }
                    //cargar errores en la vista
                    array_push($errores, "Error al actualizar el estado del usuario, intente registrarse nuevamente o vuelve a intenarlo más tarde");
                    $data = [
                        "errores" => $errores
                    ];
                    return view('users/verification/verification_failure', $data);
                   }   
                }
                else{
                    //si el estudiante no está activo eliminamos los datos del usuario de la bd
                    if($user['activo'] == 0){
                        $Estudiante->eliminar($user['nick']);
                    }
                    //cargar errores en la vista
                    array_push($errores, "Token inválido, intente registrarse nuevamente o vuelve a intenarlo más tarde");
                    $data = [
                        "errores" => $errores
                    ];
                    return view('users/verification/verification_failure', $data);
                }
            }
            else{

                //si el estudiante no está activo eliminamos los datos del usuario de la bd
                if($user['activo'] == 0){
                    $Estudiante->eliminar($user['nick']);
                }
                //cargar errores en la vista
                array_push($errores, "Token expirado, intenta registrarte nuevamente");
                $data = [
                    "errores" => $errores
                ];
                return view('users/verification/verification_failure', $data);
            }
        }
        else{
            //cargar errores en la vista
            array_push($errores, "Link de verificación inválido");
            $data = [
                "errores" => $errores
            ];
            return view('users/verification/verification_failure', $data);
        }
    }


    public function verificationSuccess()
    {
        return view('users/verification/verification_success');
    }

    public function verificationFailure()
    {
        return view('users/verification/verification_failure');
    }

    public function verificationUnfinished()
    {
        return view('users/verification/verification_unfinished');
    }

    

    
}
