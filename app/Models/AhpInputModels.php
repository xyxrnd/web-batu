<?php

namespace App\Models;

use CodeIgniter\Model;

class AhpInputModels extends Model
{
    protected $table      = 't_ahp_input';
    protected $primaryKey = 'id_input';

    protected $allowedFields = [
        'id_user',
        'id_batu',
        'id_kriteria_1',
        'id_kriteria_2',
        'nilai'
    ];

    protected $useTimestamps = true;

    public function getDetailBobot($id_batu, $id_kriteria)
    {
        return $this->select('
            t_ahp_input.nilai,
            t_ahp_input.id_kriteria_1,
            t_ahp_input.id_kriteria_2,
            u.nama AS nama_user,
            k1.kriteria  AS kriteria_1,
            k2.kriteria  AS kriteria_2
        ')
            ->join('t_user u', 'u.id_user = t_ahp_input.id_user')
            ->join('t_kriteria k1', 'k1.id_kriteria = t_ahp_input.id_kriteria_1')
            ->join('t_kriteria k2', 'k2.id_kriteria = t_ahp_input.id_kriteria_2')
            ->where('t_ahp_input.id_batu', $id_batu)
            ->groupStart()
            ->where('t_ahp_input.id_kriteria_1', $id_kriteria)
            ->orWhere('t_ahp_input.id_kriteria_2', $id_kriteria)
            ->groupEnd()
            ->findAll();
    }


    public function getTotalNilaiKriteria($id_batu, $id_kriteria)
    {
        return $this->where('id_batu', $id_batu)
            ->groupStart()
            ->where('id_kriteria_1', $id_kriteria)
            ->orWhere('id_kriteria_2', $id_kriteria)
            ->groupEnd()
            ->selectSum('nilai')
            ->first()['nilai'] ?? 0;
    }
}
