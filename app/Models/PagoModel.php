<?php

namespace App\Models;
use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $table = 'transaccion';

    public function insertarPago($data){
        $Transaccion = $this->db->table('transaccion');
        $Transaccion->insert($data);
    }

    public function obtenerPago($data){
        $Pago = $this->db->table('transaccion');
        $Pago->where($data);
        return $Pago->get()->getResult();
    }

    public function procesarPago()
    {
        

        // Lógica para procesar el pago utilizando la plataforma de pago seleccionada (por ejemplo, PayPal)

        // Aquí deberías llamar a la API de PayPal o realizar cualquier acción necesaria para procesar el pago

        // Si el pago es exitoso, devuelve true; de lo contrario, devuelve false
        $paymentSuccessful = true;

        return $paymentSuccessful;
    }

    public function ejecutarConsulta($sql, $params = [])
    {
        $db = db_connect(); // Obtén la instancia de la base de datos
    
        $query = $db->query($sql, $params); // Ejecuta la consulta con los parámetros
    
        return $query->getResultArray(); // Devuelve los resultados
    }

    public function listarCursos($data)
    {
        $nick = $data['nick_estudiante'];     

        $consulta = "SELECT curso.nombre AS nombre , curso.id_curso, curso.descripcion, curso.precio, transaccion.metodo_pago FROM curso 
        JOIN transaccion ON transaccion.id_curso = curso.id_curso
        JOIN estudiante ON estudiante.nick = transaccion.nick_estudiante
        WHERE estudiante.nick = ?";

        $respuesta = $this->ejecutarConsulta($consulta, [$nick]);

        return $respuesta;
    }


    public function listarSeminariosPresencialesEstudiante($nickEstudiante){
        $consulta = "SELECT seminario_presencial.nombre AS nombre, seminario_presencial.id_seminario_presencial, seminario_presencial.descripcion, seminario_presencial.precio, transaccion.metodo_pago FROM seminario_presencial
        JOIN transaccion ON transaccion.id_seminario_presencial = seminario_presencial.id_seminario_presencial
        JOIN estudiante ON estudiante.nick = transaccion.nick_estudiante
        WHERE estudiante.nick = ?";

        $respuesta = $this->ejecutarConsulta($consulta, [$nickEstudiante]);

        return $respuesta;


    }

    public function listarSeminariosVirtualesEstudiante($nickEstudiante){
        $consulta = "SELECT seminario_virtual.nombre AS nombre, seminario_virtual.id_seminario_virtual, seminario_virtual.descripcion, seminario_virtual.precio, transaccion.metodo_pago FROM seminario_virtual
        JOIN transaccion ON transaccion.id_seminario_virtual = seminario_virtual.id_seminario_virtual
        JOIN estudiante ON estudiante.nick = transaccion.nick_estudiante
        WHERE estudiante.nick = ?";

        $respuesta = $this->ejecutarConsulta($consulta, [$nickEstudiante]);

        return $respuesta;
    }

}
