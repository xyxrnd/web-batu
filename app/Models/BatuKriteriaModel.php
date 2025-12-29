<?php

namespace App\Models;

use CodeIgniter\Model;

class BatuKriteriaModel extends Model
{
    protected $table            = 't_batu_kriteria';
    protected $primaryKey       = 'id_batu_kriteria';

    protected $allowedFields    = [
        'id_batu',
        'id_kriteria',
    ];

    protected $useTimestamps    = true;
    protected $createdField    = 'created_at';
    protected $updatedField    = 'updated_at';

    /* =====================================================
     * BASIC CRUD
     * ===================================================== */

    /**
     * Simpan relasi batu - kriteria - sub kriteria
     */
    public function insertData(array $data)
    {
        return $this->insert($data);
    }

    /**
     * Update sub kriteria pada batu + kriteria tertentu
     */
    public function updateSubKriteria($id_batu, $id_kriteria, $id_sub)
    {
        return $this->where('id_batu', $id_batu)
            ->where('id_kriteria', $id_kriteria)
            ->set(['id_sub' => $id_sub])
            ->update();
    }

    /**
     * Hapus relasi batu + kriteria
     */
    public function deleteByBatuKriteria($id_batu, $id_kriteria)
    {
        return $this->where('id_batu', $id_batu)
            ->where('id_kriteria', $id_kriteria)
            ->delete();
    }

    /* =====================================================
     * QUERY KHUSUS (JOIN & PREVIEW)
     * ===================================================== */

    /**
     * Ambil kriteria & sub kriteria berdasarkan batu
     * (untuk preview sebelum AHP)
     */
    public function getByBatu($id_batu)
    {
        return $this->select('
            t_batu_kriteria.id_batu_kriteria,
            t_batu_kriteria.id_kriteria,
            t_batu_kriteria.id_sub,
            k.kriteria AS nama_kriteria,
            s.nama_sub
        ')
            ->join('t_kriteria k', 'k.id_kriteria = t_batu_kriteria.id_kriteria')
            ->join('t_sub_kriteria s', 's.id_sub = t_batu_kriteria.id_sub', 'left')
            ->where('t_batu_kriteria.id_batu', $id_batu)
            ->orderBy('k.id_kriteria', 'ASC')
            ->findAll();
    }


    /**
     * Ambil sub kriteria tertentu
     */
    public function getSubKriteria($id_batu, $id_kriteria)
    {
        return $this->where([
            'id_batu'     => $id_batu,
            'id_kriteria' => $id_kriteria
        ])
            ->first();
    }

    /* =====================================================
     * VALIDATION & CHECK
     * ===================================================== */

    /**
     * Cek apakah kombinasi batu + kriteria sudah ada
     */
    public function exists($id_batu, $id_kriteria)
    {
        return $this->where([
            'id_batu'     => $id_batu,
            'id_kriteria' => $id_kriteria
        ])
            ->countAllResults() > 0;
    }

    public function getSubForAHP($id_batu, $id_kriteria)
    {
        return $this->select('
            t_sub_kriteria.id_sub,
            t_sub_kriteria.nama_sub
        ')
            ->join(
                't_sub_kriteria',
                't_sub_kriteria.id_sub = t_batu_kriteria.id_sub'
            )
            ->where('t_batu_kriteria.id_batu', $id_batu)
            ->where('t_batu_kriteria.id_kriteria', $id_kriteria)
            ->groupBy('t_sub_kriteria.id_sub')
            ->findAll();
    }
}
