<?php 

namespace App\Models;

use CodeIgniter\Model;

class OpcionModel extends Model{
    protected $table = 'opcion';

    public function agregarOpcion($data){
        return $this->db->table('opcion')->insert($data); 
    }

    public function obtenerOpciones($data){
        $Opcion = $this->db->table('opcion');
        $Opcion->where($data);
        return $Opcion->get()->getResultArray();
    }

}