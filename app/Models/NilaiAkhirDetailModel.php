<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiAkhirDetailModel extends Model
{
    protected $table      = 't_nilai_akhir_detail';
    protected $primaryKey = 'id_detail';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_nilai_akhir',
        'id_kriteria',
        'id_sub_kriteria',
        'nilai_rata_juri',
        'bobot_kriteria',
        'bobot_sub',
        'nilai_akhir'
    ];

    protected $useTimestamps = false;

    // ===============================
    // BASIC QUERY
    // ===============================

    public function deleteByNilaiAkhir($id_nilai_akhir)
    {
        return $this->where('id_nilai_akhir', $id_nilai_akhir)->delete();
    }

    public function getDetailByNilaiAkhir($id_nilai_akhir)
    {
        return $this->select('
                t_nilai_akhir_detail.*,
                t_kriteria.kriteria,
                t_sub_kriteria.nama_sub
            ')
            ->join('t_kriteria', 't_kriteria.id_kriteria = t_nilai_akhir_detail.id_kriteria')
            ->join('t_sub_kriteria', 't_sub_kriteria.id_sub = t_nilai_akhir_detail.id_sub_kriteria')
            ->where('id_nilai_akhir', $id_nilai_akhir)
            ->orderBy('nilai_akhir', 'DESC')
            ->findAll();
    }
}
