<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModels extends Model
{
    protected $table      = 't_pendaftaran';
    protected $primaryKey = 'id_pendaftaran';

    protected $allowedFields = [
        'id_user',
        'id_batu',
        'jumlah_batu',
        'total_bayar',
        'catatan',
        'status_pembayaran',
        'status_pendaftaran'
    ];

    protected $useTimestamps = true;

    // ================= INDEX =================
    public function getPendaftaranIndex()
    {
        return $this->select('
            t_user.id_user,
            t_user.nama,
            MIN(t_pendaftaran.created_at) AS tanggal,
            SUM(t_pendaftaran.total_bayar) AS total_bayar,
            MAX(t_pendaftaran.status_pembayaran) AS status_pembayaran
        ')
            ->join('t_user', 't_user.id_user = t_pendaftaran.id_user')
            ->groupBy('t_user.id_user')
            ->orderBy('tanggal', 'DESC')
            ->findAll();
    }

    // ================= DETAIL =================
    public function getDetail($id_user)
    {
        return $this->select('
            t_batu.jenis_batu,
            t_pendaftaran.jumlah_batu,
            t_pendaftaran.total_bayar
        ')
            ->join('t_batu', 't_batu.id_batu = t_pendaftaran.id_batu')
            ->where('t_pendaftaran.id_user', $id_user)
            ->findAll();
    }

    // ================= NAMA USER =================
    public function getNamaUser($id_user)
    {
        return $this->db->table('t_user')
            ->select('nama')
            ->where('id_user', $id_user)
            ->get()
            ->getRow();
    }
}
