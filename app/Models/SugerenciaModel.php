<?php 

namespace App\Models;

use CodeIgniter\Model;

class SugerenciaModel extends Model{
    protected $table = 'sugerencia';

    public function agregarSugerencia($data){
        return $this->db->table('sugerencia')->insert($data) ? $this->db->insertID() : null; 
    }

    public function obtenerSugerencias($data){
        $Sugerencia = $this->db->table('sugerencia');
        $Sugerencia->where($data);
        $Sugerencia->where(['aprobada' => 0]);
        return $Sugerencia->get()->getResultArray();
    }

    public function actualizar($id, $data){
        $Sugerencia = $this->db->table('sugerencia');
        $Sugerencia->where('id_sugerencia', $id);
        $Sugerencia->update($data);
        //Retornar si salio bien
        return $this->db->affectedRows();
    }

    public function eliminar($id_sugerencia){
        $Usuario = $this->db->table('sugerencia');
        $Usuario->where('id_sugerencia', $id_sugerencia);
        $Usuario->delete();
        //Retornar si salio bien
        return $this->db->affectedRows();
    }

}