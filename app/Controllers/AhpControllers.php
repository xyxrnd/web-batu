<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KriteriaModels;
use App\Models\BatuModels;
use App\Models\AhpInputModels;
use App\Models\BatuKriteriaModel;
use App\Models\BobotKriteriaModel;

class AhpControllers extends BaseController
{
    protected $kriteria;
    protected $batu;
    protected $ahp;
    protected $batukriteria;
    protected $bobotKriteria;

    public function __construct()
    {
        $this->kriteria = new KriteriaModels();
        $this->batu     = new BatuModels();
        $this->ahp      = new AhpInputModels();
        $this->batukriteria      = new BatuKriteriaModel();
        $this->bobotKriteria      = new BobotKriteriaModel();
    }

    // =====================================
    // FORM INPUT BOBOT
    // =====================================
    public function tambahBobot()
    {
        return view('TambahBobot', [
            'batu'     => $this->batu->findAll(),
            'kriteria' => $this->kriteria->findAll()
        ]);
    }


    public function simpanBobot()
    {
        $id_user = session()->get('id_user');
        $id_batu = $this->request->getPost('id_batu');
        $pairs   = $this->request->getPost('pair');

        if (!$pairs || !$id_batu) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data tidak lengkap');
        }

        // ===============================
        // CEGAH INPUT GANDA (PER USER)
        // ===============================
        $cek = $this->ahp
            ->where('id_user', $id_user)
            ->where('id_batu', $id_batu)
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
                ->with('error', 'Minimal 2 Kriteria');
        }

        // ===============================
        // 2. MATRIX USER (UNTUK CR)
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
        // 3. NORMALISASI & CR (USER)
        // ===============================
        $colSum = [];
        foreach ($ids as $j) {
            $colSum[$j] = 0;
            foreach ($ids as $i) {
                $colSum[$j] += $matrix[$i][$j];
            }
        }

        $norm = [];
        foreach ($ids as $i) {
            foreach ($ids as $j) {
                $norm[$i][$j] = $matrix[$i][$j] / $colSum[$j];
            }
        }

        $bobotUser = [];
        foreach ($ids as $i) {
            $bobotUser[$i] = array_sum($norm[$i]) / $n;
        }

        $lambda = 0;
        foreach ($ids as $i) {
            $sum = 0;
            foreach ($ids as $j) {
                $sum += $matrix[$i][$j] * $bobotUser[$j];
            }
            $lambda += $sum / $bobotUser[$i];
        }
        $lambda /= $n;

        $CI = ($lambda - $n) / ($n - 1);
        $RI = [1 => 0, 2 => 0, 3 => 0.58, 4 => 0.9, 5 => 1.12, 6 => 1.24, 7 => 1.32, 8 => 1.41, 9 => 1.45];
        $CR = ($RI[$n] == 0) ? 0 : $CI / $RI[$n];

        if ($CR > 0.1) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Penilaian tidak konsisten (CR = ' . round($CR, 3) . ')');
        }

        // ===============================
        // 4. SIMPAN INPUT USER
        // ===============================
        foreach ($pairs as $i => $row) {
            foreach ($row as $j => $nilai) {
                $this->ahp->insert([
                    'id_user'       => $id_user,
                    'id_batu'       => $id_batu,
                    'id_kriteria_1' => $i,
                    'id_kriteria_2' => $j,
                    'nilai'         => $nilai
                ]);
            }
        }

        // ===============================
        // 5. GROUP AHP (SEMUA USER)
        // ===============================
        $data = $this->ahp
            ->where('id_batu', $id_batu)
            ->findAll();

        $matrixGroup = [];
        foreach ($ids as $i) {
            foreach ($ids as $j) {
                $matrixGroup[$i][$j] = 1;
            }
        }

        $pairValues = [];
        foreach ($data as $d) {
            $pairValues[$d['id_kriteria_1']][$d['id_kriteria_2']][] = $d['nilai'];
        }

        foreach ($pairValues as $i => $rows) {
            foreach ($rows as $j => $values) {
                $gm = pow(array_product($values), 1 / count($values));
                $matrixGroup[$i][$j] = $gm;
                $matrixGroup[$j][$i] = 1 / $gm;
            }
        }

        // ===============================
        // 6. NORMALISASI GROUP
        // ===============================
        $colSum = [];
        foreach ($ids as $j) {
            $colSum[$j] = 0;
            foreach ($ids as $i) {
                $colSum[$j] += $matrixGroup[$i][$j];
            }
        }

        $bobotFinal = [];
        foreach ($ids as $i) {
            $sum = 0;
            foreach ($ids as $j) {
                $sum += $matrixGroup[$i][$j] / $colSum[$j];
            }
            $bobotFinal[$i] = $sum / $n;
        }

        // ===============================
        // 7. SIMPAN HASIL AKHIR
        // ===============================
        $this->bobotKriteria
            ->where('id_batu', $id_batu)
            ->delete();

        foreach ($bobotFinal as $id_kriteria => $nilai) {
            $this->bobotKriteria->insert([
                'id_batu'     => $id_batu,
                'id_kriteria' => $id_kriteria,
                'bobot'       => $nilai,
                'persen'      => round($nilai * 100, 2),
            ]);
        }

        foreach ($ids as $id_k) {
            $this->batukriteria->insert([
                'id_batu'     => $id_batu,
                'id_kriteria' => $id_k
            ]);
        }


        return redirect()->to('/kriteria')
            ->with('success', 'Penilaian berhasil disimpan (CR = ' . round($CR, 3) . ')');
    }

    // // =====================================
    // // HITUNG GROUP AHP & TAMPILKAN HASIL
    // // =====================================
    public function hasilBobot($id_batu)
    {
        return view('HasilBobot', [
            'id_batu' => $id_batu,
            'hasil'   => $this->bobotKriteria->getHasilByBatu($id_batu),
            'batu'    => $this->batu->find($id_batu)
        ]);
    }

    public function detailBobot($id_batu, $id_kriteria)
    {
        return view('DetailBobot', [
            'detail'   => $this->ahp->getDetailBobot($id_batu, $id_kriteria),
            'total'    => $this->ahp->getTotalNilaiKriteria($id_batu, $id_kriteria),
            'kriteria' => $this->kriteria->find($id_kriteria),
            'batu'     => $this->batu->find($id_batu)
        ]);
    }
}
