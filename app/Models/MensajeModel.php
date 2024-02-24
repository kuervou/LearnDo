<?php 

namespace App\Models;

use CodeIgniter\Model;

class MensajeModel extends Model {
    protected $table = 'mensaje';

    protected $allowedFields = ['id_mensaje', 'nick_emisor_estudiante', 'nick_emisor_organizador', 'nick_destinatario_estudiante', 'nick_destinatario_organizador', 'contenido', 'fecha_hora', 'id_seminario'];

    public function obtenerMensaje($data){
        $Mensaje = $this->db->table('mensaje');
        $Mensaje->where($data);
        return $Mensaje->get()->getResultArray();
    }

    public function insertarMensaje($data){
        return $this->db->table('mensaje')->insert($data) ? $this->db->insertID() : null;
    }

    public function obtenerChats($emisor, $receptor){
        $Mensaje = $this->db->table('mensaje');
        $Mensaje->where($emisor);
        $Mensaje->where($receptor);
        return $Mensaje->get()->getResultArray();
    }

    public function insertMessage($data)
    {
        return $this->insert($data);
    }

    public function getMessages($id_seminario)
    {
        $builder = $this->db->table('mensaje');

        $builder->select('mensaje.*, estudiante.ruta_multimedia as estudiante_ruta_multimedia, organizador.ruta_multimedia as organizador_ruta_multimedia');
        $builder->join('estudiante', 'estudiante.nick = mensaje.nick_emisor_estudiante', 'left');
        $builder->join('organizador', 'organizador.nick = mensaje.nick_emisor_organizador', 'left');
        $builder->where('mensaje.id_seminario', $id_seminario);
        $builder->orderBy('mensaje.fecha_hora', 'ASC');

        return $builder->get()->getResult();
    }

}