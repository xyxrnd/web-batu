<?php

namespace App\Models;

use CodeIgniter\Model;

class SubKriteriaModel extends Model
{
    protected $table            = 't_sub_kriteria';
    protected $primaryKey       = 'id_sub';

    protected $allowedFields    = [
        'nama_sub'
    ];

    protected $useTimestamps    = true;
    protected $createdField    = 'created_at';
    protected $updatedField    = 'updated_at';

    /* =====================================================
     * BASIC CRUD
     * ===================================================== */

    /**
     * Ambil semua sub kriteria
     * (untuk dropdown)
     */
    public function getAll()
    {
        return $this->orderBy('id_sub', 'ASC')->findAll();
    }

    /**
     * Ambil 1 sub kriteria berdasarkan ID
     */
    public function getById($id_sub)
    {
        return $this->find($id_sub);
    }

    /**
     * Simpan sub kriteria baru
     */
    public function insertSub(array $data)
    {
        return $this->insert($data);
    }

    /**
     * Update sub kriteria
     */
    public function updateSub($id_sub, array $data)
    {
        return $this->update($id_sub, $data);
    }

    /**
     * Hapus sub kriteria
     */
    public function deleteSub($id_sub)
    {
        return $this->delete($id_sub);
    }

    /* =====================================================
     * VALIDATION & UTILITIES
     * ===================================================== */

    /**
     * Cek apakah nama sub kriteria sudah ada
     * (hindari duplikat)
     */
    public function existsByName($nama_sub, $excludeId = null)
    {
        $this->where('nama_sub', $nama_sub);

        if ($excludeId) {
            $this->where('id_sub !=', $excludeId);
        }

        return $this->countAllResults() > 0;
    }
}
