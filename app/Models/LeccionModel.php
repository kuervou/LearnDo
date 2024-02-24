<?php 

namespace App\Models;

use CodeIgniter\Model;

class LeccionModel extends Model{
    protected $table = 'leccion';
    
    
    public function obtenerLeccion($data){
        $Leccion = $this->db->table('leccion');
        $Leccion->where($data);
        return $Leccion->get()->getResultArray();
    }

    public function insertarLeccion($data){
        return $this->db->table('leccion')->insert($data) ? $this->db->insertID() : null;

    }

    public function obtenerIdAnterior($idLeccion, $idModulo){
        $builder = $this->db->table('leccion');
        $builder->select('id_leccion');
        $builder->where('id_modulo', $idModulo);
        $builder->where('id_leccion <', $idLeccion);
        $builder->orderBy('id_leccion', 'DESC');
        $builder->limit(1);
    
        $query = $builder->get();
        $result = $query->getRow();
    
        if ($result) {
            return $result->id_leccion;
        } else {
            return null;
        }
    }

    public function obtenerIdSiguiente($idLeccion, $idModulo) {
        $builder = $this->db->table('leccion');
        $builder->select('id_leccion');
        $builder->where('id_modulo', $idModulo);
        $builder->where('id_leccion >', $idLeccion);
        $builder->orderBy('id_leccion', 'ASC');
        $builder->limit(1);
    
        $query = $builder->get();
        $result = $query->getRow();
    
        if ($result) {
            return $result->id_leccion;
        } else {
            return null;
        }
    }

    public function isDownload($id_Leccion, $nick){
        //la funcion consulta la tabla estudiante_leccion 
        //y si el nick_estudiante y el id_leccion están presentes en una fila donde descarga == 1, devuelve true
        //si no, devuelve false
        $builder = $this->db->table('estudiante_leccion');
        $builder->select('descarga');
        $builder->where('nick_estudiante', $nick);
        $builder->where('id_leccion', $id_Leccion);
        $builder->where('descarga', 1);
        $query = $builder->get();
        $result = $query->getRow();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function download($id_leccion, $nick){
        // La función modifica la tabla estudiante_leccion
        // Debe crear un registro en la tabla estudiante_leccion con los datos de nick_estudiante, id_leccion y descarga = 1
        
        $builder = $this->db->table('estudiante_leccion');
        $builder->select('descarga');
        $builder->where('nick_estudiante', $nick);
        $builder->where('id_leccion', $id_leccion);
    
        $result = $builder->get();
    
        if ($result->getRow()) {
            // Si existe un registro con los mismos valores de nick_estudiante y id_leccion, se actualiza el campo 'descarga' a 1
            $builder->set('descarga', 1);
            $builder->where('nick_estudiante', $nick);
            $builder->where('id_leccion', $id_leccion);
            $builder->update();
        } else {
            // Si no existe un registro con los mismos valores, se crea un nuevo registro con los valores proporcionados
            $data = [
                'nick_estudiante' => $nick,
                'id_leccion' => $id_leccion,
                'descarga' => 1
            ];
            $builder->insert($data);
        }
    }
    

    public function lessonsDownloaded($nick){
        // La función devuelve un array con los id_leccion de las lecciones que el estudiante ha descargado
        $builder = $this->db->table('estudiante_leccion');
        $builder->select('estudiante_leccion.id_leccion, leccion.id_modulo, modulo.id_curso');
        $builder->join('leccion', 'leccion.id_leccion = estudiante_leccion.id_leccion');
        $builder->join('modulo', 'modulo.id_modulo = leccion.id_modulo');
        $builder->where('nick_estudiante', $nick);
        $builder->where('descarga', 1);
        $query = $builder->get();
        $result = $query->getResultArray();
        return $result;
    }
    
    




}