<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiAkhirModel extends Model
{
    protected $table      = 't_nilai_akhir';
    protected $primaryKey = 'id_nilai_akhir';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_detail_pendaftaran',
        'id_batu',
        'total_nilai',
        'peringkat',
        'created_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = false;

    // ===============================
    // INSERT / UPDATE
    // ===============================

    /**
     * Simpan atau update nilai akhir
     */
    public function saveNilaiAkhir($data)
    {
        $exist = $this->where('id_detail_pendaftaran', $data['id_detail_pendaftaran'])
            ->first();

        if ($exist) {
            return $this->update($exist['id_nilai_akhir'], $data);
        }

        return $this->insert($data);
    }

    // ===============================
    // QUERY
    // ===============================

    /**
     * Ambil nilai akhir peserta
     */
    public function getByDetailPendaftaran($id_detail_pendaftaran)
    {
        return $this->where('id_detail_pendaftaran', $id_detail_pendaftaran)
            ->first();
    }

    /**
     * Ambil ranking per batu
     */
    public function getRankingByBatu($id_batu)
    {
        return $this->select('
                t_nilai_akhir.*,
                u.nama,
                dp.nomor_batu
            ')
            ->join('t_detail_pendaftaran dp', 'dp.id_detail_pendaftaran = t_nilai_akhir.id_detail_pendaftaran')
            ->join('t_pendaftaran p', 'p.id_pendaftaran = dp.id_pendaftaran')
            ->join('t_user u', 'u.id_user = p.id_user')
            ->where('t_nilai_akhir.id_batu', $id_batu)
            ->orderBy('total_nilai', 'DESC')
            ->findAll();
    }
}
