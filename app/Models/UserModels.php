<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModels extends Model
{
    protected $table            = 't_user';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'nama',
        'no_hp',
        'password'
    ];

    protected $useTimestamps    = false;

    // Cari user berdasarkan no_hp
    public function getUserByNoHp($no_hp)
    {
        return $this->where('no_hp', $no_hp)->first();
    }
}
