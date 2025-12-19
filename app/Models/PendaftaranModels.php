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

    public function getPendaftaranIndex()
    {
        return $this->select('
            t_pendaftaran.id_pendaftaran,
            t_user.nama,
            t_pendaftaran.total_bayar,
            t_pendaftaran.status_pembayaran,
            t_pendaftaran.status_pendaftaran,
            t_pendaftaran.created_at
        ')
            ->join('t_user', 't_user.id_user = t_pendaftaran.id_user')
            ->orderBy('t_pendaftaran.id_pendaftaran', 'DESC')
            ->findAll();
    }
}
