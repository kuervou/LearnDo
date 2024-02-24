<?php 

namespace App\Models;

use CodeIgniter\Model;

class SeminaryModel extends Model{
    protected $tableVirtual = 'seminario_virtual';
    protected $tablePresencial = 'seminario_presencial';
    
    public function obtenerSeminarioVirtual($data){
        $Seminario = $this->db->table('seminario_virtual');
        $Seminario->where($data);
        return $Seminario->get()->getResultArray();
    }

    public function obtenerSeminarioPresencial($data){
        $Seminario = $this->db->table('seminario_presencial');
        $Seminario->where($data);
        return $Seminario->get()->getResultArray();
    }


    public function listarSeminariosVirtualRecomendados(){
        $query = $this->db->query('
            SELECT seminario_virtual.id_seminario_virtual, COUNT(transaccion.id_transaccion) AS total_transacciones
            FROM seminario_virtual
            JOIN transaccion ON seminario_virtual.id_seminario_virtual = transaccion.id_seminario_virtual
            GROUP BY seminario_virtual.nombre
            ORDER BY total_transacciones DESC
            LIMIT 3
        ');
    
        $results = $query->getResultArray();
    
        $seminariosVirtualRecomendados = [];
        foreach ($results as $result) {
            $data = ['id_seminario_virtual' => $result['id_seminario_virtual']];
            $seminariosVirtual = $this->obtenerSeminarioVirtual($data);
            $seminariosVirtualRecomendados[] = $seminariosVirtual[0];
        }
    
        return $seminariosVirtualRecomendados;
    }

    public function listarSeminariosPresencialRecomendados(){
        $query = $this->db->query('
            SELECT seminario_presencial.id_seminario_presencial, COUNT(transaccion.id_transaccion) AS total_transacciones
            FROM seminario_presencial
            JOIN transaccion ON seminario_presencial.id_seminario_presencial = transaccion.id_seminario_presencial
            GROUP BY seminario_presencial.nombre
            ORDER BY total_transacciones DESC
            LIMIT 3
        ');
    
        $results = $query->getResultArray();
    
        $seminariosPresencialRecomendados = [];
        foreach ($results as $result) {
            $data = ['id_seminario_presencial' => $result['id_seminario_presencial']];
            $seminariosPresencial = $this->obtenerSeminarioPresencial($data);
            $seminariosPresencialRecomendados[] = $seminariosPresencial[0];
        }
    
        return $seminariosPresencialRecomendados;
    }


    public function searchSeminarioVirtual($data)
    {
        $Seminario = $this->db->table('seminario_virtual');
        $Seminario->like('nombre', $data, 'after');
        return $Seminario->get()->getResultArray();
    }

    public function searchSeminarioPresencial($data){
        $Seminario = $this->db->table('seminario_presencial');
        $Seminario->like('nombre', $data, 'after');
        return $Seminario->get()->getResultArray();
    }




    
    public function insertarSeminarioVirtual($data){
        return $this->db->table('seminario_virtual')->insert($data) ? $this->db->insertID() : null;
    }

    public function insertarSeminarioPresencial($data){
        return $this->db->table('seminario_presencial')->insert($data) ? $this->db->insertID() : null;
    }

    public function listarSeminarioVirtual(){
        $Seminario = $this->db->table('seminario_virtual');
        return $Seminario->get()->getResultArray();
    }

    public function listarSeminarioPresencial(){
        $Seminario = $this->db->table('seminario_presencial');
        return $Seminario->get()->getResultArray();
    }

    //devuelve las coordenadas para aquellos seminarios que tengan fecha mayor o igual al dia de hoy
    public function obtenerCoordenadas(){
        $Seminario = $this->db->table('seminario_presencial');
        $Seminario->select('ubicacion');
        $Seminario->where('fecha >=', date('Y-m-d'));
        return $Seminario->get()->getResultArray();
        
    }

    public function obtenerSeminariosPorFecha($fecha){
        $Seminario = $this->db->table('seminario_presencial');
        $Seminario->where('fecha', $fecha);
        return $Seminario->get()->getResultArray();
    }

    //devuelve las coordenadas del seminario cuya id se pasa por parametro
    public function obtenerCoordenadasPorId($id){
        $Seminario = $this->db->table('seminario_presencial');
        $Seminario->select('ubicacion');
        $Seminario->where('id_seminario_presencial', $id);
        return $Seminario->get()->getResultArray();
    }

    //funcion para actualizar una columna de la tabla seminario_presencial
    public function actualizar($id, $data){
        $Seminario = $this->db->table('seminario_presencial');
        $Seminario->where('id_seminario_presencial', $id);
        $Seminario->update($data);
        //Retornar si salio bien
        return $this->db->affectedRows();
    }

    public function buscarSeminarioVirtualXCategoria($categoria){

        $builder = $this->db->table('seminario_virtual');
        $builder->select('seminario_virtual.*');
        $builder->join('seminario_virtual_categoria', 'seminario_virtual.id_seminario_virtual = seminario_virtual_categoria.id_seminario_virtual');
        $builder->join('categoria', 'seminario_virtual_categoria.nombre_cat = categoria.nombre');
        $builder->where('categoria.nombre', $categoria);
        $query = $builder->get();
        
        return $query->getResultArray();

    }

    public function buscarSeminarioPresencialXCategoria($categoria){

        $builder = $this->db->table('seminario_presencial');
        $builder->select('seminario_presencial.*');
        $builder->join('seminario_presencial_categoria', 'seminario_presencial.id_seminario_presencial = seminario_presencial_categoria.id_seminario_presencial');
        $builder->join('categoria', 'seminario_presencial_categoria.nombre_cat = categoria.nombre');
        $builder->where('categoria.nombre', $categoria);
        $query = $builder->get();
        
        return $query->getResultArray();
    }

}