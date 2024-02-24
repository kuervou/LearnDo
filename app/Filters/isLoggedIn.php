<?php


namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\EstudianteModel;
use App\Models\OrganizadorModel;

class isLoggedIn implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

         // Obtén la ruta actual
    $currentPath = service('request')->uri->getPath();

    // Verifica si la ruta actual comienza con 'register/verify'
    $isVerificationRoute = substr($currentPath, 0, strlen('register/verif')) === 'register/verif';

    //Verifica si la ruta actual comienza con consultarSeminario
    $isConsultarSeminario = substr($currentPath, 0, strlen('consultarSeminario')) === 'consultarSeminario';

    //Verifica si la ruta actual comienza con consultarCurso
    $isConsultarCurso = substr($currentPath, 0, strlen('consultarCurso')) === 'consultarCurso';


    if( $currentPath == 'register/verification_unfinished' 
    || $currentPath == 'logout' 
    || $currentPath == 'tienda' 
    || $isVerificationRoute 
    || $currentPath == 'lessonsDownloaded' 
    || $currentPath == 'forgotPassword'
    || $currentPath == 'restablecerContrasena'
    || $isConsultarCurso
    || $isConsultarSeminario
    ){
        return $request;
    }

        if(session()->has('usuario')){
            {
                //cargar modelo de estudiante y organizador
                $Estudiante = new EstudianteModel();
                $Organizador = new OrganizadorModel();
    
                //obtener datos de la sesion
                $nick = session()->get('usuario');
    
                //si hay un estudiante o un organizador con ese nick guardar en la variable activo el valor de la columna activo de la tabla 
    
                $datosEstudiante = $Estudiante->obtenerEstudiante(['nick' => $nick]);
                if(count($datosEstudiante) > 0){
                    $activo = $datosEstudiante[0]['activo'];
                }
                else{
                    $activo = false;
                }
    
                $datosOrganizador = $Organizador->obtenerOrganizador(['nick' => $nick]);
                if(count($datosOrganizador) > 0){
                    $activo2 = $datosOrganizador[0]['activo'];
                }
                else{
                    $activo2 = false;
                }
               
    
                //si ambos son false entonces la cuenta no ha sido activada y debemos reenviarlo a la vista correspondiente
                if($activo == false && $activo2 == false){
                    return redirect()->to(base_url('/register/verification_unfinished'));
                }
            } 
        }
        // Verifica si la ruta actual es una de las rutas excluidas
        if (
            $currentPath == '/' ||
            $currentPath == 'login' ||
            $currentPath == 'register' ||
            $currentPath == 'registro' ||
            $currentPath == 'logout' ||
            $currentPath == 'auth/linkedin' 

            
        ) {
            // Si es así, simplemente devuelve $request para pasar por el filtro
            return $request;
        }
        if (!session()->has('usuario')) {
            return redirect()->to(base_url('/login'));
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
