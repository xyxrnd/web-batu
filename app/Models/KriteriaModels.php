<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaModels extends Model
{
    protected $table            = 't_kriteria';
    protected $primaryKey       = 'id_kriteria';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = ['kriteria', 'bobot'];
}
