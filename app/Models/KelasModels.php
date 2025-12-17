<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModels extends Model
{
    protected $table            = 't_kelas';
    protected $primaryKey       = 'id_kelas';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'kelas'
    ];
}
