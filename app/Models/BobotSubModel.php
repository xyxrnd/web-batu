<?php

namespace App\Models;

use CodeIgniter\Model;

class BobotSubModel extends Model
{
    protected $table      = 't_bobot_sub';
    protected $primaryKey = 'id_bobot_sub';

    protected $returnType = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_batu',
        'id_kriteria',
        'id_sub_kriteria',
        'bobot',
        'persen',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ===============================
    // BASIC QUERY ONLY
    // ===============================

    public function getByBatuKriteria($id_batu, $id_kriteria)
    {
        return $this->where('id_batu', $id_batu)
            ->where('id_kriteria', $id_kriteria)
            ->findAll();
    }

    public function deleteByBatuKriteria($id_batu, $id_kriteria)
    {
        return $this->where('id_batu', $id_batu)
            ->where('id_kriteria', $id_kriteria)
            ->delete();
    }

    public function insertBatchData(array $data)
    {
        return $this->insertBatch($data);
    }


    // UNTUK PENILAIAN
    public function getHasilByBatuKriteria($id_batu, $id_kriteria)
    {
        return $this->select('
                t_bobot_sub.id_sub_kriteria,
                t_sub_kriteria.nama_sub,
                t_bobot_sub.bobot,
                t_bobot_sub.persen
            ')
            ->join(
                't_sub_kriteria',
                't_sub_kriteria.id_sub = t_bobot_sub.id_sub_kriteria'
            )
            ->where('t_bobot_sub.id_batu', $id_batu)
            ->where('t_bobot_sub.id_kriteria', $id_kriteria)
            ->orderBy('t_bobot_sub.bobot', 'DESC')
            ->findAll();
    }
}
