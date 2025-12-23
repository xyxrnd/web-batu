<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPendaftaranModels extends Model
{
    protected $table      = 't_detail_pendaftaran';
    protected $primaryKey = 'id_detail_pendaftaran';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_pendaftaran',
        'id_batu',
        'nomor_batu',
        'status_pendaftaran',
        'catatan'
    ];

    public function getNextNomorBatu($id_batu)
    {
        $last = $this->where('id_batu', $id_batu)
            ->where('nomor_batu IS NOT NULL')
            ->orderBy('nomor_batu', 'DESC')
            ->first();

        return $last ? $last['nomor_batu'] + 1 : 1;
    }
}
