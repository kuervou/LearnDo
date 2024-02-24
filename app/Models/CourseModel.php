<?php 

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model{
    protected $table = 'curso';
    
    
    public function obtenerCurso($data){
        $Curso = $this->db->table('curso');
        $Curso->where($data);
        return $Curso->get()->getResultArray();
    }

    public function searchCourses($data)
    {
        $this->like('nombre', $data, 'after');
        return $this->findAll();
    }

    public function insertarCurso($data){
        return $this->db->table('curso')->insert($data) ? $this->db->insertID() : null;

    }

    public function listarCurso(){
        $Curso = $this->db->table('curso');
        return $Curso->get()->getResultArray();
    }

    public function obtenerRutas($id_curso){
        // Esta función devuelve para cada lección del curso, la ruta de la lección + el nombre de la lección + el nombre del módulo
        $builder = $this->db->table('leccion');
        $builder->select('leccion.id_leccion, leccion.nombre AS nombre_leccion, leccion.ruta_multimedia AS multimedia, modulo.nombre AS nombre_modulo, modulo.id_modulo, curso.nombre AS nombre_curso');
        $builder->join('modulo', 'leccion.id_modulo = modulo.id_modulo');
        $builder->join('curso', 'modulo.id_curso = curso.id_curso');
        $builder->where('curso.id_curso', $id_curso);
        $builder->orderBy('modulo.id_modulo', 'ASC');
        $builder->orderBy('leccion.id_leccion', 'ASC');
        return $builder->get()->getResultArray();
    }

    public function obtenerCursosDescargados($nick){
        $builder = $this->db->table('estudiante_leccion');
        $builder->select('curso.*');
        $builder->join('leccion', 'leccion.id_leccion = estudiante_leccion.id_leccion');
        $builder->join('modulo', 'modulo.id_modulo = leccion.id_modulo');
        $builder->join('curso', 'curso.id_curso = modulo.id_curso');
        $builder->where('nick_estudiante', $nick);
        $builder->where('descarga', 1);
        $query = $builder->get();
        $result = $query->getResultArray();
        return $result;
    }

    public function listarCursoRecomendados(){
        $query = $this->db->query('
            SELECT curso.id_curso, COUNT(transaccion.id_transaccion) AS total_transacciones
            FROM curso
            JOIN transaccion ON curso.id_curso = transaccion.id_curso
            GROUP BY curso.nombre
            ORDER BY total_transacciones DESC
            LIMIT 3
        ');
    
        $results = $query->getResultArray();
    
        $cursoRecomendados = [];
        foreach ($results as $result) {
            $data = ['id_curso' => $result['id_curso']];
            $cursos = $this->obtenerCurso($data);
            $cursoRecomendados[] = $cursos[0];
        }
    
        return $cursoRecomendados;
    }
    
    public function buscarXCategoria($categoria)
    {
        $builder = $this->db->table('curso');
        $builder->select('curso.*');
        $builder->join('curso_categoria', 'curso.id_curso = curso_categoria.id_curso');
        $builder->join('categoria', 'curso_categoria.nombre_cat = categoria.nombre');
        $builder->where('categoria.nombre', $categoria);
        $query = $builder->get();
        
        return $query->getResultArray();
    }

}