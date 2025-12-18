<?php

namespace App\Models;

use CodeIgniter\Model;

class AhpInputModels extends Model
{
    protected $table      = 't_ahp_input';
    protected $primaryKey = 'id_input';

    protected $allowedFields = [
        'id_user',
        'id_batu',
        'id_kriteria_1',
        'id_kriteria_2',
        'nilai'
    ];

    protected $useTimestamps = true;
}
