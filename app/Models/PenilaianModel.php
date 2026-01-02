<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $table            = 't_penilaian';
    protected $primaryKey       = 'id_penilaian';
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'id_detail_pendaftaran',
        'id_user',
        'id_batu',
        'id_kriteria',
        'id_sub',
        'nilai_input',
        'created_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = false;


    // Form penilaian
    public function getNilai($detail, $user, $kriteria, $sub)
    {
        return $this->where([
            'id_detail_pendaftaran' => $detail,
            'id_user'               => $user,
            'id_kriteria'           => $kriteria,
            'id_sub'                => $sub
        ])->first();
    }

    // ambil nilai per batu & juri
    public function getNilaiByBatuDanUser($idBatu, $idUser)
    {
        return $this->where('id_batu', $idBatu)
            ->where('id_user', $idUser)
            ->findAll();
    }


    // hasil form penilaian
    public function getNilaiByBatu($id_batu, $id_user)
    {
        $rows = $this->where('id_batu', $id_batu)
            ->where('id_user', $id_user)
            ->findAll();

        $nilai = [];

        foreach ($rows as $r) {
            $nilai[$r['id_detail_pendaftaran']][$r['id_kriteria']][$r['id_sub']]
                = $r['nilai_input'];
        }

        return $nilai;
    }

    // Index penilaian
    public function getKelasPenilaian()
    {
        return $this->db->table('t_kelas')
            ->select('t_kelas.id_kelas, t_kelas.kelas')
            ->join('t_batu', 't_batu.id_kelas = t_kelas.id_kelas')
            ->join('t_detail_pendaftaran', 't_detail_pendaftaran.id_batu = t_batu.id_batu')
            ->groupBy('t_kelas.id_kelas')
            ->get()
            ->getResultArray();
    }


    /**
     * ===============================
     * Ambil jenis batu & total batu per kelas
     * ===============================
     */
    public function getBatuPenilaianByKelas($idKelas)
    {
        return $this->db->table('t_batu')
            ->select('
                t_batu.id_batu,
                t_batu.jenis_batu,
                COUNT(t_detail_pendaftaran.id_detail_pendaftaran) AS total_batu
            ')
            ->join(
                't_detail_pendaftaran',
                't_detail_pendaftaran.id_batu = t_batu.id_batu'
            )
            ->where('t_batu.id_kelas', $idKelas)
            ->groupBy('t_batu.id_batu')
            ->orderBy('t_batu.jenis_batu', 'ASC')
            ->get()
            ->getResultArray();
    }

    // ===============================
    // INSERT / UPDATE
    // ===============================

    /**
     * Simpan atau update nilai juri
     */
    public function saveNilai($data)
    {
        return $this->where([
            'id_detail_pendaftaran' => $data['id_detail_pendaftaran'],
            'id_user'               => $data['id_user'],
            'id_sub'       => $data['id_sub'],
        ])
            ->set('nilai_input', $data['nilai_input'])
            ->set('created_at', date('Y-m-d H:i:s'))
            ->update();
    }

    // ===============================
    // QUERY
    // ===============================

    /**
     * Ambil semua nilai juri per peserta
     */
    public function getByDetailPendaftaran($id_detail_pendaftaran)
    {
        return $this->where('id_detail_pendaftaran', $id_detail_pendaftaran)
            ->findAll();
    }

    /**
     * Ambil nilai juri per sub kriteria
     */
    public function getNilaiSub($id_detail_pendaftaran, $id_sub)
    {
        return $this->where([
            'id_detail_pendaftaran' => $id_detail_pendaftaran,
            'id_sub'       => $id_sub
        ])
            ->findAll();
    }

    /**
     * Hitung rata-rata nilai juri per sub kriteria
     */
    public function getRataSub($id_detail_pendaftaran, $id_sub)
    {
        return $this->selectAvg('nilai_input', 'rata')
            ->where([
                'id_detail_pendaftaran' => $id_detail_pendaftaran,
                'id_sub'       => $id_sub
            ])
            ->get()
            ->getRowArray();
    }

    public function getIndexPenilaian()
    {
        return $this->db->table('t_detail_pendaftaran dp')
            ->select('
                b.id_batu,
                b.jenis_batu,
                COUNT(dp.id_detail_pendaftaran) AS total_batu
            ')
            ->join('t_batu b', 'b.id_batu = dp.id_batu')
            ->where('dp.status_pendaftaran', 'Diterima')
            ->groupBy('b.id_batu')
            ->orderBy('b.jenis_batu', 'ASC')
            ->get()
            ->getResultArray();
    }
}
