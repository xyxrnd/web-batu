<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BatuModels;
use App\Models\KriteriaModels;
use App\Models\SubKriteriaModel;
use App\Models\AhpSubModel;

class AhpSubController extends BaseController
{
    protected $batu;
    protected $kriteria;
    protected $sub;
    protected $ahpSub;

    public function __construct()
    {
        $this->batu     = new BatuModels();
        $this->kriteria = new KriteriaModels();
        $this->sub      = new SubKriteriaModel();
        $this->ahpSub   = new AhpSubModel();
    }

    // ===============================
    // FORM INPUT SUB KRITERIA AHP
    // ===============================
    public function tambahBobot()
    {
        return view('TambahBobotSub', [
            'batu'     => $this->batu->findAll(),
            'kriteria' => $this->kriteria->findAll(),
            'sub' => $this->sub->findAll()
        ]);
    }


    public function kriteriaByBatu($id_batu)
    {
        $data = $this->kriteria
            ->select('t_kriteria.id_kriteria, t_kriteria.kriteria')
            ->join('t_batu_kriteria', 't_batu_kriteria.id_kriteria = t_kriteria.id_kriteria')
            ->where('t_batu_kriteria.id_batu', $id_batu)
            ->findAll();

        return $this->response->setJSON($data);
    }




    // ===============================
    // SIMPAN AHP SUB KRITERIA
    // ===============================
    public function simpanBobot()
    {
        $id_user = session()->get('id_user');
        $id_batu = $this->request->getPost('id_batu');
        $id_kriteria = $this->request->getPost('id_kriteria');
        $pairs   = $this->request->getPost('pair');
        $sub = $this->request->getPost('nama_sub'); // ini array dari id_kriteria


        if (!$pairs || !$id_batu) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data tidak lengkap');
        }

        // ===============================
        // CEGAH INPUT GANDA
        // ===============================
        $cek = $this->ahpSub
            ->where('id_user', $id_user)
            ->where('id_batu', $id_batu)
            ->where('id_kriteria', $id_kriteria)
            ->countAllResults();


        if ($cek) {
            return redirect()->back()
                ->with('error', 'Anda sudah mengisi penilaian');
        }

        // ===============================
        // 1. AMBIL ID KRITERIA
        // ===============================
        $ids = [];
        foreach ($pairs as $i => $row) {
            $ids[] = $i;
            foreach ($row as $j => $v) {
                $ids[] = $j;
            }
        }
        $ids = array_unique($ids);
        sort($ids);
        $n = count($ids);

        if ($n < 2) {
            return redirect()->back()
                ->with('error', 'Minimal 2 Sub Kriteria');
        }

        // ===============================
        // 2. BANGUN MATRIX AHPsubahpSub
        // ===============================
        $matrix = [];

        foreach ($ids as $i) {
            foreach ($ids as $j) {
                $matrix[$i][$j] = ($i == $j) ? 1 : 0;
            }
        }

        foreach ($pairs as $i => $row) {
            foreach ($row as $j => $nilai) {
                $matrix[$i][$j] = $nilai;
                $matrix[$j][$i] = 1 / $nilai;
            }
        }

        // ===============================
        // 3. NORMALISASI
        // ===============================
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

        // ===============================
        // 4. VEKTOR PRIORITAS
        // ===============================
        $bobot = [];
        foreach ($ids as $i) {
            $bobot[$i] = array_sum($norm[$i]) / $n;
        }

        // ===============================
        // 5. HITUNG λ MAX
        // ===============================
        $lambda = 0;
        foreach ($ids as $i) {
            $sum = 0;
            foreach ($ids as $j) {
                $sum += $matrix[$i][$j] * $bobot[$j];
            }
            $lambda += $sum / $bobot[$i];
        }
        $lambda /= $n;

        // ===============================
        // 6. CI & CR (SAATY)
        // ===============================
        $CI = ($lambda - $n) / ($n - 1);

        $RI = [
            1 => 0.00,
            2 => 0.00,
            3 => 0.58,
            4 => 0.90,
            5 => 1.12,
            6 => 1.24,
            7 => 1.32,
            8 => 1.41,
            9 => 1.45
        ];

        $CR = ($RI[$n] == 0) ? 0 : $CI / $RI[$n];

        // ===============================
        // ❌ JIKA TIDAK KONSISTEN
        // ===============================
        if ($CR > 0.1) {
            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'Penilaian tidak konsisten (CR = ' . round($CR, 3) .
                        '). Silakan perbaiki bobot.'
                );
        }

        // ===============================
        // ✅ SIMPAN KE DATABASE
        // ===============================
        foreach ($pairs as $i => $row) {
            foreach ($row as $j => $nilai) {
                $this->ahpSub->insert([
                    'id_user'       => $id_user,
                    'id_batu'       => $id_batu,
                    'id_kriteria'       => $id_kriteria,
                    'id_sub1' => $i,
                    'id_sub2' => $j,
                    'nilai'         => $nilai
                ]);
            }
        }

        return redirect()->to('/sub-kriteria')
            ->with('success', 'Penilaian berhasil disimpan (CR = ' . round($CR, 3) . ')');
    }

    public function hasilBobot($id_kriteria)
    {
        // ===============================
        // 1. AMBIL DATA AHP SUB
        // ===============================
        $data = $this->ahpSub
            ->where('id_kriteria', $id_kriteria)
            ->findAll();

        // Default nilai (AMAN)
        $hasil = [];
        $ids   = [];

        // ===============================
        // 2. JIKA ADA DATA PENILAIAN
        // ===============================
        if (!empty($data)) {

            // Ambil ID sub kriteria dari pasangan AHP
            foreach ($data as $d) {
                $ids[] = $d['id_sub1'];
                $ids[] = $d['id_sub2'];
            }

            $ids = array_unique($ids);
            sort($ids);

            // Minimal 2 sub kriteria (aturan AHP)
            if (count($ids) >= 2) {

                // ===============================
                // 3. AMBIL DATA SUB KRITERIA
                // ===============================
                $sub_k = $this->sub
                    ->whereIn('id_sub', $ids)
                    ->findAll();

                $n = count($ids);

                // ===============================
                // 4. INISIALISASI MATRIX
                // ===============================
                $matrix = [];
                foreach ($ids as $i) {
                    foreach ($ids as $j) {
                        $matrix[$i][$j] = 1;
                    }
                }

                // ===============================
                // 5. GROUP AHP (GEOMETRIC MEAN)
                // ===============================
                $pairValues = [];
                foreach ($data as $d) {
                    $pairValues[$d['id_sub1']][$d['id_sub2']][] = $d['nilai'];
                }

                foreach ($pairValues as $i => $rows) {
                    foreach ($rows as $j => $values) {
                        $gm = pow(array_product($values), 1 / count($values));
                        $matrix[$i][$j] = $gm;
                        $matrix[$j][$i] = 1 / $gm;
                    }
                }

                // ===============================
                // 6. NORMALISASI
                // ===============================
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

                // ===============================
                // 7. BOBOT PRIORITAS
                // ===============================
                $bobot = [];
                foreach ($ids as $i) {
                    $bobot[$i] = array_sum($norm[$i]) / $n;
                }

                // ===============================
                // 8. HASIL AKHIR
                // ===============================
                foreach ($sub_k as $s) {
                    $hasil[] = [
                        'id_sub'   => $s['id_sub'],
                        'nama_sub' => $s['nama_sub'],
                        'bobot'    => $bobot[$s['id_sub']],
                        'persen'   => round($bobot[$s['id_sub']] * 100, 2)
                    ];
                }
            }
        }

        // ===============================
        // 9. TAMPILKAN VIEW (SELALU)
        // ===============================
        return view('HasilBobotSubKriteria', [
            'hasil'    => $hasil, // bisa kosong
            'kriteria' => $this->kriteria->find($id_kriteria)
        ]);
    }
}
