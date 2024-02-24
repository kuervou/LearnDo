<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class isSuperAdmin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Comprueba si el usuario tiene el rol correcto
        if(session()->get('tipoUser') != 'organizador' || session()->get('usuario') != 'superAdmin') 
            return redirect()->to(base_url('/ups')); 
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // ...
    }
}
