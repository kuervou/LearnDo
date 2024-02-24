<?php 

namespace App\Models;

use CodeIgniter\Model;

class StatModel extends Model{

    public function obtenerEstadisticasVentas($id_curso)
    {
        $builder = $this->db->table('curso');
        $builder->select('curso.id_curso, curso.nombre, COUNT(t1.id_curso) AS cantidad_ventas,
                         SUM(t1.metodo_pago = "Paypal") AS paypal,
                         SUM(t1.metodo_pago = "creditos") AS creditos,
                         SUM(t1.precio * (t1.metodo_pago = "Paypal")) AS recaudacion');
        $builder->join('transaccion AS t1', 'curso.id_curso = t1.id_curso');
        $builder->where('curso.id_curso', $id_curso);
        $builder->groupBy('curso.id_curso, curso.nombre');

        $query = $builder->get();
        return $query->getRow();
    }


    public function cantidadAprobados($id_curso)
    {
        $query = $this->db->query("
            SELECT COUNT(*) AS total_registros
            FROM (
                SELECT prueba.nick_estudiante, COUNT(curso.id_curso) AS 'cant_aprobadas'
                FROM prueba
                JOIN evaluacion ON evaluacion.id_evaluacion = prueba.id_evaluacion
                JOIN modulo ON modulo.id_modulo = evaluacion.id_modulo
                JOIN curso ON curso.id_curso = modulo.id_curso
                WHERE modulo.id_curso = $id_curso AND prueba.aprobado = 1
                GROUP BY curso.id_curso, prueba.nick_estudiante
                HAVING (COUNT(prueba.nick_estudiante) = (
                        SELECT COUNT(id_evaluacion)
                        FROM evaluacion
                        JOIN modulo ON modulo.id_modulo = evaluacion.id_modulo
                        JOIN curso ON curso.id_curso = modulo.id_curso
                        WHERE modulo.id_curso = $id_curso
                        GROUP BY curso.id_curso
                    )
                )
            ) AS registros_contados;
        ");

        return $query->getRow()->total_registros;
    }

    
}

