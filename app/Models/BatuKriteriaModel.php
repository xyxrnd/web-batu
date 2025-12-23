<?php

namespace App\Models;

use CodeIgniter\Model;

class BatuKriteriaModel extends Model
{
    protected $table      = 't_batu_kriteria';
    protected $primaryKey = 'id_batu_kriteria';

    protected $allowedFields = [
        'id_batu',
        'id_kriteria',
        'nilai',
        'created_at',
        'updated_at'
    ];

    // Jika ingin otomatis mengisi created_at dan updated_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Jika ingin menggunakan soft delete (opsional)
    // protected $useSoftDeletes = true;
    // protected $deletedField  = 'deleted_at';

    // Menentukan tipe data yang dihasilkan
    protected $returnType = 'array'; // bisa juga 'object'
}
