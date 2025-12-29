<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenilaianModel;
use App\Models\NilaiAkhirModel;
use App\Models\SubKriteriaModel;

class NilaiAkhirController extends BaseController
{
    protected $penilaian;
    protected $nilaiAkhir;
    protected $sub;

    public function __construct()
    {
        $this->penilaian  = new PenilaianModel();
        $this->nilaiAkhir = new NilaiAkhirModel();
        $this->sub        = new SubKriteriaModel();
    }

    /**
     * HITUNG NILAI AKHIR BATU
     */
    public function hitung($id_detail_pendaftaran)
    {
        // 1. Ambil nilai rata-rata tiap sub
        $nilaiSub = $this->penilaian->getRataRataSub($id_detail_pendaftaran);

        if (!$nilaiSub) {
            return redirect()->back()->with('error', 'Belum ada penilaian');
        }

        // 2. Ambil bobot sub kriteria (hasil AHP)
        $subs = $this->sub->findAll();
        $bobotSub = [];
        foreach ($subs as $s) {
            $bobotSub[$s['id_sub']] = $s['nilai']; // nilai = bobot AHP
        }

        // 3. Hitung nilai akhir
        $nilaiAkhir = 0;
        foreach ($nilaiSub as $n) {
            $nilaiAkhir += $n['nilai'] * ($bobotSub[$n['id_sub']] ?? 0);
        }

        // 4. Simpan / update
        $this->nilaiAkhir
            ->where('id_detail_pendaftaran', $id_detail_pendaftaran)
            ->delete();

        $this->nilaiAkhir->insert([
            'id_detail_pendaftaran' => $id_detail_pendaftaran,
            'nilai_akhir' => $nilaiAkhir,
            'rangking' => 0 // diisi setelah semua dihitung
        ]);

        return redirect()->back()->with('success', 'Nilai akhir dihitung');
    }

    /**
     * UPDATE RANKING
     */
    public function ranking()
    {
        $data = $this->nilaiAkhir
            ->orderBy('nilai_akhir', 'DESC')
            ->findAll();

        $rank = 1;
        foreach ($data as $d) {
            $this->nilaiAkhir->update($d['id_nilai_akhir'], [
                'rangking' => $rank++
            ]);
        }

        return redirect()->back()->with('success', 'Ranking diperbarui');
    }
}
