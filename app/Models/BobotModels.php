<?php

namespace App\Models;

use CodeIgniter\Model;

class BobotModels extends Model
{
    protected $table      = 't_bobot';
    protected $primaryKey = 'id_bobot';

    protected $allowedFields = [
        'id_batu',
        'id_kriteria',
        'bobot'
    ];
}
