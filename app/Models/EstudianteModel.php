<?php 

namespace App\Models;

use CodeIgniter\Model;

class EstudianteModel extends Model {
    protected $table = 'estudiante';
    protected $tabla = 'estudiante_colabora';

    public function obtenerEstudiante($data){
        $Usuario = $this->db->table('estudiante');
        $Usuario->where($data);
        return $Usuario->get()->getResultArray();
    }

    public function insertarEstudiante($data){
        $Usuario = $this->db->table('estudiante');
        $Usuario->insert($data);
    }

    
    public function actualizar($nick, $data){
        $Usuario = $this->db->table('estudiante');
        $Usuario->where('nick', $nick);
        $Usuario->update($data);
        //Retornar si salio bien
        return $this->db->affectedRows();
    }

    //eliminar estudiante
    public function eliminar($nick){
        $Usuario = $this->db->table('estudiante');
        $Usuario->where('nick', $nick);
        $Usuario->delete();
        //Retornar si salio bien
        return $this->db->affectedRows();
    }

    public function listarEstudiantes(){
        $Usuario = $this->db->query("SELECT * FROM estudiante");
        return $Usuario->getResultArray();
    }

    public function obtenerEstudiantesPorSeminario($id_seminario){
        // Conexión a la base de datos
        $db = \Config\Database::connect();
    
        // Consulta a la base de datos con enlace de parámetros
        $query = $db->query('SELECT e.* FROM estudiante e JOIN transaccion t ON e.nick = t.nick_estudiante WHERE t.id_seminario_presencial = ?', [$id_seminario]);
    
        // Resultados
        $results = $query->getResultArray();
    
        return $results;
    }

    public function agregarColaborador($data){
        $Usuario = $this->db->table('estudiante_colabora');
        $Usuario->insert($data);
    }

    public function obtenerColaborador($data){
        $Usuario = $this->db->table('estudiante_colabora');
        $Usuario->where($data);
        return $Usuario->get()->getResultArray();
    }

}