<?php
namespace App\Controllers;
use App\Models\EstudianteModel;
use App\Models\OrganizadorModel;
use CodeIgniter\API\ResponseTrait;
class UsuarioController extends BaseController
{
    use ResponseTrait;

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }


    public function login(){
        $nick = $this->request->getPost('nick');
        $password = $this->request->getPost('pass');

        $Estudiante = new EstudianteModel();
        $datosEstudiante = $Estudiante->obtenerEstudiante(['nick' => $nick]);

        $Organizador = new OrganizadorModel();
        $datosOrganizador = $Organizador->obtenerOrganizador(['nick' => $nick]);


        if (count($datosEstudiante) > 0 && 
            password_verify($password, $datosEstudiante[0]['password'])) {

            $data = [
                        "usuario" => $datosEstudiante[0]['nick'],
                        "email" => $datosEstudiante[0]['email'],
                        "tipoUser" => "estudiante",
                        "ruta_multimedia" => $datosEstudiante[0]['ruta_multimedia']
                         
            ];

            $session = session();
            $session->set($data);
            $mensajes = array();
            array_push($mensajes,"Bienvenido ".$datosEstudiante[0]['nick']);
            session()->set('mensajes', $mensajes);

                    
            session()->set($data);
            //Redireccionamos a la ruta "/" que es la vista home
            return redirect()->to(base_url('/'));

        } else if(count($datosOrganizador) > 0 && password_verify($password, $datosOrganizador[0]['password'])) {
            
            $data = [
                        "usuario" => $datosOrganizador[0]['nick'],
                        "email" => $datosOrganizador[0]['email'],
                        "tipoUser" => "organizador",
                        "ruta_multimedia" => $datosOrganizador[0]['ruta_multimedia']
            ];
            $session = session();
            $session->set($data);
            $mensajes = array();
            array_push($mensajes,"Bienvenido ".$datosOrganizador[0]['nick']);
            session()->set('mensajes', $mensajes);  
            
            session()->set($data);
           //Redireccionamos a la ruta "/" que es la vista home
           return redirect()->to(base_url('/'));

        }else{
            $errores = array();
            array_push($errores,"Usuario o contraseña incorrectos");
            session()->set('errores', $errores);
            return view('users/login');
        }
    }
    
    public function iniciarSesion(){
        $mensaje = session('mensaje');
        return view('users/login', ["mensaje" => $mensaje]);
    }

    public function profile(){
        $nick = $this->request->getGet('nick_usuario');
        $tipo = $this->request->getGet('tipo');
       
        if($tipo == "estudiante"){
            $Estudiante = new EstudianteModel();
            $datosEstudiante = $Estudiante->obtenerEstudiante(['nick' => $nick]);
            $data = [
                "datos" => $datosEstudiante
            ];
        }else{
            $Organizador = new OrganizadorModel();
            $datosOrganizador = $Organizador->obtenerOrganizador(['nick' => $nick]);
            $data = [
                "datos" => $datosOrganizador
            ];    
        }    

        
        return view('users/profile', $data);
    }

    public function actualizarPerfil(){
            

         // Obtén los datos del JSON en el cuerpo de la solicitud
             $data = $this->request->getJSON();

         // Aquí puedes hacer más validación, si es necesario
 
         // Crea una instancia del modelo de usuario y actualiza el usuario
             


            $Estudiante = new EstudianteModel();
            $estudiante = $Estudiante->obtenerEstudiante(['nick' => session()->get('usuario')]);

            $Organizador = new OrganizadorModel();
            $organizador = $Organizador->obtenerOrganizador(['nick' => session()->get('usuario')]);

            if(count($estudiante) > 0){
                $userModel = new EstudianteModel();
            }
            else if(count($organizador) > 0){
                $userModel = new OrganizadorModel();}
            
                $updatedData = [    
                    'nombre' => $data->nombre,
                    'apellido' => $data->apellido,
                    'telefono' => $data->phone,
                    'biografia' => $data->bio,
                ];
                
 
         // Aquí asumimos que tienes el ID del usuario almacenado en la sesión
         $userNick = session()->get('usuario');
 
         if ($userModel->actualizar($userNick, $updatedData)) {
             // Si la actualización fue exitosa, devuelve un mensaje de éxito
             return $this->respondUpdated(['message' => 'Datos actualizados correctamente']);
         } else {
             // Si algo salió mal, devuelve un error
             return $this->failServerError('Error al actualizar los datos');
         }

    }


    public function actualizarContrasena(){

         // Obtén los datos del JSON en el cuerpo de la solicitud
         $data = $this->request->getJSON();


        $Estudiante = new EstudianteModel();
        $estudiante = $Estudiante->obtenerEstudiante(['nick' => session()->get('usuario')]);

        $Organizador = new OrganizadorModel();
        $organizador = $Organizador->obtenerOrganizador(['nick' => session()->get('usuario')]);
   
        if(count($estudiante) > 0){
            $userModel = new EstudianteModel();
        }
        else if(count($organizador) > 0){
            $userModel = new OrganizadorModel();}
        
            $updatedData = [    
                'password' => password_hash($data->contrasena, PASSWORD_BCRYPT)
            ];


         // Aquí asumimos que tienes el ID del usuario almacenado en la sesión
         $userNick = session()->get('usuario');
 
         if ($userModel->actualizar($userNick, $updatedData)) {
             // Si la actualización fue exitosa, devuelve un mensaje de éxito
             return $this->respondUpdated(['message' => 'Datos actualizados correctamente']);
         } else {
             // Si algo salió mal, devuelve un error
             return $this->failServerError('Error al actualizar los datos');
         }    

    }

    public function actualizarImagen(){

        // Obtén los datos del JSON en el cuerpo de la solicitud
        $file = $this->request->getFile('image'); // Obtén el archivo de imagen recibido

        // Verifica si se cargó correctamente el archivo
        if ($file->isValid()) {
            // Genera un nombre único para el archivo
            $nombreArchivo = $file->getRandomName();
        
            // Mueve el archivo a la ubicación deseada
            $file->move(ROOTPATH . 'public/uploads/contenidoMultimedia/fotosPerfil', $nombreArchivo);
        
            // Obtén la ruta completa del archivo guardado
            $rutaImagen = 'public/uploads/contenidoMultimedia/fotosPerfil/' . $nombreArchivo;
        
            // Aquí puedes almacenar $rutaImagen en una variable o guardarla en la base de datos según tus necesidades
        } else {
            // Ocurrió un error al cargar el archivo
            // Maneja el error de acuerdo a tus necesidades
        }
        



        $Estudiante = new EstudianteModel();
        $estudiante = $Estudiante->obtenerEstudiante(['nick' => session()->get('usuario')]);

        $Organizador = new OrganizadorModel();
        $organizador = $Organizador->obtenerOrganizador(['nick' => session()->get('usuario')]);
   
        if(count($estudiante) > 0){
            $userModel = new EstudianteModel();
        }
        else if(count($organizador) > 0){
            $userModel = new OrganizadorModel();}
        
            $updatedData = [    
                'ruta_multimedia' => $rutaImagen
            ];

        
        $session = session();   
         
        $dataNueva = $session->get();    
        //Seteo la imagen en la sesion
        $dataNueva['ruta_multimedia'] = $rutaImagen;


        // Establecer el nuevo valor en la sesión
        $session->set($dataNueva);

         // Aquí asumimos que tienes el ID del usuario almacenado en la sesión
         $userNick = session()->get('usuario');
 
         if ($userModel->actualizar($userNick, $updatedData)) {
             // Si la actualización fue exitosa, devuelve un mensaje de éxito
             return $this->respondUpdated(['message' => 'Datos actualizados correctamente']);
         } else {
             // Si algo salió mal, devuelve un error
             return $this->failServerError('Error al actualizar los datos');
         }    
    }

    public function listarUsuarios(){
        //Inicializamos el modelo de estudiantes
        $Estudiante = new EstudianteModel();

        //Obtenemos todos los estudiantes
        $estudiantes = $Estudiante->listarEstudiantes();

        //Inicializamos el modelo de organizadores
        $Organizador = new OrganizadorModel();

        //Obtenemos todos los organizadores
        $organizadores = $Organizador->listarOrganizador();

        //Inicializamos un data
        $data = [
            "estudiantes" => $estudiantes,
            "organizadores" => $organizadores
        ];
    
        //Redirigimos a la vista de listar usuarios
        return view('home/listaUsuarios', $data);
    }

    public function forgotPassword(){
        $emailConfig = new \Config\Email();
        $email = \Config\Services::email();
        $email->initialize($emailConfig);

        //Inicializamos los errores y mensajes
        $errores = array();
        $mensajes = array();

        //creación del token

        // Generar un timestamp
        $timestamp = time();

       // Creación del token
        $random = md5(rand(0, 1000));
        $seed = $random . uniqid();
        $hashed_seed = password_hash($seed, PASSWORD_BCRYPT);

        // Agregar el timestamp al token
        $token = $timestamp . $hashed_seed;

        //Traemos el mail del formulario
        $userEmail = $this->request->getPost('email');

        //obtener el tipo de usuario
        $Estudiante = new EstudianteModel();
        $Organizador = new OrganizadorModel();

        $estudiante = $Estudiante->obtenerEstudiante(['email' => $userEmail]);
        $organizador = $Organizador->obtenerOrganizador(['email' => $userEmail]);

        //verificamos si existe el estudiante
        if(count($estudiante) > 0){
            $tipo = "estudiante";
        }else if(count($organizador) > 0){
            $tipo = "organizador";
        }else{
            array_push($errores, "El email no es correcto");
            session()->set('errores', $errores);
            return redirect()->to(base_url('/login'));   
        }

        // Almacenar el token en la base de datos
        if($tipo == "estudiante"){
            $user = $Estudiante->where('email', $userEmail)->first();
            if (!$user) {
                // Manejar el caso en que el usuario no exista
                return false;
            }
             // Almacenar el token en la base de datos
            $updated = $Estudiante->actualizar($user['nick'], ['token' => $token]);
        }else{
            $user = $Organizador->where('email', $userEmail)->first();
            if (!$user) {
                // Manejar el caso en que el usuario no exista
                return false;
            }
             // Almacenar el token en la base de datos
            $updated = $Organizador->actualizar($user['nick'], ['token' => $token]);
        }
        
        if (!$updated) {
            // Manejar el caso en que la actualización falla
            return false;
        }

        $verificationLink = base_url() . "forgotPassword?token={$token}";

        $email->setTo($userEmail);
        $email->setSubject('Recuperar contraseña');
        $email->setMessage("Por favor, ingresa al siguiente link para restablecer tu contraseña: {$verificationLink}");

        if ($email->send()) {
            //Seteamos el mensaje de éxito
            array_push($mensajes, "Solicitud realizada, revisa el correo {$userEmail} para restablecer tu contraseña en los próximos 60 minutos");
            
            //Seteamos el mensaje en la sesion
            session()->set('mensajes', $mensajes);
            
            //Redireccionamos a la página de login
            return redirect()->to(base_url('/login')); 
        } else {
            return false;
        }

         
    }

    public function processForgotPassword()
    {
        $errores = array();
        $token = $this->request->getGet('token');

        $Estudiante = new EstudianteModel();  
        $Organizador = new OrganizadorModel();
        
        $estudiante = $Estudiante->obtenerEstudiante(['token'=>$token]);
        $organizador = $Organizador->obtenerorganizador(['token'=>$token]);
        $user = null;
        
        if(count($estudiante) > 0){
            $user = $estudiante[0];
            $tipo = "estudiante";
        }else if(count($organizador) > 0){
            $user = $organizador[0];
            $tipo = "organizador";  
        }

        if ($user) {
            //extraer el timestamp del token
            $timestamp = substr($user['token'], 0, 10); //como usamos time() para crearlo el timestamp tiene 10 caracteres

            //si el token no ha expirado (20 minutos) verificamos que $token sea válido
            if (time() - $timestamp < (60*60)) {
                //verificar que el token sea válido
                if ($user['token'] == $token) {
                    //actualizar el estado del usuario a 'activo' y el token a null
                    if($tipo == "estudiante"){
                        $ok = $Estudiante->actualizar($user['nick'], ['token' => null]);
                    }else if($tipo == "organizador"){
                        $ok = $Organizador->actualizar($user['nick'], ['token' => null]);
                    }
                if($ok){
                    $data = [
                        'tipo' => $tipo,
                        'user' => $user['nick']
                    ];
                    return view('users/newPassword', $data);
                }  
                }
                else{
                    //cargar errores en la vista
                    array_push($errores, "Token inválido, inicie la solicitud nuevamente");
                    $data = [
                        "errores" => $errores
                    ];
                    return view('users/forgotten/forgot_failure', $data);
                }
            }
            else{
                //cargar errores en la vista
                array_push($errores, "Token expirado, inicie la solicitud nuevamente");
                if($tipo == "estudiante"){
                    $ok = $Estudiante->actualizar($user['nick'], ['token' => null]);
                }else if($tipo == "organizador"){
                    $ok = $Organizador->actualizar($user['nick'], ['token' => null]);
                }
                $data = [
                    "errores" => $errores
                ];
                return view('users/forgotten/forgot_failure', $data);
            }
        }
        else{
            //cargar errores en la vista
            array_push($errores, "Link de verificación inválido");
            $data = [
                "errores" => $errores
            ];
            return view('users/forgotten/forgot_failure', $data);
        }
    }
    
    public function restablecerContrasena(){
        //Traemos los datos del formulario
        $tipo = $this->request->getPost("tipo");
        $user = $this->request->getPost("user");
        $newPass = $this->request->getPost("newPassword");
        $confirmPass = $this->request->getPost("confirmNewPassword");

        //Inicializamos los errores

        if($newPass != $confirmPass){
            $errores = array();
            array_push($errores, "Las contraseñas no coinciden");
            session()->set('errores', $errores);
                $data = [
                    "tipo" => $tipo,
                    "user" => $user
                ];
                return view('users/newPassword', $data);
        }
        log_message('error', "pass {$newPass}");

        $updatedData = [    
            'password' => password_hash($newPass, PASSWORD_BCRYPT)
        ];
        //Identificamos si es Estudiante u Organizador
        if($tipo == "estudiante"){
            $Estudiante = new EstudianteModel();
            $estudiante = $Estudiante->obtenerEstudiante(['nick' => $user]);
            $Estudiante->actualizar($user, $updatedData);
        }else{
            $Organizador = new OrganizadorModel();
            $organizador = $Organizador->obtenerOrganizador(['nick' => $user]);
            $Organizador->actualizar($user, $updatedData);
        }

        return view('users/forgotten/forgot_success'); 
    }

}
