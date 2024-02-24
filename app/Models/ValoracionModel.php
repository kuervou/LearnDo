<?php 

namespace App\Models;

use CodeIgniter\Model;

class ValoracionModel extends Model {
    protected $table = 'valoracion';

    public function agregarValoracionCurso($data){
        return $this->db->table('valoracion')->insert($data) ? $this->db->insertID() : null;
    }

    public function agregarValoracionSeminarioP($data){
        return $this->db->table('valoracion')->insert($data) ? $this->db->insertID() : null;
    }

    public function agregarValoracionSeminarioV($data){
        return $this->db->table('valoracion')->insert($data) ? $this->db->insertID() : null;
    }

    public function obtenerValoracionCurso($nick, $idCurso) {
        return $this->db->table('valoracion')
            ->where('nick_estudiante', $nick)
            ->where('id_curso', $idCurso)
            ->get()
            ->getResultArray();
    }

    public function obtenerValoracionSeminarioP($nick, $idSeminario) {
        return $this->db->table('valoracion')
            ->where('nick_estudiante', $nick)
            ->where('id_seminario_presencial', $idSeminario)
            ->get()
            ->getResultArray();
    }

    public function obtenerValoracionSeminarioV($nick, $idSeminario) {
        return $this->db->table('valoracion')
            ->where('nick_estudiante', $nick)
            ->where('id_seminario_virtual', $idSeminario)
            ->get()
            ->getResultArray();
    }

    
    public function obtenerValoracionCursoPorId($id)
{
    $result = $this->db->table('curso')
        ->select('AVG(valoracion.nota) AS "nota_promedio"')
        ->join('valoracion', 'curso.id_curso = valoracion.id_curso')
        ->where('curso.id_curso', $id)
        ->groupBy('curso.id_curso')
        ->get()
        ->getResult();

    if (!empty($result)) {
        $result[0]->nota_promedio = round($result[0]->nota_promedio); // Redondea la cifra a un número entero
    }

    return $result;
}

public function obtenerValoracionSeminarioPresencialPorId($id)
{
    $result = $this->db->table('seminario_presencial')
        ->select('AVG(valoracion.nota) AS "nota_promedio"')
        ->join('valoracion', 'seminario_presencial.id_seminario_presencial = valoracion.id_seminario_presencial')
        ->where('seminario_presencial.id_seminario_presencial', $id)
        ->groupBy('seminario_presencial.id_seminario_presencial')
        ->get()
        ->getResult();



    if (!empty($result)) {
        $result[0]->nota_promedio = round($result[0]->nota_promedio); // Redondea la cifra a un número entero
    }

    return $result;
}

public function obtenerValoracionSeminarioVirtualPorId($id)
{   
    $result = $this->db->table('seminario_virtual')
        ->select('AVG(valoracion.nota) AS "nota_promedio"')
        ->join('valoracion', 'seminario_virtual.id_seminario_virtual = valoracion.id_seminario_virtual')
        ->where('seminario_virtual.id_seminario_virtual', $id)
        ->groupBy('seminario_virtual.id_seminario_virtual')
        ->get()
        ->getResult();

    if (!empty($result)) {
        $result[0]->nota_promedio = round($result[0]->nota_promedio); // Redondea la cifra a un número entero
    }

    return $result;
}

//obtener valoraciones con nota=5
public function obtenerValoraciones5() {
    return $this->db->table('valoracion')
        ->where('nota', 5)
        ->get()
        ->getResultArray();
}
}