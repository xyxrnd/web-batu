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
        'password',
        'role'
    ];

    protected $useTimestamps    = false;

    // Login pakai NAMA
    public function getUserByNama($nama)
    {
        return $this->where('nama', $nama)->first();
    }
}
