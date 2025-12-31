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

    public function getDetailBobotSub($id_batu, $id_sub)
    {
        return $this->select('
            t_ahp_sub.nilai,
            t_ahp_sub.id_sub1,
            t_ahp_sub.id_sub2,
            u.nama AS nama_user,
            k1.nama_sub  AS sub1,
            k2.nama_sub  AS sub2
        ')
            ->join('t_user u', 'u.id_user = t_ahp_sub.id_user')
            ->join('t_sub_kriteria k1', 'k1.id_sub = t_ahp_sub.id_sub1')
            ->join('t_sub_kriteria k2', 'k2.id_sub = t_ahp_sub.id_sub2')
            ->where('t_ahp_sub.id_batu', $id_batu)
            ->groupStart()
            ->where('t_ahp_sub.id_sub1', $id_sub)
            ->orWhere('t_ahp_sub.id_sub2', $id_sub)
            ->groupEnd()
            ->findAll();
    }


    public function getTotalNilaiSub($id_batu, $id_sub)
    {
        return $this->where('id_batu', $id_batu)
            ->groupStart()
            ->where('id_sub1', $id_sub)
            ->orWhere('id_sub2', $id_sub)
            ->groupEnd()
            ->selectSum('nilai')
            ->first()['nilai'] ?? 0;
    }
}
