<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaModels extends Model
{
    protected $table            = 't_kriteria';
    protected $primaryKey       = 'id_kriteria';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = ['kriteria', 'bobot'];

    public function getByBatuKriteria($id_batu)
    {
        return $this->select('t_kriteria.id_kriteria, t_kriteria.kriteria')
            ->join('t_batu_kriteria', 't_batu_kriteria.id_kriteria = t_kriteria.id_kriteria')
            ->where('t_batu_kriteria.id_batu', $id_batu)
            ->orderBy('t_kriteria.id_kriteria', 'ASC')
            ->findAll();
    }
}
