<?php 

namespace App\Models;

use CodeIgniter\Model;

class RespuestaModel extends Model{
    protected $table = 'respuesta';

    public function agregarRespuesta($data){
        return $this->db->table('respuesta')->insert($data) ? $this->db->insertID() : null; 
    }

    public function obtenerRespuesta($data){
        $Respuesta = $this->db->table('respuesta');
        $Respuesta->where($data);
        return $Respuesta->get()->getResultArray();
    }

}