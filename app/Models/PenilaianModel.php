<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $table            = 't_penilaian';
    protected $primaryKey       = 'id_penilaian';
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'id_detail_pendaftaran',
        'id_user',
        'id_batu',
        'id_kriteria',
        'id_sub',
        'nilai_input',
        'created_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = false;

    // ===============================
    // INSERT / UPDATE
    // ===============================

    /**
     * Simpan atau update nilai juri
     */
    public function saveNilai($data)
    {
        return $this->where([
            'id_detail_pendaftaran' => $data['id_detail_pendaftaran'],
            'id_user'               => $data['id_user'],
            'id_sub'       => $data['id_sub'],
        ])
            ->set('nilai_input', $data['nilai_input'])
            ->set('created_at', date('Y-m-d H:i:s'))
            ->update();
    }

    // ===============================
    // QUERY
    // ===============================

    /**
     * Ambil semua nilai juri per peserta
     */
    public function getByDetailPendaftaran($id_detail_pendaftaran)
    {
        return $this->where('id_detail_pendaftaran', $id_detail_pendaftaran)
            ->findAll();
    }

    /**
     * Ambil nilai juri per sub kriteria
     */
    public function getNilaiSub($id_detail_pendaftaran, $id_sub)
    {
        return $this->where([
            'id_detail_pendaftaran' => $id_detail_pendaftaran,
            'id_sub'       => $id_sub
        ])
            ->findAll();
    }

    /**
     * Hitung rata-rata nilai juri per sub kriteria
     */
    public function getRataSub($id_detail_pendaftaran, $id_sub)
    {
        return $this->selectAvg('nilai_input', 'rata')
            ->where([
                'id_detail_pendaftaran' => $id_detail_pendaftaran,
                'id_sub'       => $id_sub
            ])
            ->get()
            ->getRowArray();
    }

    public function getIndexPenilaian()
    {
        return $this->db->table('t_detail_pendaftaran dp')
            ->select('
                b.id_batu,
                b.jenis_batu,
                COUNT(dp.id_detail_pendaftaran) AS total_batu
            ')
            ->join('t_batu b', 'b.id_batu = dp.id_batu')
            ->where('dp.status_pendaftaran', 'Diterima')
            ->groupBy('b.id_batu')
            ->orderBy('b.jenis_batu', 'ASC')
            ->get()
            ->getResultArray();
    }
}
