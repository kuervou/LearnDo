<?php 

namespace App\Models;

use CodeIgniter\Model;

class EvaluacionModel extends Model{
    protected $table = 'evaluacion';
    

    public function agregarEvaluacion($data){
        return $this->db->table('evaluacion')->insert($data) ? $this->db->insertID() : null;
    }

    //Hacemos una funcion que nos lista las categorias de la base de datos
    public function listarEvaluaciones(){
        return $this->db->table('evaluacion')->get()->getResultArray();
    }

    public function obtenerEvaluacion($data){
        $Evaluacion = $this->db->table('evaluacion');
        $Evaluacion->where($data);
        return $Evaluacion->get()->getResultArray();
    }


    public function ejecutarConsulta($sql, $params = [])
    {
        $db = db_connect(); // Obtén la instancia de la base de datos
    
        $query = $db->query($sql, $params); // Ejecuta la consulta con los parámetros
    
        return $query->getResultArray(); // Devuelve los resultados
    }

    public function obtenerEvaluacionCurso($curso){
        $id_curso = $curso['id_curso'];

        $consulta = "SELECT id_evaluacion FROM evaluacion
        JOIN modulo ON modulo.id_modulo = evaluacion.id_modulo
        JOIN curso ON curso.id_curso = modulo.id_curso
        WHERE curso.id_curso = ?";

        $respuesta = $this->ejecutarConsulta($consulta, [$id_curso]);

        return $respuesta;
    }

}