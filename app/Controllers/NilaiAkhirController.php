<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NilaiAkhirModel;
use App\Models\NilaiAkhirDetailModel;

class NilaiAkhirController extends BaseController
{
    protected $nilaiAkhir;
    protected $detail;

    public function __construct()
    {
        $this->nilaiAkhir = new NilaiAkhirModel();
        $this->detail    = new NilaiAkhirDetailModel();
    }

    // =========================================
    // 1️⃣ INDEX – RANKING PESERTA
    // =========================================
    public function index()
    {
        $data['ranking'] = $this->nilaiAkhir
            ->select('
                t_nilai_akhir.id_nilai_akhir,
                t_nilai_akhir.total_nilai,
                dp.nomor_batu,
                b.jenis_batu,
                u.nama
            ')
            ->join('t_detail_pendaftaran dp', 'dp.id_detail_pendaftaran = t_nilai_akhir.id_detail_pendaftaran')
            ->join('t_pendaftaran p', 'p.id_pendaftaran = dp.id_pendaftaran')
            ->join('t_user u', 'u.id_user = p.id_user')
            ->join('t_batu b', 'b.id_batu = t_nilai_akhir.id_batu')
            ->orderBy('t_nilai_akhir.total_nilai', 'DESC')
            ->findAll();

        return view('nilai_akhir/index', $data);
    }

    // =========================================
    // 2️⃣ DETAIL NILAI AKHIR
    // =========================================
    public function detail($id_nilai_akhir)
    {
        $nilai = $this->nilaiAkhir->find($id_nilai_akhir);

        if (!$nilai) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $detail = $this->detail
            ->select('
                d.nilai_rata_juri,
                d.bobot_kriteria,
                d.bobot_sub,
                d.nilai_akhir,
                k.kriteria,
                s.nama_sub
            ')
            ->join('t_kriteria k', 'k.id_kriteria = d.id_kriteria')
            ->join('t_sub_kriteria s', 's.id_sub = d.id_sub_kriteria')
            ->where('d.id_nilai_akhir', $id_nilai_akhir)
            ->orderBy('d.nilai_akhir', 'DESC')
            ->findAll();

        return view('nilai_akhir/detail', [
            'nilai'  => $nilai,
            'detail' => $detail
        ]);
    }
}
