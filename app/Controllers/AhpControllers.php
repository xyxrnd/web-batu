<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KriteriaModels;
use App\Models\BatuModels;
use App\Models\AhpInputModels;

class AhpControllers extends BaseController
{
    protected $kriteria;
    protected $batu;
    protected $ahp;

    public function __construct()
    {
        $this->kriteria = new KriteriaModels();
        $this->batu     = new BatuModels();
        $this->ahp      = new AhpInputModels();
    }

    // =====================================
    // FORM INPUT BOBOT (MULTI USER)
    // =====================================
    public function tambahBobot()
    {
        return view('TambahBobot', [
            'batu'     => $this->batu->findAll(),
            'kriteria' => $this->kriteria->findAll()
        ]);
    }

    // =====================================
    // SIMPAN INPUT USER (RAW DATA)
    // =====================================
    public function simpanBobot()
    {
        $id_user = session()->get('id_user');
        $id_batu = $this->request->getPost('id_batu');
        $pairs   = $this->request->getPost('pair');

        if (!$pairs || !$id_batu) {
            return redirect()->back()
                ->with('error', 'Data tidak lengkap');
        }

        // Cegah input ganda
        $cek = $this->ahp
            ->where('id_user', $id_user)
            ->where('id_batu', $id_batu)
            ->first();

        if ($cek) {
            return redirect()->back()
                ->with('error', 'Anda sudah mengisi penilaian untuk batu ini');
        }

        // Simpan semua pairwise user
        foreach ($pairs as $i => $row) {
            foreach ($row as $j => $nilai) {
                $this->ahp->insert([
                    'id_user'        => $id_user,
                    'id_batu'        => $id_batu,
                    'id_kriteria_1'  => $i,
                    'id_kriteria_2'  => $j,
                    'nilai'          => $nilai
                ]);
            }
        }

        return redirect()->to('/kriteria')
            ->with('success', 'Penilaian berhasil disimpan');
    }

    // =====================================
    // HITUNG GROUP AHP & TAMPILKAN HASIL
    // =====================================
    public function hasilBobot($id_batu)
    {
        // Ambil ID kriteria yang BENAR-BENAR digunakan
        $data = $this->ahp
            ->where('id_batu', $id_batu)
            ->findAll();

        $ids = [];
        foreach ($data as $d) {
            $ids[] = $d['id_kriteria_1'];
            $ids[] = $d['id_kriteria_2'];
        }
        $ids = array_unique($ids);
        sort($ids);

        // Ambil data kriteria hanya yang dipakai
        $kriteria = $this->kriteria
            ->whereIn('id_kriteria', $ids)
            ->findAll();

        $n = count($ids);


        // Ambil semua input AHP untuk batu tertentu
        $data = $this->ahp
            ->where('id_batu', $id_batu)
            ->findAll();

        if (!$data) {
            return redirect()->back()
                ->with('error', 'Belum ada data penilaian');
        }

        // =====================================
        // 1. INISIALISASI MATRIX FULL (WAJIB)
        // =====================================
        $matrix = [];

        foreach ($ids as $i) {
            foreach ($ids as $j) {
                $matrix[$i][$j] = 1; // default
            }
        }

        // =====================================
        // 2. ISI DARI GROUP AHP (GEOMETRIC MEAN)
        // =====================================
        $pairValues = [];

        foreach ($data as $d) {
            $pairValues[$d['id_kriteria_1']][$d['id_kriteria_2']][] = $d['nilai'];
        }

        foreach ($pairValues as $i => $rows) {
            foreach ($rows as $j => $values) {
                $gm = pow(array_product($values), 1 / count($values));
                $matrix[$i][$j] = $gm;
                $matrix[$j][$i] = 1 / $gm;
            }
        }


        // =====================================
        // 2. NORMALISASI
        // =====================================
        $colSum = [];
        foreach ($ids as $j) {
            $colSum[$j] = array_sum(array_column($matrix, $j));
        }

        $norm = [];
        foreach ($ids as $i) {
            foreach ($ids as $j) {
                $norm[$i][$j] = $matrix[$i][$j] / $colSum[$j];
            }
        }

        // =====================================
        // 3. BOBOT PRIORITAS
        // =====================================
        $bobot = [];
        foreach ($ids as $i) {
            $bobot[$i] = array_sum($norm[$i]) / $n;
        }

        // =====================================
        // 4. KONVERSI KE PERSENTASE
        // =====================================
        $hasil = [];
        foreach ($kriteria as $k) {
            $hasil[] = [
                'kriteria' => $k['kriteria'],
                'bobot'    => $bobot[$k['id_kriteria']],
                'persen'   => round($bobot[$k['id_kriteria']] * 100, 2)
            ];
        }

        return view('HasilBobot', [
            'hasil' => $hasil,
            'batu'  => $this->batu->find($id_batu)
        ]);
    }
}
