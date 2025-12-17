<?php

namespace App\Models;

use CodeIgniter\Model;

class BatuModels extends Model
{
    protected $table            = 't_batu';
    protected $primaryKey       = 'id_batu';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'jenis_batu',
        'id_kelas',
    ];

    // JOIN kelas
    public function getBatuWithKelas()
    {
        return $this->select('t_batu.*, t_kelas.kelas')
            ->join('t_kelas', 't_kelas.id_kelas = t_batu.id_kelas')
            ->findAll();
    }
}
