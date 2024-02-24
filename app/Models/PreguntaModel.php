<?php 

namespace App\Models;

use CodeIgniter\Model;

class PreguntaModel extends Model{
    protected $table = 'pregunta';

    public function agregarPregunta($data){
        return $this->db->table('pregunta')->insert($data) ? $this->db->insertID() : null; 
    }

    public function obtenerPreguntas($data){
        $Pregunta = $this->db->table('pregunta');
        $Pregunta->where($data);
        return $Pregunta->get()->getResultArray();
    }

}