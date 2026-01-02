<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPendaftaranModels extends Model
{
    protected $table      = 't_detail_pendaftaran';
    protected $primaryKey = 'id_detail_pendaftaran';
    protected $returnType = 'array';

    protected $allowedFields = [
        'id_pendaftaran',
        'id_batu',
        'nomor_batu',
        'status_pendaftaran',
        'catatan'
    ];

    public function getNextNomorBatu($id_batu)
    {
        // Ambil semua nomor batu yang aktif
        $nomorTerpakai = $this->select('nomor_batu')
            ->where('id_batu', $id_batu)
            ->where('status_pendaftaran !=', 'Ditolak')
            ->where('nomor_batu IS NOT NULL')
            ->orderBy('nomor_batu', 'ASC')
            ->findColumn('nomor_batu');

        // Jika belum ada batu sama sekali
        if (empty($nomorTerpakai)) {
            return 1;
        }

        // Cari nomor terkecil yang hilang
        $expected = 1;
        foreach ($nomorTerpakai as $nomor) {
            if ($nomor != $expected) {
                return $expected;
            }
            $expected++;
        }

        // Jika tidak ada yang kosong, pakai nomor terakhir + 1
        return $expected;
    }

    // Form Penilaian
    public function getDetailByBatu($id_batu)
    {
        return $this->select('
        t_detail_pendaftaran.id_detail_pendaftaran,
        t_detail_pendaftaran.nomor_batu,
        t_user.nama
    ')
            ->join(
                't_pendaftaran',
                't_pendaftaran.id_pendaftaran = t_detail_pendaftaran.id_pendaftaran'
            )
            ->join(
                't_user',
                't_user.id_user = t_pendaftaran.id_user'
            )
            ->where('t_detail_pendaftaran.id_batu', $id_batu)
            ->where('t_detail_pendaftaran.status_pendaftaran !=', 'ditolak')
            ->orderBy('t_detail_pendaftaran.nomor_batu', 'ASC')
            ->findAll();
    }
}
