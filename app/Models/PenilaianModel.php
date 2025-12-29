<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $table      = 't_penilaian';
    protected $primaryKey = 'id_penilaian';

    protected $allowedFields = [
        'id_detail_pendaftaran',
        'id_sub',
        'id_user',
        'nilai'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';

    /**
     * Ambil nilai rata-rata sub kriteria (multi user)
     */
    public function getRataRataSub($id_detail_pendaftaran)
    {
        return $this->select('id_sub, AVG(nilai) as nilai')
            ->where('id_detail_pendaftaran', $id_detail_pendaftaran)
            ->groupBy('id_sub')
            ->findAll();
    }
}
