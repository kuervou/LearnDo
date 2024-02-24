<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table = 'curso_categoria';
    protected $tabla = 'categoria';
    protected $virtual = 'seminario_virtual_categoria';
    protected $presencial = 'seminario_presencial_categoria';


    public function agregarCategoria($data)
    {
        return $this->db->table('curso_categoria')->insert($data);
    }

    public function crearCategoria($data){
        return $this->db->table('categoria')->insert($data);
    }

    public function obtenerCategoria($data){
        $Categoria = $this->db->table('categoria');
        $Categoria->where($data);
        return $Categoria->get()->getResultArray();
    }

    public function actualizar($nombre, $data){
        $Categoria = $this->db->table('categoria');
        $Categoria->where('nombre', $nombre);
        $Categoria->update($data);
        //Retornar si salio bien
        return $this->db->affectedRows();
    }

    public function eliminar($nombre){
        $Categoria = $this->db->table('categoria');
        $Categoria->where('nombre', $nombre);
        $Categoria->delete();
        // Retornar si salió bien
        return $this->db->affectedRows();
    }    

    //Hacemos una funcion que nos lista las categorias de la base de datos
    public function listarCategoriasDestacadas()
    {
        $query = $this->db->query('
        SELECT nombre, COUNT(id_transaccion) AS total_transacciones
        FROM (
            SELECT categoria.nombre AS nombre, transaccion.id_transaccion AS id_transaccion
            FROM categoria
            JOIN curso_categoria ON categoria.nombre = curso_categoria.nombre_cat
            JOIN curso ON curso_categoria.id_curso = curso.id_curso
            JOIN transaccion ON curso.id_curso = transaccion.id_curso

            UNION ALL

            SELECT categoria.nombre AS nombre, transaccion.id_transaccion AS id_transaccion
            FROM categoria
            JOIN seminario_virtual_categoria ON categoria.nombre = seminario_virtual_categoria.nombre_cat
            JOIN seminario_virtual ON seminario_virtual_categoria.id_seminario_virtual = seminario_virtual.id_seminario_virtual
            JOIN transaccion ON seminario_virtual.id_seminario_virtual = transaccion.id_transaccion

            UNION ALL

            SELECT categoria.nombre AS nombre, transaccion.id_transaccion AS id_transaccion
            FROM categoria
            JOIN seminario_presencial_categoria ON categoria.nombre = seminario_presencial_categoria.nombre_cat
            JOIN seminario_presencial ON seminario_presencial_categoria.id_seminario_presencial = seminario_presencial.id_seminario_presencial
            JOIN transaccion ON seminario_presencial.id_seminario_presencial = transaccion.id_transaccion
        ) AS union_categorias
        GROUP BY nombre
        ORDER BY total_transacciones DESC
        LIMIT 3    
        ');

        return $query->getResultArray();
    }
    public function listarCategorias()
    {
        return $this->db->table('categoria')->get()->getResultArray();
    }

    public function insertarCategoriaVirtual($data)
    {
        return $this->db->table('seminario_virtual_categoria')->insert($data);
    }

    public function insertarCategoriaPresencial($data)
    {
        return $this->db->table('seminario_presencial_categoria')->insert($data);
    }
}
