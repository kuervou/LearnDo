<?php 

namespace App\Models;

use CodeIgniter\Model;

class MuroModel extends Model{

    public function insertarPublicacion($data){
        return $this->db->table('publicacion')->insert($data) ? $this->db->insertID() : null;

    }

    public function obtenerPublicacion($data){
        $Leccion = $this->db->table('publicacion');
        $Leccion->where($data);
        return $Leccion->get()->getResultArray();
    }

    public function listarPublicaciones(){
        //listar las publicaciones en la bd ordenadas por fecha_hora
        $Publicacion = $this->db->table('publicacion');
        $Publicacion->orderBy('fecha_hora', 'DESC');
        return $Publicacion->get()->getResultArray(); 
    }
    
}

