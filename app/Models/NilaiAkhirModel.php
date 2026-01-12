<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiAkhirModel extends Model
{
    protected $table      = 't_nilai_akhir';
    protected $primaryKey = 'id_nilai_akhir';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_detail_pendaftaran',
        'id_batu',
        'total_nilai',
        'peringkat',
        'created_at'
    ];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = false;

    // ===============================
    // INSERT / UPDATE
    // ===============================

    /**
     * Simpan atau update nilai akhir
     */
    public function saveNilaiAkhir($data)
    {
        $exist = $this->where('id_detail_pendaftaran', $data['id_detail_pendaftaran'])
            ->first();

        if ($exist) {
            return $this->update($exist['id_nilai_akhir'], $data);
        }

        return $this->insert($data);
    }

    // ===============================
    // QUERY
    // ===============================

    /**
     * Ambil nilai akhir peserta
     */
    public function getByDetailPendaftaran($id_detail_pendaftaran)
    {
        return $this->where('id_detail_pendaftaran', $id_detail_pendaftaran)
            ->first();
    }

    /**
     * Ambil ranking per batu
     */
    public function getRankingByBatu($id_batu)
    {
        return $this->select('
                t_nilai_akhir.*,
                u.nama,
                dp.nomor_batu
            ')
            ->join('t_detail_pendaftaran dp', 'dp.id_detail_pendaftaran = t_nilai_akhir.id_detail_pendaftaran')
            ->join('t_pendaftaran p', 'p.id_pendaftaran = dp.id_pendaftaran')
            ->join('t_user u', 'u.id_user = p.id_user')
            ->where('t_nilai_akhir.id_batu', $id_batu)
            ->orderBy('total_nilai', 'DESC')
            ->findAll();
    }

    public function publishNilai($idBatu, $dataRata, $bobotKriteria, $bobotSub)
    {
        // Mapping bobot
        $mapKriteria = [];
        foreach ($bobotKriteria as $k) {
            $mapKriteria[$k['id_kriteria']] = (float)$k['bobot'];
        }

        $mapSub = [];
        foreach ($bobotSub as $s) {
            $mapSub[$s['id_sub']] = (float)$s['bobot'];
        }

        // Hitung nilai akhir
        $rekap = [];

        foreach ($dataRata as $row) {
            $idDetail = $row['id_detail_pendaftaran'];

            $bobotGlobal =
                $mapKriteria[$row['id_kriteria']] *
                $mapSub[$row['id_sub']];

            $nilaiSub = $row['nilai_rata'] * $bobotGlobal;

            if (!isset($rekap[$idDetail])) {
                $rekap[$idDetail] = 0;
            }

            $rekap[$idDetail] += $nilaiSub;
        }

        // UPSERT (AMAN DARI DUPLICATE)
        foreach ($rekap as $idDetail => $totalNilai) {

            $existing = $this->where('id_detail_pendaftaran', $idDetail)->first();

            if ($existing) {
                $this->update($existing['id_nilai_akhir'], [
                    'total_nilai' => round($totalNilai, 5),
                ]);
            } else {
                $this->insert([
                    'id_detail_pendaftaran' => $idDetail,
                    'id_batu'               => $idBatu,
                    'total_nilai'           => round($totalNilai, 5),
                    'created_at'            => date('Y-m-d H:i:s')
                ]);
            }
        }
    }

    public function hitungPeringkat($idBatu)
    {
        $data = $this->where('id_batu', $idBatu)
            ->orderBy('total_nilai', 'DESC')
            ->findAll();

        $rank = 1;
        foreach ($data as $row) {
            $this->update($row['id_nilai_akhir'], [
                'peringkat' => $rank++
            ]);
        }
    }

    public function getRankingByKelas($idKelas)
    {
        return $this->select('
                t_nilai_akhir.peringkat,
                t_nilai_akhir.total_nilai,
                t_detail_pendaftaran.nomor_batu,
                t_batu.jenis_batu,
                t_user.nama
            ')
            ->join(
                't_detail_pendaftaran',
                't_detail_pendaftaran.id_detail_pendaftaran = t_nilai_akhir.id_detail_pendaftaran'
            )
            ->join(
                't_pendaftaran',
                't_pendaftaran.id_pendaftaran = t_detail_pendaftaran.id_pendaftaran'
            )
            ->join(
                't_user',
                't_user.id_user = t_pendaftaran.id_user'
            )
            ->join(
                't_batu',
                't_batu.id_batu = t_detail_pendaftaran.id_batu'
            )
            ->where('t_batu.id_kelas', $idKelas)
            ->orderBy('t_nilai_akhir.peringkat', 'ASC')
            ->findAll();
    }
}
