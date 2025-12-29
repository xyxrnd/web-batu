<?php

namespace App\Models;

use CodeIgniter\Model;

class AhpSubModel extends Model
{
    protected $table      = 't_ahp_sub';
    protected $primaryKey = 'id_ahp_sub';

    protected $allowedFields = [
        'id_batu',
        'id_kriteria',
        'id_user',
        'id_sub1',
        'id_sub2',
        'nilai'
    ];

    protected $useTimestamps = false;
}
