<?php

namespace App\Controllers;

use PayPal\Api\PaymentExecution;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use Config\Paypal;
use Exception;

use App\Models\CourseModel;
use App\Models\SeminaryModel;
use App\Models\PagoModel;
use App\Models\EstudianteModel;

// NOTAS :
// 1. Para que esto funcione, debe tener instalado el SDK de PayPal y haber ejecutado
// `composer require paypal/rest-api-sdk-php: *`
/*
Este controlador inicializa el contexto de la API de PayPal en su constructor, y proporciona dos métodos: payWithPaypal y paymentStatus.

El método payWithPaypal se invoca cuando el usuario hace clic en el botón "Pagar con PayPal". 
Crea un nuevo pago y redirige al usuario a PayPal para completar el pago.

El método paymentStatus se invoca cuando el usuario es redirigido de vuelta desde PayPal. 
Aquí es donde se gestiona el resultado del pago y se actualiza el estado del pedido en la base de datos.
*/

class PaypalController extends BaseController
{
    private $apiContext;

    public function __construct()
    {
        $paypal = new Paypal();

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypal->clientId,
                $paypal->clientSecret
            )
        );

        $this->apiContext->setConfig($paypal->settings);
    }

    public function payWithPaypal()
    {

        //obtener tipoPrograma y IdPrograma de los parámetros del get
        $tipoPrograma = $this->request->getGet('tipoPrograma');
        $idPrograma = $this->request->getGet('idPrograma');
        $tipo = "";
        $nick_estudiante = $this->request->getGet('nick_estudiante');
        if($tipoPrograma != "curso"){
            $tipo = "seminario";
        }
        

        //obtener el precio del programa
        if ($tipoPrograma == "curso") {
            $Curso = new CourseModel();
            $curso = $Curso->obtenerCurso(['id_curso' => $idPrograma]);
            $precio = $curso[0]['precio'];
            $nombrePrograma = $curso[0]['nombre'];
        } else if ($tipoPrograma == "presencial") {
            $SeminarioPresencial = new SeminaryModel();
            $seminarioPresencial = $SeminarioPresencial->obtenerSeminarioPresencial(['id_seminario_presencial' => $idPrograma]);
            $precio = $seminarioPresencial[0]['precio'];
            $nombrePrograma = $seminarioPresencial[0]['nombre'];
        } else if ($tipoPrograma == "virtual") {
            $SeminarioVirtual = new SeminaryModel();
            $seminarioVirtual = $SeminarioVirtual->obtenerSeminarioVirtual(['id_seminario_virtual' => $idPrograma]);
            $precio = $seminarioVirtual[0]['precio'];
            $nombrePrograma = $seminarioVirtual[0]['nombre'];
        }
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($precio);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription($tipo .$tipoPrograma . ' : ' . $nombrePrograma . ' by ' . 'Learndo Connecting Minds');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(base_url() . 'PaypalController/paymentStatus?tipoPrograma=' . $tipoPrograma . '&idPrograma=' . $idPrograma . '&nick_estudiante=' . $nick_estudiante)
            ->setCancelUrl(base_url() . 'PaypalController/paymentStatus/paymentStatus?tipoPrograma=' . $tipoPrograma . '&idPrograma=' . $idPrograma);

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->apiContext);
        } catch (Exception $ex) {
            die($ex);
        }

        $approvalUrl = $payment->getApprovalLink();

        return redirect()->to($approvalUrl);
    }

    public function paymentStatus()
    {
        // El ID de pago se enviará como un parámetro GET
        $paymentId = $this->request->getGet('paymentId');
        $payerId = $this->request->getGet('PayerID');
        $tipoPrograma = $this->request->getGet('tipoPrograma');
        $idPrograma = $this->request->getGet('idPrograma');
        $nick_estudiante = $this->request->getGet('nick_estudiante');

        if (empty($payerId) || empty($paymentId)) {
            // El pago no se completó
            //cargar errores en la vista
            array_push($errores, "Ocurrió un problema durante la transacción y el pago no se completó");
            $data = [
                "errores" => $errores
            ];
            return view('pago/failure', $data);
        }

        $payment = Payment::get($paymentId, $this->apiContext);

        // Puedes verificar el estado del pago aquí y hacer lo que necesites con el resultado
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);


        try {
            //este es el punto en el que el pago se ejecuta realmente.
            $payment->execute($execution, $this->apiContext);

            // Vuelve a obtener el objeto de pago para obtener la información actualizada
            $payment = Payment::get($paymentId, $this->apiContext);
        } catch (Exception $ex) {
            // Agregar código para manejar la excepción aquí
            exit(1);
        }


        // Aquí puedes verificar si el pago se completó correctamente y realizar las acciones necesarias
        if ($payment) {
            if ($payment->getState() == 'approved') {
                print_r("Pago aprobado");
                // El pago se completó correctamente
                return $this->succesManager($tipoPrograma, $idPrograma, $nick_estudiante);
            } else {
                print_r($payment->getState());

                //cargar errores en la vista
                array_push($errores, "Ocurrió un problema durante la transacción: Pago no aprobado");
                $data = [
                    "errores" => $errores
                ];
                return view('pago/failure', $data);
            }
        } else {
            print_r("No se pudo recuperar el pago de PayPal");
            //cargar errores en la vista
            array_push($errores, "Ocurrió un problema durante la transacción: No se pudo recuperar el pago de PayPal");
            $data = [
                "errores" => $errores
            ];
            return view('pago/failure', $data);
        }

        
    }


    private function succesManager($tipoPrograma, $idPrograma, $nick_estudiante){
        //obtener el nick del usuario logueado
        $nick = session('usuario');

        //obtener el precio del programa
        if ($tipoPrograma == "curso") {
            $Curso = new CourseModel();
            $curso = $Curso->obtenerCurso(['id_curso' => $idPrograma]);
            $precio = $curso[0]['precio'];
            $tipoId = "id_curso";
            if($nick_estudiante != null){
                $this->recommendationManager($nick_estudiante, $curso[0]['creditos_otorga']);
            }

        } else if ($tipoPrograma == "presencial") {
            $SeminarioPresencial = new SeminaryModel();
            $seminarioPresencial = $SeminarioPresencial->obtenerSeminarioPresencial(['id_seminario_presencial' => $idPrograma]);
            //actualizar capacidad
            $capacidad = $seminarioPresencial[0]['capacidad'] - 1;
            $SeminarioPresencial->actualizar($idPrograma, ["capacidad"=>$capacidad]);
            
            $precio = $seminarioPresencial[0]['precio'];
            $tipoId = "id_seminario_presencial";
        } else if ($tipoPrograma == "virtual") {
            $SeminarioVirtual = new SeminaryModel();
            $seminarioVirtual = $SeminarioVirtual->obtenerSeminarioVirtual(['id_seminario_virtual' => $idPrograma]);
            $precio = $seminarioVirtual[0]['precio'];
            $tipoId = "id_seminario_virtual";
        }

        //cargar el PagoModel donde usaremos insertarPago($data) para insertar el pago en la base de datos
        $Pago = new PagoModel();
        print_r($nick);
        //crear $data
        $data = [
            'nick_estudiante' => $nick,
            'creditos_usados' => 0,
            'precio' => $precio,
            $tipoId => $idPrograma,
            'metodo_pago' => 'Paypal',
        ];

        //insertar el pago en la base de datos
        $Pago->insertarPago($data);

        $data2 = [
            'tipoPrograma' => $tipoPrograma,
            'tipoId' => $tipoId,
            'idPrograma' => $idPrograma
        ];
       
        //cargar la vista de éxito
        return view('pago/success', $data2);

    }

    private function recommendationManager($nick_estudiante, $creditos_otorga){
        $EstudianteModel = new EstudianteModel();
        $estudiante = $EstudianteModel->obtenerEstudiante(['nick' => $nick_estudiante]);

        //Actualizamos sus creditos
        $creditos = $estudiante[0]['creditos'] + $creditos_otorga;
        $EstudianteModel->actualizar($nick_estudiante, ["creditos"=>$creditos]);
    }
}