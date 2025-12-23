<?php

namespace App\Models;

use CodeIgniter\Model;

class SubKriteriaModel extends Model
{
    protected $table      = 't_sub_kriteria';
    protected $primaryKey = 'id_sub_kriteria';

    protected $allowedFields = [
        'id_batu',
        'id_kriteria',
        'nama_sub_kriteria',
        'nilai'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /* =====================================================
     * BASIC CRUD
     * ===================================================== */

    public function getById($id)
    {
        return $this->where('id_sub_kriteria', $id)->first();
    }

    /**
     * Validasi sub kriteria milik batu tertentu
     */
    public function getByIdAndBatu($id, $id_batu)
    {
        return $this->where([
            'id_sub_kriteria' => $id,
            'id_batu'         => $id_batu
        ])->first();
    }

    public function insertSubKriteria(array $data)
    {
        return $this->insert($data);
    }

    public function updateSubKriteria($id, array $data)
    {
        return $this->update($id, $data);
    }

    public function deleteSubKriteria($id)
    {
        return $this->delete($id);
    }

    /* =====================================================
     * LISTING
     * ===================================================== */

    /**
     * Ambil semua sub kriteria + nama kriteria
     * (untuk admin/global)
     */
    public function getAllWithKriteria()
    {
        return $this->select('
                t_sub_kriteria.*,
                t_kriteria.kriteria
            ')
            ->join('t_kriteria', 't_kriteria.id_kriteria = t_sub_kriteria.id_kriteria')
            ->orderBy('t_sub_kriteria.id_sub_kriteria', 'ASC')
            ->findAll();
    }

    /**
     * Ambil sub kriteria per BATU (flat)
     */
    public function getByBatu($id_batu)
    {
        return $this->select('
                t_sub_kriteria.*,
                t_kriteria.kriteria
            ')
            ->join('t_kriteria', 't_kriteria.id_kriteria = t_sub_kriteria.id_kriteria')
            ->where('t_sub_kriteria.id_batu', $id_batu)
            ->orderBy('t_sub_kriteria.id_sub_kriteria', 'ASC')
            ->findAll();
    }

    /**
     * Ambil sub kriteria per BATU (GROUP BY KRITERIA)
     * --> untuk halaman kelola sub kriteria
     */
    public function getByBatuAndKriteria($id_batu, $id_kriteria)
    {
        return $this->where([
            'id_batu'     => $id_batu,
            'id_kriteria' => $id_kriteria
        ])
            ->orderBy('id_sub_kriteria', 'ASC')
            ->findAll();
    }


    // public function getByBatuAndKriteria($id_batu, $id_kriteria)
    // {
    //     return $this->where('id_batu', $id_batu)
    //         ->where('id_kriteria', $id_kriteria)
    //         ->orderBy('id_sub_kriteria', 'ASC')
    //         ->findAll();
    // }

    // public function getByBatuGrouped($id_batu)
    // {
    //     $data = $this->select('
    //             t_sub_kriteria.*,
    //             t_kriteria.kriteria
    //         ')
    //         ->join('t_kriteria', 't_kriteria.id_kriteria = t_sub_kriteria.id_kriteria')
    //         ->where('t_sub_kriteria.id_batu', $id_batu)
    //         ->orderBy('t_sub_kriteria.id_kriteria', 'ASC')
    //         ->orderBy('t_sub_kriteria.id_sub_kriteria', 'ASC')
    //         ->findAll();

    //     $grouped = [];
    //     foreach ($data as $row) {
    //         $grouped[$row['id_kriteria']][] = $row;
    //     }

    //     return $grouped;
    // }

    /* =====================================================
     * AHP SUPPORT
     * ===================================================== */

    /**
     * Hitung jumlah sub kriteria per BATU + KRITERIA
     */
    public function countByBatuAndKriteria($id_batu, $id_kriteria)
    {
        return $this->where([
            'id_batu'     => $id_batu,
            'id_kriteria' => $id_kriteria
        ])->countAllResults();
    }

    /**
     * Reset nilai sub kriteria sebelum hitung AHP
     */
    public function resetNilaiByBatu($id_batu)
    {
        return $this->where('id_batu', $id_batu)
            ->set(['nilai' => null])
            ->update();
    }
}
