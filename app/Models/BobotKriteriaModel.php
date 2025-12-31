<?php

namespace App\Models;

use CodeIgniter\Model;

class BobotKriteriaModel extends Model
{
    protected $table      = 't_bobot_kriteria';
    protected $primaryKey = 'id_bobot_kriteria';

    protected $returnType = 'array';
    protected $allowedFields = [
        'id_batu',
        'id_kriteria',
        'bobot',
        'persen'
    ];

    protected $useTimestamps = true;

    // ambil hasil final
    public function getHasilByBatu($id_batu)
    {
        return $this->select('
                t_bobot_kriteria.id_kriteria,
                t_kriteria.kriteria,
                t_bobot_kriteria.bobot,
                t_bobot_kriteria.persen
            ')
            ->join('t_kriteria', 't_kriteria.id_kriteria = t_bobot_kriteria.id_kriteria')
            ->where('t_bobot_kriteria.id_batu', $id_batu)
            ->orderBy('t_bobot_kriteria.bobot', 'DESC')
            ->findAll();
    }

    public function deleteByBatu($id_batu)
    {
        return $this->where('id_batu', $id_batu)->delete();
    }


    // UNTUK PENILAIAN
    public function getByBatu($id_batu)
    {
        return $this->select('
            t_bobot_kriteria.id_kriteria,
            t_kriteria.kriteria,
            t_bobot_kriteria.bobot,
            t_bobot_kriteria.persen
        ')
            ->join('t_kriteria', 't_kriteria.id_kriteria = t_bobot_kriteria.id_kriteria')
            ->where('t_bobot_kriteria.id_batu', $id_batu)
            ->orderBy('t_bobot_kriteria.bobot', 'DESC')
            ->findAll();
    }
}
