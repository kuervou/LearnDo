<?php 

namespace App\Models;

use CodeIgniter\Model;

class ForoModel extends Model {
    protected $table = 'foro';

    public function obtenerForo($data){
        $Leccion = $this->db->table('foro');
        $Leccion->where($data);
        return $Leccion->get()->getResultArray();
    }

    public function insertarForo($data){
        return $this->db->table('foro')->insert($data) ? $this->db->insertID() : null;
    }

}