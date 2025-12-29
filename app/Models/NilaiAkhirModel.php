<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiAkhirModel extends Model
{
    protected $table      = 't_nilai_akhir';
    protected $primaryKey = 'id_nilai_akhir';

    protected $allowedFields = [
        'id_detail_pendaftaran',
        'nilai_akhir',
        'rangking'
    ];

    protected $useTimestamps = false;
}
