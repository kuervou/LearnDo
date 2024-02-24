<?php 

namespace App\Models;

use CodeIgniter\Model;

class OrganizadorModel extends Model{
    protected $table = 'organizador';

    public function obtenerorganizador($data){
        $Usuario = $this->db->table('organizador');
        $Usuario->where($data);
        return $Usuario->get()->getResultArray();
    }

    public function insertarorganizador($data){
        $Usuario = $this->db->table('organizador');
        $Usuario->insert($data);
    }

    public function actualizar($nick, $data){
        $Usuario = $this->db->table('organizador');
        $Usuario->where('nick', $nick);
        $Usuario->update($data);
        return $this->db->affectedRows();
    }

    public function listarOrganizador(){
        $Usuario = $this->db->query("SELECT * FROM organizador");
        return $Usuario->getResultArray();
    }

    public function eliminar($nick){
        $Usuario = $this->db->table('organizador');
        $Usuario->where('nick', $nick);
        $Usuario->delete();
    }
}