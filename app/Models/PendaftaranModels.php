<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModels extends Model
{
    protected $table      = 't_pendaftaran';
    protected $primaryKey = 'id_pendaftaran';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_user',
        'id_batu',
        'total_bayar',
        'dp',
        'status_pembayaran',
        'created_at'
    ];

    /**
     * Data index pendaftaran (JOIN user)
     */
    public function getIndex()
    {
        return $this->select('
                t_pendaftaran.id_pendaftaran,
                t_pendaftaran.id_user,
                t_pendaftaran.total_bayar,
                t_pendaftaran.status_pembayaran,
                t_pendaftaran.created_at AS tanggal,
                t_user.nama
            ')
            ->join('t_user', 't_user.id_user = t_pendaftaran.id_user')
            ->orderBy('t_pendaftaran.created_at', 'DESC')
            ->findAll();
    }
}
