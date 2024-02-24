<?php 

namespace App\Models;

use CodeIgniter\Model;

class DiscusionModel extends Model {
    protected $table = 'discusion';

    public function agregarDiscusion($data){
        return $this->db->table('discusion')->insert($data) ? $this->db->insertID() : null;
    }

    public function obtenerDiscusion($data){
        return $this->db->table('discusion')->where($data)->get()->getResultArray();
    }

}