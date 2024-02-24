<?php namespace App\Controllers;

use App\Config\LinkedIn;
use CodeIgniter\Controller;
use League\OAuth2\Client\Provider\LinkedIn as LinkedInProvider;
use App\Models\EstudianteModel;

class AuthLinkedInController extends Controller
{
    private $provider;

    public function __construct()
    {
        $config = new \Config\LinkedIn();
        $this->provider = new LinkedInProvider([
            'clientId'          => $config->clientId,
            'clientSecret'      => $config->clientSecret,
            'redirectUri'       => $config->redirectUri,
            'scopes'            => ['r_liteprofile', 'r_emailaddress'],
        ]);
    }

    public function index()
    {
        if (!$this->request->getGet('code')) {
            // Si no tenemos el código de autorización, solicitamos la autorización del usuario
            $authUrl = $this->provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $this->provider->getState();
            return redirect()->to($authUrl);
        }
    
        // Verificar si el estado es válido
        if ($this->request->getGet('state') !== $_SESSION['oauth2state']) {
            unset($_SESSION['oauth2state']);
            throw new \Exception('Estado no válido');
        }
    
        // Obtener el token de acceso y datos del usuario
        $token = $this->provider->getAccessToken('authorization_code', [
            'code' => $this->request->getGet('code')
        ]);
    
        $user = $this->provider->getResourceOwner($token);

       //Inicializamos variables de errores
       $errores = array();
       $mensajes = array();
    
       //vamos a ver si el usuario existe en la base de datos
       $EstudianteModel = new EstudianteModel();
       $datosEstudiante = $EstudianteModel->obtenerEstudiante(['email' => $user->getEmail()]);

       //si no existe el user debemos proceder a registrarlo 
       if (count($datosEstudiante) <= 0) {
           
           

           

           //generar $nickLinkedIn a partir del nombre y apellido del usuario 
           $nickLinkedIn = $user->getFirstName().$user->getLastName();
           $nickLinkedIn = strtolower($nickLinkedIn);
           $nickLinkedIn = str_replace(' ', '', $nickLinkedIn);

           //verificar que el nick generado no esté en uso y si lo está generar uno nuevo en loop
           $datosEstudiante = $EstudianteModel->obtenerEstudiante(['nick' => $nickLinkedIn]);
           while (count($datosEstudiante) > 0) {
               $nickLinkedIn = $nickLinkedIn.rand(0, 100);
               $datosEstudiante = $EstudianteModel->obtenerEstudiante(['nick' => $nickLinkedIn]);
           }


           //Generamos una contraseña aleatoria basada en el $user->getId() y un token
           // Obtener el string random
           $random = $user->getId(). md5(rand(0, 100));

           // Generar una semilla basada en esto
           $seed = $random. uniqid();

           // Generar una cadena de caracteres aleatoria
           $randomString = str_shuffle($seed);
                       

           
           //Si no hay errores, vamos a crear el estudiante
           $datosEstudiante = array(
               "nombre" => $user->getFirstName(),
               "apellido" => $user->getLastName(),
               "nick" => $nickLinkedIn,
               "password" => password_hash($randomString, PASSWORD_BCRYPT),
               "email" => $user->getEmail(),
               "activo" => true,
               "ruta_multimedia" => 'public/assets/images/user.png',
               'id_linkedin' => $user->getId()
               );
               
           //Guardamos el estudiante
           $EstudianteModel->insertarEstudiante($datosEstudiante);

           //Seteamos el mensaje de éxito
           array_push($mensajes, "Registro exitoso");
           
           //Seteamos el mensaje en la sesion
           session()->set('mensajes', $mensajes);
           
       }
       //volvemos a revisar si el user existe en la bd
       $datosEstudiante = $EstudianteModel->obtenerEstudiante(['email' => $user->getEmail()]);
       //si el user existe
       if (count($datosEstudiante) > 0) {
          // si el usuario tiene id_linkedin = $user->getId() entonces iniciamos sesión
          if($datosEstudiante[0]['id_linkedin'] == $user->getId()){
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
          }
             //si el usuario tiene id_linkedin != $user->getId() entonces mostramos un error
             else{                
               array_push($errores, "Ya existe un usuario registrado con el email ".$user->getEmail());
               session()->set('errores', $errores);
               return redirect()->to(base_url('/register')); 
             }
            
       }
        
    }
    
}