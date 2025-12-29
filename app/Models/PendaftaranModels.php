<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModels extends Model
{
    protected $table      = 't_pendaftaran';
    protected $primaryKey = 'id_pendaftaran';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_user',
        'id_batu',
        'total_bayar',
        'dp',
        'status_pembayaran',
        'created_at'
    ];

    /**
     * Data index pendaftaran (JOIN user)
     */
    public function getIndex()
    {
        return $this->select('
                t_pendaftaran.id_pendaftaran,
                t_pendaftaran.id_user,
                t_pendaftaran.total_bayar,
                t_pendaftaran.status_pembayaran,
                t_pendaftaran.created_at AS tanggal,
                t_user.nama
            ')
            ->join('t_user', 't_user.id_user = t_pendaftaran.id_user')
            ->orderBy('t_pendaftaran.created_at', 'DESC')
            ->findAll();
    }

    public function getNamaUser($id_user)
    {
        return $this->db->table('t_user')
            ->select('nama')
            ->where('id_user', $id_user)
            ->get()
            ->getRow();
    }

    public function getDetailByPendaftaran($id_pendaftaran)
    {
        return $this->db->table('t_detail_pendaftaran dp')
            ->select('
            dp.id_detail_pendaftaran,
            dp.nomor_batu,
            dp.status_pendaftaran,
            dp.catatan,
            b.jenis_batu,
            u.nama AS nama_user
        ')
            ->join('t_pendaftaran p', 'p.id_pendaftaran = dp.id_pendaftaran')
            ->join('t_user u', 'u.id_user = p.id_user')
            ->join('t_batu b', 'b.id_batu = dp.id_batu')
            ->where('dp.id_pendaftaran', $id_pendaftaran)
            ->orderBy('b.jenis_batu', 'ASC')
            ->get()
            ->getResultArray();
    }
}
