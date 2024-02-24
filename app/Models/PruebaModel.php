<?php 

namespace App\Models;

use CodeIgniter\Model;

class PruebaModel extends Model{
    protected $table = 'prueba';

    public function agregarPrueba($data){
        return $this->db->table('prueba')->insert($data) ? $this->db->insertID() : null; 
    }

    public function obtenerPrueba($data){
        $Prueba = $this->db->table('prueba');
        $Prueba->where($data);
        return $Prueba->get()->getResultArray();
    }

    public function ultimaPrueba($user, $evaluacion){
        $Prueba = $this->db->table('prueba');
        $Prueba->where($user);
        $Prueba->where($evaluacion);
        $Prueba->orderBy('id_prueba', 'DESC');
        $Prueba->limit(1);
        return $Prueba->get()->getRowArray();
    }

    public function ejecutarConsulta($sql, $params = [])
    {
        $db = db_connect(); // Obtén la instancia de la base de datos
    
        $query = $db->query($sql, $params); // Ejecuta la consulta con los parámetros
    
        return $query->getResultArray(); // Devuelve los resultados
    }

    public function obtenerPruebaNickCurso($curso, $user){
        $nick = $user['nick_estudiante'];
        $id_curso = $curso['id_curso'];

        $consulta = "SELECT id_prueba FROM prueba 
        JOIN evaluacion ON evaluacion.id_evaluacion = prueba.id_evaluacion
        JOIN modulo ON modulo.id_modulo = evaluacion.id_modulo
        JOIN curso ON curso.id_curso = modulo.id_curso
        WHERE curso.id_curso = ? AND prueba.nick_estudiante = ? AND aprobado = true";

        $respuesta = $this->ejecutarConsulta($consulta, [$id_curso, $nick]);

        return $respuesta;
    }
    
}