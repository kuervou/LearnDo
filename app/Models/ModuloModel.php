<?php 

namespace App\Models;

use CodeIgniter\Model;

class ModuloModel extends Model{
    protected $table = 'modulo';
    
    
    public function obtenerModulo($data){
        $Modulo = $this->db->table('modulo');
        $Modulo->where($data);
        return $Modulo->get()->getResultArray();
    }

    public function insertarModulo($data){
        return $this->db->table('modulo')->insert($data) ? $this->db->insertID() : null;

    }


}